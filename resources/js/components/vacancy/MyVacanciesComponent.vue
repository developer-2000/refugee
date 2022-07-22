<template>
    <div class="box-page">
        <!-- обратная ссылка -->
        <div class="top-panel bread-top-cabinet">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="m166.5 424.5-143.1-152a23.94 23.94 0 0 1-6.562-16.5 23.94 23.94 0 0 1 6.562-16.5l143.1-152c9.125-9.625 24.31-10.03 33.93-.938 9.688 9.126 10.03 24.38.938 33.94l-128.4 135.5 128.4 135.5c9.094 9.562 8.75 24.75-.938 33.94-9.53 9.058-24.73 8.658-33.93-.942z"/></svg>
                <a :href="`${lang.prefix_lang}private-office`">
                    {{trans('menu.menu','cabinet')}}
                </a>
                <span class="bread-slash"> | </span>
            </div>

            <a class="btn btn-block btn-primary" id="create-vacancy" :href="`${lang.prefix_lang}private-office/vacancy/create`">Добавить вакансию</a>
        </div>
        <!-- title -->
        <h1 class="title_page card-body">
            <u>{{trans('vacancies','my')}}</u>
            {{trans('vacancies','vacancies')}}
        </h1>

        <!-- No vacancies -->
        <div class="callout callout-warning"
             v-if="!vacancies.length"
        >
            <b>{{trans('vacancies','no_vacancies')}}</b>
            <div>
                {{trans('vacancies','your_personal_vacancies')}}
                <br>
                <a class="link-a" target="_blank"
                   :href="`${lang.prefix_lang}private-office/vacancy/create`"
                >{{trans('vacancies','create_job')}}</a>
                {{trans('vacancies','and_start_receiving')}}
            </div>
        </div>
        <div v-else class="desc-helper-italic">
            {{trans('vacancies','helps_you_track_have')}}
        </div>

        <!-- vacancies -->
        <a class="box-vacancy"
           v-for="(vacancy, key) in vacancies" :key="key"
           :href="getGenerateUrlDocument(vacancy, 'vacancy')"
           :class="{'close-document-border': vacancy.job_posting.status_name == 'hidden' }"
        >
            <!-- лента -->
            <div class="ribbon-wrapper">
                <div class="ribbon euro-color">
                    <svg xmlns="http://www.w3.org/2000/svg" class="euro-star-icon" viewBox="0 0 576 512"><path d="m305.3 12.57 54.9 169.03h177.6c17.6 0 24.92 22.55 10.68 32.9L404.78 319l54.89 169.1c5.44 16.76-13.72 30.69-27.96 20.33L288 403.1 144.3 507.6c-14.24 10.36-33.4-3.577-27.96-20.33l54.89-169.1L27.53 214.5c-14.25-10.3-6.93-32.9 10.68-32.9h177.6L270.7 12.5c5.5-16.69 29.1-16.69 34.6.07z"/></svg>
                </div>
            </div>

            <!-- vacancy -->
            <vacancy_template
                :vacancy="vacancy"
                :settings="settings"
                :lang="lang"
                :page="'my_vacancies'"
            ></vacancy_template>

        </a>
    </div>
</template>

<script>
    import translation from '../../mixins/translation'
    import response_methods_mixin from "../../mixins/response_methods_mixin";
    import bookmark_vacancies_mixin from "../../mixins/bookmark_vacancies_mixin";
    import vacancy_template from "./details/VacancyTemplateComponent";
    import general_functions_mixin from "../../mixins/general_functions_mixin";
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
            initialData(){
                // click menu vacancy
                $(document).on('click.bs.dropdown', '.dropdown-toggle', (e) => {
                    e.stopPropagation();
                });
            }
        },
        props: [
            'lang',   // масив названий и url языка
            'settings',
            'vacancies',
        ],
        mounted() {
            this.initialData()
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .top-panel{
        display: flex;
        justify-content: space-between;
        &>div{
            display: flex;
            align-items: center;
        }
    }
    .box-vacancy {
        display: flex;
        justify-content: space-between;
        .salary-vacancy {
            display: flex;
            .salary {
                color: $black;
                margin-right: 4px;
                white-space: nowrap;
                svg {
                    width: 12px;
                    margin-bottom: 2px;
                    path {
                        fill: $euro-color-blue;
                    }
                }
            }
        }
    }
    #create-vacancy{
        width: 175px;
    }
    .mode-vacancy{
        margin: 0 20px 0 0;
    }

</style>





























