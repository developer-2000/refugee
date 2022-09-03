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
        <h2 class="title_page card-body">
            {{trans('vacancies','bookmarks')}}
            <u>{{trans('vacancies','hidden_2')}}</u>
            {{trans('vacancies','resume')}}
        </h2>
        <!-- No resumes -->
        <div class="callout callout-warning"
             v-if="!resumes.length"
        >
            <b>
                {{trans('vacancies','there_no_resumes')}}.
            </b>
            <div>
                {{trans('vacancies','do_not_show2')}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M150.7 92.77C195 58.27 251.8 32 320 32C400.8 32 465.5 68.84 512.6 112.6C559.4 156 590.7 207.1 605.5 243.7C608.8 251.6 608.8 260.4 605.5 268.3C592.1 300.6 565.2 346.1 525.6 386.7L630.8 469.1C641.2 477.3 643.1 492.4 634.9 502.8C626.7 513.2 611.6 515.1 601.2 506.9L9.196 42.89C-1.236 34.71-3.065 19.63 5.112 9.196C13.29-1.236 28.37-3.065 38.81 5.112L150.7 92.77zM189.8 123.5L235.8 159.5C258.3 139.9 287.8 128 320 128C390.7 128 448 185.3 448 256C448 277.2 442.9 297.1 433.8 314.7L487.6 356.9C521.1 322.8 545.9 283.1 558.6 256C544.1 225.1 518.4 183.5 479.9 147.7C438.8 109.6 385.2 79.1 320 79.1C269.5 79.1 225.1 97.73 189.8 123.5L189.8 123.5zM394.9 284.2C398.2 275.4 400 265.9 400 255.1C400 211.8 364.2 175.1 320 175.1C319.3 175.1 318.7 176 317.1 176C319.3 181.1 320 186.5 320 191.1C320 202.2 317.6 211.8 313.4 220.3L394.9 284.2zM404.3 414.5L446.2 447.5C409.9 467.1 367.8 480 320 480C239.2 480 174.5 443.2 127.4 399.4C80.62 355.1 49.34 304 34.46 268.3C31.18 260.4 31.18 251.6 34.46 243.7C44 220.8 60.29 191.2 83.09 161.5L120.8 191.2C102.1 214.5 89.76 237.6 81.45 255.1C95.02 286 121.6 328.5 160.1 364.3C201.2 402.4 254.8 432 320 432C350.7 432 378.8 425.4 404.3 414.5H404.3zM192 255.1C192 253.1 192.1 250.3 192.3 247.5L248.4 291.7C258.9 312.8 278.5 328.6 302 333.1L358.2 378.2C346.1 381.1 333.3 384 319.1 384C249.3 384 191.1 326.7 191.1 255.1H192z"/></svg>
                <br>
                {{trans('vacancies','hidden_resumes_will')}}
            </div>
        </div>
        <div v-else class="desc-helper-italic">
            {{trans('vacancies','these_resumes_will_not_show')}}
        </div>

        <!-- resumes -->
        <a class="box-vacancy"
           v-for="(array, key) in arrResumes" :key="key"
           :href="getGenerateUrlDocument(array.resume, 'resume')"
           :class="{'close-document-border': array.resume.job_posting.status_name == 'hidden' }"
        >
            <!-- лента -->
            <div class="ribbon-wrapper">
                <div class="ribbon uk-color">
                    <svg xmlns="http://www.w3.org/2000/svg" class="uk-star-icon" viewBox="0 0 576 512"><path d="m305.3 12.57 54.9 169.03h177.6c17.6 0 24.92 22.55 10.68 32.9L404.78 319l54.89 169.1c5.44 16.76-13.72 30.69-27.96 20.33L288 403.1 144.3 507.6c-14.24 10.36-33.4-3.577-27.96-20.33l54.89-169.1L27.53 214.5c-14.25-10.3-6.93-32.9 10.68-32.9h177.6L270.7 12.5c5.5-16.69 29.1-16.69 34.6.07z"/></svg>
                </div>
            </div>
            <!-- resume -->
            <resume_template
                :resume="array.resume"
                :settings="settings"
                :lang="lang"
                :page="'bookmark'"
            ></resume_template>

            <div class="footer-vacancy">
                <!-- отображение прошедшего времени -->
                <div class="date-document">
                    {{getDateDocumentString(array.resume.updated_at)}}
                    {{trans('vacancies','back')}}
                    <!-- вакансия закрыта -->
                    <div class="close-document-fon"
                         v-if="array.resume.job_posting.status_name == 'hidden'"
                    >
                        {{trans('vacancies','vacancy_closed')}}
                    </div>
                </div>

                <!-- buttons -->
                <div class="panel-button">
                    <button class="btn btn-block btn-outline-danger" type="button"
                            @click.prevent.stop="bookmarkResume($event, array.resume.id)"
                    >
                        {{trans('vacancies','remove')}}
                    </button>
                </div>
            </div>
        </a>

    </div>
</template>

<script>
    import translation from '../../mixins/translation'
    import response_methods_mixin from "../../mixins/response_methods_mixin";
    import bookmark_vacancies_mixin from "../../mixins/bookmark_vacancies_mixin";
    import resume_template from "./details/ResumeTemplateComponent";
    import date_mixin from "../../mixins/date_mixin";
    import url_mixin from "../../mixins/url_mixin";

    export default {
        components: {
            'resume_template': resume_template,
        },
        mixins: [
            translation,
            response_methods_mixin,
            bookmark_vacancies_mixin,
            date_mixin,
            url_mixin,
        ],
        data() {
            return {
            }
        },
        methods: {
            async bookmarkResume(event, resume_id){
                event.stopPropagation()
                let data = {
                    resume_id: resume_id,
                    action: 0,
                };
                const response = await this.$http.post(`/private-office/resume/hide-resume`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            let response = this.resumes.findIndex(obj => obj['resume']['id'] == resume_id)
                            if(response != -1){
                                this.resumes.splice(response, 1)
                                this.arrResumes = this.resumes
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
            'resumes',
            'settings',
        ],
        mounted() {
            this.arrResumes = this.resumes
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





























