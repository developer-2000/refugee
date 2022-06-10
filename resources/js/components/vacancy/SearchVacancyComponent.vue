<template>
    <div class="search-panel container">
        <h1 class="title_page">
            {{trans('vacancies','job_search')}}
        </h1>

        <!-- search line -->
        <div class="top-search">
            <div class="form-group">
                <div class="box-position">
                    <input type="text" class="form-control" maxlength="100" autocomplete="off"
                           :placeholder="trans('vacancies','search')"
                           v-model="position"
                           @keyup="searchPosition($event.target.value)"
                           @keydown="enterKey"
                    >
                    <!-- подсказка -->
                    <div class="block_position_list">
                        <div class="dropdown-menu" id="position_list">
                            <div class="dropdown-item"
                                 v-for="(value, key) in position_list" :key="key"
                                 @click="setValuePosition(value)"
                            >
                                {{value}}
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-block btn-primary"
                        @click="searchVacancies"
                >
                    {{trans('vacancies','search_2')}}
                </button>
            </div>
        </div>

        <div class="bottom-search">
            <!-- vacancies -->
            <div class="left-site">
                <!-- item -->
                <div class="box-vacancy"
                     v-for="(vacancy, key) in vacancies.data" :key="key"
                     :id="`v${key}`"
                     @click.prevent="transitionToVacancy(vacancy.alias)"
                >
                    <!-- лента -->
                    <div class="ribbon-wrapper">
                        <div class="ribbon euro-color">
                            <svg xmlns="http://www.w3.org/2000/svg" class="euro-star-icon" viewBox="0 0 576 512"><path d="m305.3 12.57 54.9 169.03h177.6c17.6 0 24.92 22.55 10.68 32.9L404.78 319l54.89 169.1c5.44 16.76-13.72 30.69-27.96 20.33L288 403.1 144.3 507.6c-14.24 10.36-33.4-3.577-27.96-20.33l54.89-169.1L27.53 214.5c-14.25-10.3-6.93-32.9 10.68-32.9h177.6L270.7 12.5c5.5-16.69 29.1-16.69 34.6.07z"/></svg>
                        </div>
                    </div>
                    <!-- vacancy -->
                    <vacancy_template
                        :vacancy="vacancy"
                        :settings="settings"
                        :lang="lang"
                        :page="'search'"
                    ></vacancy_template>

                    {{getDateDocumentString(vacancy.updated_at)}}


                    <!-- кнопки закладок вакансий -->
                    <bookmark_buttons
                        :lang="lang"
                        :vacancy="vacancy"
                        :user="user"
                        :which_button_show="'search_vacancy'"
                    ></bookmark_buttons>
                </div>

                <pagination
                    v-if="vacancies.last_page > 1"
                    :pagination="vacancies"
                    @paginate="searchVacancies"
                    :offset="1"
                >
                </pagination>
            </div>

            <!-- search panel -->
            <div class="right-site">
                <search_panel
                    :lang="lang"
                    :settings="settings"
                    @returnParent="getVacancies"
                ></search_panel>
            </div>
        </div>
    </div>
</template>

