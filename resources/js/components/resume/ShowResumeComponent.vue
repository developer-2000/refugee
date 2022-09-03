<template>
    <div id="show-vacancy">

        <div class="bread-panel">

            <!-- title -->
            <h1 class="title_page">
                {{respond['resume'].position.title}}
            </h1>
            <!-- обратная ссылка -->
            <div class="bread-top">
                <ul class="ul-breadcrumbs">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="m166.5 424.5-143.1-152a23.94 23.94 0 0 1-6.562-16.5 23.94 23.94 0 0 1 6.562-16.5l143.1-152c9.125-9.625 24.31-10.03 33.93-.938 9.688 9.126 10.03 24.38.938 33.94l-128.4 135.5 128.4 135.5c9.094 9.562 8.75 24.75-.938 33.94-9.53 9.058-24.73 8.658-33.93-.942z"/></svg>
                    <li v-for="(obj, key) in getGenerateBackLink(respond['resume'].address)" :key="key">
                        <a :href="obj.url" class="back-url-link">{{obj.name}}</a>
                        <span class="bread-slash"> | </span>
                    </li>
                </ul>
            </div>

        </div>

        <!-- buttons -->
        <div class="top-panel">

            <div class="left-site">
                <!-- Откликнуться -->
                <button v-if="
            respond['owner_resume'] == null && (user !== null && user.id !== respond['resume']['user_id']) ||
            respond['owner_vacancy'] == null && user === null"
                        class="btn btn-block btn-outline-primary" type="button"
                        @click="scrollRespond()"
                >
                    {{trans('respond','respond')}}
                </button>

                <!-- общение с -->
                <button v-else-if="respond['owner_resume'] !== null"
                        class="btn btn-block btn-primary" type="button"
                        @click="goToDialog(respond['owner_resume'].offer, respond['in_table'])"
                >
                    {{trans('respond','open_dialog_with')}} {{respond['owner_resume'].contact.name}}
                </button>

                <!-- Найти похожие вакансии -->
                <button class="btn btn-block btn-outline-primary" type="button"
                        @click="findSimilarResume()"
                >
                    {{trans('vacancies','find_similar_resumes')}}
                </button>

                <!-- кнопки закладок вакансий -->
                <bookmark_buttons
                    :lang="lang"
                    :resume="respond['resume']"
                    :user="user"
                    :which_button_show="'show_resume'"
                ></bookmark_buttons>
            </div>

            <!-- Sharing panel -->
            <div class="right-site">
                <sharing_panel
                    :lang="lang"
                    :page="'resume'"
                ></sharing_panel>
            </div>

        </div>

        <!-- resume -->
        <div class="box-page">
            <resume_template
                :resume="respond['resume']"
                :settings="respond['settings']"
                :lang="lang"
                :page="'show'"
                :user="user"
                :contact_list="respond['contact_list']"
            ></resume_template>
        </div>

        <!-- откликнуться -->
        <div v-if="respond_bool" id="box-respond" >
            <h2 class="section-title">
                {{trans('vacancies','respond_to_resume')}}
            </h2>

                <!-- показ vacancy сайта -->
                <div>
                    <label>
                        {{trans('vacancies','choose_vacancy')}}
                    </label>
                    <!-- есть vacancy -->
                    <div v-if="respond['respond_data'].arr_vacancy.length">
                        <div v-for="(obj, key) in respond['respond_data'].arr_vacancy" :key="key">
                            <input type="radio"
                                   v-model="vacancyObj.vacancy_id"
                                   :id="`vacancy_${key}`"
                                   :value="obj.id"
                            >
                            <label class="target-label"
                                   :for="`vacancy_${key}`"
                            >
                                {{obj.position.title}}
                            </label>
                        </div>
                    </div>
                    <!-- no vacancy -->
                    <a v-else class="link-a"
                       :href="lang.prefix_lang+'private-office/vacancy/create'"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M352 232h-72v-72c0-13.26-10.74-24-23.1-24S232 146.7 232 160v72h-72c-13.3 0-24 10.7-24 24 0 13.25 10.75 24 24 24h72v72c0 13.25 10.75 24 24 24s24-10.7 24-24v-72h72c13.3 0 24-10.7 24-24s-10.7-24-24-24zM256 0C114.6 0 0 114.6 0 256s114.6 256 256 256 256-114.6 256-256S397.4 0 256 0zm0 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208-93.3 208-208 208z"/></svg>
                        {{trans('vacancies','create_your_job')}}
                    </a>
                </div>

                <!-- сопроводительное -->
                <div class="form-group textarea-letter">
                    <!-- ссылка -->
                    <div v-show="!vacancyObj.bool_letter">
                        <a href="javascript:void(0)" class="link-a"
                           @click="vacancyObj.bool_letter = !vacancyObj.bool_letter"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M352 232h-72v-72c0-13.26-10.74-24-23.1-24S232 146.7 232 160v72h-72c-13.3 0-24 10.7-24 24 0 13.25 10.75 24 24 24h72v72c0 13.25 10.75 24 24 24s24-10.7 24-24v-72h72c13.3 0 24-10.7 24-24s-10.7-24-24-24zM256 0C114.6 0 0 114.6 0 256s114.6 256 256 256 256-114.6 256-256S397.4 0 256 0zm0 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208-93.3 208-208 208z"/></svg>
                            {{trans('respond','add_cover_letter')}}
                        </a>
                    </div>
                    <div v-show="vacancyObj.bool_letter">
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
                    <button type="submit" class="btn btn-block btn-primary btn-lg open-button"
                            :class="{'disabled': disableButton()}"
                            :disabled="disableButton()"
                            @click.prevent="respondResume"
                    >
                        {{trans('vacancies','open_contacts_start')}}
                    </button>
                </div>

        </div>

    </div>
