<template>
    <div class="container show-vacancy" id="show-vacancy">

        <div class="bread-panel">

            <!-- title -->
            <h1 class="title_page">
                {{respond['vacancy'].position.title}}
            </h1>

            <!-- обратная ссылка -->
            <div class="bread-top">
                <ul class="ul-breadcrumbs">
                    <li v-for="(obj, key) in getGenerateBackLink(respond['vacancy'].address)" :key="key">
                        <template v-if="key === 0">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="m166.5 424.5-143.1-152a23.94 23.94 0 0 1-6.562-16.5 23.94 23.94 0 0 1 6.562-16.5l143.1-152c9.125-9.625 24.31-10.03 33.93-.938 9.688 9.126 10.03 24.38.938 33.94l-128.4 135.5 128.4 135.5c9.094 9.562 8.75 24.75-.938 33.94-9.53 9.058-24.73 8.658-33.93-.942z"/></svg>
                        </template>
                        <template v-else>
                            <span class="bread-slash"> | </span>
                        </template>
                        <a :href="obj.url" class="back-url-link">{{obj.name}}</a>

                    </li>
                </ul>
            </div>

        </div>

        <!-- buttons -->
        <div class="top-panel button-panel">

            <div class="left-site">
                <!-- Откликнуться -->
                <button v-if="
                respond['owner_vacancy'] == null && (user !== null && user.id !== respond['vacancy']['user_id']) ||
                respond['owner_vacancy'] == null && user === null"
                        class="btn btn-block btn-outline-primary" type="button"
                        @click="scrollRespond()"
                >
                    {{trans('respond','respond')}}
                </button>

                <!-- общение с -->
                <button v-else-if="respond['owner_vacancy'] !== null"
                        class="btn btn-block btn-primary" type="button"
                        @click="goToDialog(respond['owner_vacancy'].offer, respond['in_table'])"
                >
                    {{trans('respond','open_dialog_with')}} {{respond['owner_vacancy'].contact.name}}
                </button>

                <!-- Найти похожие вакансии -->
                <button class="btn btn-block btn-outline-primary" type="button"
                        @click="findSimilarVacancy()"
                >
                    {{trans('vacancies','find_similar_jobs')}}
                </button>

                <!-- кнопки закладок вакансий -->
                <bookmark_buttons
                    :lang="lang"
                    :vacancy="respond['vacancy']"
                    :user="user"
                    :which_button_show="'show_vacancy'"
                ></bookmark_buttons>
            </div>

            <!-- Sharing panel -->
            <div class="right-site">
                <sharing_panel
                    :lang="lang"
                    :page="'vacancy'"
                ></sharing_panel>
            </div>

        </div>

        <!-- vacancy -->
        <div class="box-page">
            <vacancy_template
                :vacancy="respond['vacancy']"
                :settings="respond['settings']"
                :lang="lang"
                :page="'show'"
                :user="user"
                :contact_list="respond['contact_list']"
            ></vacancy_template>
        </div>

        <!-- откликнуться -->
        <div v-if="respond_bool" id="box-respond" >
            <h2 class="section-title">
                {{trans('respond','apply_to_job')}}
            </h2>
            <div class="card card-primary card-outline card-outline-tabs card-respond">
                <!-- buttons tabs -->
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="first-card-link-tab" data-toggle="pill"
                               href="#first-card-link" role="tab" aria-controls="first-card-link" aria-selected="true"
                               @click="resumeObj.bool_tab = 1"
                            >
                                {{trans('respond','resume_on_site')}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="javascript:void(0)"
                               @click="resumeObj.bool_tab = 0"
                            >
                                {{trans('respond','attach_resume_file')}}
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- body -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="first-card-link" role="tabpanel" aria-labelledby="first-card-link-tab">

                            <!-- показ resume сайта -->
                            <template v-if="resumeObj.bool_tab">
                                <label>
                                    {{trans('respond','select_cv')}}
                                </label>
                                <!-- есть resume сайтовое -->
                                <div v-if="lookingValueInArrayObjects('type', 0, respond['respond_data'].arr_resume)"
                                     class="box-yes-resume"
                                >
                                    <div class="form-group" id="box-radio">
                                        <div v-for="(obj, key) in respond['respond_data'].arr_resume" :key="key">
                                            <template v-if="obj.type === 0">
                                                <input type="radio"
                                                       v-model="resumeObj.resume_id"
                                                       :id="`resume_${key}`"
                                                       :value="obj.id"
                                                >
                                                <label class="target-label"
                                                       :for="`resume_${key}`"
                                                >
                                                    {{obj.position.title}}
                                                </label>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                <!-- no resume -->
                                <div v-else class="box-no-resume">
                                    <a class="link-a"
                                       :href="lang.prefix_lang+'private-office/resume/create'"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M352 232h-72v-72c0-13.26-10.74-24-23.1-24S232 146.7 232 160v72h-72c-13.3 0-24 10.7-24 24 0 13.25 10.75 24 24 24h72v72c0 13.25 10.75 24 24 24s24-10.7 24-24v-72h72c13.3 0 24-10.7 24-24s-10.7-24-24-24zM256 0C114.6 0 0 114.6 0 256s114.6 256 256 256 256-114.6 256-256S397.4 0 256 0zm0 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208-93.3 208-208 208z"/></svg>
                                        {{trans('respond','create_your_resume')}}
                                    </a>
                                </div>
                            </template>

                            <!-- показ Drop file -->
                            <template v-else>
                                <label>
                                    {{trans('respond','resume_file')}}
                                </label>

                                <!-- если нет загруженного файла резюме -->
                                <div v-if="!file_resume" class="block-drop-file">
                                    <drag_drop_file
                                        @load_resume='addResume'
                                        :lang="lang"
                                        :arr_files="filelist"
                                    ></drag_drop_file>
                                </div>

                                <!-- есть загруженный резюме -->
                                <a v-else
                                   class="file-load-resume" href="javascript:void(0)"
                                   @click="targetFileLoadResume(file_resume.url)"
                                >
                                    {{file_resume.title}}
                                    <svg @click="removeFileLoadResume($event)" class="xmark-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256 7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256l118.2 119z"/></svg>
                                </a>

                            </template>

                            <!-- сопроводительное -->
                            <div class="form-group textarea-letter">
                                <!-- ссылка -->
                                <div v-show="!resumeObj.bool_letter">
                                    <a href="javascript:void(0)" class="link-a"
                                       @click="resumeObj.bool_letter = !resumeObj.bool_letter"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M352 232h-72v-72c0-13.26-10.74-24-23.1-24S232 146.7 232 160v72h-72c-13.3 0-24 10.7-24 24 0 13.25 10.75 24 24 24h72v72c0 13.25 10.75 24 24 24s24-10.7 24-24v-72h72c13.3 0 24-10.7 24-24s-10.7-24-24-24zM256 0C114.6 0 0 114.6 0 256s114.6 256 256 256 256-114.6 256-256S397.4 0 256 0zm0 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208-93.3 208-208 208z"/></svg>
                                        {{trans('respond','add_cover_letter')}}
                                    </a>
                                </div>
                                <div v-show="resumeObj.bool_letter">
                                    <label>
                                        {{trans('respond','cover_letter')}}
                                    </label>
                                    <ckeditor v-model="objTextarea.textarea_letter"
                                              :config="objTextarea.editorConfig1"
                                    ></ckeditor>
                                </div>
                            </div>

                            <!-- button -->
                            <div class="box-button">
                                <a href="javascript:void(0)" class="btn btn-block btn-outline-danger btn-lg"
                                   @click.prevent="cancelRespond()"
                                >
                                    {{trans('vacancies','cancel')}}
                                </a>
                                <button type="submit" class="btn btn-block btn-primary btn-lg"
                                        :class="{'disabled': disableButton()}"
                                        :disabled="disableButton()"
                                        @click.prevent="respondVacancy"
                                >
                                    {{trans('vacancies','open_contacts_start')}}
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import bookmark_buttons from "./details/BookmarkButtonsVacancyComponent";
    import vacancy_template from "./details/VacancyTemplateComponent";
    import sharing_panel from "../details/SharingPanelComponent";
    import translation from "../../mixins/translation";
    import response_methods_mixin from "../../mixins/response_methods_mixin";
    import general_functions_mixin from "../../mixins/general_functions_mixin";
    import drag_drop_file from '../load_files/DragDropFileComponent'
    import show_resume_vacancy_mixin from "../../mixins/show_resume_vacancy_mixin";
    import url_mixin from "../../mixins/url_mixin";
    import top_panel from "../../mixins/vacancy_resume/top_panel_vacancy_resume_mixin";

    export default {
        delimiters: ['${', '}'], // Avoid Twig conflicts
        components: {
            'bookmark_buttons': bookmark_buttons,
            'vacancy_template': vacancy_template,
            'drag_drop_file': drag_drop_file,
            'sharing_panel': sharing_panel,
        },
        mixins: [
            translation,
            response_methods_mixin,
            general_functions_mixin,
            show_resume_vacancy_mixin,
            url_mixin,
            top_panel,
        ],
        data() {
            return {
                respond_bool: false,
                resumeObj:{
                    resume_id: null,
                    bool_letter: false,
                    bool_tab: 1,
                },
                objTextarea: {
                    textarea_letter: '',
                    editorConfig1: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList', 'Link' ]
                        ],
                    },
                },
                filelist: [],
                file_resume: null,
            }
        },
        methods: {
            async respondVacancy(){
                let formData = new FormData;
                formData.append('vacancy_id', this.respond['vacancy'].id);
                formData.append('bool_tab', this.resumeObj.bool_tab);
                formData.append('resume_id', this.resumeObj.resume_id !== null ? this.resumeObj.resume_id : '');
                formData.append('textarea_letter', this.objTextarea.textarea_letter);
                formData.append('old_file_id', this.file_resume !== null ? this.file_resume.id : '');
                formData.append('new_file', this.filelist.length ? this.filelist[0] : '');

                const response = await this.$http.post(this.lang.prefix_lang+"respond-vacancy", formData)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            localStorage.setItem('respond_alert', this.trans('respond','interlocutor_notified'))
                            location.reload()
                        }
                        // custom ошибки
                        else{
                            this.message(res.data.message, 'error', 10000, true);
                        }
                    })
                    // ошибки сервера
                    .catch(err => {
                        this.messageError(err)
                    })
            },
            findSimilarVacancy(){
                let params = new URLSearchParams(window.location.search)
                params.delete('categories')
                params.delete('position')
                params.set('categories',this.respond['vacancy'].categories.toString())
                params.set('position',this.respond['vacancy'].position.title)
                params.sort()

                location.href = this.lang.prefix_lang+'vacancy?'+params.toString()
            },
            disableButton() {
                if(
                    (this.resumeObj.bool_tab && !this.resumeObj.resume_id) ||
                    (!this.resumeObj.bool_tab && (!this.filelist.length && !this.file_resume))
                ){
                    return true;
                }
                return false;
            },
            // раскрытие загруженного резюме
            targetFileLoadResume(url) {
                window.open("//"+location.hostname+"/"+url)
            },
            // очистка данных о загруженном резюме
            removeFileLoadResume(e) {
                this.file_resume = null
                e.stopPropagation()
            },
            // @emit дочернего
            addResume(file){
                this.filelist = file
            },
        },
        computed: {
            initializationFunc() {
                // есть ли file resume
                let obj = this.lookingValueInArrayObjects('type', 1, this.respond['respond_data'].arr_resume)
                if(obj){
                    this.file_resume = obj
                }

                // оповещение после respond документа
                if (localStorage.getItem('respond_alert') !== null) {
                    this.message(localStorage.getItem('respond_alert'), 'success', 10000, true);
                    localStorage.removeItem('respond_alert')
                }
            },
        },
        props: [
            'lang',   // масив названий и url языка
            'respond',
            'user',
            'back_url',
        ],
        mounted() {
            this.initializationFunc
            $('html, body').animate({scrollTop: 0},500);

            // console.log(this.respond.social_share)
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .show-vacancy{
        padding: 0;
    }
    .button-panel{
        justify-content: space-between;
        .left-site{
            display: flex;
        }
    }
    .bread-panel{
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        background-color: #fff;
        z-index: 20;
        font-size: 15px;
        .bread-top{
            display: flex;
            align-items: center;
            padding: 0 15px 10px;
        }
    }
    .box-page {
        padding: 15px 15px 50px;
    }
    #box-respond{
        border-top: 1px solid $border-style-grey-2;
        background-color: #fff;
        padding: 15px 25px;
        font-size: 17px;
        .card-respond{
            box-shadow: none;
            border: 1px solid $border-style-grey-2;
            border-radius: 5px 5px 0 0;
            margin-top: 20px;
            .nav-link.active{
                background-color: white;
                &:hover{
                    border-top: 3px solid #007bff;
                }
            }
        }
        .box-no-resume{
            display: flex;
            flex-direction: column;
        }
        .textarea-letter{
            padding-top: 15px;
        }
        #first-card-link{
            .box-no-resume{
                padding-bottom: 15px;
                border-bottom: 1px solid #dee2e6;
            }
            .box-yes-resume{
                border-bottom: 1px solid #dee2e6;
            }
            .textarea-letter,
            .block-drop-file{
                padding-bottom: 15px;
            }
            &>div:last-child{
                border-bottom: none;
                padding-bottom: 0;
            }
            .file-load-resume{
                display: flex;
                padding-bottom: 15px;
                border-bottom: 1px solid #dee2e6;
            }
        }
        .box-button{
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
            a, button{
                width: auto;
            }
            a{
               margin-right: 35px;
            }
        }
    }
    .link-a{
        display: flex;
        align-items: center;
        width: 340px;
        svg{
            margin-right: 5px;
            path{
                fill:#1d68a7;
            }
        }
    }
    .xmark-icon{
        fill: red;
        width: 13px;
        margin-left: 5px;
        cursor: pointer;
    }
    .search-panel .title_page,
    .bread-panel .title_page,
    .box-page .title_page {
        padding: 25px 15px 15px;
    }

    @media (max-width: 992px){
        .bread-top {
            padding: 5px 15px 15px 15px;
        }
        .ul-breadcrumbs{
            flex-wrap: wrap;
            li{
                margin-top: 10px;
            }
        }
        .button-panel{
            .left-site{
                flex-direction: column;
                &>button{
                    margin: 0 0 10px 0 !important;
                }
            }
        }
        .top-panel{
            align-items: flex-start;
        }
    }

    @media (max-width: 768px){
        .top-panel{
            flex-direction: column;
        }
        .right-site{
            margin-top: 40px;
        }
    }

    @media (max-width: 520px){
        #box-respond{
            .box-button{
                flex-direction: column;
                a{
                    margin: 0 0 15px;
                }
                button{
                    white-space: inherit;
                }
            }
        }

    }



</style>





























