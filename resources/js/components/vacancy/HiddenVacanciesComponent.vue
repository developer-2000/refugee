<template>
    <div class="box-vacancies">
        <a  class="link-back"
            :href="`${lang.prefix_lang}private-office`"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="m166.5 424.5-143.1-152a23.94 23.94 0 0 1-6.562-16.5 23.94 23.94 0 0 1 6.562-16.5l143.1-152c9.125-9.625 24.31-10.03 33.93-.938 9.688 9.126 10.03 24.38.938 33.94l-128.4 135.5 128.4 135.5c9.094 9.562 8.75 24.75-.938 33.94-9.53 9.058-24.73 8.658-33.93-.942z"/></svg>
            Кабинет
        </a>
        <h1 class="title_page card-body">Закладки <u>скрытых</u> вакансий</h1>
        <!-- No vacancies -->
        <div class="callout callout-warning"
             v-if="!vacancies.length"
        >
            <b>Вакансии отсутствуют.</b>
            <div>
                В этом разделе хранятся вакансии, которые вы скрыли на странице поиска вакансий. Они не будут отображаться на странице поиска, предоставляя возможность увидеть новое и интересное.
                <br>
                Скрывайте вакансии всякий раз, когда точно знаете, что она вам не подходит.
            </div>
        </div>
        <div v-else class="desc-helper-italic">
            Они не будут отображаться на странице поиска, предоставляя возможность увидеть новое и интересное.
        </div>

        <!-- vacancies -->
        <div class="box-vacancy"
             v-for="(array, key) in arrVacancies" :key="key"
             @click="transitionToVacancy(array.vacancy.alias)"
        >
            <!-- title -->
            <div class="box-title-logo">
                <h2 class="title-vacancy">
                    {{array.vacancy.position.title}}
                </h2>
                <img :src="array.vacancy.employer.logo.url" alt="Test image" class="img-logo">
            </div>
            <!-- salary -->
            <div class="line-div">
                <div class="font-weight-bold">
                    {{salaryView(array.vacancy.salary)}} euro
                </div>
                <div class="address-comment"
                     v-if="array.vacancy.salary.comment !== null"
                >
                    <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/>
                    </svg>
                    {{array.vacancy.salary.comment}}
                </div>
            </div>
            <!-- company -->
            <div class="line-div">
                <div class="font-weight-bold">
                    {{array.vacancy.employer.title}}
                </div>
                <div class="address-comment">
                    <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/>
                    </svg>
                    {{addressView(array.vacancy)}}
                </div>
            </div>
            <!-- buttons -->
            <div class="panel-button">
                <button class="btn btn-block btn-outline-danger btn-sm" type="button"
                        @click="bookmarkVacancy($event, array.vacancy.id)"
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

    export default {
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





























