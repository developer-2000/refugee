<template>
    <div class="search-panel">
        <h1 class="title_page">
            Поиск вакансий
        </h1>

        <!-- search line -->
        <div class="top-search">
            <div class="form-group">
                <input type="text" class="form-control" maxlength="100" autocomplete="off"
                       placeholder="Поиск"
                       v-model="search_value"
                >
                <button type="button" class="btn btn-block btn-primary">Искать</button>
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
                    <!-- title -->
                    <div class="box-title-logo">
                        <h2 class="title-vacancy">
                            {{vacancy.position.title}}
                        </h2>
                        <img :src="vacancy.employer.logo.url" alt="Test image" class="img-logo">
                    </div>
                    <!-- salary -->
                    <div class="line-div">
                        <div class="font-weight-bold">
                            {{salaryView(vacancy.salary)}} euro
                        </div>
                        <div class="address-comment"
                             v-if="vacancy.salary.comment !== null"
                        >
                            <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/>
                            </svg>
                            {{vacancy.salary.comment}}
                        </div>
                    </div>
                    <!-- company -->
                    <div class="line-div">
                        <div class="font-weight-bold">
                            {{vacancy.employer.title}}
                        </div>
                        <div class="address-comment">
                            <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/>
                            </svg>
                            {{addressView(vacancy)}}
                        </div>
                    </div>
                    <!-- experience -->
                    <div class="line-div">
                        <div class="address-comment">
                            {{settings.type_employment[vacancy.type_employment]}}
                            <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/>
                            </svg>
                            {{settings.work_experience[vacancy.experience]}}
                        </div>
                    </div>
                    <!-- description -->
                    <div class="line-div">
                        <div class="address-comment display-inline">
                            <template v-if="vacancy.text_description">
                                {{ cutTags(vacancy.text_description).slice(0, 150) }}
                                <div class="link-vacancy display-inline">
                                    ...
                                    <svg viewBox="0 0 320 512" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"/>
                                    </svg>
                                </div>
                            </template>
                        </div>
                    </div>
                    <!-- кнопки закладок вакансий -->
                    <bookmark_buttons
                        :lang="lang"
                        :vacancy="vacancy"
                        :user="user"
                        :which_button_show="'search_vacancy'"
                    ></bookmark_buttons>
                </div>
            </div>

            <!-- search panel -->
            <div class="right-site">
                <search_panel
                    :lang="lang"
                    :settings="settings"
                    @returnParent="updateData"
                ></search_panel>
            </div>
        </div>
    </div>
</template>

<script>
    import search_panel from './SearchPanelVacancyComponent.vue'
    import bookmark_buttons from './details/BookmarkButtonsVacancyComponent'
    import general_functions_mixin from "../../mixins/general_functions_mixin.js";

    export default {
        components: {
            'search_panel': search_panel,
            'bookmark_buttons': bookmark_buttons,
        },
        mixins: [
            general_functions_mixin,
        ],
        data() {
            return {
                search_value: '',
                description: 'Вакансія для фахівців-початківців з кібербезпеки, які хочуть брати участь у тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів⁠',
            }
        },
        methods: {
            updateData(data){
                console.log(data)
            },
            transitionToVacancy(vacancy_alias){
                location.href = this.lang.prefix_lang+'vacancy/'+vacancy_alias+'?country=US'
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
                input{
                    border-radius: 4px 0 0 4px;
                    min-width: 75%;
                    font-size: 18px;
                    height: 38px;
                    padding-right: 30px;
                }
                button{
                    border-radius: 0 4px 4px 0;
                    min-width: 25%;
                    font-size: 18px;
                    height: 38px;
                    line-height: 0;
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
                min-width: 25%;
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
    }

</style>





























