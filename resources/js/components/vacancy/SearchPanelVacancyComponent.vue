<template>
    <div class="box-search">
        <!-- сбросить все-->
        <a v-if="locationSearch != ''"
            class="but-reset-all"
            :href="`${lang.prefix_lang}vacancy`">
            {{trans('vacancies','reset_all')}}
        </a>

        <!-- Location card-primary -->
        <div class="card"
             :class="{'collapsed-card': !objLocations.country}"
        >
            <!-- header -->
            <div class="card-header" id="card-location"
                 :class="{'card-header-active': objLocations.country}"
            >
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            data-id="card-location"
                            @click="changeCardStatus($event)"
                    >
                        <h3 class="card-title">
                            {{trans('vacancies','location')}}
                        </h3>
                        <template v-if="!objLocations.country"><i class="fas fa-plus"></i></template>
                        <template v-else><i class="fas fa-minus"></i></template>
                    </button>
                </div>
            </div>
            <!-- body -->
            <div class="card-body">
                <div class="form-group location-grope">
                    <!-- Country -->
                    <div class="box-div">
                        <label for="country">
                            {{trans('vacancies','search_country')}}
                        </label>
                        <select class="form-control select2" id="country">
                            <option :value="null" selected>
                                {{trans('vacancies','select')}}
                            </option>
                            <template v-for="(array, key) in settings.obj_countries">
                                <!-- в случае обновления страницы -->
                                <template v-if="objLocations.country == array.code" >
                                    <option :value="array.code" :key="key" selected>{{array.name}}</option>
                                </template>
                                <template v-else>
                                    <option :value="array.code" :key="key">{{array.name}}</option>
                                </template>
                            </template>
                        </select>
                    </div>
                    <!-- Region -->
                    <div class="box-div" v-show="objLocations.load_regions">
                        <label for="region">
                            {{trans('vacancies','search_region')}}
                        </label>
                        <select class="form-control select2" id="region">
                            <option :value="null" selected>
                                {{trans('vacancies','select')}}
                            </option>
                            <template v-for="(array, key) in objLocations.load_regions">
                                <!-- в случае обновления страницы -->
                                <template v-if="objLocations.region == array.code" >
                                    <option :value="array.code" :key="key" selected>{{array.name}}</option>
                                </template>
                                <template v-else>
                                    <option :value="array.code" :key="key">{{array.name}}</option>
                                </template>
                            </template>
                        </select>
                    </div>
                    <!-- City -->
                    <div class="box-div" v-show="objLocations.load_cities != null">
                        <label for="city">
                            {{trans('vacancies','search_city')}}
                        </label>
                        <select class="form-control select2" id="city">
                            <option :value="null" selected>
                                {{trans('vacancies','select')}}
                            </option>
                            <template v-for="(array, key) in objLocations.load_cities">
                                <!-- в случае обновления страницы -->
                                <template v-if="objLocations.city == array.code" >
                                    <option :value="array.code" :key="key" selected>{{array.name}}</option>
                                </template>
                                <template v-else>
                                    <option :value="array.code" :key="key">{{array.name}}</option>
                                </template>
                            </template>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories -->
        <div class="card"
             :class="{'collapsed-card': !objCategory.categories.length}"
        >
            <!-- header -->
            <div class="card-header" id="card-categories"
                 :class="{'card-header-active': objCategory.categories.length}">
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            data-id="card-categories"
                            @click="changeCardStatus($event)"
                    >
                        <h3 class="card-title">
                            {{trans('vacancies','categories')}}
                        </h3>
                        <template v-if="!objCategory.categories.length"><i class="fas fa-plus"></i></template>
                        <template v-else><i class="fas fa-minus"></i></template>
                    </button>
                </div>
            </div>
            <!-- body -->
            <div class="card-body">
                <div class="form-group">
                    <select class="form-control select2" id="categories" multiple="multiple"
                            :data-placeholder="trans('vacancies','select')"
                    >
                        <template v-for="(value, index) in settings.categories">
                            <!-- в случае обновления страницы -->
                            <template v-if="objCategory.categories.indexOf(index) !== -1" >
                                <option :value="index" :key="index" selected>
                                    {{trans('vacancies',value)}}
                                </option>
                            </template>
                            <template v-else>
                                <option :value="index" :key="index">
                                    {{trans('vacancies',value)}}
                                </option>
                            </template>
                        </template>
                    </select>
                </div>
            </div>
        </div>

        <!-- Salary -->
        <div class="card salary"
             :class="{'collapsed-card': !objSalary.check}"
        >
            <!-- header -->
            <div class="card-header" id="card-salary"
                 :class="{'card-header-active': objSalary.check}"
            >
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            data-id="card-salary"
                            @click="changeCardStatus($event)"
                    >
                        <h3 class="card-title">
                            {{trans('vacancies','salary')}}
                        </h3>
                        <template v-if="!objSalary.check"><i class="fas fa-plus"></i></template>
                        <template v-else><i class="fas fa-minus"></i></template>
                    </button>
                </div>
            </div>
            <!-- body -->
            <div class="card-body">
                <div class="form-group">
                    <!-- 1 -->
                    <div class="checkbox-box">
                        <input class="form-check-input" id="salary_checkbox" type="checkbox"
                               @change="checkSalary(true, 'check')"
                               v-model="objSalary.without_salary_checkbox"
                        >
                        <label for="salary_checkbox" class="target-label">
                            {{trans('vacancies','with_unspecified_salary')}}
                        </label>
                    </div>
                    <!-- 2 -->
                    <label for="salary">
                        {{UpperCaseFirstCharacter(trans('vacancies','euro_per_month'))}}
                    </label>
                    <div class="box-suitable" id="salary">
                        <input :placeholder="`${trans('vacancies','from')}`"
                               type="number" min="0" max="100000000"
                               v-model="objSalary.from"
                               :disabled="objSalary.without_salary_checkbox ? true : false"
                        >
                        <span>-</span>
                        <input :placeholder="`${trans('vacancies','to')}`"
                               max="100000000" min="0" type="number"
                               v-model="objSalary.to"
                               :disabled="objSalary.without_salary_checkbox ? true : false"
                        >
                        <!-- check -->
                        <svg type="button" class="svg-button svg-button-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                             @click="checkSalary(true)"
                             v-if="!objSalary.without_salary_checkbox"
                        >
                            <path d="M243.8 339.8C232.9 350.7 215.1 350.7 204.2 339.8L140.2 275.8C129.3 264.9 129.3 247.1 140.2 236.2C151.1 225.3 168.9 225.3 179.8 236.2L224 280.4L332.2 172.2C343.1 161.3 360.9 161.3 371.8 172.2C382.7 183.1 382.7 200.9 371.8 211.8L243.8 339.8zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                        </svg>
                        <!-- clear -->
                        <svg type="button" class="svg-button svg-button-clear" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                             @click="checkSalary(false)"
                             v-if="!objSalary.without_salary_checkbox"
                        >
                            <path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256 256-114.6 256-256S397.4 0 256 0zM48 256c0-48.71 16.95-93.47 45.11-128.1l291.9 291.9C349.5 447 304.7 464 256 464c-114.7 0-208-93.3-208-208zm370.9 128.1L127 93.11C162.5 64.95 207.3 48 256 48c114.7 0 208 93.31 208 208 0 48.7-17 93.5-45.1 128.1z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Language -->
        <div class="card"
             :class="{'collapsed-card': !arrLanguages.length}"
        >
            <!-- header -->
            <div class="card-header" id="card-language"
                 :class="{'card-header-active': arrLanguages.length}"
            >
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            data-id="card-language"
                            @click="changeCardStatus($event)"
                    >
                        <h3 class="card-title">
                            {{trans('vacancies','language')}}
                        </h3>
                        <template v-if="!arrLanguages.length"><i class="fas fa-plus"></i></template>
                        <template v-else><i class="fas fa-minus"></i></template>
                    </button>
                </div>
            </div>
            <!-- body -->
            <div class="card-body">
                <div class="form-group">
                    <select class="form-control select2" id="languages" multiple="multiple"
                            :data-placeholder="trans('vacancies','select')"
                    >
                        <template v-for="(obj, index) in lang.lang">
                            <!-- в случае редиктирования -->
                            <template v-if="arrLanguages.indexOf(index) !== -1" >
                                <option :value="index" :key="index" selected>{{obj.title}}</option>
                            </template>
                            <template v-else>
                                <option :value="index" :key="index">{{obj.title}}</option>
                            </template>
                        </template>
                    </select>
                </div>
            </div>
        </div>

        <!-- Employment -->
        <div class="card"
             :class="{'collapsed-card': !index_employment}"
        >
            <!-- header -->
            <div class="card-header" id="card-employment"
                 :class="{'card-header-active': index_employment}"
            >
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            data-id="card-employment"
                            @click="changeCardStatus($event)"
                    >
                        <h3 class="card-title">
                            {{trans('vacancies','type_employment')}}
                        </h3>
                        <template v-if="!index_employment"><i class="fas fa-plus"></i></template>
                        <template v-else><i class="fas fa-minus"></i></template>
                    </button>
                </div>
            </div>
            <!-- body -->
            <div class="card-body">
                <div class="form-group">
                    <select class="form-control" id="employment"
                            @change="changeEmployment($event.target.value)"
                    >
                        <option :value="null" selected>
                            {{trans('vacancies','select')}}
                        </option>
                        <template v-for="(value, key) in settings.type_employment">
                            <!-- в случае обновления страницы -->
                            <template v-if="key == index_employment" >
                                <option :value="key" :key="key" selected>
                                    {{trans('vacancies',value)}}
                                </option>
                            </template>
                            <template v-else>
                                <option :value="key" :key="key">
                                    {{trans('vacancies',value)}}
                                </option>
                            </template>
                        </template>
                    </select>
                </div>
            </div>
        </div>

        <!-- Experience -->
        <div class="card"
             :class="{'collapsed-card': !experience}"
        >
            <!-- header -->
            <div class="card-header" id="card-experience"
                 :class="{'card-header-active': experience}"
            >
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            data-id="card-experience"
                            @click="changeCardStatus($event)"
                    >
                        <h3 class="card-title">{{trans('vacancies','work_experience')}}</h3>
                        <template v-if="!experience"><i class="fas fa-plus"></i></template>
                        <template v-else><i class="fas fa-minus"></i></template>
                    </button>
                </div>
            </div>
            <!-- body -->
            <div class="card-body">
                <div class="form-group">
                    <select class="form-control"
                            @change="changeExperience($event.target.value)"
                    >
                        <option :value="null" selected>
                            {{trans('vacancies','select')}}
                        </option>
                        <template v-for="(value, key) in this.settings.work_experience">
                            <!-- в случае обновления страницы -->
                            <template v-if="key == experience" >
                                <option :value="key" selected>
                                    {{trans('vacancies',value)}}
                                </option>
                            </template>
                            <template v-else>
                                <option :value="key">
                                    {{trans('vacancies',value)}}
                                </option>
                            </template>
                        </template>
                    </select>
                </div>
            </div>
        </div>

        <!-- Suitable -->
        <div class="card"
             :class="{'collapsed-card': !objCheckSuitable.check}"
        >
            <!-- header -->
            <div class="card-header" id="card-suitable"
                 :class="{'card-header-active': objCheckSuitable.check}"
            >
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            data-id="card-suitable"
                            @click="changeCardStatus($event)"
                    >
                        <h3 class="card-title">
                            {{trans('vacancies','applicant_age')}}
                        </h3>
                        <template v-if="!objCheckSuitable.check"><i class="fas fa-plus"></i></template>
                        <template v-else><i class="fas fa-minus"></i></template>
                    </button>
                </div>
            </div>
            <!-- body -->
            <div class="card-body">
                <div class="form-group">
                    <label for="suitable">
                        {{trans('vacancies','years_age')}}
                    </label>
                    <div id="suitable" class="box-suitable">
                        <input :placeholder="`${trans('vacancies','from')}`"
                               max="100" min="0" type="number"
                               v-model="objCheckSuitable.suitable_from"
                        >
                        <span>-</span>
                        <input :placeholder="`${trans('vacancies','to')}`"
                               max="150" min="0" type="number"
                               v-model="objCheckSuitable.suitable_to"
                        >
                        <!-- check -->
                        <svg type="button" class="svg-button svg-button-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                             @click="checkSuitable(true)"
                        >
                            <path d="M243.8 339.8C232.9 350.7 215.1 350.7 204.2 339.8L140.2 275.8C129.3 264.9 129.3 247.1 140.2 236.2C151.1 225.3 168.9 225.3 179.8 236.2L224 280.4L332.2 172.2C343.1 161.3 360.9 161.3 371.8 172.2C382.7 183.1 382.7 200.9 371.8 211.8L243.8 339.8zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                        </svg>
                        <!-- clear -->
                        <svg type="button" class="svg-button svg-button-clear" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                             @click="checkSuitable(false)"
                        >
                            <path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256 256-114.6 256-256S397.4 0 256 0zM48 256c0-48.71 16.95-93.47 45.11-128.1l291.9 291.9C349.5 447 304.7 464 256 464c-114.7 0-208-93.3-208-208zm370.9 128.1L127 93.11C162.5 64.95 207.3 48 256 48c114.7 0 208 93.31 208 208 0 48.7-17 93.5-45.1 128.1z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Education -->
        <div class="card"
             :class="{'collapsed-card': !education}"
        >
            <!-- header -->
            <div class="card-header" id="card-education"
                 :class="{'card-header-active': education}"
            >
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            data-id="card-education"
                            @click="changeCardStatus($event)"
                    >
                        <h3 class="card-title">{{trans('vacancies','education_1')}}</h3>
                        <template v-if="!education"><i class="fas fa-plus"></i></template>
                        <template v-else><i class="fas fa-minus"></i></template>
                    </button>
                </div>
            </div>
            <!-- body -->
            <div class="card-body">
                <div class="form-group">
                    <select class="form-control"
                            @change="changeEducation($event.target.value)"
                    >
                        <option :value="null" selected>
                            {{trans('vacancies','select')}}
                        </option>
                        <template v-for="(value, key) in this.settings.education">
                            <!-- в случае обновления страницы -->
                            <template v-if="key == education" >
                                <option :value="key" selected>
                                    {{trans('vacancies',value)}}
                                </option>
                            </template>
                            <template v-else>
                                <option :value="key">
                                    {{trans('vacancies',value)}}
                                </option>
                            </template>
                        </template>
                    </select>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import localisation_functions_mixin from '../../mixins/localisation_functions_mixin'
    import general_functions_mixin from "../../mixins/general_functions_mixin.js";
    import translation from '../../mixins/translation'
    import response_methods_mixin from "../../mixins/response_methods_mixin";

    export default {
        mixins: [
            localisation_functions_mixin,
            translation,
            response_methods_mixin,
            general_functions_mixin
        ],
        data() {
            return {
                timerId: 1,
                locationSearch: window.location.search,
                objSalary: {
                    // переключатель поиска и отмены у 2 типов - checkbox и кнопки
                    check: false,
                    // искать по checkbox - true по нему, false по цифрам
                    without_salary_checkbox: false,
                    from: 0,
                    to: 99999,
                },
                objCheckSuitable:{
                    check:false,
                    suitable_from: 18,
                    suitable_to: 60,
                },
                index_employment: null,
                experience: null,
                education: null,
                arrLanguages:[],
            }
        },
        methods: {
            // переключение стиля card header
            changeCardStatus(e){
                let str_id = $(e.currentTarget).attr("data-id")
                let header_elem = $("#"+str_id)
                if (! header_elem.hasClass("card-header-active") ) {
                    header_elem.addClass( "card-header-active" )
                }
                else{
                    header_elem.removeClass( "card-header-active" )
                }
            },
            returnParent(obj) {
                this.$emit('returnParent', obj)
            },
            setReturnParent() {
                this.returnParent({
                    region: this.objLocations.region,
                    country: this.objLocations.country,
                    city: this.objLocations.city,
                    categories: this.objCategory.categories,
                    languages: this.arrLanguages,
                    suitable: this.objCheckSuitable,
                    employment: this.index_employment,
                    salary: this.objSalary,
                    experience: this.experience,
                    education: this.education,
                })
            },
            eventSelect2(){
                // categories
                $('#categories').on('select2:select', (e) => {
                    this.objCategory.categories.push( parseInt(e.params.data.id) );
                    this.setReturnParent()
                })
                $('#categories').on("select2:unselect", (e) => {
                    // удалить этот елемент
                    this.objCategory.categories.splice(this.objCategory.categories.indexOf( parseInt(e.params.data.id) ), 1)
                    this.setReturnParent()
                    // отключить раскрытие после удаления
                    if (!e.params.originalEvent) {
                        return;
                    }

                    e.params.originalEvent.stopPropagation();
                });
                // languages
                $('#languages').on('select2:select', (e) => {
                    this.arrLanguages.push( parseInt(e.params.data.id) );
                    this.setReturnParent()
                })
                $('#languages').on("select2:unselect", (e) => {
                    // удалить этот елемент
                    this.arrLanguages.splice(this.arrLanguages.indexOf( parseInt(e.params.data.id) ), 1)
                    this.setReturnParent()
                    // отключить раскрытие после удаления
                    if (!e.params.originalEvent) {
                        return;
                    }

                    e.params.originalEvent.stopPropagation();
                });
                // страна
                $('#country').on('select2:select', (e) => {
                    this.setReturnParent()
                })
                // region
                $('#region').on('select2:select', (e) => {
                    // выбрано "Выбрать"
                    if(e.params.data.id == ''){
                        this.objLocations.region = null
                    }
                    else{
                        this.objLocations.region = e.params.data.id
                    }
                    this.objLocations.city = null
                    this.setReturnParent()
                })
                // city
                $('#city').on('select2:select', (e) => {
                    // выбрано "Выбрать"
                    if(e.params.data.id == ''){
                        this.objLocations.city = null
                    }
                    else{
                        this.objLocations.city = e.params.data.id
                    }
                    this.setReturnParent()
                })
            },
            changeEmployment(value){
                this.index_employment = value
                this.setReturnParent()
            },
            changeExperience(value){
                this.experience = value
                this.setReturnParent()
            },
            changeEducation(value){
                this.education = value
                this.setReturnParent()
            },
            checkSuitable(bool) {
                if(!this.checkingInteger(this.objCheckSuitable.suitable_from)){
                    this.objCheckSuitable.suitable_from = 0
                }
                else if(!this.checkingInteger(this.objCheckSuitable.suitable_to)){
                    this.objCheckSuitable.suitable_to = 0
                }

                this.objCheckSuitable.check = bool
                this.setReturnParent()
            },
            checkSalary(bool, caller=null) {
                this.objSalary.from = isNaN(parseInt(this.objSalary.from)) ? 0 : this.objSalary.from
                this.objSalary.to = isNaN(parseInt(this.objSalary.to)) ? 99999 : this.objSalary.to

                // вызвал checkbox
                if(caller != null){
                    // поиск по - ЗП не указано
                    if(this.objSalary.without_salary_checkbox){
                        this.objSalary.check = true
                    }
                    // очистить поиск
                    else{
                        this.objSalary.check = false
                    }
                }
                // вызвал кнопки возраста
                else{
                    this.objSalary.check = bool
                }

                this.setReturnParent()
            },
            // после обновления страницы
            setValuesFields(){
                const params = new URLSearchParams(window.location.search)

                // Location
                this.objLocations.load_countries = this.settings.obj_countries
                if(params.has('country')){
                    this.objLocations.country = params.get('country')
                    this.loadRegions();
                }
                if(params.has('region')){
                    this.objLocations.region = params.get('region')
                    setTimeout(() => {
                        this.loadCity()
                    }, 1000);
                }
                if(params.has('city')){
                    this.objLocations.city = params.get('city')
                }
                if(params.has('categories')){
                    let arr = JSON.parse("[" + params.get('categories') + "]");
                    this.objCategory.categories = arr
                }
                if(params.has('languages')){
                    let arr = JSON.parse("[" + params.get('languages') + "]");
                    this.arrLanguages = arr
                }
                if(params.has('suitable')){
                    let arr = JSON.parse("[" + params.get('suitable') + "]");
                    this.objCheckSuitable.check = true
                    this.objCheckSuitable.suitable_from = (arr[0] != undefined) ? parseInt(arr[0]) : 0
                    this.objCheckSuitable.suitable_to = (arr[1] != undefined) ? parseInt(arr[1]) : 100
                }
                if(params.has('employment')){
                    this.index_employment = params.get('employment')
                }
                if(params.has('salary')){
                    let arr = JSON.parse("[" + params.get('salary') + "]");
                    this.objSalary.without_salary_checkbox = (arr[0] == undefined) ? false : (parseInt(arr[0]) === 0) ? false : true
                    this.objSalary.from = (arr[1] == undefined) ? 0 : (!Number.isInteger(parseInt(arr[1]))) ? 0 : parseInt(arr[1])
                    this.objSalary.to = (arr[2] == undefined) ? 99999 : (!Number.isInteger(parseInt(arr[2]))) ? 99999 : parseInt(arr[2])
                    this.objSalary.check = true
                }
                if(params.has('experience')){
                    this.experience = params.get('experience')
                }
                if(params.has('education')){
                    this.education = params.get('education')
                }
            },
        },
        props: [
            'lang',   // масив названий и url языка
            'settings'
        ],
        mounted() {
            this.eventSelect2()
            // Код, который будет запущен только после отрисовки всех представлений
            this.$nextTick(function () {
                this.setValuesFields()
            })
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .card-header > .card-tools {
        float: none;
        margin: 0;
    }
    .box-search{
        .card-header{
            padding: 8px 13px;
            border-radius: 0;
            border: 1px solid #2176bd;
            height: 50px;
            .card-tools{
                float: none;
                margin: 0;
                height: 100%;
                button{
                    height: 100%;
                    color: #2176bd;
                    position: static;
                    padding: 0;
                    margin: 0;
                    width: 100%;
                    display: flex;
                    flex-direction: row;
                    justify-content: space-between;
                    align-content: center;
                    align-items: center;
                    i{
                        color: #2176bd;
                    }
                    &:hover i{
                        color: #165a93;
                    }
                    h3{
                        margin: 0;
                    }
                }
            }
        }
        .card-header-active{
            border: none;
            background-color: #1d68a7;
            .card-tools{
                button{
                    color: #fff;
                    i{
                        color: rgba(255,255,255,.8);
                    }
                    &:hover i{
                        color: #fff;
                    }
                }
            }
        }
    }
    #suitable,
    #salary {
        display: flex;
        align-items: center;
        input {
            width: 83px;
            margin: 0 5px;
            &:nth-child(1) {
                margin-left: 0;
            }
        }
    }
    .svg-button{
        width: 25px;
        margin-left: 10px;
    }
    .svg-button-check{
        path{
            fill: #28a745;
        }
        &:hover{
            path{
                fill: #23923c;
            }
        }
    }
    .svg-button-clear{
        path{
            fill: #dc3545;
        }
        &:hover{
            path{
                fill: #ad2733;
            }
        }
    }
    .but-reset-all{
        width: 150px;
        text-align: center;
        display: block;
        margin: -25px auto 10px;
        font-size: 19px;
        color: #3490dc;
        text-decoration: none;
        border-bottom: 1px dashed #3490dc;
        line-height: 25px;
        &:hover{
            border-bottom: 1px dashed #0268bc;
            color: #0268bc;
        }
    }
    .form-group{
        margin: 0 0 4px 0;
    }
    .card{
        width: 100%;
        border: none;
        box-shadow: none;
        margin-bottom: 3px;
        .card-body{
            padding: 10px 12px 8px;
            border-left: 1px solid #c0ddfb;
            border-right: 1px solid #c0ddfb;
            border-bottom: 1px solid #c0ddfb;
        }
    }
    .checkbox-box {
        margin: 0;
        display: flex;
        label {
            cursor: pointer;
            margin: 0 0 0 6px;
        }
    }
    .box-div{
        margin-bottom: 10px;
    }
    .salary{
        .checkbox-box{
            margin-bottom: 10px;
        }
    }
    .target-label{
        color: $color-a-blue;
        font-weight: 500!important;
    }

</style>





























