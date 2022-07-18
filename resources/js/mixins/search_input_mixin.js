import url_mixin from "./url_mixin";

export default {
    mixins: [
        url_mixin
    ],
    data() {
        return {
            objGeo: {
                bool_select_country: false,
            },
            objLocations: {
                load_countries:null,
                load_regions:null,
                load_cities:null,
                country: null,
                country_translate: null,
                region: null,
                city: null,
            },
            objUrlHierarchyDocument:{
                all_vacancies: this.lang.prefix_lang+'vacancy/',
            },
            urlPrefixElements: [],
        }
    },
    methods: {
        async loadCity2(){
            let data = {
                country_code: this.objLocations.country,
                region_code: ''+this.objLocations.region,
                lang_local: this.lang.lang_local,
            };
            const response = await this.$http.post(`/localisation/get-city`, data)
                .then(res => {
                    if(this.checkSuccess(res)){
                        // у региона есть города
                        if(res.data.message !== null){
                            $("span[data-select2-id='5']").css('display', "block")
                            this.objLocations.load_cities = res.data.message
                            console.log(this.objLocations.load_cities)
                        }
                        else{
                            this.clearLocation2('load_cities')
                            $("span[data-select2-id='5']").css('display', "none")
                        }
                    }
                    // custom ошибки
                    else{
                        this.clearLocation2('load_cities')
                    }
                })
                // ошибки сервера
                .catch(err => {
                    this.messageError(err)
                })
        },
        clearLocation2(value) {
            switch (value) {
                case 'load_cities':
                    this.objLocations.load_cities = null
                    break;
                case 'bool_rest':
                    this.objLocations.city = null
                    break;
                case 'load_region':
                    this.objLocations.load_cities = null
                    break;
                default:
                    this.objLocations.country = null
                    this.objLocations.region = null
                    this.objLocations.city = null
                    this.objLocations.load_regions = null
                    this.objLocations.load_cities = null
            }
        },
        // --- методы строки поиска
        urlReload2(obj){
            let params = new URLSearchParams(window.location.search)
            params.delete('page')
            // page
            if(obj.page != undefined && obj.page != null){
                params.set('page',obj.page)
            }
            // search
            if(this.position == ''){
                params.delete(this.name_query)
            }
            else{
                params.set(this.name_query,this.position)
            }
            params.sort()
            let query = (params.toString() == '') ? '' : '?'+params.toString()
            location.href = this.urlNotQuery()+query
        },
        clearSearch2(){
            let params = new URLSearchParams(window.location.search)
            this.position = ''
            this.position_list = []
            $('.dropdown-menu').removeClass('show')
            if(params.has(this.name_query)){
                this.urlReload2({})
            }
            $('.x-mark-clear').css('display','none')
        },
        enterKey2(e){
            if(e.code == 'Enter'){
                this.urlReload2({})
            }
        },
        selectHelp(value){
            $('#position_list').removeClass('show')
            this.position = value
        },
        searchPositionInUrl2(){
            const params = new URLSearchParams(window.location.search)
            if(params.has(this.name_query)){
                this.position = params.get(this.name_query)
                $('.x-mark-clear').css('display','block')
            }
        },
        // click по display country
        viewSelectCountry2() {
            // hide display country
            $(".one-select").css('display', "none")
            // show select country
            $("span[data-select2-id='1']").css('display', "block")
            // open select country
            setTimeout(() => {
                $('#country').select2('open')
            }, 100);
        },
        initializeData2(){
            this.searchPositionInUrl2();
            this.urlPrefixElements = this.urlPathname().split('/')


            // страна
            $('#country-title-panel').on('select2:select', (e) => {
                let value = e.params.data.id
                // hide select city
                $("span[data-select2-id='5']").css('display', "none")

                // не выбрано
                if(value == ''){
                    // добавить странам warning
                    $("span[data-select2-id='1']").addClass('not-select')
                    // hide select region
                    $("span[data-select2-id='3']").css('display', "none")
                }
                // выбрано
                else{
                    // показать display country
                    // $(".one-select").css('display', "inherit")
                    // // hide select country, убрать warning
                    // $("span[data-select2-id='1']").css('display', "none").removeClass('not-select')
                    // let arr = e.params.data.id.split(',')
                    // this.objLocations.country = arr[0]
                    // this.objLocations.country_translate = arr[1]

                    console.log(this.urlPrefixElements)

                    let vacancy_index = this.urlPrefixElements.indexOf('vacancy')
                    // загрузка country page с индекс page
                    if(vacancy_index === -1){
                        location.href = this.objUrlHierarchyDocument.all_vacancies+value
                    }
                    // загрузка country page с показа всех вакансий page
                    else if(vacancy_index !== -1 && vacancy_index === (this.urlPrefixElements.length-1)){
                        location.href = this.objUrlHierarchyDocument.all_vacancies+value
                    }
                    // загрузка country page сменяя другую страну
                    else if(vacancy_index !== -1 && vacancy_index+1 === (this.urlPrefixElements.length-1)){
                        location.href = this.objUrlHierarchyDocument.all_vacancies+value
                    }
                }
            })

            // регион
            $('#region').on('select2:select', (e) => {
                let value = e.params.data.id
                this.objLocations.region = value
                this.clearLocation2('load_cities')

                if(value == ""){
                    $("span[data-select2-id='3']").addClass('not-select')
                    $("span[data-select2-id='5']").css('display', "none")
                }
                else{
                    $("span[data-select2-id='3']").removeClass('not-select')
                    // показ select city
                    this.loadCity2();
                }
            })

            // регион
            $('#city').on('select2:select', (e) => {
                let value = e.params.data.id
                this.objLocations.city = value

                if(value == ""){
                    $("span[data-select2-id='5']").addClass('not-select')
                }
                else{
                    $("span[data-select2-id='5']").removeClass('not-select')
                }
            })

            // спрятать default .css('display', "none")
            setTimeout(() => {
                // страны
                $("span[data-select2-id='1']").addClass('not-select')
                // регионы
                $("span[data-select2-id='3']").css('display', "none").addClass('not-select')
                // города
                $("span[data-select2-id='5']").css('display', "none").addClass('not-select')
            }, 200);

        },
    },
    mounted() {
        this.$nextTick(function () {
            this.initializeData2();
        })
    },
}

