<template>
    <div class="box-vacancies">
        <a  class="link-back"
            :href="`${lang.prefix_lang}private-office`"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="m166.5 424.5-143.1-152a23.94 23.94 0 0 1-6.562-16.5 23.94 23.94 0 0 1 6.562-16.5l143.1-152c9.125-9.625 24.31-10.03 33.93-.938 9.688 9.126 10.03 24.38.938 33.94l-128.4 135.5 128.4 135.5c9.094 9.562 8.75 24.75-.938 33.94-9.53 9.058-24.73 8.658-33.93-.942z"/></svg>
            Кабинет
        </a>
        <h1 class="title_page card-body">Закладки <u>сохраненных</u> вакансий</h1>
        <!-- No vacancies -->
        <div class="callout callout-warning"
             v-if="!vacancies.length"
        >
            <b>Вакансии отсутствуют.</b>
            <div>
                В этом разделе хранятся вакансии, которые вы добавили на странице поиска вакансий при нажатии на иконку в виде
                «<svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                    <path d="M244 84L255.1 96L267.1 84.02C300.6 51.37 347 36.51 392.6 44.1C461.5 55.58 512 115.2 512 185.1V190.9C512 232.4 494.8 272.1 464.4 300.4L283.7 469.1C276.2 476.1 266.3 480 256 480C245.7 480 235.8 476.1 228.3 469.1L47.59 300.4C17.23 272.1 0 232.4 0 190.9V185.1C0 115.2 50.52 55.58 119.4 44.1C164.1 36.51 211.4 51.37 244 84C243.1 84 244 84.01 244 84L244 84zM255.1 163.9L210.1 117.1C188.4 96.28 157.6 86.4 127.3 91.44C81.55 99.07 48 138.7 48 185.1V190.9C48 219.1 59.71 246.1 80.34 265.3L256 429.3L431.7 265.3C452.3 246.1 464 219.1 464 190.9V185.1C464 138.7 430.4 99.07 384.7 91.44C354.4 86.4 323.6 96.28 301.9 117.1L255.1 163.9z"/>
                </svg>».
                Добавление вакансий, помогает отслеживать и иметь быстрый доступ. Это удобно когда вы ведете переписки с работодателем, обращаясь к нужной вам информации.
                <br>
                Чтобы сохранить вакансию, перейдите на страницу
                <a class="title-vacancy" target="_blank"
                   :href="`${lang.prefix_lang}vacancy`"
                >поиска вакансий.</a>
            </div>
        </div>
        <div v-else class="desc-helper-italic">
            Помогает отслеживать и иметь быстрый доступ к необходимой вакансии.
        </div>

        <!-- vacancies -->
        <div class="box-vacancy"
             v-for="(array, key) in arrVacancies" :key="key"
             @click="transitionToVacancy(array.vacancy.alias)"
        >

            <!-- vacancy -->
            <vacancy_template
                :vacancy="array.vacancy"
                :settings="settings"
                :lang="lang"
                :page="'bookmark'"
            ></vacancy_template>

            <!-- buttons -->
            <div class="panel-button">
                <button class="btn btn-block btn-outline-danger" type="button"
                        @click="bookmarkVacancy($event,array.vacancy.id)"
                >
                    Убрать
                </button>
            </div>

        </div>

    </div>
</template>

<script>
    import translation from '../../mixins/translation'
    import response_methods_mixin from "../../mixins/response_methods_mixin";
    import bookmark_vacancies_mixin from "../../mixins/bookmark_vacancies_mixin";
    import vacancy_template from "./details/VacancyTemplateComponent";

    export default {
        components: {
            'vacancy_template': vacancy_template,
        },
        mixins: [
            translation,
            response_methods_mixin,
            bookmark_vacancies_mixin
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
                const response = await this.$http.post(`/private-office/vacancy/bookmark-vacancy`, data)
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

    .box-vacancies{
        background-color: #fff;
        padding: 0 15px 15px;
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
                display: flex;
                justify-content: flex-end;
                margin: 15px 0 0;
                & > button:nth-child(1) {
                    margin-right: 15px;
                }
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
        .desc-helper-italic{
            font-style: italic;
            margin-bottom: 10px;
        }
    }





</style>





























