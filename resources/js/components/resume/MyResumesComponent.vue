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

            <a class="btn btn-block btn-primary" id="create-vacancy" :href="`${lang.prefix_lang}private-office/resume/create`">Добавить резюме</a>
        </div>
        <!-- title -->
        <h1 class="title_page card-body">
            <u>{{trans('vacancies','my')}}</u>
            резюме
        </h1>

        <!-- No resume -->
        <div v-if="!lookingValueInArrayObjects('type', 0, resumes)"
             class="callout callout-warning"
        >
            <b>Резюме отсутствуют.</b>
            <div>
                На этой странице отображаются ваши собственные резюме. Имеете доступ управления ими и просматриваете отклики работодателей на них.
                <br>
                <a class="link-a" target="_blank"
                   :href="`${lang.prefix_lang}private-office/resume/create`"
                >Создайте резюме</a>
                 и начните получать предложения от заинтересованных работодателей.
            </div>
        </div>
        <div v-else class="desc-helper-italic">
            Помогает отслеживать и иметь быстрый доступ к необходимому резюме.
        </div>

        <!-- resumes -->
        <div class="box-vacancy"
             v-for="(resume, key) in resumes" :key="key"
             :data-alias="resume.alias"
        >
            <!-- лента -->
            <div class="ribbon-wrapper">
                <div class="ribbon uk-color">
                    <svg xmlns="http://www.w3.org/2000/svg" class="uk-star-icon" viewBox="0 0 576 512"><path d="m305.3 12.57 54.9 169.03h177.6c17.6 0 24.92 22.55 10.68 32.9L404.78 319l54.89 169.1c5.44 16.76-13.72 30.69-27.96 20.33L288 403.1 144.3 507.6c-14.24 10.36-33.4-3.577-27.96-20.33l54.89-169.1L27.53 214.5c-14.25-10.3-6.93-32.9 10.68-32.9h177.6L270.7 12.5c5.5-16.69 29.1-16.69 34.6.07z"/></svg>
                </div>
            </div>
            <!-- left -->
            <div class="left-site">
                <!-- resume -->
                <resume_template
                    :resume="resume"
                    :settings="settings"
                    :lang="lang"

                ></resume_template>

                <div class="footer-vacancy">
                    <!-- отображение прошедшего времени -->
                    <div class="date-document">
                        {{getDateDocumentString(resume.updated_at)}} назад
                    </div>

                    <!-- статус -->
                    <div class="mode-vacancy"
                         v-html="getStatus(resume.resume_posting)"
                    >
                    </div>
                </div>

            </div>
            <!-- right -->

        </div>



    </div>
</template>

<script>
    import translation from '../../mixins/translation'
    import date_mixin from "../../mixins/date_mixin";
    import response_methods_mixin from "../../mixins/response_methods_mixin";
    import general_functions_mixin from "../../mixins/general_functions_mixin";
    import resume_template from "./details/ResumeTemplateComponent";

    export default {
        components: {
            'resume_template':resume_template,
        },
        mixins: [
            translation,
            date_mixin,
            general_functions_mixin,
        ],
        data() {
            return {
            }
        },
        methods: {
            // статус и дни вакансии
            getStatus(statusObj){
                let html_status = '<div class="mode standard">'
                html_status += statusObj.status_name
                html_status += '</div>'

                if(statusObj.status_name == 'hidden'){
                    html_status += '<div class="balance-mode">'
                    html_status += '~ 0 дней'
                }
                else{
                    // прибавить месяц к дате пуюликации
                    let create_date = new Date(statusObj.create_time)
                    create_date.setMonth(create_date.getMonth() + 1)
                    // сколько осталось дней у публикации
                    let count_day = this.getDifferenceDays(create_date, Date.now())

                    html_status += '<div class="balance-mode standard">'
                    html_status += '~ '+count_day+' дней'
                }

                html_status += '</div>'

                return html_status
            },
            initialData(){
                // зарплата
                $('.box-salary').css('margin-top','0')
                // h2 заголовок в моих вакансиях
                $('.title-vacancy').removeClass("col-sm-9").css('margin','0px 0 10px')
                // click menu vacancy
                $(document).on('click.bs.dropdown', '.dropdown-toggle', (e) => {
                    e.stopPropagation();
                });
                // click vacancy
                document.querySelectorAll('.box-vacancy').forEach( (el) => {
                    el.addEventListener('click', (e) => {
                        // клик по родителю
                        if ( $(e.target).hasClass("dropdown-toggle") ) {
                            return false
                        }
                        // переход по url
                        let target = e.target;
                        // с дочернего на .box-vacancy
                        let parent = target.closest('.box-vacancy');
                        if (!parent) return;

                        let alias = $(parent).attr('data-alias')
                        this.transitionToVacancy(alias)
                    })
                } );
            }
        },
        props: [
            'lang',   // масив названий и url языка
            'resumes',
            'settings',
        ],
        mounted() {
            this.initialData()

            console.log(this.resumes)
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
        .left-site{
            width: 100%;
        }
        .right-site {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-self: stretch;
            align-items: flex-end;

            .response-vacancy {
                text-align: center;
                font-weight: 600;
                line-height: 22px;
                margin-right: 5px;
            }

            .button-vacancy {
                display: flex;

                & > button {
                    margin-right: 10px;
                }
            }
        }
    }
    #create-vacancy{
        width: 175px;
    }

</style>





























