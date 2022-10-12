<template>
    <div class="container customer_survey">

        <div id="box-content">
            <!-- title -->
            <h1 class="h1-translate">
                {{trans('pages.customer_survey','poll_improvements')}}
                <!-- перевод страницы гуглом -->
                <div class="box-translate-google">
                    <svg class="svg-translate" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M0 128C0 92.7 28.7 64 64 64H256h48 16H576c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H320 304 256 64c-35.3 0-64-28.7-64-64V128zm320 0V384H576V128H320zM178.3 175.9c-3.2-7.2-10.4-11.9-18.3-11.9s-15.1 4.7-18.3 11.9l-64 144c-4.5 10.1 .1 21.9 10.2 26.4s21.9-.1 26.4-10.2l8.9-20.1h73.6l8.9 20.1c4.5 10.1 16.3 14.6 26.4 10.2s14.6-16.3 10.2-26.4l-64-144zM160 233.2L179 276H141l19-42.8zM448 164c11 0 20 9 20 20v4h44 16c11 0 20 9 20 20s-9 20-20 20h-2l-1.6 4.5c-8.9 24.4-22.4 46.6-39.6 65.4c.9 .6 1.8 1.1 2.7 1.6l18.9 11.3c9.5 5.7 12.5 18 6.9 27.4s-18 12.5-27.4 6.9l-18.9-11.3c-4.5-2.7-8.8-5.5-13.1-8.5c-10.6 7.5-21.9 14-34 19.4l-3.6 1.6c-10.1 4.5-21.9-.1-26.4-10.2s.1-21.9 10.2-26.4l3.6-1.6c6.4-2.9 12.6-6.1 18.5-9.8l-12.2-12.2c-7.8-7.8-7.8-20.5 0-28.3s20.5-7.8 28.3 0l14.6 14.6 .5 .5c12.4-13.1 22.5-28.3 29.8-45H448 376c-11 0-20-9-20-20s9-20 20-20h52v-4c0-11 9-20 20-20z"/></svg>
                    <div id="google_translate_element"></div>
                </div>
            </h1>

            <div class="page-explanation">
                <p>
                    {{trans('pages.customer_survey','this_questionnaire_designed')}}
                </p>


                <h2>{{trans('pages.customer_survey','things_pay_attention')}}</h2>

                <ol>
                    <li>
                        {{trans('pages.customer_survey','what_should_not_be')}}
                    </li>
                    <li>
                        {{trans('pages.customer_survey','how_should_chain')}}
                    </li>
                    <li>
                        {{trans('pages.customer_survey','what_result_does_applicant')}}
                    </li>
                    <li>
                        {{trans('pages.customer_survey','and_so_on')}}
                    </li>
                </ol>

            </div>

            <h2>{{trans('pages.customer_survey','main_pages_service')}}</h2>

            <p>
                {{trans('pages.customer_survey','once_you_selected_page')}}
            </p>

            <ol id="accordionExample_1" class="accordion">
                <!-- Главная страница -->
                <li>
                    <div class="box-li">
                        <a class="link-a" target="_blank" :href="`${lang.prefix_lang}`">
                            {{trans('pages.customer_survey','main_page')}}
                        </a>
                        <svg data-target="#dataDocument_1"
                             aria-controls="dataDocument_1"
                             data-toggle="collapse" aria-expanded="true"
                             class="edit-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"> <path data-v-98cf25ea="" d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"></path></svg>
                    </div>
                    <!-- dataDocument Accordion v-model="objTextarea.textarea_main_page" -->
                    <div id="dataDocument_1" class="collapse">
                        <div class="card-body">
                            <div class="form-group">
                                <label> {{trans('pages.customer_survey','describe_your_idea')}} </label>
                                <ckeditor v-model="objTextarea.textarea_main_page"
                                          :config="objTextarea.config_main_page"
                                          @input="fixInfo('main_page', objTextarea.textarea_main_page)"
                                ></ckeditor>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Поиск вакансий -->
                <li>
                    <div class="box-li">
                        <a class="link-a" target="_blank" :href="`${lang.prefix_lang}vacancy`">
                            {{trans('pages.customer_survey','search_vacancies')}}
                        </a>
                        <svg data-target="#dataDocument_2"
                             aria-controls="dataDocument_2"
                             data-toggle="collapse" aria-expanded="true"
                             class="edit-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"> <path data-v-98cf25ea="" d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"></path></svg>
                    </div>
                    <!-- dataDocument Accordion -->
                    <div id="dataDocument_2"
                         class="collapse">
                        <div class="card-body">
                            <div class="form-group">
                                <label>
                                    {{trans('pages.customer_survey','describe_your_idea')}}
                                </label>
                                <ckeditor v-model="objTextarea.textarea_search_vacancies"
                                          :config="objTextarea.config_search_vacancies"
                                          @input="fixInfo('search_vacancies', objTextarea.textarea_search_vacancies)"
                                ></ckeditor>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Поиск резюме -->
                <li>
                    <div class="box-li">
                        <a class="link-a" target="_blank" :href="`${lang.prefix_lang}resume`">
                            {{trans('pages.customer_survey','search_resume')}}
                        </a>
                        <svg data-target="#dataDocument_3"
                             aria-controls="dataDocument_3"
                             data-toggle="collapse" aria-expanded="true"
                             class="edit-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"> <path data-v-98cf25ea="" d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"></path></svg>
                    </div>
                    <!-- dataDocument Accordion -->
                    <div id="dataDocument_3"
                         class="collapse">
                        <div class="card-body">
                            <div class="form-group">
                                <label>
                                    {{trans('pages.customer_survey','describe_your_idea')}}
                                </label>
                                <ckeditor v-model="objTextarea.textarea_search_resume"
                                          :config="objTextarea.config_search_resume"
                                          @input="fixInfo('search_resume', objTextarea.textarea_search_resume)"
                                ></ckeditor>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Личный кабинет -->
                <li>
                    <div class="box-li">
                        <a class="link-a" href="javascript:void(0)"
                           @click.prevent="checkAuth1(lang.prefix_lang+'private-office')"
                        >
                            {{trans('pages.customer_survey','private_office')}}
                        </a>
                        <svg data-target="#dataDocument_4"
                             aria-controls="dataDocument_4"
                             data-toggle="collapse" aria-expanded="true"
                             class="edit-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"> <path data-v-98cf25ea="" d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"></path></svg>
                    </div>
                    <!-- dataDocument Accordion -->
                    <div id="dataDocument_4"
                         class="collapse">
                        <div class="card-body">
                            <div class="form-group">
                                <label>
                                    {{trans('pages.customer_survey','describe_your_idea')}}
                                </label>
                                <ckeditor v-model="objTextarea.textarea_private_office"
                                          :config="objTextarea.config_private_office"
                                          @input="fixInfo('private_office', objTextarea.textarea_private_office)"
                                ></ckeditor>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Создание / обновление страницы компании -->
                <li>
                    <div class="box-li">
                        <a class="link-a" href="javascript:void(0)"
                           @click.prevent="checkAuth1(lang.prefix_lang+'private-office/company/create')"
                        >
                            {{trans('pages.customer_survey','company_create')}}
                        </a>
                        <svg data-target="#dataDocument_5"
                             aria-controls="dataDocument_5"
                             data-toggle="collapse" aria-expanded="true"
                             class="edit-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"> <path data-v-98cf25ea="" d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"></path></svg>
                    </div>
                    <!-- dataDocument Accordion -->
                    <div id="dataDocument_5"
                         class="collapse">
                        <div class="card-body">
                            <div class="form-group">
                                <label>
                                    {{trans('pages.customer_survey','describe_your_idea')}}
                                </label>
                                <ckeditor v-model="objTextarea.textarea_company_create"
                                          :config="objTextarea.config_company_create"
                                          @input="fixInfo('company_create', objTextarea.textarea_company_create)"
                                ></ckeditor>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Представительская страница просмотра данных компании. -->
                <li>
                    <div class="box-li">
                        <a class="link-a" target="_blank" :href="`${lang.prefix_lang}company/work-ukraine`">
                            {{trans('pages.customer_survey','company_page')}}
                        </a>
                        <svg data-target="#dataDocument_6"
                             aria-controls="dataDocument_6"
                             data-toggle="collapse" aria-expanded="true"
                             class="edit-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"> <path data-v-98cf25ea="" d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"></path></svg>
                    </div>
                    <!-- dataDocument Accordion -->
                    <div id="dataDocument_6"
                         class="collapse">
                        <div class="card-body">
                            <div class="form-group">
                                <label>
                                    {{trans('pages.customer_survey','describe_your_idea')}}
                                </label>
                                <ckeditor v-model="objTextarea.textarea_company_page"
                                          :config="objTextarea.config_company_page"
                                          @input="fixInfo('company_page', objTextarea.textarea_company_page)"
                                ></ckeditor>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Страница заполнения контактных данных о себе. -->
                <li>
                    <div class="box-li">
                        <a class="link-a" href="javascript:void(0)"
                           @click.prevent="checkAuth1(lang.prefix_lang+'private-office/contact-information')"
                        >
                            {{trans('pages.customer_survey','contact_page')}}
                        </a>
                        <svg data-target="#dataDocument_7"
                             aria-controls="dataDocument_7"
                             data-toggle="collapse" aria-expanded="true"
                             class="edit-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"> <path data-v-98cf25ea="" d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"></path></svg>
                    </div>
                    <!-- dataDocument Accordion -->
                    <div id="dataDocument_7"
                         class="collapse">
                        <div class="card-body">
                            <div class="form-group">
                                <label>
                                    {{trans('pages.customer_survey','describe_your_idea')}}
                                </label>
                                <ckeditor v-model="objTextarea.textarea_contact_page"
                                          :config="objTextarea.config_contact_page"
                                          @input="fixInfo('contact_page', objTextarea.textarea_contact_page)"
                                ></ckeditor>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Страницы просмотра личных вакансий -->
                <li>
                    <div class="box-li">
                        <a class="link-a" href="javascript:void(0)"
                           @click.prevent="checkAuth1(lang.prefix_lang+'private-office/vacancy/my-vacancies')"
                        >
                            {{trans('pages.customer_survey','my_vacancies')}}
                        </a>
                        <svg data-target="#dataDocument_8"
                             aria-controls="dataDocument_8"
                             data-toggle="collapse" aria-expanded="true"
                             class="edit-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"> <path data-v-98cf25ea="" d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"></path></svg>
                    </div>
                    <!-- dataDocument Accordion -->
                    <div id="dataDocument_8"
                         class="collapse">
                        <div class="card-body">
                            <div class="form-group">
                                <label>
                                    {{trans('pages.customer_survey','describe_your_idea')}}
                                </label>
                                <ckeditor v-model="objTextarea.textarea_my_vacancies"
                                          :config="objTextarea.config_my_vacancies"
                                          @input="fixInfo('my_vacancies', objTextarea.textarea_my_vacancies)"
                                ></ckeditor>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Страницы просмотра личных резюме -->
                <li>
                    <div class="box-li">
                        <a class="link-a" href="javascript:void(0)"
                           @click.prevent="checkAuth1(lang.prefix_lang+'private-office/resume/my-resumes')"
                        >
                            {{trans('pages.customer_survey','my_resumes')}}
                        </a>
                        <svg data-target="#dataDocument_9"
                             aria-controls="dataDocument_9"
                             data-toggle="collapse" aria-expanded="true"
                             class="edit-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"> <path data-v-98cf25ea="" d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"></path></svg>
                    </div>
                    <!-- dataDocument Accordion -->
                    <div id="dataDocument_9"
                         class="collapse">
                        <div class="card-body">
                            <div class="form-group">
                                <label>
                                    {{trans('pages.customer_survey','describe_your_idea')}}
                                </label>
                                <ckeditor v-model="objTextarea.textarea_my_resumes"
                                          :config="objTextarea.config_my_resumes"
                                          @input="fixInfo('my_resumes', objTextarea.textarea_my_resumes)"
                                ></ckeditor>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Страницы добавленных в закладку вакансий / резюме -->
                <li>
                    <div class="box-li">
                        <a class="link-a" href="javascript:void(0)"
                           @click.prevent="checkAuth1(lang.prefix_lang+'private-office/vacancy/bookmark-vacancies')"
                        >
                            {{trans('pages.customer_survey','bookmark_documents')}}
                        </a>
                        &nbsp;/&nbsp;
                        <a class="link-a" href="javascript:void(0)"
                           @click.prevent="checkAuth1(lang.prefix_lang+'private-office/resume/bookmark-resumes')"
                        >
                            {{trans('pages.customer_survey','resume1')}}
                        </a>
                        <svg data-target="#dataDocument_10"
                             aria-controls="dataDocument_10"
                             data-toggle="collapse" aria-expanded="true"
                             class="edit-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"> <path data-v-98cf25ea="" d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"></path></svg>
                    </div>
                    <!-- dataDocument Accordion -->
                    <div id="dataDocument_10"
                         class="collapse">
                        <div class="card-body">
                            <div class="form-group">
                                <label>
                                    {{trans('pages.customer_survey','describe_your_idea')}}
                                </label>
                                <ckeditor v-model="objTextarea.textarea_bookmark_documents"
                                          :config="objTextarea.config_bookmark_documents"
                                          @input="fixInfo('bookmark_documents', objTextarea.textarea_bookmark_documents)"
                                ></ckeditor>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Страницы скрытых вакансий / резюме -->
                <li>
                    <div class="box-li">
                        <a class="link-a" href="javascript:void(0)"
                           @click.prevent="checkAuth1(lang.prefix_lang+'private-office/vacancy/hidden-vacancies')"
                        >
                            {{trans('pages.customer_survey','hidden_documents')}}
                        </a>
                        &nbsp;/&nbsp;
                        <a class="link-a" href="javascript:void(0)"
                           @click.prevent="checkAuth1(lang.prefix_lang+'private-office/resume/hidden-resumes')"
                        >
                            {{trans('pages.customer_survey','resume1')}}
                        </a>
                        <svg data-target="#dataDocument_11"
                             aria-controls="dataDocument_11"
                             data-toggle="collapse" aria-expanded="true"
                             class="edit-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"> <path data-v-98cf25ea="" d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"></path></svg>
                    </div>
                    <!-- dataDocument Accordion -->
                    <div id="dataDocument_11"
                         class="collapse">
                        <div class="card-body">
                            <div class="form-group">
                                <label>
                                    {{trans('pages.customer_survey','describe_your_idea')}}
                                </label>
                                <ckeditor v-model="objTextarea.textarea_hidden_documents"
                                          :config="objTextarea.config_hidden_documents"
                                          @input="fixInfo('hidden_documents', objTextarea.textarea_hidden_documents)"
                                ></ckeditor>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Общая страница Предложений (чат) -->
                <li>
                    <div class="box-li">
                        <a class="link-a" href="javascript:void(0)"
                           @click.prevent="checkAuth1(lang.prefix_lang+'offers')"
                        >
                            {{trans('pages.customer_survey','offers')}}
                        </a>
                        <svg data-target="#dataDocument_12"
                             aria-controls="dataDocument_12"
                             data-toggle="collapse" aria-expanded="true"
                             class="edit-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"> <path data-v-98cf25ea="" d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"></path></svg>
                    </div>
                    <!-- dataDocument Accordion -->
                    <div id="dataDocument_12"
                         class="collapse">
                        <div class="card-body">
                            <div class="form-group">
                                <label>
                                    {{trans('pages.customer_survey','describe_your_idea')}}
                                </label>
                                <ckeditor v-model="objTextarea.textarea_offers"
                                          :config="objTextarea.config_offers"
                                          @input="fixInfo('offers', objTextarea.textarea_offers)"
                                ></ckeditor>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Внутренняя страница выбранного Предложения (чат) -->
                <li>
                    <div class="box-li">
                        <a class="link-a" href="javascript:void(0)"
                           @click.prevent="checkAuth1(lang.prefix_lang+'offers')"
                        >
                            {{trans('pages.customer_survey','offers_to')}}
                        </a>
                        <svg data-target="#dataDocument_13"
                             aria-controls="dataDocument_13"
                             data-toggle="collapse" aria-expanded="true"
                             class="edit-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"> <path data-v-98cf25ea="" d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"></path></svg>
                    </div>
                    <!-- dataDocument Accordion -->
                    <div id="dataDocument_13"
                         class="collapse">
                        <div class="card-body">
                            <div class="form-group">
                                <label>
                                    {{trans('pages.customer_survey','describe_your_idea')}}
                                </label>
                                <ckeditor v-model="objTextarea.textarea_offers_to"
                                          :config="objTextarea.config_offers_to"
                                          @input="fixInfo('offers_to', objTextarea.textarea_offers_to)"
                                ></ckeditor>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Страница Финансовой Поддержки -->
                <li>
                    <div class="box-li">
                        <a class="link-a" target="_blank" :href="`${lang.prefix_lang}show-charity`">
                            {{trans('pages.customer_survey','show_charity')}}
                        </a>
                        <svg data-target="#dataDocument_14"
                             aria-controls="dataDocument_14"
                             data-toggle="collapse" aria-expanded="true"
                             class="edit-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"> <path data-v-98cf25ea="" d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"></path></svg>
                    </div>
                    <!-- dataDocument Accordion -->
                    <div id="dataDocument_14"
                         class="collapse">
                        <div class="card-body">
                            <div class="form-group">
                                <label>
                                    {{trans('pages.customer_survey','describe_your_idea')}}
                                </label>
                                <ckeditor v-model="objTextarea.textarea_show_charity"
                                          :config="objTextarea.config_show_charity"
                                          @input="fixInfo('show_charity', objTextarea.textarea_show_charity)"
                                ></ckeditor>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Страница О сервисе -->
                <li>
                    <div class="box-li">
                        <a class="link-a" target="_blank" :href="`${lang.prefix_lang}about-us`">
                            {{trans('pages.customer_survey','about_us')}}
                        </a>
                        <svg data-target="#dataDocument_15"
                             aria-controls="dataDocument_15"
                             data-toggle="collapse" aria-expanded="true"
                             class="edit-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"> <path data-v-98cf25ea="" d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"></path></svg>
                    </div>
                    <!-- dataDocument Accordion -->
                    <div id="dataDocument_15"
                         class="collapse">
                        <div class="card-body">
                            <div class="form-group">
                                <label>
                                    {{trans('pages.customer_survey','describe_your_idea')}}
                                </label>
                                <ckeditor v-model="objTextarea.textarea_about_us"
                                          :config="objTextarea.config_about_us"
                                          @input="fixInfo('about_us', objTextarea.textarea_about_us)"
                                ></ckeditor>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Страница обратной связи -->
                <li>
                    <div class="box-li">
                        <a class="link-a" target="_blank" :href="`${lang.prefix_lang}feedback`">
                            {{trans('pages.customer_survey','feedback')}}
                        </a>
                        <svg data-target="#dataDocument_16"
                             aria-controls="dataDocument_16"
                             data-toggle="collapse" aria-expanded="true"
                             class="edit-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"> <path data-v-98cf25ea="" d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"></path></svg>
                    </div>
                    <!-- dataDocument Accordion -->
                    <div id="dataDocument_16"
                         class="collapse">
                        <div class="card-body">
                            <div class="form-group">
                                <label>
                                    {{trans('pages.customer_survey','describe_your_idea')}}
                                </label>
                                <ckeditor v-model="objTextarea.textarea_feedback"
                                          :config="objTextarea.config_feedback"
                                          @input="fixInfo('feedback', objTextarea.textarea_feedback)"
                                ></ckeditor>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Страница Политика Cookie -->
                <li>
                    <div class="box-li">
                        <a class="link-a" target="_blank" :href="`${lang.prefix_lang}cookie-police`">
                            {{trans('pages.customer_survey','cookie_police')}}
                        </a>
                        <svg data-target="#dataDocument_18"
                             aria-controls="dataDocument_18"
                             data-toggle="collapse" aria-expanded="true"
                             class="edit-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"> <path data-v-98cf25ea="" d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"></path></svg>
                    </div>
                    <!-- dataDocument Accordion -->
                    <div id="dataDocument_18"
                         class="collapse">
                        <div class="card-body">
                            <div class="form-group">
                                <label>
                                    {{trans('pages.customer_survey','describe_your_idea')}}
                                </label>
                                <ckeditor v-model="objTextarea.textarea_cookie_police"
                                          :config="objTextarea.config_cookie_police"
                                          @input="fixInfo('cookie_police', objTextarea.textarea_cookie_police)"
                                ></ckeditor>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Страница Пользовательского соглашения -->
                <li>
                    <div class="box-li">
                        <a class="link-a" target="_blank" :href="`${lang.prefix_lang}terms-use`">
                            {{trans('pages.customer_survey','terms_use')}}
                        </a>
                        <svg data-target="#dataDocument_19"
                             aria-controls="dataDocument_19"
                             data-toggle="collapse" aria-expanded="true"
                             class="edit-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"> <path data-v-98cf25ea="" d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"></path></svg>
                    </div>
                    <!-- dataDocument Accordion -->
                    <div id="dataDocument_19"
                         class="collapse">
                        <div class="card-body">
                            <div class="form-group">
                                <label>
                                    {{trans('pages.customer_survey','describe_your_idea')}}
                                </label>
                                <ckeditor v-model="objTextarea.textarea_terms_use"
                                          :config="objTextarea.config_terms_use"
                                          @input="fixInfo('terms_use', objTextarea.textarea_terms_use)"
                                ></ckeditor>
                            </div>
                        </div>
                    </div>
                </li>
            </ol>

            <h2>{{trans('pages.customer_survey','interface_elements')}}</h2>

            <ol id="accordionExample_2" class="accordion">
                <!-- Главное меню -->
                <li>
                    <div class="box-li">
                        {{trans('pages.customer_survey','main_menu')}}
                        <svg data-target="#dataDocument_20"
                             aria-controls="dataDocument_20"
                             data-toggle="collapse" aria-expanded="true"
                             class="edit-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"> <path data-v-98cf25ea="" d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"></path></svg>
                    </div>
                    <!-- dataDocument Accordion -->
                    <div id="dataDocument_20"
                         class="collapse">
                        <div class="card-body">
                            <div class="form-group">
                                <label>
                                    {{trans('pages.customer_survey','describe_your_idea')}}
                                </label>
                                <ckeditor v-model="objTextarea.textarea_main_menu"
                                          :config="objTextarea.config_main_menu"
                                          @input="fixInfo('main_menu', objTextarea.textarea_main_menu)"
                                ></ckeditor>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Футер сайта -->
                <li>
                    <div class="box-li">
                        {{trans('pages.customer_survey','footer')}}
                        <svg data-target="#dataDocument_21"
                             aria-controls="dataDocument_21"
                             data-toggle="collapse" aria-expanded="true"
                             class="edit-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"> <path data-v-98cf25ea="" d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"></path></svg>
                    </div>
                    <!-- dataDocument Accordion -->
                    <div id="dataDocument_21"
                         class="collapse">
                        <div class="card-body">
                            <div class="form-group">
                                <label>
                                    {{trans('pages.customer_survey','describe_your_idea')}}
                                </label>
                                <ckeditor v-model="objTextarea.textarea_footer"
                                          :config="objTextarea.config_footer"
                                          @input="fixInfo('footer', objTextarea.textarea_footer)"
                                ></ckeditor>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Языки сайта -->
                <li>
                    <div class="box-li">
                        {{trans('pages.customer_survey','languages')}}
                        <svg data-target="#dataDocument_22"
                             aria-controls="dataDocument_22"
                             data-toggle="collapse" aria-expanded="true"
                             class="edit-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"> <path data-v-98cf25ea="" d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"></path></svg>
                    </div>
                    <!-- dataDocument Accordion -->
                    <div id="dataDocument_22"
                         class="collapse">
                        <div class="card-body">
                            <div class="form-group">
                                <label>
                                    {{trans('pages.customer_survey','describe_your_idea')}}
                                </label>
                                <ckeditor v-model="objTextarea.textarea_languages"
                                          :config="objTextarea.config_languages"
                                          @input="fixInfo('languages', objTextarea.textarea_languages)"
                                ></ckeditor>
                            </div>
                        </div>
                    </div>
                </li>
            </ol>

            <!-- Отправка данных -->
            <div v-show="objInfo.length" class="box-personal-data">
                <div class="header-personal-data">
                    {{trans('pages.customer_survey','sending_data')}}
                </div>
                <div class="body-personal-data">
                    <b>
                        {{trans('pages.customer_survey','you_made_suggestions')}}
                    </b>
                    <div class="box-data-section">
                    <span v-for="(obj, key) in objInfo" :key="key"
                          class="item-filter-parameter"
                    >
                        {{trans('pages.customer_survey',obj.name)}}
                        <svg @click="deleteInfo(obj.name)"
                             class="svg-circle-xmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M331.3 180.7c-6.25-6.25-16.38-6.25-22.62 0L256 233.4l-52.7-52.7c-6.25-6.25-16.38-6.25-22.62 0s-6.25 16.38 0 22.62L233.4 256l-52.7 52.7c-6.25 6.25-6.25 16.38 0 22.62 6.246 6.246 16.37 6.254 22.62 0L256 278.6l52.69 52.69c6.246 6.246 16.37 6.254 22.62 0 6.25-6.25 6.25-16.38 0-22.62L278.6 256l52.69-52.69c6.31-6.21 6.31-16.41.01-22.61zM256 0C114.6 0 0 114.6 0 256s114.6 256 256 256 256-114.6 256-256S397.4 0 256 0zm0 480C132.5 480 32 379.5 32 256S132.5 32 256 32s224 100.5 224 224-100.5 224-224 224z"/></svg>
                    </span>
                    </div>
                    <div class="box-input">
                        <!-- первый row -->
                        <div class="row">
                            <!-- name -->
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>
                                        {{trans('contact','your_name')}}
                                        <span class="mandatory-filling">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                                    </span>
                                    </label>
                                    <input type="text" class="form-control" maxlength="100"
                                           :placeholder="trans('contact','enter_name')"
                                           :class="{'is-invalid': $v.name.$error}"
                                           v-model="name"
                                           @blur="$v.name.$touch()"
                                    >
                                    <div class="invalid-feedback" v-if="!$v.name.required">
                                        {{trans('contact','enter_your_name')}}
                                    </div>
                                </div>
                            </div>
                            <!-- email -->
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>
                                        {{trans('contact','email')}}
                                        <span class="mandatory-filling">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                                    </span>
                                    </label>
                                    <input type="email" class="form-control" maxlength="100"
                                           :placeholder="trans('contact','enter_email')"
                                           :class="{'is-invalid': $v.email.$error}"
                                           v-model="email"
                                           @blur="$v.email.$touch()"
                                    >
                                    <div class="invalid-feedback" v-if="!$v.email.required"> {{ trans('auth','field_not_filled') }} </div>
                                    <div class="invalid-feedback" v-if="!$v.email.email"> {{ trans('auth','email_not_incorrectly') }} </div>
                                </div>
                            </div>
                            <!-- коментарий -->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>
                                        {{trans('pages.customer_survey','comment')}}
                                    </label>
                                    <ckeditor v-model="objTextarea.textarea_comment"
                                              :config="objTextarea.config_comment"
                                    ></ckeditor>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-personal-data">
                    <button type="submit" class="btn btn-block btn-primary btn-lg btn_send_message"
                            :class="{'disabled': $v.$invalid}"
                            :disabled="$v.$invalid"
                            @click.prevent="sendMessage()"
                    >
                        {{trans('pages.customer_survey','submit')}}
                    </button>
                </div>
            </div>
        </div>

        <!-- alert после отправки -->
        <div class="box-alert-exit">

            <div class="alert-exit">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"/></svg>
                <br>
                {{trans('pages.feedback','your_message_been_sent')}}
                <br>
                {{trans('pages.feedback','keep_track_specified')}}
                <br>
                {{trans('pages.feedback','thank_you_contacting')}}
            </div>

            <!-- сброс -->
            <button type="submit" class="btn btn-block btn-primary btn-lg"
                    @click.prevent="resetPage()"
            >
                {{trans('pages.feedback','proceed')}}
            </button>

        </div>

        <!-- кнопка scroll к отправке -->
        <div class="btn-up btn-primary btn-up_hide">
            Отправить
            <svg class="svg-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M360 431.1H24c-13.25 0-24 10.76-24 24.02C0 469.2 10.75 480 24 480h336c13.25 0 24-10.76 24-24.02 0-13.28-10.7-24.88-24-24.88zm-57.5-223.4-86.5 92V56.1c0-13.34-10.7-24.1-24-24.1s-24 10.76-24 24.02v243.6L81.47 207.7c-4.72-5.1-11.09-7.6-17.47-7.6-5.906 0-11.81 2.158-16.44 6.536-9.656 9.069-10.12 24.27-1.031 33.93l128 136.1c9.062 9.694 25.88 9.694 34.94 0l128-136.1c9.094-9.663 8.625-24.86-1.031-33.93C326.8 197.5 311.6 197.1 302.5 207.7z"/></svg>
        </div>

    </div>
