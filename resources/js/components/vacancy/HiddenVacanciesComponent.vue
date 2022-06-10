<template>
    <div class="box-page">
        <!-- обратная ссылка -->
        <div class="top-panel bread-top-cabinet">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="m166.5 424.5-143.1-152a23.94 23.94 0 0 1-6.562-16.5 23.94 23.94 0 0 1 6.562-16.5l143.1-152c9.125-9.625 24.31-10.03 33.93-.938 9.688 9.126 10.03 24.38.938 33.94l-128.4 135.5 128.4 135.5c9.094 9.562 8.75 24.75-.938 33.94-9.53 9.058-24.73 8.658-33.93-.942z"/></svg>
            <a :href="`${lang.prefix_lang}private-office`">
                {{trans('menu.menu','cabinet')}}
            </a>
            <span class="bread-slash"> | </span>
        </div>
        <h1 class="title_page card-body">
            {{trans('vacancies','bookmarks')}}
            <u>{{trans('vacancies','hidden_2')}}</u>
            {{trans('vacancies','vacancies_2')}}
        </h1>
        <!-- No vacancies -->
        <div class="callout callout-warning"
             v-if="!vacancies.length"
        >
            <b>{{trans('vacancies','no_vacancies')}}</b>
            <div>
                {{trans('vacancies','this_section_you_hidden')}}
                <br>
                {{trans('vacancies','hide_vacancies_whenever')}}
            </div>
        </div>
        <div v-else class="desc-helper-italic">
            {{trans('vacancies','they_not_show_up')}}
        </div>

        <!-- vacancies -->
        <div class="box-vacancy"
             v-for="(array, key) in arrVacancies" :key="key"
             @click="transitionToVacancy(array.vacancy.alias)"
        >
            <!-- лента -->
            <div class="ribbon-wrapper">
                <div class="ribbon euro-color">
                    <svg xmlns="http://www.w3.org/2000/svg" class="euro-star-icon" viewBox="0 0 576 512"><path d="m305.3 12.57 54.9 169.03h177.6c17.6 0 24.92 22.55 10.68 32.9L404.78 319l54.89 169.1c5.44 16.76-13.72 30.69-27.96 20.33L288 403.1 144.3 507.6c-14.24 10.36-33.4-3.577-27.96-20.33l54.89-169.1L27.53 214.5c-14.25-10.3-6.93-32.9 10.68-32.9h177.6L270.7 12.5c5.5-16.69 29.1-16.69 34.6.07z"/></svg>
                </div>
            </div>
            <!-- vacancy -->
            <vacancy_template
                :vacancy="array.vacancy"
                :settings="settings"
                :lang="lang"
                :page="'bookmark'"
            ></vacancy_template>

            <div class="footer-vacancy">
                <!-- отображение прошедшего времени -->
                <div class="date-document">
                    {{getDateDocumentString(array.vacancy.updated_at)}} назад
                </div>

                <!-- buttons -->
                <div class="panel-button">
                    <button class="btn btn-block btn-outline-danger" type="button"
                            @click="bookmarkVacancy($event, array.vacancy.id)"
                    >
                        {{trans('vacancies','remove')}}
                    </button>
                </div>
            </div>

        </div>

    </div>
</template>

<script>
    import translation from '../../mixins/translation'
    import response_methods_mixin from "../../mixins/response_methods_mixin";
    import bookmark_vacancies_mixin from "../../mixins/bookmark_vacancies_mixin";
    import vacancy_template from "./details/VacancyTemplateComponent";
    import date_mixin from "../../mixins/date_mixin";

    export default {
        components: {
            'vacancy_template': vacancy_template,
        },
        mixins: [
            translation,
            response_methods_mixin,
            bookmark_vacancies_mixin,
            date_mixin
        ],
        data() {
            return {
            }
        },
        methods: {
            async bookmarkVacancy(event, vacancy_id){
                event.stopPropagation()
                let data = {
                    vacancy_id: vacancy_id,
                    action: 0,
                };
                const response = await this.$http.post(`/private-office/vacancy/hide-vacancy-search`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            let response = this.vacancies.findIndex(obj => obj['vacancy']['id'] == vacancy_id)
                            if(response != -1){
                                this.vacancies.splice(response, 1)
                                this.arrVacancies = this.vacancies
                            }
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
        },
        props: [
            'lang',   // масив названий и url языка
            'vacancies',
            'settings',
        ],
        mounted() {
            this.arrVacancies = this.vacancies
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .box-page{
        .callout{
            color: #666;
            line-height: 30px;
            svg{
                path{
                    fill:#666;
                }
            }
            a{
                font-size: 17px;
            }
        }
        .box-vacancy{
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
                .link-vacancy{
                    color: #1d68a7;
                    svg{
                        margin: 0 5px 0 0;
                        path{
                            fill: #1d68a7;
                        }
                    }
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
            .display-inline{
                display: inline;
            }
            .panel-button{
                /*display: flex;*/
                /*justify-content: flex-end;*/
                /*margin: 15px 0 0;*/
                button{
                    width: auto;
                    display: flex;
                    justify-content: center;
                    &:hover svg path{
                        fill: white;
                    }
                    svg{
                        width: 17px;
                        margin-right: 5px;
                        path{
                            transition: fill 0.15s ease-in-out;
                        }
                    }
                }
                button:nth-child(1){
                    svg{
                        width: 14px;
                    }
                }
                button.save-two {
                    svg{
                        width: 14px;
                    }
                }
                button.show-two {
                    svg{
                        width: 15px;
                    }
                }
            }
        }
    }

</style>





























