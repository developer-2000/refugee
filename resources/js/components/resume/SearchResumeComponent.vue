<template>
    <div class="search-panel container">
        <h1 class="title_page">
            Поиск резюме
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

                    <svg @click="clearSearch"
                         class="x-mark-clear" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256 7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256l118.2 119z"/></svg>

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
                        @click="urlReload"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="m504.1 471-134-134c29-35.5 45-80.2 45-129 0-114.9-93.13-208-208-208S0 93.13 0 208s93.12 208 207.1 208c48.79 0 93.55-16.91 129-45.04l134 134c5.6 4.74 11.8 7.04 17.9 7.04s12.28-2.344 16.97-7.031c9.33-9.369 9.33-24.569-.87-33.969zM48 208c0-88.22 71.78-160 160-160s160 71.78 160 160-71.78 160-160 160S48 296.2 48 208z"/></svg>
                </button>
            </div>
        </div>

        <div class="bottom-search">
            <!-- resumes -->
            <div class="left-site">
                <!-- item -->
                <div class="box-vacancy"
                     v-for="(resume, key) in resumes.data" :key="key"
                     :id="`v${key}`"
                     @click.prevent="transitionToResume(resume.alias)"
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
                        :settings="settings"
                        :lang="lang"
                        :contact_list="contact_list"
                        :ids_respond="ids_respond"
                        :page="'search'"
                    ></resume_template>

                    <div class="footer-vacancy">
                        <!-- отображение прошедшего времени -->
                        <div class="date-document">
                            {{getDateDocumentString(resume.updated_at)}} назад
                            <!-- вакансия закрыта -->
                            <div class="close-document-fon"
                                 v-if="resume.job_posting.status_name == 'hidden'"
                            >
                                Вакансия закрыта
                            </div>
                        </div>

                        <!-- кнопки закладок вакансий -->
                        <bookmark_buttons
                            :lang="lang"
                            :resume="resume"
                            :user="user"
                            :which_button_show="'search_resume'"
                            @return="pageReload"
                        ></bookmark_buttons>
                    </div>

                </div>

                <pagination
                    v-if="resumes.last_page > 1"
                    :pagination="resumes"
                    @paginate="urlReload"
                    :offset="1"
                >
                </pagination>
            </div>

            <!-- search panel -->
            <div class="right-site">
                <search_panel
                    :lang="lang"
                    :settings="settings"
                    :page="'search_resumes'"
                    @returnParent="getResumes"
                ></search_panel>
            </div>
        </div>
    </div>
</template>

<script>
    import pagination from "../details/PaginationComponent";
    import search_panel from '../details/SearchPanelComponent.vue'
    import bookmark_buttons from './details/BookmarkButtonsResumeComponent'
    import resume_template from "./details/ResumeTemplateComponent";

    import general_functions_mixin from "../../mixins/general_functions_mixin.js";
    import response_methods_mixin from "../../mixins/response_methods_mixin";
    import translation from "../../mixins/translation";
    import date_mixin from "../../mixins/date_mixin";
    import bookmark_vacancies_mixin from "../../mixins/bookmark_vacancies_mixin";
    import search_input_mixin from "../../mixins/search_input_mixin";

    export default {
        components: {
            'pagination': pagination,
            'search_panel': search_panel,
            'bookmark_buttons': bookmark_buttons,
            'resume_template': resume_template,
        },
        mixins: [
            general_functions_mixin,
            response_methods_mixin,
            bookmark_vacancies_mixin,
            translation,
            date_mixin,
            search_input_mixin
        ],
        data() {
            return {
                name_query: 'position',
                name_url: 'resume',
                contact_list: [],
                position: '',
                position_list: [],
                description: 'Вакансія для фахівців-початківців з кібербезпеки, які хочуть брати участь у тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів⁠',
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
            getResumes(obj){
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

                location.href = this.lang.prefix_lang+'resume'+query
            },
            setValuePosition(value){
                $('#position_list').removeClass('show')
                this.position = value
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
            addressView(resumeObj){
                let address_string = ''

                if(resumeObj.country !== null){
                    address_string += resumeObj.country.name+'.'
                }
                if(resumeObj.region !== null){
                    address_string += ' ' + resumeObj.region.name+'.'
                }
                if(resumeObj.city !== null){
                    address_string += ' ' + resumeObj.city.name+'.'
                }

                address_string += ' ' + resumeObj.rest_address+'.'

                return address_string
            },
        },
        props: [
            'lang',
            'settings',
            'resumes',
            'ids_respond',
            'user',
        ],
        mounted() {
            console.log(this.resumes)

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
            padding: 30px 15px 0;
            .left-site{
                min-width: 77%;
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





























