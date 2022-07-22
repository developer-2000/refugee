export default {
    data() {
        return {
            arrVacancies:[],
            arrResumes: [],
        }
    },
    methods: {
        salaryView(salaryObj){
            let salary_string = ''
            let arr_field = this.settings.salary[salaryObj.radio_name]
            $.each(arr_field, function(key, name) {
                salary_string += salaryObj.inputs[name]
                if( (key+1) < arr_field.length){
                    salary_string += ' - '
                }
            })
            salary_string = salary_string == '' ? 0 : salary_string
            return salary_string
        },
        addressView(vacancyObj){
            let address_string = ''

            if(vacancyObj.country !== null){
                address_string += vacancyObj.country.name+'.'
            }
            if(vacancyObj.region !== null){
                address_string += ' ' + vacancyObj.region.name+'.'
            }
            if(vacancyObj.city !== null){
                address_string += ' ' + vacancyObj.city.name+'.'
            }

            address_string += ' ' + vacancyObj.rest_address+'.'

            return address_string
        },
        transitionToVacancy(alias){
            location.href = this.lang.prefix_lang+'vacancy/show-vacancy/'+alias
        },
        transitionToResume(alias){
            location.href = this.lang.prefix_lang+'resume/show-resume/'+alias
        },

        getGenerateUrlDocument(objDocument, prefix){
            let one_alias = objDocument.address.country.original_index
            let two_alias = (objDocument.address.region !== undefined) ? objDocument.address.region.original_index :
                (objDocument.address.city !== undefined) ? objDocument.address.city.original_index : ""

            return `${this.lang.prefix_lang+prefix}/${one_alias}/${two_alias}/${objDocument.alias}`
        },

        pageReload(){
            location.reload()
        },
    },
}
