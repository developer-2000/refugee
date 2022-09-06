@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="box-title-panel">
            <!-- title -->
            <h1>
                About the Employment Service in Europe - work.es.ua.com
            </h1>

            <div class="block-page">
                <h2>Objective of the project.</h2>

                <div class="box-photo">
                    <img src="/img/custom/bagalov-shamil.jpg" alt="bagalov shamil">
                    <div class="about-photo">
                        <div class="font-weight-bold">Bagalov Shamil</div>
                        <div>Developer, founder.</div>
                    </div>
                </div>

                <p>
                    February 24, 2022 is the time for radical change. Fighting began on my land, in Ukraine.
                    The aggressor country simultaneously entered from 4 directions and hastily moved through the territory of Ukraine,
                    accompanying its offensive with regular missile strikes on cities and residential villages.
                    This caused panic fear among the civilian population, stopping small and medium-sized businesses,
                    mass migration of women and children to other European countries. Those who remained in the country froze in anticipation of the threatening future,
                    faced with unemployment, destruction and numerous casualties. Special thanks to the countries of Europe and the West
                    for their contribution and support to Ukrainians in difficult times!
                </p>
                <p>
                    It's time for a change. And according to the law of nature - where it decreases, there will definitely be something that replenishes.
                    The first thing I faced after my relatives left for Europe was the choice of a host country where they could stay.
                    I was interested in housing, food, minimal financial assistance and, of course, employment. The last one was the hardest.
                    This was the moment of truth, the day the start of my startup, this site you are on.
                    The goal of the work.es.ua.com project is to help every Ukrainian who needs a job as much as possible. The service includes 45 European countries.
                    On it, every official employer can post their vacancies, relieve the burden of their state of social payments,
                    find your employee and at the same time help the Ukrainian. This is cool, noble, good!
                </p>

            </div>

            <div class="clear-float"></div>

            <div class="block-page">
                <h2>Project development.</h2>

                <div class="box-above-photo">
                    <div class="above-text">
                        <p>
                            It's time for a change. To sum up - this service is for people and about people. This is a completely free service aimed at helping
                            people and studying the topic of employment in Europe. My profession is web developer (full stack). In the matter of the technical part, I am autonomous and practically
                            I devote all my time to this project. There is an idea, a goal, a movement. There is only one small thing left, I need help:
                        </p>
                        <ol>
                            <li>Material - technical (mailings, advertising, services), personal needs (productivity, motivation)</li>
                            <li>Participation and partnership with state organizations for employment and social policy in Europe. volunteer centers. <br> Required:</li>
                            <ol>
                                <li>Service promotion, advertising. People should know this service and that they will solve their problems here.</li>
                                <li>Employer flow in Europe and job posting.</li>
                            </ol>
                        </ol>
                        <p>
                            I am ready to consider proposals and make improvements to the service for a particular country and its standards.
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

    </style>
@endsection
