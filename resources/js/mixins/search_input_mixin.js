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
                start_vacancy: this.lang.prefix_lang+'vacancy/',
            },
            urlPrefixElements: [],
            bool_open_region: false,
            bool_open_city: false,
            _selectCountry: {},
            _selectRegion: {},
            _selectCity: {},
        }
    },
    methods: {
        async loadCity2(){
            let data = {
                country_code: this.objLocations.country,
                region_code: ''+this.objLocations.region,
                lang_local: this.lang.lang_local,
            };
            // return false
            const response = await this.$http.post(`/localisation/get-city`, data)
                .then(res => {
                    if(this.checkSuccess(res)){
                        // у региона есть города
                        if(res.data.message !== null){
                            // show city select
                            this._selectCity.css('display', "block").addClass('not-select')
                            this.objLocations.load_cities = res.data.message
                        }
                        else{
                            this.clearLocation2('load_cities')
                            // hide city select
                            this._selectCity.css('display', "none")
                            // грузим страницу регионов
                            this.constructionLogicUrl(this.objLocations.region_original_index, "city")
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
            this._selectRegion.css('display', "none")
            this._selectCity.css('display', "none")

            // show select country
            this._selectCountry.css('display', "block")
            // open select country
            setTimeout(() => {
                $('#country-title-panel').select2('open')
            }, 100);
        },
        // click по display city
        viewSelectCity() {
            // hide display city
            $(".two-select").css('display', "none")
            // show select region
            this._selectRegion.css('display', "block")
            // show select city
            this._selectCity.css('display', "block")

            if(this.respond.now_city !== null){
                setTimeout(() => {
                    $('#city-title-panel').select2('open')
                }, 100);
            }
            else{
                setTimeout(() => {
                    if(this.respond.now_region !== null){
                        $('#region-title-panel').select2('open')
                    }
                }, 100);
            }
        },
        constructionLogicUrl(original_index, prefix_name){
            this.urlPrefixElements = this.urlPathname().split('/')
            let vacancy_index = this.urlPrefixElements.indexOf('vacancy')
            // масив после префикса - vacancy
            if(vacancy_index !== -1){
                this.urlPrefixElements.splice(0, vacancy_index+1)
            }

            if(prefix_name === "country"){
                // загрузка с индекс page (/)
                if(vacancy_index === -1 ){
                    location.href = this.objUrlHierarchyDocument.start_vacancy+original_index
                }
                else{
                    // загрузка с показа всех вакансий (/vacancy)
                    if(this.urlPrefixElements.length === 0){
                        location.href = this.objUrlHierarchyDocument.start_vacancy+original_index
                    }
                    // загрузка сменяя другую страну (/vacancy/andorra)
                    else if(this.urlPrefixElements.length === 1 || this.urlPrefixElements.length === 2){
                        location.href = this.objUrlHierarchyDocument.start_vacancy+original_index
                    }
                }
            }
            else {
                // загрузка добавляя регион или город (/vacancy/andorra)
                if (this.urlPrefixElements.length === 1 || this.urlPrefixElements.length === 2) {
                    location.href = this.objUrlHierarchyDocument.start_vacancy+this.urlPrefixElements[0]+"/"+original_index
                }
            }
        },
        // события select у select2
        eventChangeSelectCountry(){

            // страна blur
            $('#country-title-panel').on('select2:close', (e) => {
                let value = e.target.value

                setTimeout(() => {
                    // если в стране не выбран - "Страна поиска"
                    if(value !== ""){
                        // только если есть что показать в стране
                        if(this.objLocations.country_translate !== null){
                            // show display country
                            $(".one-select").css('display', "inherit")

                            if(this.objLocations.region_translate !== null){
                                // show display city
                                $(".two-select").css('display', "inherit")
                            }
                            // hide select country
                            this._selectCountry.css('display', "none")

                            if(this.respond.regions_country !== null && this.objLocations.region_translate == null){
                                // show select region
                                this._selectRegion.css('display', "block")
                            }

                        }
                    }
                }, 200);

            })

            // страна change
            $('#country-title-panel').on('select2:select', (e) => {
                let arr = e.params.data.id.split(',')
                let value = arr[0]
                // hide select city
                this._selectCity.css('display', "none")

                // не выбрано
                if(value == ''){
                    // добавить select country warning
                    this._selectCountry.addClass('not-select')
                    // hide select region
                    this._selectRegion.css('display', "none")
                    // загрузить все вакансии
                    location.href = this.objUrlHierarchyDocument.start_vacancy
                }
                // выбрано
                else{
                    this.objLocations.country_translate = arr[1]
                    this.constructionLogicUrl(value, "country")
                }
            })
        },
        // события select у select2
        eventChangeSelectRegion(){

            $('#region-title-panel').on('select2:open', (e) => {
                this.bool_open_region = true
            })

            // регион blur
            $('#region-title-panel').on('select2:close', (e) => {
                let value = e.target.value
                setTimeout(() => { this.bool_open_region = false }, 500);
                // если не выбран - "Регион посика"
                if(value !== ""){
                    // только если есть что показать в display city и не произведен клик по select sity
                    if(this.objLocations.region_translate !== null && !this.bool_open_city){
                        // show display region
                        $(".two-select").css('display', "inherit")
                        // hide select country
                        this._selectRegion.css('display', "none")
                        this._selectCity.css('display', "none")
                    }
                }
            })

            // регион change
            $('#region-title-panel').on('select2:select', (e) => {
                let arr = e.params.data.id.split(',')
                this.objLocations.region = arr[0]
                this.objLocations.region_original_index = arr[1]
                // this.clearLocation2('load_cities')

                if(arr[0] == ""){
                    // добавить select region warning
                    this._selectRegion.addClass('not-select')
                    // hide select city
                    this._selectCity.css('display', "none")
                    // только если регионы являлись вместо city и не был открыт выбор городов
                    if(this.respond.now_region !== null){
                        // загрузить со страны
                        location.href = this.objUrlHierarchyDocument.start_vacancy+this.respond.now_country.original_index
                    }
                }
                else{
                    this._selectRegion.removeClass('not-select')
                    this.objLocations.region_translate = arr[2]
                    // show city select
                    this._selectCity.css('display', "none")

                    // если регионы не выбраны изначально ИЛИ выбраны но происходит переход на другой регион
                    if(this.respond.now_region === null || (this.respond.now_region !== null && this.respond.now_region.code_region != arr[0])){
                        this.loadCity2()
                    }
                }
            })
        },
        // события select у select2
        eventChangeSelectCity(){

            $('#city-title-panel').on('select2:open', (e) => {
                this.bool_open_city = true
            })

            // город blur
            $('#city-title-panel').on('select2:close', (e) => {
                let value = e.target.value
                setTimeout(() => { this.bool_open_city = false }, 500);

                // только если есть что показать в display city и не произведен клик по select region
                if(this.objLocations.region_translate !== null && !this.bool_open_region){
                    // show display region
                    $(".two-select").css('display', "inherit")
                    // hide select country
                    this._selectRegion.css('display', "none")
                    this._selectCity.css('display', "none")
                }
            })

            // город change
            $('#city-title-panel').on('select2:select', (e) => {
                let arr = e.params.data.id.split(',')
                // this.objLocations.city = value

                if(arr[0] == ""){
                    this._selectCity.addClass('not-select')
                    // загрузить с региона
                    // location.href = this.objUrlHierarchyDocument.start_vacancy+this.respond.now_region.original_index
                    this.constructionLogicUrl(this.respond.now_country.original_index, "country")
                }
                else{
                    this._selectCity.removeClass('not-select')
                    this.objLocations.region_translate = arr[1]
                    this.constructionLogicUrl(arr[0], "city")
                }
            })
        },
        initializeData2(){
            this.objLocations.load_cities = this.respond.cities_region
            // вставка поиска названия из url в input search
            this.searchPositionInUrl2();
            // события select у select2
            this.eventChangeSelectCountry()
            this.eventChangeSelectRegion()
            this.eventChangeSelectCity()

            setTimeout(() => {
                // show обвертка select
                $(".box-select").css('display', "flex")

                // 1 выбрана страна
                if(this.respond.now_country !== null){
                    // установить в country select выбранную страну
                    $('#country-title-panel').val(this.respond.now_country.original_index+","+this.respond.now_country.translate).trigger("change")
                    // показать display country
                    $(".one-select").css('display', "inherit")
                    this.objLocations.country_translate = this.respond.now_country.translate
                    this.objLocations.country = this.respond.now_country.prefix.toLowerCase()
                }
                else{
                    // показать select country
                    this._selectCountry.css('display', "inherit").addClass('not-select')
                }

                // 2 регион не выбран
                if(this.respond.now_region === null){
                    if(this.respond.now_country !== null){
                        // показать select region
                        this._selectRegion.css('display', "inherit").addClass('not-select')
                    }
                }
                // выбран регион
                else{
                    // установить в region select выбранный регион
                    $('#region-title-panel').val( this.respond.now_region.code_region+","+this.respond.now_region.original_index+","+this.respond.now_region.translate ).trigger("change")
                    // показать display city
                    $(".two-select").css('display', "inherit")
                    this.objLocations.region_translate = this.respond.now_region.translate
                }

                // 3 город выбран
                if(this.respond.now_city !== null){
                    // установить в city select выбранный город
                    $('#city-title-panel').val(this.respond.now_city.original_index+","+this.respond.now_city.translate).trigger("change")
                    $(".two-select").css('display', "inherit")
                    this.objLocations.region_translate = this.respond.now_city.translate
                }
            }, 300);

        },
    },
    mounted() {
        this.$nextTick( () => {
            setTimeout(() => {
                this._selectCountry = $("span[data-select2-id='1']")
                this._selectRegion = $("span[data-select2-id='3']")
                this._selectCity = $("span[data-select2-id='5']")
                this.initializeData2();
            }, 300);

        })
    },
}