</template>

<script>
    import bookmark_buttons from "./details/BookmarkButtonsResumeComponent";
    import resume_template from "./details/ResumeTemplateComponent";
    import translation from "../../mixins/translation";
    import response_methods_mixin from "../../mixins/response_methods_mixin";
    import general_functions_mixin from "../../mixins/general_functions_mixin";
    import show_resume_vacancy_mixin from "../../mixins/show_resume_vacancy_mixin";
    import url_mixin from "../../mixins/url_mixin";
    import top_panel from "../../mixins/vacancy_resume/top_panel_vacancy_resume_mixin";
    import sharing_panel from "../details/SharingPanelComponent";

    export default {
        components: {
            'bookmark_buttons': bookmark_buttons,
            'resume_template': resume_template,
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
                vacancyObj:{
                    vacancy_id: null,
                    bool_letter: false,
                },
                objTextarea: {
                    textarea_letter: '',
                    editorConfig1: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList', 'Link' ]
                        ],
                    },
                },
            }
        },
        methods: {
            async respondResume(){
                let formData = new FormData;
                formData.append('resume_id', this.respond['resume'].id);
                formData.append('vacancy_id', this.vacancyObj.vacancy_id !== null ? this.vacancyObj.vacancy_id : '');
                formData.append('textarea_letter', this.objTextarea.textarea_letter);

                const response = await this.$http.post(`/respond-resume`, formData)
                    .then(res => {
                        if(this.checkSuccess(res)){
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
            // Найти похожие вакансии
            findSimilarResume(){
                let params = new URLSearchParams(window.location.search)
                params.delete('categories')
                params.delete('position')
                params.set('categories',this.respond['resume'].categories.toString())
                params.set('position',this.respond['resume'].position.title)
                params.sort()

                location.href = this.lang.prefix_lang+'resume?'+params.toString()
            },
            disableButton() {
                if( !this.vacancyObj.vacancy_id ){
                    return true;
                }
                return false;
            },
        },
        props: [
            'lang',   // масив названий и url языка
            'respond',
            'user',
            'back_url',
        ],
        mounted() {
            this.scrollUp()
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .top-panel{
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
        .title_page {
            padding: 25px 15px 15px;
        }
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
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: center;
            align-content: flex-start;
            align-items: flex-start;
            margin-bottom: 15px;
            button{
                width: 380px;
            }
            a{
               margin-right: 35px;
                width: 175px;
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

</style>





























