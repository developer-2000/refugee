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
                region_code: ''+this.objLocations.region,
            };
            const response = await this.$http.post(`/localisation/get-city`, data)
                .then(res => {
                    if(this.checkSuccess(res)){
                        this.clearLocation('bool_rest')
                        this.objLocations.load_cities = res.data.message
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
                this.loadCity();
            }
            else if(name == 'city'){
                this.objLocations.city = value
                this.objLocations.bool_rest_address = true
            }
            else if(name == 'search_city'){
                this.objCity.search_city = value
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
        checkingInteger(value) {
            if(parseInt(value) >= 0){
                return true;
            }
            return false;
        },
    },
    mounted() {

        // страна
        $('#country').on('select2:select', (e) => {
            this.clearLocation()
            this.objLocations.country = e.params.data.id
            this.loadRegions();
        })
    },

}
