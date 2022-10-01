@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="box-page">
            <div class="box-title-panel">
            <!-- title -->
            <h1>
                Про сервіс працевлаштування в Європі {{$domain}}
            </h1>

            <div class="block-page">
                <h2>Мета проекту.</h2>

                <div class="box-photo">
                    <img src="/img/custom/bagalov-shamil.jpg" alt="bagalov shamil">
                    <div class="about-photo">
                        <div class="font-weight-bold">Багалов Шаміль</div>
                        <div>Розробник, фундатор.</div>
                    </div>
                </div>

                <p>
                    24 лютого 2022 року настав час радикальних змін. Почалися бойові дії на моїй землі в Україні.
                    Країна агресор одночасно зайшла з 4 напрямків і спішно просувалася територією України,
                    супроводжуючи свій наступ регулярними ракетними ударами по містах та житлових селищах.
                    Це викликало панічний страх у мирного населення, зупинку малого та середнього бізнесів,
                    масове переселення жінок та дітей до інших країн Європи. Ті хто залишилися в країні, завмерли в очікуванні майбутнього,
                    зустрівшись з безробіттям, руйнуваннями та численними жертвами. Окрема подяка країнам Європи та Заходу
                    за їхній внесок та підтримку Українців у скрутний час!
                </p>
                <p>
                    Настав час змін. І за законом природи – там де зменшується, обов'язково знайдеться те, що
                    заповнює.
                    Перше з чим я зіткнувся після від'їзду рідних до Європи, це вибір країни, що приймає, в якій
                    можуть вони зупиниться.
                    Мене цікавило житло, харчування, мінімальна фінансова допомога та звичайно працевлаштування. З
                    останнім виявилося найскладніше.
                    Це і стало моментом істини, днем ​​початок мого стартапу, цього сайту, на якому ви знаходитесь.
                    Мета проекту - максимально допомогти кожному Українцю, який потребує отримання
                    роботи. Сервіс включає 45 країн Європи.
                    На ньому кожен офіційний роботодавець може розмістити свої вакансії, зняти навантаження свого.
                    держави соціальних виплат,
                    знайти свого співробітника та водночас допомогти Українцю. Це класно, благородно, гаразд!
                </p>

            </div>

            <div class="clear-float"></div>

            <div class="block-page">
                <h2>Розвиток проекту.</h2>

                <div class="box-above-photo">
                    <div class="above-text">
                        <p>
                            Настав час змін. Підсумовуючи - цей сервіс для людей і людей. Це повністю безкоштовний сервіс, спрямований на допомогу
                            людям та вивчення теми працевлаштування в Європі. Моя професія — web developer (full stack). У питанні технічної частини я автономен і практично
                            увесь свій час приділяю цьому проекту. Є ідея, ціль, рух. Залишилася справа за малим, <a href="{{ route('show-charity') }}">необхідна ваша підтримка</a>:
                        </p>
                        <ol>
                            <li>Матеріальна – технічні (розсилки, реклама, послуги), особисті потреби (продуктивність, мотивація)</li>
                            <li>Участь та партнерство з державними організаціями працевлаштування та соціальної політики Європи. Волонтерські центри. <br> Необхідно:</li>
                            <ol>
                                <li>Просування сервісу, реклама. Люди повинні знати цей сервіс і те, що вони вирішать свої питання.</li>
                                <li>Потік роботодавців Європи та розміщення вакансій.</li>
                            </ol>
                        </ol>
                        <p>
                            Готовий <a href="{{ route('feedback') }}">розглядати пропозиції</a> та проводити доопрацювання сервісу для окремо взятої країни та її стандартів.
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

    </style>
@endsection
