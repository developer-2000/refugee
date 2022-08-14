<template>
    <div class="search-panel container">

        <div class="box-title-panel">
            <h1 class="title_page">
                Лучший сайт по поиску и предоставлению работы в Европе
            </h1>

            <div class="box-flags">
                <a :href="`${lang.prefix_lang}vacancy`" class="flag">
                    <b>Найти работу</b>
                    <img alt="european flag" src="/img/custom/european flag.jpg">
                </a>
                <a :href="`${lang.prefix_lang}resume`" class="flag">
                    <b>Найти работника</b>
                    <img alt="ukrainian flag" src="/img/custom/ukrainian flag.jpg">
                </a>
            </div>

            <h2 class="title_page">
                Поиск вакансий работодателей
            </h2>

            <!-- search input line -->
            <search_title_panel
                :lang="lang"
                :respond="respond"
                :prefix="prefix_url"
            ></search_title_panel>
        </div>

        <div class="box-page">
            <h2>Используйте сервис европейского уровня</h2>

            <div class="annotation-page">Реализуй желаемое пройдя по списку описанному ниже.</div>
        </div>


        <div class="box-list row">

            <!-- 1 -->
            <div class="col-sm-4 item-list">
                <div class="title-item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path class="fa-primary" d="M344 360c0 13.25-10.75 24-24 24H192c-13.25 0-24-10.75-24-24s10.8-24 24-24h40V196.8l-14.7 9.8c-11 7.3-25.9 3.5-33.3-7.5-7.3-10.2-4.3-25.1 6.7-32.4l52-34.66a23.922 23.922 0 0 1 24.64-1.188C275.1 135 280 143.2 280 152v184h40c13.3 0 24 10.8 24 24z"/><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256 256-114.6 256-256S397.4 0 256 0zm64 384H192c-13.25 0-24-10.75-24-24s10.8-24 24-24h40V196.8l-14.7 9.8c-11 7.3-25.9 3.5-33.3-7.5-7.3-10.2-4.3-25.1 6.7-32.4l52-34.66a23.922 23.922 0 0 1 24.64-1.188C275.1 135 280 143.2 280 152v184h40c13.25 0 24 10.75 24 24s-10.7 24-24 24z" style="opacity:.4"/></svg>
                    <h3>Бесплатный сервис</h3>
                </div>

                <p>Сервис в себя включает бесплатный функционал и оповещения, позволяющий легко находить работодателя и потенциального сотрудника.</p>
            </div>

            <!-- 2 -->
            <div class="col-sm-4 item-list">
                <div class="title-item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path class="fa-primary" d="M352 360c0 13.25-10.75 24-24 24H184a23.98 23.98 0 0 1-22.39-15.38c-3.578-9.25-1.078-19.75 6.266-26.41l108.4-98.31c7.047-6.938 11.31-17 11.31-27.66s-4.266-20.72-12-28.31C259.4 172 232.9 172 216.6 187.9l-11 10.8c-9.5 9.4-25.5 9.2-33.9-.3-9.3-9.5-9.2-24.7.3-33.9l11-10.78c34.8-34.19 91.45-34.19 126.3 0 17 16.69 26.38 38.91 26.38 62.56s-9.375 45.88-26.38 62.56L246.2 336H328c13.3 0 24 10.8 24 24z"/><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256 256-114.6 256-256S397.4 0 256 0zm72 384H184a23.98 23.98 0 0 1-22.39-15.38c-3.578-9.25-1.078-19.75 6.266-26.41l108.4-98.31c7.047-6.938 11.31-17 11.31-27.66s-4.266-20.72-12-28.31C259.4 172 232.9 172 216.6 187.9l-11 10.8c-9.5 9.4-25.5 9.2-33.9-.3-9.3-9.5-9.2-24.7.3-33.9l11-10.78c34.8-34.19 91.45-34.19 126.3 0 17 16.69 26.38 38.91 26.38 62.56s-9.375 45.88-26.38 62.56L246.2 336H328c13.25 0 24 10.75 24 24s-10.7 24-24 24z" style="opacity:.4"/></svg>
                    <h3>Удобный поиск</h3>
                </div>

                <p>Сразу приступи к поиску интересующего тебя контента. Используя фильтры, сузь обьем представленной информации.</p>
                <p>
                    <b>Для работодателя – </b>
                    <a :href="`${lang.prefix_lang}resume`" class="nav-link" rel="nofollow">
                        найти сотрудника
                    </a>
                </p>
                <p>
                    <b>Для сотрудника – </b>
                    <a :href="`${lang.prefix_lang}vacancy`" class="nav-link" rel="nofollow">
                        найти вакансию
                    </a>
                </p>
            </div>

            <!-- 3 -->
            <div class="col-sm-4 item-list">
                <div class="title-item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path class="fa-primary" d="M352 300c0 46.3-37.7 84-84 84h-44.6c-28.23 0-53.2-17.1-62.13-44.78-4.188-12.59 2.609-26.19 15.19-30.38C189 304.8 202.6 311.5 206.8 324c2.4 7.2 9 12 16.6 12H268c19.84 0 36-16.16 36-36s-16.2-36-36-36h-52a24.01 24.01 0 0 1-22.38-15.31C190 239.5 192.5 229 199.8 222.3l50.5-46.3H184c-13.2 0-24-10.7-24-24s10.8-24 24-24h128a24.01 24.01 0 0 1 22.38 15.31 24 24 0 0 1-6.156 26.38L277.2 216.5c42 4.6 74.8 40.3 74.8 83.5z"/><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256 256-114.6 256-256S397.4 0 256 0zm12 384h-44.6c-28.23 0-53.2-18-62.13-44.78-4.188-12.59 2.609-26.19 15.19-30.38C189 304.8 202.6 311.5 206.8 324c2.4 7.2 9 12 16.6 12H268c19.84 0 36-16.16 36-36s-16.2-36-36-36h-52a24.01 24.01 0 0 1-22.38-15.31C190 239.5 192.5 229 199.8 222.3l50.5-46.3H184c-13.2 0-24-10.7-24-24s10.8-24 24-24h128a24.01 24.01 0 0 1 22.38 15.31 24 24 0 0 1-6.156 26.38L277.2 216.5c42 4.6 74.8 40.3 74.8 83.5 0 46.3-37.7 84-84 84z" style="opacity:.4"/></svg>
                    <h3>Быстрая авторизация </h3>
                </div>

                <p>Пройдите в личный кабинет через быструю авторизацию кнопок соцсетей -
                    <a class="nav-link" href="javascript:void(0)" rel="nofollow"
                       @click.prevent="checkAuth(lang.prefix_lang+'private-office')"
                    >
                        личный кабинет
                    </a>
                </p>
            </div>

            <!-- 4 -->
            <div class="col-sm-4 item-list">
                <div class="title-item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path class="fa-primary" d="M352 300c0 46.3-37.7 84-84 84h-44.6c-28.23 0-53.2-17.1-62.13-44.78-4.188-12.59 2.609-26.19 15.19-30.38C189 304.8 202.6 311.5 206.8 324c2.4 7.2 9 12 16.6 12H268c19.84 0 36-16.16 36-36s-16.2-36-36-36h-52a24.01 24.01 0 0 1-22.38-15.31C190 239.5 192.5 229 199.8 222.3l50.5-46.3H184c-13.2 0-24-10.7-24-24s10.8-24 24-24h128a24.01 24.01 0 0 1 22.38 15.31 24 24 0 0 1-6.156 26.38L277.2 216.5c42 4.6 74.8 40.3 74.8 83.5z"/><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256 256-114.6 256-256S397.4 0 256 0zm12 384h-44.6c-28.23 0-53.2-18-62.13-44.78-4.188-12.59 2.609-26.19 15.19-30.38C189 304.8 202.6 311.5 206.8 324c2.4 7.2 9 12 16.6 12H268c19.84 0 36-16.16 36-36s-16.2-36-36-36h-52a24.01 24.01 0 0 1-22.38-15.31C190 239.5 192.5 229 199.8 222.3l50.5-46.3H184c-13.2 0-24-10.7-24-24s10.8-24 24-24h128a24.01 24.01 0 0 1 22.38 15.31 24 24 0 0 1-6.156 26.38L277.2 216.5c42 4.6 74.8 40.3 74.8 83.5 0 46.3-37.7 84-84 84z" style="opacity:.4"/></svg>
                    <h3>Личная информация</h3>
                </div>

                <p>Заполнение не сложных форм, позволит вам полноценно начать работу.</p>

                <p>
                    <b>Работодатель – </b>
                    <a class="nav-link" href="javascript:void(0)" rel="nofollow"
                       @click.prevent="checkAuth(lang.prefix_lang+'private-office/company/create')"
                    >
                        Моя компания
                    </a>
                    ,
                    <a class="nav-link" href="javascript:void(0)" rel="nofollow"
                       @click.prevent="checkAuth(lang.prefix_lang+'private-office/vacancy/create')"
                    >
                        Создать вакансию
                    </a>
                </p>

                <p>
                    <b>Сотрудник – </b>
                    <a class="nav-link" href="javascript:void(0)" rel="nofollow"
                       @click.prevent="checkAuth(lang.prefix_lang+'private-office/resume/create')"
                    >
                        Создать резюме
                    </a>
                </p>

                <p>Так-же, для обоих сторон необходимо привести в порядок свои личные данные -
                    <a class="nav-link" href="javascript:void(0)" rel="nofollow"
                       @click.prevent="checkAuth(lang.prefix_lang+'private-office/contact-information')"
                    >
                        Контактная информация
                    </a>
                </p>

            </div>

            <!-- 5 -->
            <div class="col-sm-4 item-list">
                <div class="title-item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path class="fa-primary" d="M352 300c0 46.3-37.7 84-84 84h-44.6c-28.23 0-53.2-17.1-62.13-44.78-4.188-12.59 2.609-26.19 15.19-30.38C189 304.8 202.6 311.5 206.8 324c2.4 7.2 9 12 16.6 12H268c19.84 0 36-16.16 36-36s-16.2-36-36-36h-52a24.01 24.01 0 0 1-22.38-15.31C190 239.5 192.5 229 199.8 222.3l50.5-46.3H184c-13.2 0-24-10.7-24-24s10.8-24 24-24h128a24.01 24.01 0 0 1 22.38 15.31 24 24 0 0 1-6.156 26.38L277.2 216.5c42 4.6 74.8 40.3 74.8 83.5z"/><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256 256-114.6 256-256S397.4 0 256 0zm12 384h-44.6c-28.23 0-53.2-18-62.13-44.78-4.188-12.59 2.609-26.19 15.19-30.38C189 304.8 202.6 311.5 206.8 324c2.4 7.2 9 12 16.6 12H268c19.84 0 36-16.16 36-36s-16.2-36-36-36h-52a24.01 24.01 0 0 1-22.38-15.31C190 239.5 192.5 229 199.8 222.3l50.5-46.3H184c-13.2 0-24-10.7-24-24s10.8-24 24-24h128a24.01 24.01 0 0 1 22.38 15.31 24 24 0 0 1-6.156 26.38L277.2 216.5c42 4.6 74.8 40.3 74.8 83.5 0 46.3-37.7 84-84 84z" style="opacity:.4"/></svg>
                    <h3>Личная информация</h3>
                </div>

                <p>Заполнение не сложных форм, позволит вам полноценно начать работу.</p>

            </div>

        </div>

    </div>
