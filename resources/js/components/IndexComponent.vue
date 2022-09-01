<template>
    <div class="container body-page">


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
                    <b>Найти сотрудника</b>
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

        <!-- List help -->
        <div class="start">

            <div class="start-block">
                <div class="start-content">
                    <div class="left-column">
                        <h3>
                            Бесплатный сервис
                        </h3>
                        <p>
                            <b>Всё бесплатно!</b> Функционал позволяющий легко находить работодателя и потенциального сотрудника. Оповещения: откликов на ваши документы и новых сообщений от соискателя.
                        </p>
                    </div>
                </div>
            </div>

            <div class="start-block">
                <div class="start-content">
                    <div class="right-column">
                        <h3>Удобный поиск</h3>
                        <p>
                            Сразу приступи к поиску интересующего тебя контента. Используя фильтры, читай только то, что интересует тебя.
                        </p>
                        <p>
                            <b>Для работодателя – </b>
                            <a :href="`${lang.prefix_lang}resume`" rel="nofollow">
                                найти сотрудника
                            </a>
                        </p>
                        <p>
                            <b>Для сотрудника – </b>
                            <a :href="`${lang.prefix_lang}vacancy`" rel="nofollow">
                                найти вакансию
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="start-block">
                <div class="start-content">
                    <div class="left-column">
                        <h3>Быстрая авторизация </h3>
                        <p>Пройдите в личный кабинет через быструю авторизацию кнопок соцсетей -
                            <a href="javascript:void(0)" rel="nofollow"
                               @click.prevent="checkAuth(lang.prefix_lang+'private-office')"
                            >
                                личный кабинет
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="start-block">
                <div class="start-content">
                    <div class="right-column">

                        <h3>Личная информация</h3>
                        <p>Заполнение не сложных форм, позволит вам полноценно начать работу.</p>
                        <p>
                            <b>Работодатель – </b>
                            <a href="javascript:void(0)" rel="nofollow"
                               @click.prevent="checkAuth(lang.prefix_lang+'private-office/company/create')"
                            >
                                Моя компания
                            </a>
                            ,
                            <a href="javascript:void(0)" rel="nofollow"
                               @click.prevent="checkAuth(lang.prefix_lang+'private-office/vacancy/create')"
                            >
                                Создать вакансию
                            </a>
                        </p>
                        <p>
                            <b>Сотрудник – </b>
                            <a href="javascript:void(0)" rel="nofollow"
                               @click.prevent="checkAuth(lang.prefix_lang+'private-office/resume/create')"
                            >
                                Создать резюме
                            </a>
                        </p>
                        <p>Так-же, для обоих сторон необходимо привести в порядок свои личные данные -
                            <a href="javascript:void(0)" rel="nofollow"
                               @click.prevent="checkAuth(lang.prefix_lang+'private-office/contact-information')"
                            >
                                Контактная информация
                            </a>
                        </p>

                    </div>
                </div>
            </div>

            <div class="start-block">
                <div class="start-content">
                    <div class="left-column">
                        <h3>Удобное продвижение</h3>
                        <p>
                            Удобно, быстро, симпатично. Вот как работает панель Соцсетей для отправки ссылок друзьям ваших вакансий, резюме, компаний.
                            <img src="/img/custom/panel_soc.png" alt="панель соцсетей">
                        </p>
                    </div>
                </div>
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

    .start {
        position: relative;
        padding-bottom: 175px;
        &:nth-child(2) {
            border-bottom: 1px solid #DADADA;
        }
        .start-block {
            position: relative;
            &:not(:last-child)::before {
                content: '';
                position: absolute;
                top: 0;
                left: 50%;
                width: 2px;
                height: 100%;
                -webkit-transform: translate(-50%, 0);
                transform: translate(-50%, 0);
                background-color: rgba(0, 0, 0, 0);
                background-position-x: 0%;
                background-position-y: 0%;
                background-repeat: no-repeat;
                background-attachment: scroll;
                background-image: url("/img/custom/start_path.svg");
                background-size: auto;
                background-origin: padding-box;
                background-clip: border-box;
            }
            &::after {
                content: '';
                position: absolute;
                top: 0;
                left: 50%;
                width: 50px;
                height: 50px;
                -webkit-transform: translate(-50%, -9px);
                transform: translate(-50%, -9px);
                z-index: 10;
            }
            &:nth-child(1)::after {
                background: url("/img/custom/number1.png") no-repeat;
            }
            &:nth-child(2)::after {
                background: url("/img/custom/number2.png") no-repeat;
            }
            &:nth-child(3)::after {
                background: url("/img/custom/number3.png") no-repeat;
            }
            &:nth-child(4)::after {
                background: url("/img/custom/number4.png") no-repeat;
            }
            &:nth-child(5)::after {
                background: url("/img/custom/number5.png") no-repeat;
            }
            &:nth-child(2n+1) .start-content::after {
                left: 50%;
                -webkit-transform: translate(-100%, 13px);
                transform: translate(-100%, 13px);
            }
            &:nth-child(2n) .start-content::after {
                right: 50%;
                -webkit-transform: translate(100%, 13px);
                transform: translate(100%, 13px);
            }
            .start-content{
                min-height: 130px;
                max-height: 130px;
                &::after {
                    content: '';
                    position: absolute;
                    top: 0;
                    width: 85px;
                    height: 3px;
                    background: #0176d3;
                }
                .left-column, .right-column {
                    max-width: 40%;
                    position: relative;
                }
                .left-column {
                    margin-right: auto;
                    text-align: right;
                }
                .right-column {
                    margin-left: auto;
                    text-align: left;
                }
                .left-column h3 {
                    text-align: right;
                }
            }
        }
        h2 {
            margin: 0 0 20px;
            font-size: 137.5%;
            font-weight: 400;
            line-height: 1.6;
            color: #13161F;
        }
        p {
            margin: 0;
            font-size: 17px;
            line-height: 1.7;
            color: #4D5060;
        }
    }


    .top-search{
        border: none;
    }
    .annotation-page {
        font-weight: 400;
        line-height: 24px;
        max-width: 555px;
        padding-bottom: 43px;
        text-align: center;
        margin: 0 auto;
    }

    h1{
        width: 100%;
        text-align: center;
    }

    .box-page{
        margin-top: 40px;
        h2{
            width: 100%;
            text-align: center;
            font-size: 23pt;
        }
    }
    h2{
        color: #0176d3;
    }
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

</style>





























