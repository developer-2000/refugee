@extends('layouts.app')
@section('scripts')
    @parent
    <script>
        $( document ).ready(function(){
            $( ".svg-translate" ).click(() => {
                $(".svg-translate").css("display","none")
                new google.translate.TranslateElement({ layout: google.translate.TranslateElement.InlineLayout.SIMPLE }, "google_translate_element")
            });

            // клик по select выбора language
            $('.box-translate-google').on('click', '#google_translate_element', function () {
                // добавить scroll frame выбора языков
                var iframe = document.getElementsByTagName('iframe')[1];
                $(iframe).css({"width":"100%"})
                $(iframe.contentWindow.document.childNodes).children("body").css({"overflow":"scroll"})
            });
        });

    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
@endsection
@section('content')

    <div class="container">
        <div class="box-page">
            <div class="box-title-panel">

                <!-- title -->
                <h1 class="h1-translate">
                    О Сервисе трудоустройства в Европе {{$domain}}
                    <!-- перевод страницы гуглом -->
                    <div class="box-translate-google">
                        <svg class="svg-translate" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M0 128C0 92.7 28.7 64 64 64H256h48 16H576c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H320 304 256 64c-35.3 0-64-28.7-64-64V128zm320 0V384H576V128H320zM178.3 175.9c-3.2-7.2-10.4-11.9-18.3-11.9s-15.1 4.7-18.3 11.9l-64 144c-4.5 10.1 .1 21.9 10.2 26.4s21.9-.1 26.4-10.2l8.9-20.1h73.6l8.9 20.1c4.5 10.1 16.3 14.6 26.4 10.2s14.6-16.3 10.2-26.4l-64-144zM160 233.2L179 276H141l19-42.8zM448 164c11 0 20 9 20 20v4h44 16c11 0 20 9 20 20s-9 20-20 20h-2l-1.6 4.5c-8.9 24.4-22.4 46.6-39.6 65.4c.9 .6 1.8 1.1 2.7 1.6l18.9 11.3c9.5 5.7 12.5 18 6.9 27.4s-18 12.5-27.4 6.9l-18.9-11.3c-4.5-2.7-8.8-5.5-13.1-8.5c-10.6 7.5-21.9 14-34 19.4l-3.6 1.6c-10.1 4.5-21.9-.1-26.4-10.2s.1-21.9 10.2-26.4l3.6-1.6c6.4-2.9 12.6-6.1 18.5-9.8l-12.2-12.2c-7.8-7.8-7.8-20.5 0-28.3s20.5-7.8 28.3 0l14.6 14.6 .5 .5c12.4-13.1 22.5-28.3 29.8-45H448 376c-11 0-20-9-20-20s9-20 20-20h52v-4c0-11 9-20 20-20z"/></svg>
                        <div id="google_translate_element"></div>
                    </div>
                </h1>

                {{-- Миссия проекта --}}
                <div class="block-page">
                    <h2>Миссия проекта.</h2>
                    <p>
                        Предоставлять лучший сервис поиска работы в Европе для эмигрантов. Помочь людям быть счастливее, сделав сервис быстрого,
                        доступного и эффективного контакта людей, нахождения сотрудника и работодателя.
                    </p>
                </div>

                {{-- Цель проекта --}}
                <div class="block-page">
                    <h2>Цель проекта.</h2>

                    <div class="box-photo">
                        <img src="/img/custom/bagalov-shamil.jpg" alt="bagalov shamil">
                        <div class="about-photo">
                            <div class="font-weight-bold">Багалов Шамиль</div>
                            <div>Разработчик, основатель.</div>
                        </div>
                    </div>

                    <p>
                        Цель проекта - максимально помочь каждому Украинцу, нуждающемуся в получении работы.
                    </p>
                    <p>
                        24 февраля 2022 года настало время радикальных перемен. Начались боевые действия на моей земле,
                        в Украине.
                        Страна агрессор одновременно зашла с 4 направлений и спешно продвигалась по территории Украины,
                        сопровождая свое наступление регулярными ракетными ударами по городам и жилым поселкам.
                        Это вызвало панический страх у мирного населения, остановку малого и среднего бизнесов,
                        массовое переселение женщин и детей в другие страны Европы. Те кто остались в стране, замерли в
                        ожидании грозящего будущего,
                        встретившись с безработицей, разрушениями и многочисленными жертвами. Отдельная благодарность
                        странам Европы и Запада
                        за их вклад и поддержку Украинцев в трудное время!
                    </p>
                    <p>
                        Настало время перемен. И по закону природы – там где убывает, обязательно найдется то что восполняет.
                        Первое с чем я столкнулся после отъезда родных в Европу, это выбор принимающей страны, в которой могут они остановится.
                        Меня интересовало жилье, питание, минимальная финансовая помощь и конечно трудоустройство. С последним оказалось сложней всего.
                        Это и стало моментом истины, днем начало этого стартапа. Сервис включает в себя 45 стран Европы. На нем каждый официальный работодатель,
                        может разместить свои вакансии, снять нагрузку своего государства социальных выплат, найти своего сотрудника и одновременно помочь
                        эмигранту в предоставлении рабочего места. Это классно, благородно, хорошо!
                    </p>

                </div>

                <div class="clear-float"></div>

                {{-- Развитие проекта --}}
                <div class="block-page">
                    <h2>Развитие проекта.</h2>

                    <div class="box-above-photo">
                        <div class="above-text">
                            <p>
                                Настало время перемен. Подводя итог - этот сервис для людей и о людях. Это полностью
                                бесплатный сервис, направленный на помощь
                                людям и изучение темы трудоустройства в Европе. Моя профессия web developer (full
                                stack). В вопросе технической части я автономен и практически
                                все свое время уделяю этому проекту. Есть идея, цель, движение. Осталось дело за малым,
                                <a href="{{ route('show-charity') }}">необходима ваша поддержка</a>:
                            </p>
                            <ol>
                                <li>Материальная – технические (рассылки, реклама, сервисы), личные нужды
                                    (продуктивность, мотивация)
                                </li>
                                <li>Участие и партнерство с государственными организациями трудоустройства и социальной
                                    политики Европы. Волонтёрские центры. <br> Необходимо:
                                </li>
                                <ol>
                                    <li>Продвижение сервиса, реклама. Люди должны знать этот сервис и то, что здесь они
                                        решат свои вопросы.
                                    </li>
                                    <li>Поток работодателей Европы и размещение вакансий.</li>
                                </ol>
                            </ol>
                            <p>
                                Готов <a href="{{ route('feedback') }}">рассматривать предложения</a> и производить
                                доработки сервиса для отдельно взятой страны и ее стандартов.
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection

@section('style')
    @parent
    <style type="text/css">

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
        .box-above-photo{
            position: relative;
            padding: 80px 0 0 0;
            background-image: url("/img/custom/project-development.jpg");
            background-repeat: no-repeat;
            background-position: 100% 0%;
            background-size: 80%;
        }
        .above-text{
            align-items: stretch;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 25px 35px 15px 30px;
            position: relative;
            z-index: 1;
            background: #fff;
            border: 1px solid hsla(210,5%,93%,.5);
            box-shadow: 0 2px 3px 0 rgba(0,0,0,.1);
            max-width: 61%;
            min-height: 439px;
        }
        .box-photo{
            background: #f9f9f9;
            border: 1px solid #dee2e6;
            width: 300px;
            padding: 3px;
            float: left;
            margin-right: 25px;
        }
        .box-photo img{
            width: 292px;
        }
        .box-photo .about-photo{
            padding: 25px 25px 40px 25px;
        }
        strong{
            margin: 5px 0!important;
            display: inline-block!important;
        }
        p{
            margin-bottom: 5px;
        }
        .container{
            padding: 0 30px!important;
        }
        .block-page{
            padding-top: 45px;
        }
        .block-page:last-child{
            padding-top: 60px;
        }
        .box-title-panel > .block-page:last-child{
            border: none;
        }
        h1{
            padding: 60px 0 0 !important;
        }
        h2{
            padding: 10px 0 30px !important;
        }
        h3{
            margin: 0 0 15px 0 !important;
        }
        h4{
            margin: 15px 0 15px 0 !important;
        }
        ol{
            padding: 0 0 0 17px;
        }
        ol li{
            list-style-type: decimal;
            margin: 0 0 15px 0;
            padding: 0 0 0 7px;
        }
        ol ol{
            padding: 0 0 0 17px;
        }
        ol ol li{
            list-style-type: disc;
        }

        @media (max-width: 992px) {
            .box-photo {
                width: 45%;
            }
            .box-photo img{
                width: 100%;
            }
        }
        @media (max-width: 768px) {
            .above-text {
                max-width: 80%;
            }
        }
        @media (max-width: 418px) {
            .h1-translate{
                flex-wrap: wrap;
            }
            .box-translate-google {
                margin: 30px 0 0 0;
            }
        }

    </style>
@endsection