</template>

<script>

    import search_title_panel from './details/SearchTitlePanelComponent'
    import translation from "../mixins/translation";
    import general_functions_mixin from "../mixins/general_functions_mixin";

    export default {
        components: {
            'search_title_panel': search_title_panel,
        },
        mixins: [
            translation,
        ],
        data() {
            return {
                prefix_url: 'vacancy',
            }
        },
        methods: {
            checkAuth(url) {
                // не авторизован
                if(this.user == null){
                    this.$store.commit('tpSetComponent', 0)
                    $('#authModal').modal('toggle')
                    localStorage.setItem('url_click_no_auth', url)
                }
                else{
                    location.href = url;
                }
            },
        },
        props: [
            'user',
            'lang',
            'respond',
        ],
        mounted() {

        },
    }
</script>

<style scoped lang="scss">
    @import "../../sass/variables";
    .annotation-page {
        font-weight: 400;
        line-height: 24px;
        max-width: 555px;
        padding-bottom: 43px;
        text-align: center;
        margin: 0 auto;
    }
    .box-list{
        .item-list{
            background: #ebeced;
            border-right: 1px solid #009fff;
            border-bottom: 1px solid #ffe300;
            padding: 25px;
            .nav-link{
                padding: 0;
                display: inline;
            }
        }
        .title-item{
            display: flex;
            align-items: center;
            svg{
                width: 30px;
                margin-right: 10px;
                path:first-child{
                    fill: #e1e1e1;
                }
                path:last-child{
                    opacity: 1!important;
                    fill: #1d68a7;
                }
            }
            h3{
                padding: 0;
                margin: 0;
                line-height: 18px;
                height: 21px;
            }
        }
    }
    h1{
        width: 100%;
        text-align: center;
        font-size: 25pt;
    }

    .box-page{
        margin-top: 40px;
        h2{
            width: 100%;
            text-align: center;
            font-size: 25pt;
            color: #444;
        }
    }
    .search-panel{
        color: #444;
        .title_page {
            padding: 15px;
        }
        .box-flags{
            text-align: center;
            margin: 25px 0;
            .flag{
                margin: 0 15px;
                position: relative;
                display: inline-block;
                /*opacity: 0.5;*/
                b{
                    position: absolute;
                    bottom: 0px;
                    width: 100%;
                    padding: 10px 0;
                    background: rgba(255 255 255 / 0.8);
                    color: #444;
                }
                img{
                    width: 200px;
                }
            }
        }
        .bottom-search{
            display: flex;
            padding: 30px 15px 0;
            .left-site{
                min-width: 77%;
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
            }
            .right-site{
                min-width: 23%;
            }
        }
    }

</style>





























