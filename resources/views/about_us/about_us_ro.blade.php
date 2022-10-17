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
                    Despre Serviciul de Ocupare în Europa {{$domain}}
                    <!-- перевод страницы гуглом -->
                    <div class="box-translate-google">
                        <svg class="svg-translate" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M0 128C0 92.7 28.7 64 64 64H256h48 16H576c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H320 304 256 64c-35.3 0-64-28.7-64-64V128zm320 0V384H576V128H320zM178.3 175.9c-3.2-7.2-10.4-11.9-18.3-11.9s-15.1 4.7-18.3 11.9l-64 144c-4.5 10.1 .1 21.9 10.2 26.4s21.9-.1 26.4-10.2l8.9-20.1h73.6l8.9 20.1c4.5 10.1 16.3 14.6 26.4 10.2s14.6-16.3 10.2-26.4l-64-144zM160 233.2L179 276H141l19-42.8zM448 164c11 0 20 9 20 20v4h44 16c11 0 20 9 20 20s-9 20-20 20h-2l-1.6 4.5c-8.9 24.4-22.4 46.6-39.6 65.4c.9 .6 1.8 1.1 2.7 1.6l18.9 11.3c9.5 5.7 12.5 18 6.9 27.4s-18 12.5-27.4 6.9l-18.9-11.3c-4.5-2.7-8.8-5.5-13.1-8.5c-10.6 7.5-21.9 14-34 19.4l-3.6 1.6c-10.1 4.5-21.9-.1-26.4-10.2s.1-21.9 10.2-26.4l3.6-1.6c6.4-2.9 12.6-6.1 18.5-9.8l-12.2-12.2c-7.8-7.8-7.8-20.5 0-28.3s20.5-7.8 28.3 0l14.6 14.6 .5 .5c12.4-13.1 22.5-28.3 29.8-45H448 376c-11 0-20-9-20-20s9-20 20-20h52v-4c0-11 9-20 20-20z"/></svg>
                        <div id="google_translate_element"></div>
                    </div>
                </h1>

                {{-- Миссия проекта --}}
                <div class="block-page">
                    <h2>Misiunea proiectului.</h2>
                    <p>
                        Oferiți cel mai bun serviciu de căutare de locuri de muncă din Europa pentru expații. Ajutați oamenii să fie mai fericiți făcând serviciul rapid, contact accesibil și eficient al oamenilor, găsirea unui angajat și a unui angajator.
                    </p>
                </div>

                {{-- Цель проекта --}}
                <div class="block-page">
                    <h2>Obiectivul proiectului.</h2>

                    <div class="box-photo">
                        <img src="/img/custom/bagalov-shamil.jpg" alt="bagalov shamil">
                        <div class="about-photo">
                            <div class="font-weight-bold">Bagalov Shamil</div>
                            <div>Dezvoltator, fondator.</div>
                        </div>
                    </div>

                    <p>
                        Scopul proiectului este de a ajuta pe cât posibil fiecare ucrainean care are nevoie de un loc de muncă.
                    </p>
                    <p>
                        24 februarie 2022 este momentul unei schimbări radicale. Luptele au început pe pământul meu,
                        în Ucraina.
                        Țara agresor a intrat simultan din 4 direcții și s-a deplasat în grabă pe teritoriul Ucrainei,
                        însoțindu-și ofensiva cu lovituri regulate de rachete asupra orașelor și satelor rezidențiale.
                        Acest lucru a provocat teamă de panică în rândul populației civile, oprind întreprinderile mici și mijlocii,
                        migrația în masă a femeilor și copiilor către alte țări europene. Cei care au rămas în țară au înghețat
                        anticiparea unui viitor amenințător,
                        confruntat cu șomaj, distrugeri și numeroase victime. Multumiri speciale
                        ţările europene şi occidentale
                        pentru contribuția și sprijinul acordat ucrainenilor în vremuri dificile!
                    </p>
                    <p>
                        E timpul pentru o schimbare. Și conform legii naturii - acolo unde scade, cu siguranță va exista ceva care se reface.
                        Primul lucru cu care m-am confruntat după ce rudele mele au plecat în Europa a fost alegerea unei țări gazdă în care să poată sta.
                        Eram interesat de locuință, mâncare, asistență financiară minimă și, bineînțeles, angajare. Ultima a fost cea mai grea.
                        Acesta a fost momentul adevărului, ziua în care a început acest startup. Serviciul include 45 de țări europene. Pe ea, fiecare angajator oficial,
                        își pot afișa posturile vacante, își pot ușura povara plăților sociale, își pot găsi angajatul și, în același timp, pot ajuta
                        emigrant în asigurarea unui loc de muncă. E misto, nobil, bun!
                    </p>

                </div>

                <div class="clear-float"></div>

                {{-- Развитие проекта --}}
                <div class="block-page">
                    <h2>Dezvoltarea proiectului.</h2>

                    <div class="box-above-photo">
                        <div class="above-text">
                            <p>
                                E timpul pentru o schimbare. Pentru a rezuma - acest serviciu este pentru oameni și despre oameni. Este complet
                                serviciu gratuit pentru a ajuta
                                oameni și studiind tema ocupării forței de muncă în Europa. Profesia mea este un dezvoltator web (complet
                                grămadă). In materia tehnica sunt autonom si practic
                                Îmi dedic tot timpul acestui proiect. Există o idee, un scop, o mișcare. Rămâne cazul pentru mici
                                <a href="{{ route('show-charity') }}">au nevoie de sprijinul tău</a>:
                            </p>
                            <ol>
                                <li>Material - tehnic (liste de corespondență, publicitate, servicii), nevoi personale (productivitate, motivație)
                                </li>
                                <li>Participarea și parteneriatul cu organizațiile de stat pentru ocuparea forței de muncă și politica socială în Europa. centre de voluntariat.
                                    <br>
                                    Necesar:
                                </li>
                                <ol>
                                    <li>
                                        Servicii de promovare, publicitate. Oamenii ar trebui să cunoască acest serviciu și că își vor rezolva problemele aici.
                                    </li>
                                    <li>
                                        Fluxul angajatorilor europeni și plasarea posturilor vacante.
                                    </li>
                                </ol>
                            </ol>
                            <p>
                                Gata să <a href="{{ route('feedback') }}">a lua în considerare sugestiile</a> și să producă
                                îmbunătățirea serviciului pentru o anumită țară și a standardelor acesteia.
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
