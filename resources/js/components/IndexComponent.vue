<template>
    <div class="container body-page">

        <div class="box-title-panel">
            <h1 class="title_page">
                {{trans('pages.index','the_best_site_for_finding')}}
            </h1>

            <div class="box-flags">
                <a :href="`${lang.prefix_lang}vacancy`" class="flag european-flag">
                    <b>
                        {{trans('pages.index','find_job')}}
                    </b>
                </a>
                <a :href="`${lang.prefix_lang}resume`" class="flag ukraine-flag">
                    <b>
                        {{trans('pages.index','find_employee')}}
                    </b>
                </a>
            </div>

            <h2 class="title_page">
                {{trans('pages.index','job_search_employers')}}
            </h2>

            <!-- search input line -->
            <search_title_panel
                :lang="lang"
                :respond="respond"
                :prefix="prefix_url"
            ></search_title_panel>
        </div>

        <div class="box-page">
            <h2>
                {{trans('pages.index','use_european_level')}}
            </h2>

            <div class="annotation-page">
                {{trans('pages.index','realize_what_you_want')}}
            </div>
        </div>

        <!-- List help -->
        <div class="start">

            <div class="start-block">
                <div class="start-content free_service">
                    <div class="left-column">
                        <h3>
                            {{trans('pages.index','free_service')}}
                        </h3>
                        <p>
                            <b>
                                {{trans('pages.index','everything_free')}}
                            </b>
                            {{trans('pages.index','functionality_allows_you')}}
                        </p>
                    </div>
                </div>
            </div>

            <div class="start-block">
                <div class="start-content two-content convenient_search">
                    <div class="right-column">
                        <h3>
                            {{trans('pages.index','convenient_search')}}
                        </h3>
                        <p>
                            {{trans('pages.index','start_searching_content')}}
                        </p>
                        <p>
                            <b>
                                {{trans('pages.index','for_employer')}}
                            </b>
                            <a :href="`${lang.prefix_lang}resume`" rel="nofollow">
                                {{trans('pages.index','find_employee')}}
                            </a>
                        </p>
                        <p>
                            <b>
                                {{trans('pages.index','for_worker')}}
                            </b>
                            <a :href="`${lang.prefix_lang}vacancy`" rel="nofollow">
                                {{trans('pages.index','find_vacancy')}}
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="start-block">
                <div class="start-content quick_authorization">
                    <div class="left-column">
                        <h3>
                            {{trans('pages.index','quick_authorization')}}
                        </h3>
                        <p>
                            {{trans('pages.index','go_to_your_personal')}}
                            <a href="javascript:void(0)" rel="nofollow"
                               @click.prevent="checkAuth(lang.prefix_lang+'private-office')"
                            >
                                {{trans('pages.index','personal_area')}}
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="start-block">
                <div class="start-content four-content personal_information">
                    <div class="right-column">

                        <h3>
                            {{trans('pages.index','personal_information')}}
                        </h3>
                        <p>
                            {{trans('pages.index','filling_out_simple')}}
                        </p>
                        <p>
                            <b>
                                {{trans('pages.index','employer')}}
                            </b>
                            <a href="javascript:void(0)" rel="nofollow"
                               @click.prevent="checkAuth(lang.prefix_lang+'private-office/company/create')"
                            >
                                {{trans('pages.index','my_company')}}
                            </a>
                            ,
                            <a href="javascript:void(0)" rel="nofollow"
                               @click.prevent="checkAuth(lang.prefix_lang+'private-office/vacancy/create')"
                            >
                                {{trans('pages.index','create_job')}}
                            </a>
                        </p>
                        <p>
                            <b>
                                {{trans('pages.index','worker')}}
                            </b>
                            <a href="javascript:void(0)" rel="nofollow"
                               @click.prevent="checkAuth(lang.prefix_lang+'private-office/resume/create')"
                            >
                                {{trans('pages.index','create_resume')}}
                            </a>
                        </p>
                        <p>
                            {{trans('pages.index','also_for_both')}}
                            <a href="javascript:void(0)" rel="nofollow"
                               @click.prevent="checkAuth(lang.prefix_lang+'private-office/contact-information')"
                            >
                                {{trans('pages.index','contact_information')}}
                            </a>
                        </p>

                    </div>
                </div>
            </div>

            <div class="start-block">
                <div class="start-content convenient_promotion">
                    <div class="left-column">
                        <h3>
                            {{trans('pages.index','convenient_promotion')}}
                        </h3>
                        <p>
                            {{trans('pages.index','convenient_fast_nice')}}
