<template>
    <div id="table_page">

        <div id="google_translate_element"></div>

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
                            <div class="card-header"> </div>

                            <!-- body -->
                            <div class="row card-body">

                                <!-- Table 1 -->
                                <table id="main-table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr class="row">
                                        <th class="col-sm-1"> id </th>
                                        <th class="col-sm-5">название</th>
                                        <th class="col-sm-1">включен пользователем</th>
                                        <th class="col-sm-1">проверен админом</th>
                                        <th class="col-sm-1">доспуск к показам</th>
                                        <th class="col-sm-2">создан</th>
                                        <th class="col-sm-1">меню</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(vacancy, key) in vacancies.data" :key="key">
                                            <td colspan="7">
                                                <div :id="`accordionExample_${key}`" class="accordion" >
                                                    <div class="card">

                                                        <!-- Table 2 -->
                                                        <table class="">
                                                            <tr class="row">
                                                                <td class="col-sm-1">
                                                                    {{vacancy.id}}
                                                                </td>
                                                                <td class="col-sm-5">
                                                                    {{vacancy.position.title}}
                                                                </td>
                                                                <td class="col-sm-1">
                                                                    <svg :class="`small-dot ${statusView(vacancy.job_posting)}`" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M320 256c0 88.37-71.63 160-160 160S0 344.37 0 256 71.63 96 160 96s160 71.6 160 160z"/></svg>
                                                                </td>
                                                                <td class="col-sm-1">
                                                                    <svg :class="`small-dot ${accessView(vacancy.check_admin)}`" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M320 256c0 88.37-71.63 160-160 160S0 344.37 0 256 71.63 96 160 96s160 71.6 160 160z"/></svg>
                                                                </td>
                                                                <td class="col-sm-1">
                                                                    <svg :class="`small-dot ${accessView(vacancy.published)}`" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M320 256c0 88.37-71.63 160-160 160S0 344.37 0 256 71.63 96 160 96s160 71.6 160 160z"/></svg>
                                                                </td>
                                                                <td class="col-sm-2">
                                                                    {{getDateString(vacancy.created_at)}}
                                                                </td>
                                                                <!-- button menu -->
                                                                <td class="col-sm-1">
                                                                    <div class="btn-group dropleft" :id="`heading_${key}`">
                                                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            Меню
                                                                        </button>
                                                                        <div class="dropdown-menu">
                                                                            <!-- button accordion -->
                                                                            <a  :data-target="`#collapseOne_${key}`"
                                                                                :aria-controls="`collapseOne_${key}`"
                                                                                class="dropdown-item" href="javascript:void(0)"
                                                                                data-toggle="collapse"  aria-expanded="true"
                                                                            >
                                                                                Содержание
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <!-- accordion -->
                                                        <div :id="`collapseOne_${key}`"
                                                             :aria-labelledby="`heading_${key}`"
                                                             :data-parent="`#accordionExample_${key}`"
                                                             class="collapse show" >
                                                            <div class="card-body">

                                                                <div class="box-element-vacancy">
                                                                    <div class="box-title-vacancy">
                                                                        <div class="title-element-vacancy">
                                                                            Название
                                                                        </div>
                                                                        <svg @click="googleTranslateElementInit()" class="svg-translate" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M0 128C0 92.7 28.7 64 64 64H256h48 16H576c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H320 304 256 64c-35.3 0-64-28.7-64-64V128zm320 0V384H576V128H320zM178.3 175.9c-3.2-7.2-10.4-11.9-18.3-11.9s-15.1 4.7-18.3 11.9l-64 144c-4.5 10.1 .1 21.9 10.2 26.4s21.9-.1 26.4-10.2l8.9-20.1h73.6l8.9 20.1c4.5 10.1 16.3 14.6 26.4 10.2s14.6-16.3 10.2-26.4l-64-144zM160 233.2L179 276H141l19-42.8zM448 164c11 0 20 9 20 20v4h44 16c11 0 20 9 20 20s-9 20-20 20h-2l-1.6 4.5c-8.9 24.4-22.4 46.6-39.6 65.4c.9 .6 1.8 1.1 2.7 1.6l18.9 11.3c9.5 5.7 12.5 18 6.9 27.4s-18 12.5-27.4 6.9l-18.9-11.3c-4.5-2.7-8.8-5.5-13.1-8.5c-10.6 7.5-21.9 14-34 19.4l-3.6 1.6c-10.1 4.5-21.9-.1-26.4-10.2s.1-21.9 10.2-26.4l3.6-1.6c6.4-2.9 12.6-6.1 18.5-9.8l-12.2-12.2c-7.8-7.8-7.8-20.5 0-28.3s20.5-7.8 28.3 0l14.6 14.6 .5 .5c12.4-13.1 22.5-28.3 29.8-45H448 376c-11 0-20-9-20-20s9-20 20-20h52v-4c0-11 9-20 20-20z"/></svg>
                                                                    </div>
                                                                    <div :class="`value-element_${key}`">
                                                                        Presently she began looking at everything that Alice had got burnt, and eaten up by a very decided tone: 'tell her something about the crumbs,' said the King. The next thing is, to get through was more than three.' 'Your hair wants cutting,' said the King hastily said, and went on eagerly. 'That's enough about lessons,' the Gryphon went on, 'that they'd let Dinah stop in the lock, and to stand on their slates, and she jumped up and beg for its.
                                                                    </div>
                                                                </div>

                                                                <!-- buttons -->
                                                                <div class="but-box">
                                                                    <button type="submit" class="btn btn-block btn-warning"
                                                                            @click="cancelDocument(`collapseOne_${key}`)"
                                                                    >
                                                                        Закрыть
                                                                    </button>
                                                                    <button type="submit" class="btn btn-block btn-primary"
                                                                            @click="saveDocument()"
                                                                        >
                                                                        Сохранить
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

    export default {
        mixins: [
            translation,
            date_mixin,
            // general_functions_mixin,
            // response_methods_mixin,
            admin_translate_location_mixin
        ],
        components: {
            'pagination': pagination,
        },
        data() {
            return {
                vacancies: [],
                cssAction: [
                    "active",
                    "not-active"
                ],
            }
        },
        methods: {
            googleTranslateElementInit() {
                let a = new google.translate.TranslateElement({
                    pageLanguage: 'en',
                    layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                    }, 'google_translate_element');

                // заменить язык с которого перевод
                // a.ea = "uk"

                // console.log(a)

            },
            cancelDocument(id_name){
                $('#'+id_name).collapse('hide')
            },
            saveDocument(data){

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
            elementBorder(){
                let arrEl = document.querySelectorAll(".dropdown-item")
                for(let i = 0; i < arrEl.length; i++){
                    arrEl[i].addEventListener("click", (element)=>{
                        let borderEl = document.querySelector(".target-border")
                        if(borderEl !== null){
                            borderEl.classList.remove('target-border')
                        }
                        element.currentTarget.closest("tr").classList.add('target-border')
                    }, true);
                }
            },
        },
        props: [
            'lang',
            'response',
        ],
        mounted() {
            this.vacancies = this.response.vacancies
            // console.log(this.vacancies)

            this.$nextTick(function () {
                this.elementBorder()



            })


        },
    }
</script>

<style scoped lang="scss">

    .box-element-vacancy{
        text-align: left;
        outline: 1px solid #dee2e6;
        padding: 10px;
        .box-title-vacancy{
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            border-bottom: 1px solid #3490dc;
            .title-element-vacancy{
                font-weight: 700;
                font-size: 16px;
            }
            .svg-translate{
                width: 35px;
                fill: #3490dc;
                cursor: pointer;
                &:hover{
                    fill: #0370c9;
                }
            }
        }
    }
    .row{
        margin: 0;
    }
    .target-border{
        outline: 1px solid red;
        margin: 1px;
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
        table{
            td{
                border: 1px solid #dee2e6;
                padding: 0.75rem;
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                align-content: center;
            }
        }
        .but-box{
            display: flex;
            justify-content: center;
            button{
                max-width: 160px;
            }
            button:nth-child(1) {
                margin-right: 20px;
            }
        }
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

</style>

