
export default {
    data() {
        return {
            locationSearch: window.location.search,
            objButtonFilters: [],
            arrFilters: {},
        }
    },
    methods: {
        // срабатывает при изменениях в компоненте filter_panel
        reloadFilterPage(obj){
            let params = new URLSearchParams(window.location.search)
            params.delete('page')
            params.delete('categories')
            params.delete('languages')
            params.delete('suitable')
            params.delete('employment')
            params.delete('salary')
            params.delete('experience')
            params.delete('education')

            // categories
            if(obj.categories != undefined && obj.categories.length){
                params.set('categories',obj.categories.toString())
            }
            // languages
            if(obj.languages != undefined && obj.languages.length){
                params.set('languages',obj.languages.toString())
            }
            // suitable
            if(obj.suitable != undefined && obj.suitable.check){
                params.set('suitable',[obj.suitable.suitable_from,obj.suitable.suitable_to].toString())
            }
            // employment
            if(obj.employment != undefined && obj.employment){
                params.set('employment',obj.employment)
            }
            // salary
            if(obj.salary != undefined && obj.salary.check){
                params.set('salary',[
                    obj.salary.without_salary_checkbox ? 1 : 0,
                    obj.salary.from,
                    obj.salary.to
                ].toString())
            }
            // experience
            if(obj.experience != undefined && obj.experience){
                params.set('experience',obj.experience)
            }
            // education
            if(obj.education != undefined && obj.education){
                params.set('education',obj.education)
            }

            params.sort()
            let query = (params.toString() == '') ? '' : '?'+params.toString()

            location.href = this.urlPathname()+query
        },
        clearQuery(){
            window.location.href = location.protocol + '//' + location.host + location.pathname
        },
        // соберает данные примененных фильтров для отображения и очистки url (для mobile фильтров)
        forMobileFilters(){
            const params = new URLSearchParams(window.location.search)
            let name = ''
            let arr = []
            let text = ""
            let from = ''
            let to = ''

            if(params.has('categories')){
                arr = JSON.parse("[" + params.get('categories') + "]");

                this.arrFilters.categories = arr

                for (let index in arr) {
                    name = this.respond.categories[ arr[index] ]
                    this.objButtonFilters.push({
                        text : this.trans('vacancies',name),
                        type : "categories",
                        index : arr[ index ],
                    })
                }
            }
            if(params.has('salary')){
                arr = JSON.parse("[" + params.get('salary') + "]");
                let without_salary_checkbox = (arr[0] == undefined) ? false : (parseInt(arr[0]) === 0) ? false : true
                from = (arr[1] == undefined) ? 0 : (!Number.isInteger(parseInt(arr[1]))) ? 0 : parseInt(arr[1])
                to = (arr[2] == undefined) ? 99999 : (!Number.isInteger(parseInt(arr[2]))) ? 99999 : parseInt(arr[2])

                this.arrFilters.salary = {
                    without_salary_checkbox : without_salary_checkbox,
                    from : from,
                    to : to,
                    check : true
                }

                // чекбокс
                if(without_salary_checkbox){
                    text = this.trans('vacancies','with_unspecified_salary')
                    text = text[0].toUpperCase() + text.slice(1)
                }
                // цифры
                else{
                    text = from + " - " + to + " Euro"
                }
                this.objButtonFilters.push({
                    text : text,
                    type : "salary",
                    without_salary_checkbox: without_salary_checkbox,
                    check : true
                })

            }
            if(params.has('languages')){
                arr = JSON.parse("[" + params.get('languages') + "]");

                this.arrFilters.languages = arr

                for (let index in arr) {
                    this.objButtonFilters.push({
                        text : this.lang.lang[ arr[ index ] ].title,
                        type : "languages",
                        index : arr[ index ],
                    })
                }
            }
            if(params.has('employment')){
                let employment = params.get('employment')
                name = this.trans('vacancies', this.respond.type_employment[ employment ] )

                this.arrFilters.employment = employment

                this.objButtonFilters.push({
                    text : name,
                    type : "employment",
                })
            }
            if(params.has('experience')){
                let experience = params.get('experience')
                name = this.trans('vacancies', this.respond.work_experience[ experience ] )
                name = name[0].toUpperCase() + name.slice(1)

                this.arrFilters.experience = experience

                this.objButtonFilters.push({
                    text : name,
                    type : "experience",
                })
            }
            if(params.has('suitable')){
                arr = JSON.parse("[" + params.get('suitable') + "]");
                from = (arr[0] != undefined) ? parseInt(arr[0]) : 0
                to = (arr[1] != undefined) ? parseInt(arr[1]) : 100

                this.arrFilters.suitable = {
                    check : true,
                    suitable_from : from,
                    suitable_to : to,
                }

                let text = from + " - " + to + " " + this.trans('vacancies', "years" )
                this.objButtonFilters.push({
                    text : text,
                    type : "suitable",
                })
            }
            if(params.has('education')){
                let education = params.get('education')

                this.arrFilters.education = education

                name = this.trans('vacancies', this.respond.education[ education ] )
                name = name[0].toUpperCase() + name.slice(1)
                this.objButtonFilters.push({
                    text : name,
                    type : "education",
                })
            }

        },
        // сброс указанного фильтра (для mobile фильтров)
        resetFilters(obj){
            if(obj.type == "categories"){
                this.arrFilters.categories.splice(this.arrFilters.categories.indexOf( parseInt(obj.index) ), 1)
            }
            else if(obj.type == "salary"){
                this.arrFilters.salary.check = false
            }
            else if(obj.type == "languages"){
                this.arrFilters.languages.splice(this.arrFilters.languages.indexOf( parseInt(obj.index) ), 1)
            }
            else if(obj.type == "employment"){
                this.arrFilters.employment = null
            }
            else if(obj.type == "experience"){
                this.arrFilters.experience = null
            }
            else if(obj.type == "suitable"){
                this.arrFilters.suitable.check = false
            }
            else if(obj.type == "education"){
                this.arrFilters.education = null
            }

            this.reloadFilterPage(this.arrFilters)
        },
    },
    mounted() {
        this.$nextTick(function () {
            if(this.media_bool){
                this.forMobileFilters()
            }
        })
    },

}

