<template>
    <div id="table_page">

        <!-- Title -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            Вакансии
                        </h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-12">
                        <div class="card">
                            <!-- header (buttons) -->
                            <div class="card-header">
                                <div class="left-card-header">
                                    <!-- сбросить все-->
                                    <a v-if="locationSearch !== ''"
                                       href="javascript:void(0)"
                                       @click="clearQuery()"
                                    > Сбросить фильтры </a>
                                </div>

                                <!-- перевод страницы гуглом -->
                                <div class="right-card-header">
                                    <svg @click="googleTranslateElementInit()" class="svg-translate" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M0 128C0 92.7 28.7 64 64 64H256h48 16H576c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H320 304 256 64c-35.3 0-64-28.7-64-64V128zm320 0V384H576V128H320zM178.3 175.9c-3.2-7.2-10.4-11.9-18.3-11.9s-15.1 4.7-18.3 11.9l-64 144c-4.5 10.1 .1 21.9 10.2 26.4s21.9-.1 26.4-10.2l8.9-20.1h73.6l8.9 20.1c4.5 10.1 16.3 14.6 26.4 10.2s14.6-16.3 10.2-26.4l-64-144zM160 233.2L179 276H141l19-42.8zM448 164c11 0 20 9 20 20v4h44 16c11 0 20 9 20 20s-9 20-20 20h-2l-1.6 4.5c-8.9 24.4-22.4 46.6-39.6 65.4c.9 .6 1.8 1.1 2.7 1.6l18.9 11.3c9.5 5.7 12.5 18 6.9 27.4s-18 12.5-27.4 6.9l-18.9-11.3c-4.5-2.7-8.8-5.5-13.1-8.5c-10.6 7.5-21.9 14-34 19.4l-3.6 1.6c-10.1 4.5-21.9-.1-26.4-10.2s.1-21.9 10.2-26.4l3.6-1.6c6.4-2.9 12.6-6.1 18.5-9.8l-12.2-12.2c-7.8-7.8-7.8-20.5 0-28.3s20.5-7.8 28.3 0l14.6 14.6 .5 .5c12.4-13.1 22.5-28.3 29.8-45H448 376c-11 0-20-9-20-20s9-20 20-20h52v-4c0-11 9-20 20-20z"/></svg>
                                    <div id="google_translate_element"></div>
                                </div>
                            </div>

                            <!-- body -->
                            <div class="row card-body">

                                <!-- Table 1 -->
                                <table id="main-table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr class="row">
                                        <th class="col-sm-1"> id </th>
                                        <th class="col-sm-4">название</th>
                                        <th class="col-sm-1">перепроверка blocked</th>
                                        <th class="col-sm-1">включен пользователем</th>
                                        <th class="col-sm-1">допуск к показам</th>
                                        <th class="col-sm-1">проверен админом</th>
                                        <th class="col-sm-1">создан</th>
                                        <th class="col-sm-2">меню</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(vacancy, key) in vacancies" :key="key">
                                            <td colspan="8">
                                                <div :id="`accordionExample_${key}`" class="accordion" >
                                                    <div class="card">

                                                        <!-- Table 2 -->
                                                        <table class="table-document" :id="`table-document_${key}`" :data-index="key">
                                                            <tr class="row">
                                                                <!-- id -->
                                                                <td class="col-sm-1">
                                                                    {{vacancy.id}}
                                                                </td>
                                                                <!-- название -->
                                                                <td class="col-sm-4">
                                                                    {{vacancy.position.title}}
                                                                </td>
                                                                <!-- перепроверка -->
                                                                <td class="col-sm-1">
                                                                    <svg v-if="checkBlocked(vacancy)" class="small-dot active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M320 256c0 88.37-71.63 160-160 160S0 344.37 0 256 71.63 96 160 96s160 71.6 160 160z"/></svg>
                                                                    <svg v-else class="svg-pirate" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M400 128c0 44.4-25.4 83.5-64 106.4V256c0 17.7-14.3 32-32 32H208c-17.7 0-32-14.3-32-32V234.4c-38.6-23-64-62.1-64-106.4C112 57.3 176.5 0 256 0s144 57.3 144 128zM200 176c17.7 0 32-14.3 32-32s-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32zm144-32c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32zM35.4 273.7c7.9-15.8 27.1-22.2 42.9-14.3L256 348.2l177.7-88.8c15.8-7.9 35-1.5 42.9 14.3s1.5 35-14.3 42.9L327.6 384l134.8 67.4c15.8 7.9 22.2 27.1 14.3 42.9s-27.1 22.2-42.9 14.3L256 419.8 78.3 508.6c-15.8 7.9-35 1.5-42.9-14.3s-1.5-35 14.3-42.9L184.4 384 49.7 316.6c-15.8-7.9-22.2-27.1-14.3-42.9z"/></svg>
                                                                </td>
                                                                <!-- включен пользователем -->
                                                                <td class="col-sm-1">
                                                                    <svg :class="`small-dot ${statusView(vacancy.job_posting)}`" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M320 256c0 88.37-71.63 160-160 160S0 344.37 0 256 71.63 96 160 96s160 71.6 160 160z"/></svg>
                                                                </td>
                                                                <!-- допуск к показам -->
                                                                <td class="col-sm-1">
                                                                    <svg :class="`small-dot ${accessView(vacancy.published)}`" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M320 256c0 88.37-71.63 160-160 160S0 344.37 0 256 71.63 96 160 96s160 71.6 160 160z"/></svg>
                                                                </td>
                                                                <!-- проверен админом -->
                                                                <td class="col-sm-1">
                                                                    <svg :class="`small-dot ${accessView(vacancy.check_admin)}`" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M320 256c0 88.37-71.63 160-160 160S0 344.37 0 256 71.63 96 160 96s160 71.6 160 160z"/></svg>
                                                                </td>
                                                                <!-- создан -->
                                                                <td class="col-sm-1">
                                                                    {{getDateString(vacancy.created_at)}}
                                                                </td>
                                                                <!-- button menu -->
                                                                <td class="col-sm-2 box-button">

                                                                    <!-- button accordion -->
                                                                    <a  :data-target="`#dataDocument_${key}`"
                                                                        :aria-controls="`dataDocument_${key}`"
                                                                        class="link-a" href="javascript:void(0)"
                                                                        data-toggle="collapse"  aria-expanded="true"
                                                                        @click="elementBorder(`table-document_${key}`)"
                                                                    >
                                                                        Содержание
                                                                    </a>
                                                                    <a  :data-target="`#statisticDocument_${key}`"
                                                                        :aria-controls="`statisticDocument_${key}`"
                                                                        class="link-a" href="javascript:void(0)"
                                                                        data-toggle="collapse"  aria-expanded="true"
                                                                        @click="elementBorder(`table-document_${key}`)"
                                                                    >
                                                                        Статистика
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </table>

                                                        <!-- dataDocument Accordion -->
                                                        <div :id="`dataDocument_${key}`"
                                                             :data-parent="`#accordionExample_${key}`"
                                                             class="collapse">
                                                            <div class="card-body">

                                                                <!-- Название -->
                                                                <div class="box-element-vacancy">
                                                                    <div class="title-element-vacancy">
                                                                        Название
                                                                    </div>
                                                                    <div :class="`value-element value-element_${key} important`">
                                                                        {{vacancy.position.title}}
                                                                    </div>
                                                                </div>

                                                                <!-- Зарплата -->
                                                                <div class="box-element-vacancy">
                                                                    <div class="title-element-vacancy">
                                                                        Зарплата
                                                                    </div>
                                                                    <div :class="`value-element value-element_${key}`">
                                                                        {{salaryView(vacancy.salary)}}
                                                                        <span v-if="vacancy.salary.comment !== null" class=" important">
                                                                        &nbsp;( {{vacancy.salary.comment}} )
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                <!-- Язык вакансии -->
                                                                <div class="box-element-vacancy">
                                                                    <div class="title-element-vacancy">
                                                                        Язык вакансии
                                                                    </div>
                                                                    <div :class="`value-element value-element_${key}`">
                                                                        <template v-for="(value, key) in vacancy.languages">
                                                                            {{lang.lang[value].title}},
                                                                        </template>
                                                                    </div>
                                                                </div>

                                                                <!-- Категория вакансии -->
                                                                <div class="box-element-vacancy">
                                                                    <div class="title-element-vacancy">
                                                                        Категория вакансии
                                                                    </div>
                                                                    <div :class="`value-element value-element_${key}`"
                                                                         v-html="viewCategories(vacancy.categories)"
                                                                    >
                                                                    </div>
                                                                </div>

                                                                <!-- Адрес -->
                                                                <div class="box-element-vacancy">
                                                                    <div class="title-element-vacancy">
                                                                        Адрес
                                                                    </div>
                                                                    <div :class="`value-element value-element_${key} important`">
                                                                        {{addressView(vacancy)}}
                                                                    </div>
                                                                </div>

                                                                <!-- Локация работы -->
                                                                <div class="box-element-vacancy">
                                                                    <div class="title-element-vacancy">
                                                                        Локация работы
                                                                    </div>
                                                                    <div :class="`value-element value-element_${key}`">
                                                                        {{trans('vacancies',settings.type_employment[vacancy.type_employment])}}
                                                                    </div>
                                                                </div>

                                                                <!-- Требования к опыту -->
                                                                <div class="box-element-vacancy">
                                                                    <div class="title-element-vacancy">
                                                                        Требования к опыту
                                                                    </div>
                                                                    <div :class="`value-element value-element_${key}`">
                                                                        {{UpperCaseFirstCharacter( trans('vacancies',settings.work_experience[vacancy.experience]) )}}
                                                                    </div>
                                                                </div>

                                                                <!-- Образование -->
                                                                <div class="box-element-vacancy">
                                                                    <div class="title-element-vacancy">
                                                                        Образование вакансии
                                                                    </div>
                                                                    <div :class="`value-element value-element_${key}`">
                                                                        {{UpperCaseFirstCharacter( trans('vacancies',settings.education[vacancy.education]) )}}
                                                                    </div>
                                                                </div>

                                                                <!-- Возраст -->
                                                                <div class="box-element-vacancy">
                                                                    <div class="title-element-vacancy">
                                                                        Возраст
                                                                    </div>
                                                                    <!-- указан -->
                                                                    <div v-if="vacancy.vacancy_suitable.radio_name == 'set_age'"
                                                                         :class="`value-element value-element_${key}`"
                                                                    >
                                                                        {{vacancy.vacancy_suitable.inputs.from}} - {{vacancy.vacancy_suitable.inputs.to}} {{trans('vacancies','years')}}
                                                                    </div>
                                                                    <!-- не имеет значения -->
                                                                    <div v-else-if="vacancy.vacancy_suitable.radio_name == 'it_not_matter'"
                                                                         :class="`value-element value-element_${key}`"
                                                                    >
                                                                        {{UpperCaseFirstCharacter( trans('vacancies',vacancy.vacancy_suitable.radio_name) )}}
                                                                    </div>
                                                                    <!-- comment -->
                                                                    <div :class="`value-element value-element_${key} important`"
                                                                         v-if="vacancy.vacancy_suitable.comment !== null"
                                                                    >
                                                                        - {{vacancy.vacancy_suitable.comment}}
                                                                    </div>
                                                                </div>

                                                                <!-- Описание вакансии -->
                                                                <div class="box-element-vacancy">
                                                                    <div class="title-element-vacancy">
                                                                        Описание вакансии
                                                                    </div>
                                                                    <div :class="`value-element value-element_${key}`" class=" important"
                                                                         v-html="vacancy.text_description"
                                                                    ></div>
                                                                </div>

                                                                <!-- Условия работы -->
                                                                <div class="box-element-vacancy">
                                                                    <div class="title-element-vacancy">
                                                                        Условия работы
                                                                    </div>
                                                                    <div :class="`value-element value-element_${key}`" class=" important"
                                                                         v-html="vacancy.text_working"
                                                                    ></div>
                                                                </div>

                                                                <!-- Обязанности кандидата -->
                                                                <div class="box-element-vacancy">
                                                                    <div class="title-element-vacancy">
                                                                        Обязанности кандидата
                                                                    </div>
                                                                    <div :class="`value-element value-element_${key}`" class=" important"
                                                                         v-html="vacancy.text_responsibilities"
                                                                    ></div>
                                                                </div>

                                                                <!-- buttons -->
                                                                <div class="but-box">
                                                                    <button type="submit" class="btn btn-block btn-warning"
                                                                            @click="cancelDocument(`dataDocument_${key}`)"
                                                                    >
                                                                        Свернуть
                                                                    </button>
                                                                    <button type="submit" class="btn btn-block btn-danger"
                                                                            @click="verifiedByAdmin(0, vacancy.id, `dataDocument_${key}`)"
                                                                    >
                                                                        Заблокировать
                                                                    </button>
                                                                    <button type="submit" class="btn btn-block btn-primary"
                                                                            @click="verifiedByAdmin(1, vacancy.id, `dataDocument_${key}`)"
                                                                        >
                                                                        Допустить
                                                                    </button>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <!-- statisticDocument Accordion -->
                                                        <div :id="`statisticDocument_${key}`"
                                                             :aria-labelledby="`heading_${key}`"
                                                             :data-parent="`#accordionExample_${key}`"
                                                             class="collapse">
                                                            <div class="card-body">

                                                                <!-- Table 3 -->
                                                                <table class="table-statistic" :id="`table-statistic_${key}`">
                                                                    <thead>
                                                                    <tr class="row">
                                                                        <th class="col-sm-1">user id</th>
                                                                        <th class="col-sm-1">показы</th>
                                                                        <th class="col-sm-1">просмотры</th>
                                                                        <th class="col-sm-1">отклики</th>
                                                                        <th class="col-sm-8">обновления</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr class="row">
                                                                            <td class="col-sm-1">
                                                                                <a :href="`/admin-panel/users?user_id=${vacancy.user_id}`"
                                                                                   class="link-a" target="_blank"
                                                                                >
                                                                                    {{vacancy.user_id}}
                                                                                </a>
                                                                            </td>
                                                                            <td class="col-sm-1">{{vacancy.statistic.show}}</td>
                                                                            <td class="col-sm-1">{{vacancy.statistic.view}}</td>
                                                                            <td class="col-sm-1">{{vacancy.statistic.respond}}</td>
                                                                            <td class="col-sm-8">{{vacancy.statistic.update}}</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>

                                                                <!-- buttons -->
                                                                <div class="but-box">
                                                                    <button type="submit" class="btn btn-block btn-warning"
                                                                            @click="cancelDocument(`statisticDocument_${key}`)"
                                                                    >
                                                                        Свернуть
                                                                    </button>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div v-if="!vacancies.length" class="image-not-found"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <pagination
            v-if="vacancies.last_page > 1"
            :pagination="vacancies"
            @paginate="urlReload"
            :offset="1"
        >
        </pagination>

    </div>
