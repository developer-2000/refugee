<template>
    <div class="search-panel container">

        <!-- Title -->
        <h1 class="title_page">
            {{getTitlePage()}}
        </h1>

        <!-- Breadcrumbs, Sharing panel-->
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
                    :social_share="respond['social_share']"
                    :page="'search'"
                ></sharing_panel>
            </div>
        </div>

        <!-- Search input line -->
        <h2 class="title_page">
            {{trans('vacancies','resume_search')}}
        </h2>
        <search_title_panel
            :lang="lang"
            :respond="respond"
            :prefix="prefix_url"
        ></search_title_panel>

        <!-- Resumes, Right panel -->
        <div class="bottom-search">

            <!-- Кнопка modal, Resume -->
            <div class="left-site">

                <!-- mobile search filters -->
                <div v-if="media_bool" class="box-mobile-filter-buttons">

                    <!-- top -->
                    <div class="top-mobile-filter-buttons">

                        <!-- кнопка modal -->
                        <span class="but-modal-filter" data-target="#modal-filter" data-toggle="modal">
                            {{trans('vacancies','advanced_search')}}
                        </span>

                        <!-- сбросить все-->
                        <a v-if="locationSearch != '' && media_bool"
                           class="but-reset-all"
                           href="javascript:void(0)"
                           @click="clearQuery()"
                        >
                            {{trans('vacancies','reset_all')}}
                        </a>
                    </div>

                    <!-- bottom -->
                    <div class="bottom-mobile-filter-buttons">

                        <span v-for="(value, key) in objButtonFilters" :key="key"
                              class="item-filter-parameter"
                        >
                            {{value.text}}
                            <svg @click="resetFilters(objButtonFilters[key])" class="svg-circle-xmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M331.3 180.7c-6.25-6.25-16.38-6.25-22.62 0L256 233.4l-52.7-52.7c-6.25-6.25-16.38-6.25-22.62 0s-6.25 16.38 0 22.62L233.4 256l-52.7 52.7c-6.25 6.25-6.25 16.38 0 22.62 6.246 6.246 16.37 6.254 22.62 0L256 278.6l52.69 52.69c6.246 6.246 16.37 6.254 22.62 0 6.25-6.25 6.25-16.38 0-22.62L278.6 256l52.69-52.69c6.31-6.21 6.31-16.41.01-22.61zM256 0C114.6 0 0 114.6 0 256s114.6 256 256 256 256-114.6 256-256S397.4 0 256 0zm0 480C132.5 480 32 379.5 32 256S132.5 32 256 32s224 100.5 224 224-100.5 224-224 224z"/></svg>
                        </span>

                    </div>

                </div>


                <!-- item -->
                <a class="box-vacancy"
                   v-for="(resume, key) in resumes" :key="key"
                   :href="getGenerateUrlDocument(resume, 'resume')"
                   :id="`v${key}`"
                   :class="{'close-document-border': resume.job_posting.status_name == 'hidden' }"
                >
                    <!-- лента -->
                    <div class="ribbon-wrapper">
                        <div class="ribbon uk-color">
                            <svg xmlns="http://www.w3.org/2000/svg" class="uk-star-icon" viewBox="0 0 576 512"><path d="m305.3 12.57 54.9 169.03h177.6c17.6 0 24.92 22.55 10.68 32.9L404.78 319l54.89 169.1c5.44 16.76-13.72 30.69-27.96 20.33L288 403.1 144.3 507.6c-14.24 10.36-33.4-3.577-27.96-20.33l54.89-169.1L27.53 214.5c-14.25-10.3-6.93-32.9 10.68-32.9h177.6L270.7 12.5c5.5-16.69 29.1-16.69 34.6.07z"/></svg>
                        </div>
                    </div>
                    <!-- resume -->
                    <resume_template
                        :resume="resume"
                        :settings="respond"
                        :lang="lang"
                        :contact_list="contact_list"
                        :ids_respond="respond.ids_respond"
                        :page="'search'"
                    ></resume_template>

                    <div class="footer-vacancy">
                        <!-- отображение прошедшего времени -->
                        <div class="date-document">
                            {{getDateDocumentString(resume.updated_at)}}
                            {{trans('vacancies','back')}}
                            <!-- вакансия закрыта -->
                            <div class="close-document-fon"
                                 v-if="resume.job_posting.status_name == 'hidden'"
                            >
                                {{trans('vacancies','vacancy_closed')}}
                            </div>
                        </div>

                        <!-- кнопки закладок вакансий -->
                        <bookmark_buttons
                            :lang="lang"
                            :resume="resume"
                            :user="user"
                            :which_button_show="'search_resume'"
                            @return="removeHiddenDocument"
                        ></bookmark_buttons>
                    </div>
                </a>

                <pagination
                    v-if="respond.resumes.last_page > 1"
                    :pagination="respond.resumes"
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
                    :page="'search_resumes'"
                    @returnParent="reloadFilterPage"
                ></filter_panel>
                <country_sities
                    :lang="lang"
                    :respond="respond"
                ></country_sities>
            </div>
        </div>

        <!-- Modal Filter -->
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
                            :page="'search_resumes'"
                            @returnParent="reloadFilterPage"
                        ></filter_panel>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import pagination from "../details/PaginationComponent";
    import bookmark_buttons from './details/BookmarkButtonsResumeComponent'
    import resume_template from "./details/ResumeTemplateComponent";
    import general_functions_mixin from "../../mixins/general_functions_mixin.js";
    import response_methods_mixin from "../../mixins/response_methods_mixin";
    import translation from "../../mixins/translation";
    import date_mixin from "../../mixins/date_mixin";
    import bookmark_vacancies_mixin from "../../mixins/bookmark_vacancies_mixin";
    import search_title_panel from "../details/SearchTitlePanelComponent";
    import top_panel from "../../mixins/vacancy_resume/top_panel_vacancy_resume_mixin";
    import url_mixin from "../../mixins/url_mixin";
    import sharing_panel from "../details/SharingPanelComponent";
    import filter_panel from "../details/right_panel_document_search_page/FilterPanelComponent";
    import country_sities from "../details/right_panel_document_search_page/CountrySitiesRightPanelComponent";
    import mobile_filter_panel from "../../mixins/vacancy_resume/mobile_filter_panel_mixin";

    export default {
        components: {
            'pagination': pagination,
            'bookmark_buttons': bookmark_buttons,
            'resume_template': resume_template,
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
            mobile_filter_panel
        ],
        data() {
            return {
                resumes: [],
                name_query: 'position',
                prefix_url: 'resume',
                contact_list: [],
                position: '',
                position_list: [],
                description: '',
                media_width: 992,
                media_bool: false,
            }
        },
        methods: {
            // поиск похожих заголовков
            async searchPosition(value){
                if(!value.length){
                    $('.x-mark-clear').css('display','none')
                    $('#position_list').removeClass('show')
                    return false
                }
                $('.x-mark-clear').css('display','block')
                let data = {
                    value: value,
                };
                const response = await this.$http.post(`/private-office/resume/search-position`, data)
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
                if(obj.resume_id !== null){
                    let index_obj = this.lookingValueInArrayObjectsReturnIndex('id', obj.resume_id, this.resumes)
                    if(index_obj !== -1){
                        this.resumes.splice(index_obj, 1)
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
            this.resumes = this.respond.resumes.data
            window.addEventListener("resize", this.moveFilterBar, true);
            this.moveFilterBar();
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .box-mobile-filter-buttons{
        font-size: 14px;
        margin-bottom: 20px;
        .top-mobile-filter-buttons{
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            .but-modal-filter{
                color: #c97900;
                border-bottom: 1px dashed #c97900;
                display: inline-block;
                cursor: pointer;
                &:hover{
                    color: #ed9004;
                    border-bottom: 1px dashed #ed9004;
                }
            }
            .but-reset-all {
                display: inline-block;
                color: #3490dc;
                text-decoration: none;
                border-bottom: 1px dashed #3490dc;
                &:hover {
                    border-bottom: 1px dashed #0268bc;
                    color: #0268bc;
                }
            }
        }
        .bottom-mobile-filter-buttons{
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: flex-start;
            align-content: center;
            align-items: flex-start;

            .item-filter-parameter{
                display: flex;
                align-content: center;

                background: #e3e3e3;
                padding: 4px 8px 4px 10px;
                border-radius: 15px;
                line-height: 20px;
                margin: 10px 5px 0 0;
                .svg-circle-xmark{
                    width: 17px;
                    fill: #dc3545;
                    margin-left: 4px;
                    cursor: pointer;
                    &:hover{
                        fill: #e6041a;
                    }
                }
            }
        }

    }

    .top-panel{
        padding: 20px 15px!important;
    }
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
    .right-top-panel{
        display: flex;
        justify-content: flex-end;
    }
    .bread-top{
        justify-content: space-between;
    }
    .search-panel{
        .top-search{
            .form-group{
                display: flex;
                margin: 0;
                .box-position{
                    min-width: 77%;
                    position: relative;
                    input{
                        border-radius: 4px 0 0 4px;
                        font-size: 18px;
                        height: 38px;
                        padding-right: 30px;
                    }
                    .x-mark-clear{
                        position: absolute;
                        top: 1px;
                        right: 1px;
                        fill: #ff4747;
                        width: 45px;
                        padding: 6px 15px 6px 15px;
                        cursor: pointer;
                        display: none;
                        &:hover{
                            background-color: #f1f1f1;
                        }
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
            padding: 30px 15px 50px;
            .left-site{
                width: 100%;
            }
            .right-site{
                min-width: 275px;
                max-width: 275px;
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
        .top-panel{
            position: static;
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





























