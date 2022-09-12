<template>
    <div class="container">
        <div class="box-page">
            <div class="box-title-panel">

                <h1>
                    {{trans('pages.charity','support_the_service')}}
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



</style>





























