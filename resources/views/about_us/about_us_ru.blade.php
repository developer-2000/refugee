@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="box-title-panel">
            <!-- title -->
            <h1>
                О Сервисе трудоустройства в Европе - work.es.ua.com
            </h1>

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
                    24 февраля 2022 года настало время радикальных перемен. Начались боевые действия на моей земле, в Украине.
                    Страна агрессор одновременно зашла с 4 направлений и спешно продвигалась по территории Украины,
                    сопровождая свое наступление регулярными ракетными ударами по городам и жилым поселкам.
                    Это вызвало панический страх у мирного населения, остановку малого и среднего бизнесов,
                    массовое переселение женщин и детей в другие страны Европы. Те кто остались в стране, замерли в ожидании грозящего будущего,
                    встретившись с безработицей, разрушениями и многочисленными жертвами. Отдельная благодарность странам Европы и Запада
                    за их вклад и поддержку Украинцев в трудное время!
                </p>
                <p>
                    Настало время перемен. И по закону природы – там где убывает, обязательно найдется то что восполняет.
                    Первое с чем я столкнулся после отъезда родных в Европу, это выбор принимающей страны, в которой могут они остановится.
                    Меня интересовало жилье, питание, минимальная финансовая помощь и конечно трудоустройство. С последним оказалось сложней всего.
                    Это и стало моментом истины, днем начало моего стартапа, этого сайта на котором вы находитесь.
                    Цель проекта work.es.ua.com – максимально помочь каждому Украинцу, нуждающемуся в получении работы. Сервис включает в себя 45 стран Европы.
                    На нем каждый официальный работодатель, может разместить свои вакансии, снять нагрузку своего государства социальных выплат,
                    найти своего сотрудника и одновременно помочь Украинцу. Это классно, благородно, хорошо!
                </p>

            </div>

            <div class="clear-float"></div>

            <div class="block-page">
                <h2>Развитие проекта.</h2>

                <div class="box-above-photo">
                    <img class="above-photo" src="/img/custom/project-development.jpg" alt="project development">
                    <div class="above-text">
                        <p>
                            Настало время перемен. Подводя итог - этот сервис для людей и о людях. Это полностью бесплатный сервис, направленный на помощь
                            людям и изучение темы трудоустройства в Европе. Моя профессия web developer (full stack). В вопросе технической части я автономен и практически
                            все свое время уделяю этому проекту. Есть идея, цель, движение. Осталось дело за малым, <a href="{{ route('show-charity') }}">мне необходима помощь</a>:
                        </p>
                        <ol>
                            <li>Материальная – технические (рассылки, реклама, сервисы), личные нужды (продуктивность, мотивация)</li>
                            <li>Участие и партнерство с государственными организациями трудоустройства и социальной политики Европы. Волонтёрские центры. <br> Необходимо:</li>
                            <ol>
                                <li>Продвижение сервиса, реклама. Люди должны знать этот сервис и то, что здесь они решат свои вопросы.</li>
                                <li>Поток работодателей Европы и размещение вакансий.</li>
                            </ol>
                        </ol>
                        <p>
                            Готов рассматривать предложения и производить доработки сервиса для отдельно взятой страны и ее стандартов.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection

@section('style')
    @parent
    <style type="text/css">

        .box-above-photo{
            position: relative;
            padding: 0 0 75px 0;
        }
        .above-photo{
            height: 75%;
            overflow: hidden;
            position: absolute;
            right: 0;
            bottom: 40px;
            z-index: 0;
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

    </style>
@endsection
