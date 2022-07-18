export default {
    data() {
        return {
            objLocations: {
                load_countries:null,
                load_regions:null,
                load_cities:null,
                bool_rest_address:null, // показ Остальной адрес
                country: null,
                region: null,
                city: null,
                rest_address: null
            },
            objCategory: {
                categories: [],
                categoriesArray: '',
                boolChecked: false,
            },
        }
    },
    methods: {
        async loadRegions(){
            let data = {
                country_code: this.objLocations.country,
                lang_local: this.lang.lang_local,
            };
            const response = await this.$http.post(`/localisation/get-region`, data)
                .then(res => {
                    if(this.checkSuccess(res)){
                        this.objLocations.load_regions = res.data.message
                    }
                    // custom ошибки
                    else{
                        this.objLocations.bool_rest_address = true
                    }
                    this.clearLocation('load_region')
                })
                // ошибки сервера
                .catch(err => {
                    this.messageError(err)
                })
        },
        async loadCity(){
            let data = {
                country_code: this.objLocations.country,
                region_code: ''+this.objLocations.region,
                lang_local: this.lang.lang_local,
            };
            const response = await this.$http.post(`/localisation/get-city`, data)
                .then(res => {
                    if(this.checkSuccess(res)){
                        if(res.data.message !== null){
                            this.objLocations.load_cities = res.data.message
                        }
                        else{
                            this.clearLocation('load_cities')
                            this.objLocations.bool_rest_address = true
                        }
                    }
                    // custom ошибки
                    else{
                        this.clearLocation('load_cities')
                        this.objLocations.bool_rest_address = true
                    }
                })
                // ошибки сервера
                .catch(err => {
                    this.messageError(err)
                })
        },
        changeSelect(value, name){
            if(name == 'region'){
                this.objLocations.region = value
                this.clearLocation('load_cities')
                this.loadCity();
            }
            else if(name == 'city'){
                this.objLocations.city = value
                this.objLocations.bool_rest_address = true
            }
            else if(name == 'employment'){
                this.index_employment = value
            }
        },
        clearLocation(value) {
            switch (value) {
                case 'load_cities':
                    this.objLocations.load_cities = null
                    break;
                case 'bool_rest':
                    this.objLocations.bool_rest_address = null
                    this.objLocations.city = null
                    break;
                case 'load_region':
                    this.objLocations.bool_rest_address = null
                    this.objLocations.load_cities = null
                    break;
                default:
                    this.objLocations.country = null
                    this.objLocations.region = null
                    this.objLocations.city = null
                    this.objLocations.bool_rest_address = null
                    this.objLocations.load_regions = null
                    this.objLocations.load_cities = null
            }
        },
        // конвертация строки
        salaryLineToEmpty() {
            this.objSalary.from = (isNaN(parseInt(this.objSalary.from)) || parseInt(this.objSalary.from) == 0) ? null : this.objSalary.from

            this.objSalary.to = (isNaN(parseInt(this.objSalary.to)) || parseInt(this.objSalary.to) == 0) ? null : this.objSalary.to
        },
        // разбить масив категорий на несколько
        createArrayCategories(){
            let count = 15
            let tick = 0
            this.objCategory.categoriesArray = [];
            this.settings.categories.forEach((value, index) => {
                // дележка на массивы
                if((index % count) == 0){
                    this.objCategory.categoriesArray[tick] = [];
                    tick++
                }
                this.objCategory.categoriesArray[(tick-1)].push([index, value]);
            });
        },
        checkCategory(){
            this.objCategory.boolChecked = true;
            let checked = document.querySelectorAll('[name="category"]:checked');
            let selected = [];
            for (let i=0; i<checked.length; i++) {
                selected.push(parseInt(checked[i].value));
            }
            this.objCategory.categories = selected;
        },
        returnTargetLocalisation(data, value, prefix){
            let obj = null
            if(data !== null){
                for (let key in data) {
                    if(data[key][prefix] == value){
                        obj = data[key]
                    }
                }
            }

            return obj
        },
    },
    mounted() {

        // страна
        $('#country').on('select2:select', (e) => {
            this.clearLocation()
            // выбрано "Выбрать"
            if(e.params.data.id == ''){
                return false
            }

            this.objLocations.country = e.params.data.id
            this.loadRegions();
        })
    },

}