</template>

<script>

    import translation from "../../mixins/translation";
    import response_methods_mixin from "../../mixins/response_methods_mixin";
    import general_functions_mixin from "../../mixins/general_functions_mixin";
    import { required, email } from 'vuelidate/lib/validators'

    export default {
        mixins: [
            translation,
            response_methods_mixin,
            general_functions_mixin,
        ],
        data() {
            return {
                name: "",
                email: "",
                objTextarea: {
                    textarea_main_page: '',
                    textarea_search_vacancies: '',
                    textarea_search_resume: '',
                    textarea_private_office: '',
                    textarea_company_create: '',
                    textarea_company_page: '',
                    textarea_contact_page: '',
                    textarea_my_vacancies: '',
                    textarea_my_resumes: '',
                    textarea_bookmark_documents: '',
                    textarea_hidden_documents: '',
                    textarea_offers: '',
                    textarea_offers_to: '',
                    textarea_show_charity: '',
                    textarea_about_us: '',
                    textarea_feedback: '',
                    textarea_cookie_police: '',
                    textarea_terms_use: '',
                    textarea_main_menu: '',
                    textarea_footer: '',
                    textarea_languages: '',
                    textarea_comment: '',

                    config_main_page: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList' ]
                        ],
                    },
                    config_search_vacancies: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList' ]
                        ],
                    },
                    config_search_resume: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList' ]
                        ],
                    },
                    config_private_office: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList' ]
                        ],
                    },
                    config_company_create: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList' ]
                        ],
                    },
                    config_company_page: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList' ]
                        ],
                    },
                    config_contact_page: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList' ]
                        ],
                    },
                    config_my_vacancies: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList' ]
                        ],
                    },
                    config_my_resumes: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList' ]
                        ],
                    },
                    config_bookmark_documents: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList' ]
                        ],
                    },
                    config_hidden_documents: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList' ]
                        ],
                    },
                    config_offers: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList' ]
                        ],
                    },
                    config_offers_to: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList' ]
                        ],
                    },
                    config_show_charity: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList' ]
                        ],
                    },
                    config_about_us: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList' ]
                        ],
                    },
                    config_feedback: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList' ]
                        ],
                    },
                    config_cookie_police: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList' ]
                        ],
                    },
                    config_terms_use: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList' ]
                        ],
                    },
                    config_main_menu: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList' ]
                        ],
                    },
                    config_footer: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList' ]
                        ],
                    },
                    config_languages: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList' ]
                        ],
                    },
                    config_comment: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList' ]
                        ],
                    },
                },
                objInfo: [],
                btnToPersonalData: null,
            }
        },
        methods: {
            async sendMessage() {
                let data = {
                    name: this.name,
                    email: this.email,
                    comment: this.objTextarea.textarea_comment,
                    arr_data: this.objInfo,
                }

                $('.btn_send_message').attr("disabled", true)

                const response = await this.$http.post("/send-customer-survey", data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            $("#box-content").css("display","none")
                            $(".box-alert-exit").css("display","block")
                        }
                        // custom ошибки
                        else{
                            this.message(res.data.message, 'error', 10000, true);
                        }
                    })
                    // ошибки сервера
                    .catch(err => {
                        this.messageError(err)
                        $('.btn-form').attr("disabled", false)
                    })
            },
            fixInfo(name, property){
                let index = this.searchInCustomArr(name)

                // 2 проверка на символ кроме пробела
                // вырезать теги
                let str = this.cutTags(property)
                // вырезать &nbsp;
                str = this.cutNbsp(str)
                // убрать пробелы
                str = this.cutSpaces(str)

                // создать
                if(index == null && str.length){
                    this.objInfo.push({name:name,value:property})
                }
                // дописать
                else if(index !== null && str.length){
                    this.objInfo[name] = property
                }
                // удалить
                else if(index !== null && !str.length){
                    this.objInfo.splice(index, 1)
                }
            },
            deleteInfo(name){
                let index = this.searchInCustomArr(name)
                // зачистить обьекты
                if(index !== null){
                    this.objInfo.splice(index, 1)
                    this.objTextarea["textarea_"+name] = ""
                }
            },
            searchInCustomArr(name){
                let index = null
                for(let i = 0; i < this.objInfo.length; i++) {
                    if(this.objInfo[i].name == name) {
                        index = i;
                        break;
                    }
                }
                return index
            },
            show() {
                // удалим у кнопки класс btn-up_hide
                this.btnToPersonalData.classList.remove('btn-up_hide');
            },
            hide() {
                // добавим к кнопке класс btn-up_hide
                this.btnToPersonalData.classList.add('btn-up_hide');
            },
            addEventListener() {
                this.btnToPersonalData = document.querySelector('.btn-up')

                // Button появитса если скрол меньше бокса отправки данных
                window.addEventListener('scroll', () => {
                    // определяем величину прокрутки
                    const screen_now = window.scrollY || document.documentElement.scrollTop;
                    // высота видимого екрана
                    const height_screen = document.documentElement.clientHeight
                    // высота документа
                    const full_height_screen = document.documentElement.scrollHeight
                    // высота где сейчас box Отправка данных
                    let height_now_box = this.getCoords(document.querySelector('.box-personal-data'))

                    const height_element = full_height_screen - height_now_box.top

                    // 1700 - 550 - 400 = 750
                    let math = (full_height_screen - height_screen) - height_element
                    // появитса если скрол меньше бокса отправки данных
                    screen_now < math ? this.show() : this.hide()
                });
                // при нажатии на кнопку .btn-up
                document.querySelector('.btn-up').onclick = () => {
                    const el = document.querySelector('.box-personal-data');
                    $('html,body').animate({
                        scrollTop:$(el).offset().top-100+"px"
                    }, 500, 'linear');
                }
            },
            initialData(){
                // инициализация всплывающих подсказок
                $('[data-toggle="tooltip"]').tooltip();

                this.addEventListener()

                if(this.respond['contact'] !== null){
                    this.name = this.respond['contact'].name
                    this.email = this.respond['contact'].email !== null ? this.respond['contact'].email : ""
                }
            },
            resetPage() {
                location.reload()
            },
            checkAuth1(url) {
                // не авторизован
                if(this.user == null){
                    this.reset_array(0)
                    $('#authModal').modal('toggle')
                    localStorage.setItem('url_click_no_auth', url)
                }
                else{
                    window.open(url, '_blank')
                }
            },
        },
        props: [
            'lang',
            'user',
            'respond',
        ],
        mounted() {
            this.initialData()


            console.log( localStorage.getItem('url_click_no_auth') )
        },
        validations: {
            name: {
                required,
            },
            email: {
                required,
                email,
            },
        }
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .customer_survey{
        padding-bottom: 75px;
        .h1-translate{
            display: flex;
            padding: 60px 0 15px;
            .box-translate-google{
                display: flex;
                margin-left: 20px;
                .svg-translate{
                    width: 50px;
                    fill: #3490dc;
                    cursor: pointer;
                    &:hover{
                        fill: #0370c9;
                    }
                }
                #google_translate_element{
                    display: flex;
                    flex-wrap: wrap;
                    align-content: center;
                }
            }
        }
        .page-explanation{
            margin-bottom: 15px;
        }
        h2{
            margin: 25px 0 20px 0;
        }
        ol{
            padding: 0 0 0 17px;
        }
        ol li{
            list-style-type: decimal;
            margin: 0 0 15px 15px;
            padding: 0 0 0 7px;
        }
        ol ol{
            padding: 0 0 0 17px;
        }
        ol ol li{
            list-style-type: disc;
        }

        .box-li{
            display: flex;
            align-items: flex-start;
            padding: 5px 0 5px 10px;
            .edit-svg{
                fill: #007c08;
                cursor: pointer;
                margin: 0 5px;
            }
        }
    }
    .card-body{
        padding: 0;
    }
    label{
        margin: 0;
        padding: 10px 0;
        width: 100%;
    }
    .box-personal-data{
        margin-top: 40px;
        .header-personal-data{
            background-color: #007bff;
            color: white;
            padding: 10px 0 10px 20px;
            border-radius: 5px 5px 0 0;
        }
        .body-personal-data{
            border-left: 1px solid #dee2e6;
            border-right: 1px solid #dee2e6;
            border-bottom: 1px solid #dee2e6;
            padding: 10px 20px 0 20px;
            .box-data-section{
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: flex-start;
                align-content: center;
                align-items: flex-start;
                padding-bottom: 30px;
                border-bottom: 1px solid #007bff;
                .item-filter-parameter{
                    display: flex;
                    align-content: center;
                    background: #e3e3e3;
                    padding: 4px 8px 4px 10px;
                    border-radius: 15px;
                    line-height: 20px;
                    margin: 10px 5px 0 0;
                    .svg-circle-xmark{
                        width: 17px;
                        fill: #dc3545;
                        margin-left: 4px;
                        cursor: pointer;
                    }
                }
            }
            .box-input{
                padding-top: 15px;
                .row{
                    margin: 0 -5px;
                }
            }
        }
        .footer-personal-data{
            display: flex;
            justify-content: center;
            button{
                margin-top: 40px;
                width: auto;
                padding: 0.5rem 35px;
            }
        }
    }
    .box-alert-exit{
        display: none;
        width: 60%;
        margin: 50px auto 0 auto;
        .alert-exit{
            text-align: center;
            padding: 40px;
            background: #f3f9ff;
            svg{
                width: 40px;
                fill: #28a745;
                margin-bottom: 20px;
            }
        }
        button{
            width: auto;
            margin: 40px auto 0;
        }
    }

    .btn-up {
        position: fixed;
        right: 20px;
        top: 145px;
        cursor: pointer;
        padding: 0.5rem 15px 0.5rem 35px;
        border-top: 3px solid #fcc36d;
        .svg-arrow{
            margin-left: 10px;
            path{
                fill: #fcc36d;
            }
        }
    }
    .btn-up_hide {
        display: none;
    }


</style>





























