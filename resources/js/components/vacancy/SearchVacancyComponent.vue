<template>
    <div class="search-panel">
        <h1 class="title_page">
            Поиск вакансий
        </h1>

        <!-- search line -->
        <div class="top-search">
            <div class="form-group">
                <div class="box-position">
                    <input type="text" class="form-control" maxlength="100" autocomplete="off"
                           placeholder="Поиск"
                           v-model="position"
                           @keyup="searchPosition($event.target.value)"
                    >
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
                        @click="getVacancies({page:null})"
                >Искать</button>
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
                    <!-- vacancy -->
                    <vacancy_template
                        :vacancy="vacancy"
                        :settings="settings"
                        :lang="lang"
                        :page="'search'"
                    ></vacancy_template>

                    <!-- кнопки закладок вакансий -->
                    <bookmark_buttons
                        :lang="lang"
                        :vacancy="vacancy"
                        :user="user"
                        :which_button_show="'search_vacancy'"
                    ></bookmark_buttons>
                </div>

                <pagination
                    :pagination="vacancies"
                    @paginate="getVacancies"
                    :offset="1"
                >
                </pagination>


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
    import pagination from "./details/PaginationComponent";
    import search_panel from './SearchPanelVacancyComponent.vue'
    import bookmark_buttons from './details/BookmarkButtonsVacancyComponent'
    import general_functions_mixin from "../../mixins/general_functions_mixin.js";
    import vacancy_template from "./details/VacancyTemplateComponent";
    import response_methods_mixin from "../../mixins/response_methods_mixin";

    export default {
        components: {
            'pagination': pagination,
            'search_panel': search_panel,
            'bookmark_buttons': bookmark_buttons,
            'vacancy_template': vacancy_template,
        },
        mixins: [
            general_functions_mixin,
            response_methods_mixin,
        ],
        data() {
            return {
                position: '',
                position_list: [],
                description: 'Вакансія для фахівців-початківців з кібербезпеки, які хочуть брати участь у тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів тестуванні безпеки web-проєктів⁠',
            }
        },
        methods: {
            getVacancies(obj){
                let params = new URLSearchParams(window.location.search)
                params.delete('page')
                params.delete('position')

                // page
                if(obj.page != undefined && obj.page != null){
                    params.set('page',obj.page)
                }
                // position
                if(this.position != ''){
                    params.set('position',this.position)
                }

                location.href = this.lang.prefix_lang+'vacancy?'+params.toString()
            },
            async searchPosition(value){
                if(!value.length){
                    $('#position_list').removeClass('show')
                    return false
                }
                let data = {
                    value: value,
                };
                const response = await this.$http.post(`/private-office/vacancy/search-position`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            console.log(res)
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
            updateData(data){
                console.log(data)
            },
            transitionToVacancy(vacancy_alias){
                location.href = this.lang.prefix_lang+'vacancy/'+vacancy_alias
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

            // https://flaviocopes.com/urlsearchparams/
            const params = new URLSearchParams(window.location.search)
            if(params.has('position')){
                // console.log( params.get('position') )
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
                    min-width: 75%;
                    input{
                        border-radius: 4px 0 0 4px;
                        font-size: 18px;
                        height: 38px;
                        padding-right: 30px;
                    }
                }
                button{
                    border-radius: 0 4px 4px 0;
                    min-width: 25%;
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





























