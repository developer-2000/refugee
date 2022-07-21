<template>
    <div class="search-panel container">
        <div class="box-title-panel">
            <h1 class="title_page">
                Поиск вакансий работодателей
            </h1>
            <!-- search input line -->
            <search_title_panel
                :lang="lang"
                :respond="respond"
                :prefix="prefix_url"
            ></search_title_panel>
        </div>

        <div class="bottom-search">
            <!-- vacancies -->
            <div class="left-site">
                <!-- item -->
                <div class="box-vacancy"
                     v-for="(vacancy, key) in respond.vacancies.data" :key="key"
                     :id="`v${key}`"
                     @click.prevent="transitionToVacancy(vacancy.alias)"
                     :class="{'close-document-border': vacancy.job_posting.status_name == 'hidden' }"
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
                        :settings="respond"
                        :lang="lang"
                        :ids_respond="respond.ids_respond"
                        :page="'search'"
                    ></vacancy_template>

                    <div class="footer-vacancy">
                        <!-- отображение прошедшего времени -->
                        <div class="date-document">
                            {{getDateDocumentString(vacancy.updated_at)}} назад
                            <!-- вакансия закрыта -->
                            <div class="close-document-fon"
                                 v-if="vacancy.job_posting.status_name == 'hidden'"
                            >
                                Вакансия закрыта
                            </div>
                        </div>

                        <!-- кнопки закладок вакансий -->
                        <bookmark_buttons
                            :lang="lang"
                            :vacancy="vacancy"
                            :user="user"
                            :which_button_show="'search_vacancy'"
                            @return="pageReload"
                        ></bookmark_buttons>
                    </div>

                </div>

                <pagination
                    v-if="respond.vacancies.last_page > 1"
                    :pagination="respond.vacancies"
                    @paginate="paginateReload"
                    :offset="1"
                >
                </pagination>
            </div>

            <!-- search panel -->
            <div class="right-site">
                <search_panel
                    :lang="lang"
                    :settings="respond"
                    :page="'search_vacancies'"
                    @returnParent="getVacancies"
                ></search_panel>
            </div>
        </div>
    </div>
</template>

<script>
    import pagination from "../details/PaginationComponent";
    import search_panel from '../details/SearchPanelComponent.vue'
    import search_title_panel from '../details/SearchTitlePanelComponent'
    import bookmark_buttons from './details/BookmarkButtonsVacancyComponent'
    import general_functions_mixin from "../../mixins/general_functions_mixin.js";
    import vacancy_template from "./details/VacancyTemplateComponent";
    import response_methods_mixin from "../../mixins/response_methods_mixin";
    import translation from "../../mixins/translation";
    import date_mixin from "../../mixins/date_mixin";
    import bookmark_vacancies_mixin from "../../mixins/bookmark_vacancies_mixin";
    import url_mixin from "../../mixins/url_mixin";

    export default {
        components: {
            'pagination': pagination,
            'search_panel': search_panel,
            'bookmark_buttons': bookmark_buttons,
            'vacancy_template': vacancy_template,
            'search_title_panel': search_title_panel,
        },
        mixins: [
            translation,
            general_functions_mixin,
            response_methods_mixin,
            bookmark_vacancies_mixin,
            date_mixin,
            url_mixin,
        ],
        data() {
            return {
                description: 'Вакансія для фахівців-початківців з кібербезпеки, які хочуть брати участь у тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів⁠',
                position: '',
                prefix_url: 'vacancy',
            }
        },
        methods: {
            getVacancies(obj){
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
            salaryView(salaryObj){
                let salary_string = ''
                let arr_field = this.respond.salary[salaryObj.radio_name]
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
                    address_string += vacancyObj.country.alias+'.'
                }
                if(vacancyObj.region !== null){
                    address_string += ' ' + vacancyObj.region.alias+'.'
                }
                if(vacancyObj.city !== null){
                    address_string += ' ' + vacancyObj.city.alias+'.'
                }

                address_string += ' ' + vacancyObj.rest_address+'.'

                return address_string
            },
            paginateReload(obj){
                let params = new URLSearchParams(window.location.search)
                params.delete('page')
                // page
                if(obj.page != undefined && obj.page != null){
                    params.set('page',obj.page)
                }

                params.sort()
                let query = (params.toString() == '') ? '' : '?'+params.toString()
                location.href = this.urlNotQuery()+query
            },
        },
        props: [
            'lang',
            'respond',
            'user',
        ],
        mounted() {
            // console.log(this.respond)
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
        .box-title-panel{
            /*background: url("img/custom/flags.jpg");*/
        }
        .title_page {
            padding: 15px;
        }

        .bottom-search{
            display: flex;
            padding: 30px 15px 0;
            .left-site{
                min-width: 80%;
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
            }
            .right-site{
                min-width: 20%;
            }
        }
    }

</style>





























