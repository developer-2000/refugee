<template>
    <div class="container">
        <div class="box-page">
            <div class="box-title-panel">

                <!-- title -->
                <h1 class="h1-translate">
                    {{trans('pages.charity','support_the_service')}}
                    <div class="box-translate-google">
                        <svg class="svg-translate" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M0 128C0 92.7 28.7 64 64 64H256h48 16H576c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H320 304 256 64c-35.3 0-64-28.7-64-64V128zm320 0V384H576V128H320zM178.3 175.9c-3.2-7.2-10.4-11.9-18.3-11.9s-15.1 4.7-18.3 11.9l-64 144c-4.5 10.1 .1 21.9 10.2 26.4s21.9-.1 26.4-10.2l8.9-20.1h73.6l8.9 20.1c4.5 10.1 16.3 14.6 26.4 10.2s14.6-16.3 10.2-26.4l-64-144zM160 233.2L179 276H141l19-42.8zM448 164c11 0 20 9 20 20v4h44 16c11 0 20 9 20 20s-9 20-20 20h-2l-1.6 4.5c-8.9 24.4-22.4 46.6-39.6 65.4c.9 .6 1.8 1.1 2.7 1.6l18.9 11.3c9.5 5.7 12.5 18 6.9 27.4s-18 12.5-27.4 6.9l-18.9-11.3c-4.5-2.7-8.8-5.5-13.1-8.5c-10.6 7.5-21.9 14-34 19.4l-3.6 1.6c-10.1 4.5-21.9-.1-26.4-10.2s.1-21.9 10.2-26.4l3.6-1.6c6.4-2.9 12.6-6.1 18.5-9.8l-12.2-12.2c-7.8-7.8-7.8-20.5 0-28.3s20.5-7.8 28.3 0l14.6 14.6 .5 .5c12.4-13.1 22.5-28.3 29.8-45H448 376c-11 0-20-9-20-20s9-20 20-20h52v-4c0-11 9-20 20-20z"/></svg>
                        <div id="google_translate_element"></div>
                    </div>
                </h1>

                <div class="block-page">
                    <p>
                        {{trans('pages.charity','i_created_website')}}
                        <a class="link-a" :href="`${lang.prefix_lang}about-us`">
                            {{trans('pages.charity','help_people_ukraine')}}
                        </a>,
                        {{trans('pages.charity','who_were_forced')}}
                    </p>
                    <p>
                        {{trans('pages.charity','the_site_employment')}}
                    </p>
                    <p>
                        {{trans('pages.charity','thank_you_your_understanding')}}
                    </p>
                    <p>
                        {{trans('pages.charity','with_gratitude')}}
                    </p>
                </div>

                <!-- Платеж картой -->
                <div class="box-element">
                    <h2>
                        {{trans('pages.charity','card_payment')}}
                    </h2>
                    <p>
                        <span class="alert-danger">
                            {{trans('pages.charity','attention')}}
                        </span>
                        {{trans('pages.charity','your_currency')}}
                    </p>
                    <a href="https://www.paypal.com/donate/?hosted_button_id=36NTAAN5VAZ2C" rel="nofollow">
                        <img src="/img/custom/paypal.jpg" alt="paypal">
                    </a>
                </div>

                <!-- Криптовалюта -->
                <div class="box-element">
                    <h2>
                        {{trans('pages.charity','cryptocurrency')}}
                    </h2>
                    <p>
                        <span class="alert-danger">
                            {{trans('pages.charity','attention')}}
                        </span>
                        {{trans('pages.charity','after_pasting_copied')}}
                    </p>

                    <!-- item -->
                    <div class="element-item">

                        <div class="description-target">
                            {{response['bitcoin']['title']}}
                            <div @click="copyText($event)" class="box-target item-title1" :data-address="response['bitcoin']['address']">
                                <div class="box-copy link-a " data-toggle="tooltip" data-trigger="manual"
                                     :title="trans('pages.charity','copied')"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M502.6 70.63l-61.25-61.25C435.4 3.371 427.2 0 418.7 0H255.1c-35.35 0-64 28.66-64 64l.0195 256C192 355.4 220.7 384 256 384h192c35.2 0 64-28.8 64-64V93.25C512 84.77 508.6 76.63 502.6 70.63zM464 320c0 8.836-7.164 16-16 16H255.1c-8.838 0-16-7.164-16-16L239.1 64.13c0-8.836 7.164-16 16-16h128L384 96c0 17.67 14.33 32 32 32h47.1V320zM272 448c0 8.836-7.164 16-16 16H63.1c-8.838 0-16-7.164-16-16L47.98 192.1c0-8.836 7.164-16 16-16H160V128H63.99c-35.35 0-64 28.65-64 64l.0098 256C.002 483.3 28.66 512 64 512h192c35.2 0 64-28.8 64-64v-32h-47.1L272 448z"/></svg>
                                    {{trans('pages.charity','copy')}}
                                </div>
                            </div>
                        </div>

                        <div @click="copyText($event)" class="box-target" :data-address="response['bitcoin']['address']">
                            <div class="target-text">
                                {{response['bitcoin']['address']}}
                            </div>
                            <div class="box-copy link-a " data-toggle="tooltip" data-trigger="manual"
                                 :title="trans('pages.charity','copied')"
                            >
                                <div class="item-title2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M502.6 70.63l-61.25-61.25C435.4 3.371 427.2 0 418.7 0H255.1c-35.35 0-64 28.66-64 64l.0195 256C192 355.4 220.7 384 256 384h192c35.2 0 64-28.8 64-64V93.25C512 84.77 508.6 76.63 502.6 70.63zM464 320c0 8.836-7.164 16-16 16H255.1c-8.838 0-16-7.164-16-16L239.1 64.13c0-8.836 7.164-16 16-16h128L384 96c0 17.67 14.33 32 32 32h47.1V320zM272 448c0 8.836-7.164 16-16 16H63.1c-8.838 0-16-7.164-16-16L47.98 192.1c0-8.836 7.164-16 16-16H160V128H63.99c-35.35 0-64 28.65-64 64l.0098 256C.002 483.3 28.66 512 64 512h192c35.2 0 64-28.8 64-64v-32h-47.1L272 448z"/></svg>
                                    {{trans('pages.charity','copy')}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- item -->
                    <div class="element-item">

                        <div class="description-target">
                            {{response['eth']['title']}}
                            <div @click="copyText($event)" class="box-target item-title1" :data-address="response['eth']['address']">
                                <div class="box-copy link-a " data-toggle="tooltip" data-trigger="manual"
                                     :title="trans('pages.charity','copied')"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M502.6 70.63l-61.25-61.25C435.4 3.371 427.2 0 418.7 0H255.1c-35.35 0-64 28.66-64 64l.0195 256C192 355.4 220.7 384 256 384h192c35.2 0 64-28.8 64-64V93.25C512 84.77 508.6 76.63 502.6 70.63zM464 320c0 8.836-7.164 16-16 16H255.1c-8.838 0-16-7.164-16-16L239.1 64.13c0-8.836 7.164-16 16-16h128L384 96c0 17.67 14.33 32 32 32h47.1V320zM272 448c0 8.836-7.164 16-16 16H63.1c-8.838 0-16-7.164-16-16L47.98 192.1c0-8.836 7.164-16 16-16H160V128H63.99c-35.35 0-64 28.65-64 64l.0098 256C.002 483.3 28.66 512 64 512h192c35.2 0 64-28.8 64-64v-32h-47.1L272 448z"/></svg>
                                    {{trans('pages.charity','copy')}}
                                </div>
                            </div>
                        </div>

                        <div @click="copyText($event)" class="box-target" :data-address="response['eth']['address']">
                            <div class="target-text">
                                {{response['eth']['address']}}
                            </div>
                            <div class="box-copy link-a" data-toggle="tooltip" data-trigger="manual"
                                 :title="trans('pages.charity','copied')"
                            >
                                <div class="item-title2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M502.6 70.63l-61.25-61.25C435.4 3.371 427.2 0 418.7 0H255.1c-35.35 0-64 28.66-64 64l.0195 256C192 355.4 220.7 384 256 384h192c35.2 0 64-28.8 64-64V93.25C512 84.77 508.6 76.63 502.6 70.63zM464 320c0 8.836-7.164 16-16 16H255.1c-8.838 0-16-7.164-16-16L239.1 64.13c0-8.836 7.164-16 16-16h128L384 96c0 17.67 14.33 32 32 32h47.1V320zM272 448c0 8.836-7.164 16-16 16H63.1c-8.838 0-16-7.164-16-16L47.98 192.1c0-8.836 7.164-16 16-16H160V128H63.99c-35.35 0-64 28.65-64 64l.0098 256C.002 483.3 28.66 512 64 512h192c35.2 0 64-28.8 64-64v-32h-47.1L272 448z"/></svg>
                                    {{trans('pages.charity','copy')}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>

    import translation from "../../mixins/translation";

    export default {
        mixins: [
            translation,
        ],
        data() {
            return {
            }
        },
        methods: {
            // скопировать в буфер обмена
            copyText(e) {
                let elem = $(e.currentTarget);
                let text = elem.attr("data-address")
                text = text.replace(/\s/g,'')
                let $tmp = $("<textarea>");
                $("body").append($tmp);

                // copy text
                $tmp.val(text).select();
                document.execCommand("copy");
                $tmp.remove();
            },
            // клик по подсказке и убрать по уводу курсора
            tooltipHideMouseleave() {
                // (Mobile) удалить tooltip по клику вне подсказки
                $(document).click(function(e) {
                    let tooltips = document.querySelectorAll('.tooltip-inner')
                    if (tooltips.length) {
                        $(tooltips[0]).parent().remove()
                    }
                });

                // (Desc top) показать подсказку при клике на таргет и убрать подсказку при уводу курсора
                $('[data-trigger="manual"]').click(function(e) {

                    setTimeout( () => {
                        const target = $(e.currentTarget);
                        target.tooltip('show');

                        $(target).one('mouseleave', function(e) {
                            target.tooltip('hide');
                        });
                    },200)

                });
            },
        },
        props: [
            'lang',
            'response',
        ],
        mounted() {
            // инициализация всплывающих подсказок
            $('[data-toggle="tooltip"]').tooltip();
            this.tooltipHideMouseleave()
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .h1-translate{
        display: flex;
    }
    .box-translate-google{
        display: flex;
        margin-left: 20px;
    }
    .svg-translate{
        width: 50px;
        fill: #3490dc;
        cursor: pointer;
    }
    .svg-translate:hover{
        fill: #0370c9;
    }
    #google_translate_element{
        display: flex;
        flex-wrap: wrap;
        align-content: center;
    }

    .box-page{
        padding: 15px 0 50px;
    }

    h1{
        padding: 60px 0 0 !important;
        text-align: center;
    }

    .box-title-panel{
        min-width: 340px;
        .block-page{
            padding: 45px 0;
        }
        .box-element{
            outline: 2px solid #dee2e6;
            padding: 20px;
            display: flex;
            flex-direction: column;
            margin-top: 2px;
            a{
                width: 290px;
            }
            .element-item{
                margin-bottom: 10px;
            }
            .box-copy{
                svg{
                    fill: #3490dc;
                    width: 17px;
                }
                &:hover{
                    svg{
                        fill: #1d68a7;
                    }
                }
            }
            .box-target{
                display: flex;
                justify-content: space-between;
                border-bottom: 1px solid #dee2e6;
            }
            .description-target{
                color: #767676;
                display: flex;
            }
            .alert-danger{
                background: none!important;
            }
            .item-title1{
                margin-left: 10px;
                border: none;
                display: none;
            }
        }
    }

    @media (max-width: 768px){
        .box-title-panel{
            .box-element{
                .item-title1{
                    display: block;
                }
                .item-title2{
                    display: none;
                }
            }
        }

    }

    @media (max-width: 568px) {
        .box-title-panel{
            .box-element{
                padding: 10px;
            }
        }
        .target-text{
            font-size: 13px;
        }
        .container{
            padding: 0 10px!important;
        }
    }

    @media (max-width: 460px) {
        .h1-translate{
            flex-wrap: wrap;
        }
        .box-translate-google {
            margin: 30px 0 0 0;
        }
    }

</style>





























