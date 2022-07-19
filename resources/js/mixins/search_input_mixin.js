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
                region_original_index: null,
                region_translate: null,
                city: null,
            },
            objUrlHierarchyDocument:{
                country: this.lang.prefix_lang+'vacancy/',
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
                            // show city select
                            $("span[data-select2-id='5']").css('display', "block")
                            this.objLocations.load_cities = res.data.message
                            console.log(this.objLocations.load_cities)
                        }
                        else{
                            this.clearLocation2('load_cities')
                            // hide city select
                            $("span[data-select2-id='5']").css('display', "none")
                            // грузим страницу с регионов
                            location.href = this.urlPathname()+"/"+this.objLocations.region_original_index
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
        viewSelectCountry() {
            // hide display country
            $(".one-select").css('display', "none")
            $(".two-select").css('display', "none")
            // show select country
            $("span[data-select2-id='1']").css('display', "block")
            // open select country
            setTimeout(() => {
                $('#country-title-panel').select2('open')
            }, 100);
        },
        // click по display city
        viewSelectCity() {
            // hide display city
            $(".two-select").css('display', "none")
            // show select city
            $("span[data-select2-id='3']").css('display', "block")
            // open select region или city
            setTimeout(() => {
                if(this.respond.now_region !== null){
                    $('#region-title-panel').select2('open')
                }
            }, 100);
        },
        // события select у select2
        eventChangeSelectCountry(){
            this.urlPrefixElements = this.urlPathname().split('/')

            // страна blur
            $('#country-title-panel').on('select2:close', (e) => {
                // только если есть что показать в стране
                if(this.objLocations.country_translate !== null){
                    // show display country
                    $(".one-select").css('display', "inherit")
                    if(this.objLocations.region_translate !== null){
                        // show display city
                        $(".two-select").css('display', "inherit")
                    }
                    // hide select country
                    $("span[data-select2-id='1']").css('display', "none")
                }
            })

            // страна change
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
                    // загрузка country с индекс page (/)
                    if(vacancy_index === -1){
                        location.href = this.objUrlHierarchyDocument.country+value
                    }
                    // загрузка country с показа всех вакансий (/vacancy)
                    else if(vacancy_index !== -1 && vacancy_index === (this.urlPrefixElements.length-1)){
                        location.href = this.objUrlHierarchyDocument.country+value
                    }
                    // загрузка country page сменяя другую страну (/vacancy/andorra)
                    else if(vacancy_index !== -1 && vacancy_index+1 === (this.urlPrefixElements.length-1)){
                        location.href = this.objUrlHierarchyDocument.country+value
                    }
                    // загрузка country page сменяя другую страну и затирая city (/vacancy/andorra/andorra-la-vella)
                    else if(vacancy_index !== -1 && vacancy_index+2 === (this.urlPrefixElements.length-1)){
                        location.href = this.objUrlHierarchyDocument.country+value
                    }
                }
            })
        },
        // события select у select2
        eventChangeSelectRegion(){
            this.urlPrefixElements = this.urlPathname().split('/')

            // регион blur
            $('#region-title-panel').on('select2:close', (e) => {
                // только если есть что показать в display city
                if(this.objLocations.region_translate !== null){
                    // show display region
                    $(".two-select").css('display', "inherit")
                    // hide select country
                    $("span[data-select2-id='3']").css('display', "none")
                }
            })

            // регион change
            $('#region-title-panel').on('select2:select', (e) => {
                let arr = e.params.data.id.split(',')
                this.objLocations.region = arr[0]
                this.objLocations.region_original_index = arr[1]
                this.clearLocation2('load_cities')

                if(arr[0] == ""){
                    $("span[data-select2-id='3']").addClass('not-select')
                    $("span[data-select2-id='5']").css('display', "none")
                }
                else{
                    $("span[data-select2-id='3']").removeClass('not-select')
                    // показ select city
                    this.loadCity2();
                }
            })
        },
        // события select у select2
        eventChangeSelectCity(){
            this.urlPrefixElements = this.urlPathname().split('/')

            // город change
            $('#city-title-panel').on('select2:select', (e) => {
                let value = e.params.data.id
                this.objLocations.city = value

                if(value == ""){
                    $("span[data-select2-id='5']").addClass('not-select')
                }
                else{
                    $("span[data-select2-id='5']").removeClass('not-select')
                }
            })
        },
        initializeData2(){
            // вставка поиска названия из url в input search
            this.searchPositionInUrl2();
            // события select у select2
            this.eventChangeSelectCountry()
            this.eventChangeSelectRegion()
            this.eventChangeSelectCity()

            setTimeout(() => {
                // show обвертка select
                $(".box-select").css('display', "flex")
                // страны
                // $("span[data-select2-id='1']").addClass('not-select')
                // // регионы
                // $("span[data-select2-id='3']").css('display', "none").addClass('not-select')
                // // города
                // $("span[data-select2-id='5']").css('display', "none").addClass('not-select')

                // выбрана страна
                if(this.respond.now_country !== null){

                    // установить в country select выбранную страну
                    $('#country-title-panel').val(this.respond.now_country.original_index).trigger("change")
                    // показать display country
                    $(".one-select").css('display', "inherit")
                    this.objLocations.country_translate = this.respond.now_country.translate

                    // регион не выбран
                    if(this.respond.now_region === null){
                        // показать select region
                        $("span[data-select2-id='3']").css('display', "inherit").addClass('not-select')
                        this.objLocations.country = this.respond.now_country.prefix.toLowerCase()
                    }
                    // выбран регион
                    if(this.respond.now_region !== null){
                        // установить в region select выбранный регион
                        $('#region-title-panel').val(this.respond.now_region.code_region+","+this.respond.now_region.original_index).trigger("change")
                        // показать display city
                        $(".two-select").css('display', "inherit")
                        this.objLocations.region_translate = this.respond.now_region.translate
                    }
                }

            }, 500);
        },
    },
    mounted() {
        this.$nextTick(function () {
            this.initializeData2();
        })
    },
}