<!--                            <img src="/img/custom/panel_soc.png" alt="панель соцсетей">-->
                            <span class="box-share">
                                <sharing_panel
                                    :lang="lang"
                                    :page="'service'"
                                ></sharing_panel>
                            </span>

                        </p>
                    </div>
                </div>
            </div>

            <div class="start-block">
                <div class="start-content four-content">
                    <div class="right-column">

                        <h3>
                            {{trans('pages.index','communication_with_administration')}}
                        </h3>
                        <p>
                            {{trans('pages.index','if_you_have_questions')}}
                            <a :href="lang.prefix_lang+'feedback'" rel="nofollow">
                                {{trans('pages.index','feedback')}}
                            </a>
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
    import sharing_panel from "./details/SharingPanelComponent";

    export default {
        components: {
            'search_title_panel': search_title_panel,
            'sharing_panel': sharing_panel,
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
        padding-bottom: 75px;
        min-width: 340px;
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
                background-size: 50px;
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
            &:nth-child(6)::after {
                background: url("/img/custom/number6.png") no-repeat;
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
                position: relative;
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
                    position: absolute;
                    top: 0px;
                    left: 0px;
                    z-index: 2;
                }
                .right-column {
                    margin-left: auto;
                    text-align: left;
                    position: absolute;
                    top: 0px;
                    right: 0px;
                    z-index: 2;
                }
                .left-column h3 {
                    text-align: right;
                }
            }
        }
        h3 {
            margin: 0 0 20px;
            font-size: 25px;
        }
        p {
            margin: 0;
            font-size: 17px;
            line-height: 1.7;
            color: #4D5060;
        }
    }
    .box-share{
        display: flex;
        padding: 20px 0 0;
        font-size: 15px;
        justify-content: flex-end;
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
        display: flex;
        justify-content: center;
        .flag{
            width: 200px;
            height: 95px;
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            justify-content: flex-end;
            align-content: center;
            margin: 0 15px;
            b{
                display: flex;
                justify-content: center;
                align-items: center;
                background: rgba(255, 255, 255, 0.7);
                color: #444;
                height: 37%;
                width: 86%;
                margin-bottom: 12px;
                line-height: 15px;
            }
            img{
                width: 100%;
                max-width: 200px;
            }
        }
        .european-flag{
            background-image: url("/img/custom/european-flag.png");
        }
        .ukraine-flag{
            background-image: url("/img/custom/ukrainian-flag.png");
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

    @media (max-width: 1200px) {
        .start {
            .start-block {
                .personal_information{
                    min-height: 175px;
                    max-height: 175px;
                }
            }
        }
    }

    @media (max-width: 992px) {
        .start {
            .start-block {
                .start-content {
                    &::after {
                        width: 45px;
                    }
                }
                .convenient_search{
                    min-height: 165px;
                }
                .personal_information{
                    min-height: 220px;
                }
            }
        }
    }

    @media (max-width: 768px){
        .start {
            .start-block {
                padding-left: 30px;
                &:not(:last-child) {
                    padding-bottom: 50px;
                }
                &:not(:last-child)::before {
                    left: 0;
                }
                &::after{
                    left: 0;
                    width: 40px;
                    height: 40px;
                    background-size: 40px !important;
                    transform: translate(-50%, -4px);
                }
                .start-content{
                    &::after{
                        display: none;
                    }
                    .left-column, .right-column {
                        max-width: 100%;
                    }
                    .left-column {
                        text-align: left;
                        h3 {
                            text-align: left;
                            margin-bottom: 10px;
                        }
                    }
                }
                .free_service{
                    min-height: 125px;
                }
                .convenient_search{
                    min-height: 165px;
                }
                .quick_authorization{
                    min-height: 70px;
                }
                .personal_information{
                    min-height: 195px;
                }
                .convenient_promotion{
                    min-height: 175px;
                }
            }
        }
        .box-share {
            justify-content: flex-start;
        }

    }

    @media (max-width: 568px) {
        .box-flags .flag {
            margin: 0 7px;
        }
        h2.title_page {
            text-align: center;
        }
        .start {
            padding: 0 10px 75px 25px;
            .start-block {
                .start-content{
                    .left-column {
                        h3 {
                            font-size: 22px;
                        }
                    }
                    .free_service{
                        min-height: 120px;
                    }
                    .convenient_search{
                        min-height: 140px;
                    }
                    .convenient_promotion{
                        min-height: 170px;
                    }
                }
            }
        }
        .box-page h2 {
            font-size: 22px;
        }
    }

    @media (max-width: 486px) {
        .box-flags{
            flex-direction: column;
            flex-wrap: wrap;
            align-content: center;
            .european-flag{
                margin: 0 0 15px;
            }
            .ukraine-flag{
                margin: 0;
            }
        }
        .start {
            .start-block {
                .free_service{
                    min-height: 155px;
                }
                .convenient_search{
                    min-height: 165px;
                }
                .quick_authorization{
                    min-height: 90px;
                }
                .personal_information{
                    min-height: 250px;
                }
            }
        }
    }

    @media (max-width: 400px) {
        .start {
            padding-bottom: 150px;
            .start-block {
                .free_service{
                    min-height: 195px;
                }
                .convenient_search{
                    min-height: 235px;
                }
                .quick_authorization{
                    min-height: 110px;
                }
                .personal_information{
                    min-height: 295px;
                }
                .convenient_promotion{
                    min-height: 205px;
                }
            }
        }
        .box-page h2 {
            font-size: 22px;
        }
    }

</style>





























