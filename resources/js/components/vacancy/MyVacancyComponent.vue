<template>
    <div class="box-vacancies">
        <a  class="link-back"
            :href="`${lang.prefix_lang}private-office`"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="m166.5 424.5-143.1-152a23.94 23.94 0 0 1-6.562-16.5 23.94 23.94 0 0 1 6.562-16.5l143.1-152c9.125-9.625 24.31-10.03 33.93-.938 9.688 9.126 10.03 24.38.938 33.94l-128.4 135.5 128.4 135.5c9.094 9.562 8.75 24.75-.938 33.94-9.53 9.058-24.73 8.658-33.93-.942z"/></svg>
            Кабинет
        </a>
        <h1 class="title_page card-body">{{trans('vacancies','my_vacancies')}}</h1>

        <div class="box-vacancy"
             v-for="(objVacancy, key) in user_data.vacancies" :key="key"
             :data-alias="objVacancy.alias"
        >
            <!-- left -->
            <div class="left-site">
                <!-- vacancy -->
                <vacancy_template
                    :vacancy="objVacancy"
                    :settings="settings"
                    :lang="lang"
                    :page="'my_vacancy'"
                ></vacancy_template>

                <!-- статус -->
                <div class="mode-vacancy"
                     v-html="getStatus(objVacancy.job_posting)"
                >
                </div>

            </div>
            <!-- right -->
            <div class="right-site">
                <!-- отклики -->
                <div class="response-vacancy">
                    <a href="#">
                        <div class="response-num">0</div>
                        {{trans('vacancies','responses')}}
                    </a>
                </div>
                <!-- button -->
                <div class="button-vacancy">
                    <!-- Разместить -->
                    <button type="button" class="btn btn-block btn-outline-primary"
                            v-if="objVacancy.job_posting.status_name == 'hidden'"
                            @click="changeStatus($event, objVacancy.id, 0)"
                    >
                        {{trans('vacancies','post')}}
                    </button>
                    <!-- menu -->
                    <div class="btn-group dropleft">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{trans('vacancies','functions')}}
                        </button>
                        <div class="dropdown-menu">
                            <!-- скрыть -->
                            <a class="dropdown-item" href="#"
                               v-if="objVacancy.job_posting.status_name == 'standard'"
                               @click="changeStatus($event, objVacancy.id, 1)"
                            >
                                {{trans('vacancies','hide')}}
                            </a>
                            <!-- обновить -->
                            <a class="dropdown-item" href="#"
                               v-if="objVacancy.job_posting.status_name == 'standard'"
                               @click="changeStatus($event, objVacancy.id, 0)"
                            >
                                {{trans('vacancies','update')}}
                            </a>
                            <!-- редактировать -->
                            <a class="dropdown-item"
                               :href="`${lang.prefix_lang}private-office/vacancy/${objVacancy.id}/edit`"
                            >
                                {{trans('vacancies','edit')}}
                            </a>
                            <!-- скопировать -->
                            <a class="dropdown-item" href="#"
                               @click="duplicateVacancy($event, objVacancy.id)"
                            >
                                {{trans('vacancies','copy')}}
                            </a>
                            <!-- удалить -->
                            <a class="dropdown-item" href="#"
                               @click="deleteVacancy($event, objVacancy.id)"
                            >
                                {{trans('vacancies','delete')}}
                            </a>
                        </div>
                    </div>
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
            async changeStatus(event, id, index){
                event.stopPropagation()
                let data = {
                    id: id,
                    index: index
                };
                const response = await this.$http.post(`/private-office/vacancy/up-vacancy-status`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            location.reload()
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
            async duplicateVacancy(event, id){
                event.stopPropagation()
                let data = {
                    id: id,
                };
                const response = await this.$http.post(`/private-office/vacancy/duplicate-vacancy`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            location.reload()
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
            async deleteVacancy(event, id){
                event.stopPropagation()
                const response = await this.$http.destroy(`/private-office/vacancy/` + id, {})
                    .then(res => {
                        if(this.checkSuccess(res)){
                            location.reload()
                            // console.log(res)
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
                    let count_day = this.getNumberOfDays(create_date, Date.now())

                    html_status += '<div class="balance-mode standard">'
                    html_status += '~ '+count_day+' дней'
                }

                html_status += '</div>'

                return html_status
            },
            // разница в днях
            getNumberOfDays(start, end) {
                const date1 = new Date(start);
                const date2 = new Date(end);
                // One day in milliseconds
                const oneDay = 1000 * 60 * 60 * 24;
                // Calculating the time difference between two dates
                const diffInTime = date1.getTime() - date2.getTime();
                // Calculating the no. of days between two dates
                const diffInDays = Math.round(diffInTime / oneDay);

                return diffInDays;
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
            'settings',
            'user_data',
        ],
        mounted() {
            this.initialData()
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .box-vacancies {
        background-color: #fff;
        padding: 0 15px 15px;
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

</style>





























