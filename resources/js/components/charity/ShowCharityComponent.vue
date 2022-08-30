<template>
    <div class="container">
        <div class="box-title-panel">

            <h1>
                ПОДДЕРЖАТЬ СЕРВИС
            </h1>

            <div class="block-page">
                <p>
                    Я создавал этот сайт, с целью <a class="link-a" :href="`${lang.prefix_lang}about-us`">помочь людям Украины</a>, которые были вынуждены оставить свою прежнюю жизнь и большее в ней.
                    Начать жить по-новому, в новых условиях и определенных обстоятельствах.
                </p>
                <p>
                    Сайт трудоустройства в Европе, будет содержать официальных работодателей которых направит само правительство стран Евросоюза.
                    Постепенно превращаясь из сайта в платформу не простых технических решений. На данный момент сайт выполнен по мере моих сил и
                    не доведен до совершенства. Для дальнейшего развития, функционирования, оплаты необходимых сервисов, найма определенных специалистов,
                    возможности уделять все свое время и мотивации - необходима Ваша поддержка.
                </p>
                <p>
                    Благодарю Вас за понимание и желание сделать мир лучше!
                </p>
                <p>
                    С благодарностью – Багалов Шамиль.
                </p>
            </div>

            <!-- Платеж картой -->
            <div class="box-element">
                <h2>Платеж картой</h2>
                <p>
                    <span class="alert-danger">Внимание!</span>
                    Ваша валюта будет автоматически конвертирована в Евро.
                </p>
                <a href="https://www.paypal.com/donate/?hosted_button_id=36NTAAN5VAZ2C" rel="nofollow">
                    <img src="/img/custom/paypal.jpg" alt="paypal">
                </a>
            </div>

            <!-- Криптовалюта -->
            <div class="box-element">
                <h2>Криптовалюта</h2>
                <p>
                    <span class="alert-danger">Внимание!</span>
                    После вставки скопированного адреса кошелька проверьте зрительно правильность адреса. Вирусы делают подмену!
                </p>
                <div class="element-item">
                    <div class="description-target">
                        {{response['bitcoin']['title']}}
                    </div>
                    <div @click="copyText($event)" class="box-target" >
                        <div class="target-text">
                            {{response['bitcoin']['address']}}
                        </div>
                        <div class="box-copy link-a " data-toggle="tooltip" data-trigger="manual"
                             title="скопировано"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M502.6 70.63l-61.25-61.25C435.4 3.371 427.2 0 418.7 0H255.1c-35.35 0-64 28.66-64 64l.0195 256C192 355.4 220.7 384 256 384h192c35.2 0 64-28.8 64-64V93.25C512 84.77 508.6 76.63 502.6 70.63zM464 320c0 8.836-7.164 16-16 16H255.1c-8.838 0-16-7.164-16-16L239.1 64.13c0-8.836 7.164-16 16-16h128L384 96c0 17.67 14.33 32 32 32h47.1V320zM272 448c0 8.836-7.164 16-16 16H63.1c-8.838 0-16-7.164-16-16L47.98 192.1c0-8.836 7.164-16 16-16H160V128H63.99c-35.35 0-64 28.65-64 64l.0098 256C.002 483.3 28.66 512 64 512h192c35.2 0 64-28.8 64-64v-32h-47.1L272 448z"/></svg>
                            копировать
                        </div>
                    </div>
                </div>
                <div class="element-item">
                    <div class="description-target">
                        {{response['eth']['title']}}
                    </div>
                    <div @click="copyText($event)" class="box-target" >
                        <div class="target-text">
                            {{response['eth']['address']}}
                        </div>
                        <div class="box-copy link-a " data-toggle="tooltip" data-trigger="manual"
                             title="скопировано"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M502.6 70.63l-61.25-61.25C435.4 3.371 427.2 0 418.7 0H255.1c-35.35 0-64 28.66-64 64l.0195 256C192 355.4 220.7 384 256 384h192c35.2 0 64-28.8 64-64V93.25C512 84.77 508.6 76.63 502.6 70.63zM464 320c0 8.836-7.164 16-16 16H255.1c-8.838 0-16-7.164-16-16L239.1 64.13c0-8.836 7.164-16 16-16h128L384 96c0 17.67 14.33 32 32 32h47.1V320zM272 448c0 8.836-7.164 16-16 16H63.1c-8.838 0-16-7.164-16-16L47.98 192.1c0-8.836 7.164-16 16-16H160V128H63.99c-35.35 0-64 28.65-64 64l.0098 256C.002 483.3 28.66 512 64 512h192c35.2 0 64-28.8 64-64v-32h-47.1L272 448z"/></svg>
                            копировать
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>

    export default {
        mixins: [
        ],
        data() {
            return {
            }
        },
        methods: {
            // скопировать в буфер обмена
            copyText(e) {
                let elem = $(e.currentTarget);
                let text = elem.children(".target-text").text()
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
    }
    .container{
        padding: 0 30px!important;
    }
    .block-page{
        padding: 45px 0;
    }
    .alert-danger{
        background: none!important;
    }
    h1{
        padding: 60px 0 0 !important;
        text-align: center;
    }

</style>





























