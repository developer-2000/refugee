<template>
    <div class="search-panel container">

        <div class="box-title-panel">

            <!-- title -->
            <h1 class="title_page">
                {{getTitlePage()}}
            </h1>

            <div class="row top-panel bread-top">

                <!-- breadcrumbs -->
                <ul class="col-sm-12 col-md-8 ul-breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
                    <li v-for="(obj, key) in getGenerateBackLink()" :key="key"
                        itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"
                    >
                        <template v-if="key === 0">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="m166.5 424.5-143.1-152a23.94 23.94 0 0 1-6.562-16.5 23.94 23.94 0 0 1 6.562-16.5l143.1-152c9.125-9.625 24.31-10.03 33.93-.938 9.688 9.126 10.03 24.38.938 33.94l-128.4 135.5 128.4 135.5c9.094 9.562 8.75 24.75-.938 33.94-9.53 9.058-24.73 8.658-33.93-.942z"/></svg>
                        </template>
                        <template v-else>
                            <span class="bread-slash"> | </span>
                        </template>
                        <a :href="obj.url" class="back-url-link" itemprop="item">
                            <span itemprop="name">{{obj.name}}</span>
                        </a>
                        <meta itemprop="position" :content="(key+1)">
                    </li>
                </ul>

                <!-- Sharing panel -->
                <div class="col-sm-12 col-md-4 right-top-panel">
                    <sharing_panel
                        :lang="lang"
                        :page="'search'"
                    ></sharing_panel>
                </div>
            </div>

            <h2 class="title_page">
                {{trans('vacancies','job_search')}}
            </h2>

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
                <!-- кнопка modal -->
                <span v-if="media_bool" class="but-modal-filter" data-toggle="modal" data-target="#modal-filter">
                    {{trans('vacancies','advanced_search')}}
                </span>

                <!-- item -->
                <a class="box-vacancy"
                   v-for="(vacancy, key) in vacancies" :key="key"
                   :href="getGenerateUrlDocument(vacancy, 'vacancy')"
                   :id="`v${key}`"
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
                            {{getDateDocumentString(vacancy.updated_at)}}
                            {{trans('vacancies','back')}}
                            <!-- вакансия закрыта -->
                            <div class="close-document-fon"
                                 v-if="vacancy.job_posting.status_name == 'hidden'"
                            >
                                {{trans('vacancies','vacancy_closed')}}
                            </div>
                        </div>

                        <!-- кнопки закладок вакансий -->
                        <bookmark_buttons
                            :lang="lang"
                            :vacancy="vacancy"
                            :user="user"
                            :which_button_show="'search_vacancy'"
                            @return="removeHiddenDocument"
                        ></bookmark_buttons>
                    </div>

                </a>

                <pagination
                    v-if="respond.vacancies.last_page > 1"
                    :pagination="respond.vacancies"
                    @paginate="paginateReload"
                    :offset="1"
                >
                </pagination>
            </div>

            <!-- right panel -->
            <div v-show="!media_bool" class="right-site">
                <filter_panel
                    v-if="!media_bool"
                    :lang="lang"
                    :respond="respond"
                    :page="'search_vacancies'"
                    @returnParent="getVacancies"
                ></filter_panel>

                <country_sities
                    :lang="lang"
                    :respond="respond"
                ></country_sities>
            </div>
        </div>

        <!-- Modal -->
        <div v-if="media_bool" class="modal fade" id="modal-filter">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">
                            Фильтр поиска
                        </h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <filter_panel
                            :lang="lang"
                            :respond="respond"
                            :page="'search_vacancies'"
                            @returnParent="getVacancies"
                        ></filter_panel>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
    import pagination from "../details/PaginationComponent";
    import country_sities from '../details/right_panel_document_search_page/CountrySitiesRightPanelComponent.vue'
    import search_title_panel from '../details/SearchTitlePanelComponent'
    import bookmark_buttons from './details/BookmarkButtonsVacancyComponent'
    import general_functions_mixin from "../../mixins/general_functions_mixin.js";
    import vacancy_template from "./details/VacancyTemplateComponent";
    import response_methods_mixin from "../../mixins/response_methods_mixin";
    import translation from "../../mixins/translation";
    import date_mixin from "../../mixins/date_mixin";
    import bookmark_vacancies_mixin from "../../mixins/bookmark_vacancies_mixin";
    import url_mixin from "../../mixins/url_mixin";
    import top_panel from "../../mixins/vacancy_resume/top_panel_vacancy_resume_mixin";
    import sharing_panel from "../details/SharingPanelComponent";
    import filter_panel from '../details/right_panel_document_search_page/FilterPanelComponent'

    export default {
        components: {
            'pagination': pagination,
            'bookmark_buttons': bookmark_buttons,
            'vacancy_template': vacancy_template,
            'search_title_panel': search_title_panel,
            'sharing_panel': sharing_panel,
            'filter_panel': filter_panel,
            'country_sities': country_sities,
        },
        mixins: [
            translation,
            general_functions_mixin,
            response_methods_mixin,
            bookmark_vacancies_mixin,
            date_mixin,
            top_panel,
            url_mixin,
        ],
        data() {
            return {
                vacancies: [],
                description: '⁠',
                position: '',
                prefix_url: 'vacancy',
                media_width: 992,
                media_bool: false,
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
            moveFilterBar(){
                let width = window.innerWidth;

                if(width <= this.media_width){
                    this.media_bool = true
                }
                else{
                    this.media_bool = false
                }
            },
            // убрать спрятаный елемент resume_id
            removeHiddenDocument(obj){
                if(obj.vacancy_id !== null){
                    let index_obj = this.lookingValueInArrayObjectsReturnIndex('id', obj.vacancy_id, this.vacancies)
                    if(index_obj !== -1){
                        this.vacancies.splice(index_obj, 1)
                    }
                }
            }
        },
        props: [
            'lang',
            'respond',
            'user',
        ],
        mounted() {
            // console.log(this.respond)
            this.vacancies = this.respond.vacancies.data
            window.addEventListener("resize", this.moveFilterBar, true);
            this.moveFilterBar();
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .modal-body {
        padding: 2.5rem 1rem 1rem 1rem;
    }
    #modal-filter{
        h2{
            font-size: 1.125rem;
            color: #444;
            font-weight: 300;
        }
    }
    .but-modal-filter{
        font-size: 16px;
        color: #c97900;
        border-bottom: 1px dashed #c97900;
        margin-bottom: 19px;
        display: inline-block;
        cursor: pointer;
        &:hover{
            color: #ed9004;
            border-bottom: 1px dashed #ed9004;
        }
    }
    .right-top-panel{
        display: flex;
        justify-content: flex-end;
    }
    .bread-top{
        justify-content: space-between;
    }
    .search-panel{
        .bottom-search{
            display: flex;
            padding: 30px 15px 50px;
            .left-site{
                width: 100%;
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
                min-width: 275px;
                max-width: 275px;
            }
        }
    }
    .search-panel .title_page,
    .bread-panel .title_page,
    .box-page .title_page {
        padding: 25px 15px 15px;
    }

    @media (max-width: 992px){
        .search-panel{
            .bottom-search{
                padding: 10px 15px 50px;
                .left-site{
                    .box-vacancy{
                        margin-right: 0;
                    }
                }
            }
        }
        .ul-breadcrumbs{
            flex-wrap: wrap;
            li{
                margin-top: 10px;
            }
        }
    }

    @media (max-width: 768px){
        h1{
            font-size: 28px;
        }
        .bread-top {
            padding: 15px;
        }
        .right-top-panel{
            margin-top: 40px;
            justify-content: flex-start;
        }
    }

    @media (max-width: 720px){
        .footer-vacancy{
            flex-direction: column;
            align-items: flex-start;
        }
        .date-document {
            margin-bottom: 10px;
        }
        .panel-button {
            display: flex;
            justify-content: flex-start;
        }
    }

    @media (max-width: 480px){
        .bread-top {
            padding: 5px 15px 15px 15px;
        }
    }

</style>





