</template>

<script>
    import general_functions_mixin from "../../../../mixins/general_functions_mixin";
    import response_methods_mixin from "../../../../mixins/response_methods_mixin";
    import admin_translate_location_mixin from "../../../../mixins/admin/admin_translate_location_mixin";
    import pagination from "../../../details/PaginationComponent";
    import date_mixin from "../../../../mixins/date_mixin";
    import translation from "../../../../mixins/translation";
    import template_resume_vacancy_mixin from "../../../../mixins/template_resume_vacancy_mixin";

    export default {
        mixins: [
            translation,
            date_mixin,
            general_functions_mixin,
            response_methods_mixin,
            admin_translate_location_mixin,
            template_resume_vacancy_mixin
        ],
        components: {
            'pagination': pagination,
        },
        data() {
            return {
                settings: [],
                vacancies: [],
                cssAction: [
                    "active",
                    "not-active"
                ],
                locationSearch: window.location.search,
            }
        },
        methods: {
            async verifiedByAdmin(bool, vacancy_id, id_collapse){
                let data = {
                    id: vacancy_id,
                    verified: bool,
                };
                const response = await this.$http.post(`/admin-panel/vacancies/verified-by-admin`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            this.changeObj(vacancy_id, bool)
                            this.cancelDocument(id_collapse)
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
            googleTranslateElementInit() {
                $(".svg-translate").css("display","none")
                new google.translate.TranslateElement({ layout: google.translate.TranslateElement.InlineLayout.SIMPLE }, "google_translate_element")
            },
            cancelDocument(id_name){
                $('#'+id_name).collapse('hide')
            },
            statusView(obj){
                if(obj.status_name == "standard"){
                    return this.cssAction[0]
                }
                return this.cssAction[1]
            },
            accessView(value){
                if(value == 1){
                    return this.cssAction[0]
                }
                return this.cssAction[1]
            },
            elementBorder(table_id){
                // убрать выдиление везде
                let arrTable = document.querySelectorAll(".target-border")
                for(let i = 0; i < arrTable.length; i++){
                    // parent table
                    arrTable[i].classList.remove('target-border')
                    // children table
                    let index = $(arrTable[i]).attr("data-index")
                    $("#table-statistic_"+index).removeClass('target-border2')
                }

                // выдилить target table
                let targetTable = document.querySelector("#"+table_id)
                if(targetTable !== null){
                    targetTable.classList.add('target-border')

                    let index = $("#"+table_id).attr("data-index")
                    $("#table-statistic_"+index).addClass('target-border2')
                }
            },
            // после проверки
            changeObj(vacancy_id, verified){
                for(let i = 0; i < this.vacancies.length; i++){
                    if(this.vacancies[i].id === vacancy_id){
                        this.vacancies[i].check_admin = 1
                        this.vacancies[i].published = verified
                        this.vacancies[i].job_posting.status_name = !verified ? "hidden" : 'standard'
                        break
                    }
                }
            },
            clearQuery(){
                window.location.href = location.protocol + '//' + location.host + location.pathname
            },
            viewCategories(arrCategories){
                let str = ""
                arrCategories.forEach((value, index) => {
                    str += `${this.trans('vacancies', this.settings.categories[value])}, <br/>`
                });
                return str
            },
        },
        props: [
            'lang',
            'response',
        ],
        mounted() {
            this.vacancies = this.response.vacancies.data
            this.settings = this.response.settings

            this.$nextTick(function () {})

            // console.log(this.vacancies)
        }
    }
</script>

<style scoped lang="scss">

    .important{
        background: #d1eaff;
        padding: 2px 5px;
    }
    .value-element{
        display: flex;
    }
    .card-header{
        display: flex;
        justify-content: space-between;
        align-content: center;
        .svg-translate{
            width: 50px;
            fill: #3490dc;
            cursor: pointer;
            &:hover{
                fill: #0370c9;
            }
        }
    }

    .box-element-vacancy{
        text-align: left;
        outline: 1px solid #dee2e6;
        border-left: 1px solid #3490dc;
        border-right: 1px solid #3490dc;
        padding: 10px;
        .title-element-vacancy{
            margin-bottom: 10px;
            font-weight: 700;
            font-size: 16px;
        }
    }
    .row{
        margin: 0;
    }
    .target-border{
        outline: 1px solid #3490dc;
        margin: 2px 1px;
    }
    .target-border2{
        border-top: 1px solid #3490dc;
        border-right: 1px solid #3490dc;
        border-left: 1px solid #3490dc;
    }
    #main-table{
        border: none;
        padding: 0;
        th{
            border: 1px solid #dee2e6;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-content: center;
        }
        td{
            border: none;
            padding: 0;
        }
        .card{
            border: none;
            box-shadow: none;
            border-radius: 0;
            margin: 0;
        }
        .card-body{
            padding: 0!important;
        }
        table{
            td{
                border: 1px solid #dee2e6;
                padding: 0.75rem;
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                align-content: center;
            }
            .box-button{
                justify-content: flex-start;
                flex-direction: column;
            }
        }
        .but-box{
            display: flex;
            justify-content: center;
            padding: 35px 0;
            button{
                max-width: 160px;
                margin-right: 20px;
            }
        }
    }
    .svg-pirate{
        width: 20px;
        fill: #adadad;
    }
    .small-dot{
        width: 12px;
    }
    .active{
        fill: #3d9970;
    }
    .not-active{
        fill: #dc3545;
    }
    tr td:nth-child(2){
        text-align: left;
    }
    .table-statistic{
        width: 100%;
        margin: -2px 0 0;
    }


</style>