<script>
    jQuery(document).ready(function(){
        // let time = moment("2020-10-21 17:10:29").fromNow()

        // var now = new Date();
        // var utc = now.getTime() + (now.getTimezoneOffset() * 60000);
        // var startTime = new Date('2022-06-10 11:28:50')
        //
        //
        // var timeDiff = moment.duration(utc - startTime);
        //
        // var timeMessege = 'Время исследования: ' +
        //     timeDiff.years() + ' м ' +
        //     timeDiff.months() + ' м ' +
        //     timeDiff.days() + ' м ' +
        //     timeDiff.hours() + ' ч ' +
        //     timeDiff.minutes() + ' м ' +
        //     timeDiff.seconds() + ' с';
        //
        // console.log(timeMessege)

    });

    import pagination from "./details/PaginationComponent";
    import search_panel from './SearchPanelVacancyComponent.vue'
    import bookmark_buttons from './details/BookmarkButtonsVacancyComponent'
    import general_functions_mixin from "../../mixins/general_functions_mixin.js";
    import vacancy_template from "./details/VacancyTemplateComponent";
    import response_methods_mixin from "../../mixins/response_methods_mixin";
    import translation from "../../mixins/translation";

    export default {
        components: {
            'pagination': pagination,
            'search_panel': search_panel,
            'bookmark_buttons': bookmark_buttons,
            'vacancy_template': vacancy_template,
        },
        mixins: [
            general_functions_mixin,
            response_methods_mixin,
            translation,
        ],
        data() {
            return {
                position: '',
                position_list: [],
                description: 'Вакансія для фахівців-початківців з кібербезпеки, які хочуть брати участь у тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів⁠',
            }
        },
        methods: {
            getDateDocumentString(date){
                var now = new Date();
                var utc = now.getTime() + (now.getTimezoneOffset() * 60000);
                var startTime = new Date(date)
                // var startTime = new Date('2022-06-10 11:28:50')
                var timeDiff = moment.duration(utc - startTime);

                var timeMessege = 'Время исследования: ' +
                    timeDiff.years() + ' м ' +
                    timeDiff.months() + ' м ' +
                    timeDiff.days() + ' м ' +
                    timeDiff.hours() + ' ч ' +
                    timeDiff.minutes() + ' м ' +
                    timeDiff.seconds() + ' с';

                return timeMessege
            },
            enterKey(e){
                if(e.code == 'Enter'){
                    this.searchVacancies({})
                }
            },
            searchVacancies(obj){
                let params = new URLSearchParams(window.location.search)
                params.delete('page')
                // page
                if(obj.page != undefined && obj.page != null){
                    params.set('page',obj.page)
                }
                // position
                if(this.position == ''){
                    params.delete('position')
                }
                else{
                    params.set('position',this.position)
                }
                params.sort()
                let query = (params.toString() == '') ? '' : '?'+params.toString()
                location.href = this.lang.prefix_lang+'vacancy'+query
            },
            getVacancies(obj){
                let params = new URLSearchParams(window.location.search)
                params.delete('page')
                params.delete('country')
                params.delete('region')
                params.delete('city')
                params.delete('categories')
                params.delete('languages')
                params.delete('suitable')
                params.delete('employment')
                params.delete('salary')
                params.delete('experience')
                params.delete('education')

                // country
                if(obj.country != undefined && obj.country != null){
                    params.set('country',obj.country)
                }
                // region
                if(obj.region != undefined && obj.region != null){
                    params.set('region',obj.region)
                }
                // city
                if(obj.city != undefined && obj.city != null){
                    params.set('city',obj.city)
                }
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

                // console.log(query)

                location.href = this.lang.prefix_lang+'vacancy'+query
            },
            // поиск похожих заголовков
            async searchPosition(value){
                if(!value.length){
                    $('#position_list').removeClass('show')
                    return false
                }
                let data = {
                    value: value,
                };
                const response = await this.$http.post(`/private-office/vacancy/search-position`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            // вернет только опубликованные
                            if(res.data.message.position.length){
                                this.position_list = res.data.message.position
                                $('#position_list').addClass('show')
                            }
                            else{
                                $('#position_list').removeClass('show')
                            }
                        }
                        // custom ошибки
                        else{

                        }
                    })
                    // ошибки сервера
                    .catch(err => {
                        // this.messageError(err)
                    })
            },
            setValuePosition(value){
                $('#position_list').removeClass('show')
                this.position = value
            },
            transitionToVacancy(vacancy_alias){
                location.href = this.lang.prefix_lang+'vacancy/'+vacancy_alias
            },
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
        },
        props: [
            'lang',
            'settings',
            'vacancies',
            'user',
        ],
        mounted() {
            console.log(this.vacancies)

            // https://flaviocopes.com/urlsearchparams/
            const params = new URLSearchParams(window.location.search)
            if(params.has('position')){
                this.position = params.get('position')
            }
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .search-panel{
        display: flex;
        flex-direction: column;
        background-color: #fff;
        width: 100%;
        padding: 0;
        .title_page {
            padding: 15px;
        }
        .top-search{
            padding: 0 15px 10px;
            width: 100%;
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
            .form-group{
                display: flex;
                margin: 0;
                .box-position{
                    min-width: 77%;
                    input{
                        border-radius: 4px 0 0 4px;
                        font-size: 18px;
                        height: 38px;
                        padding-right: 30px;
                    }
                }
                button{
                    border-radius: 0 4px 4px 0;
                    min-width: 23%;
                    font-size: 18px;
                    height: 38px;
                    line-height: 0;
                }
            }
            .block_position_list{
                position: relative;
                #position_list{
                    width: 100%;
                    padding: 0;
                    cursor: pointer;
                    top: -3px;
                    & > div{
                        padding: 1px 12px;
                    }
                }
            }
        }
        .bottom-search{
            display: flex;
            padding: 30px 15px 0;
            .left-site{
                min-width: 75%;
            }
            .right-site{
                min-width: 23%;
            }
        }
    }

    .box-vacancy{
        margin-right: 15px;
        .box-title-logo{
            display: flex;
            justify-content: space-between;
            .title-vacancy{
                margin: 5px 0 10px;
                padding: 0;
                line-height: 25px;
                height: 25px;
                font-size: 26px;
            }
            .img-logo{
                width: 100px;
            }
        }
        .line-div{
            display: flex;
            margin-bottom: 5px;
            .font-weight-bold{
                font-weight: bold;
            }
        }
        .address-comment{
            display: flex;
            align-items: center;
            svg{
                width: 7px;
                margin: 0 5px;
            }
        }
    }

</style>





























