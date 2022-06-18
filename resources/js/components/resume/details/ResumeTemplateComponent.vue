<template>
    <div class="view-page">

        <!-- отображение прошедшего времени -->
        <div v-if="page === 'show'" class="date-document header-date-document">
            <div class="date-string">
                Резюме {{getDateDocumentString(resume.updated_at)}} назад
            </div>
            <!-- Резюме скрыто -->
            <div class="close-document-fon"
                 v-if="resume.job_posting.status_name == 'hidden'"
            >
                Резюме скрыто
            </div>
        </div>

        <!-- title company logo status -->
        <div class="box-title">
            <!-- title resume -->
            <h2 class="title-vacancy">
                {{UpperCaseFirstCharacter(resume.position.title)}}
            </h2>

            <!-- аватар контакта -->
            <template v-if="page !== 'my_resumes'">
                <!-- если file avatar не загружен -->
                <img v-if="resume.contact.avatar === null" class="img-logo"
                     :src="`/${resume.contact.default_avatar_url}`"
                     :alt="`${resume.contact.name} ${resume.contact.surname}`"
                >
                <!-- если загружен -->
                <img v-else class="img-logo"
                     :src="`/${resume.contact.avatar.url}`"
                     :alt="`${resume.contact.name} ${resume.contact.surname}`"
                >
            </template>

            <!-- проверка контента резюме -->
            <template v-else-if="page === 'my_resumes'">
                <!-- на проверке -->
                <div v-if="!resume.published" class="no-verified" >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M150.7 92.77C195 58.27 251.8 32 320 32C400.8 32 465.5 68.84 512.6 112.6C559.4 156 590.7 207.1 605.5 243.7C608.8 251.6 608.8 260.4 605.5 268.3C592.1 300.6 565.2 346.1 525.6 386.7L630.8 469.1C641.2 477.3 643.1 492.4 634.9 502.8C626.7 513.2 611.6 515.1 601.2 506.9L9.196 42.89C-1.236 34.71-3.065 19.63 5.112 9.196C13.29-1.236 28.37-3.065 38.81 5.112L150.7 92.77zM223.1 149.5L313.4 220.3C317.6 211.8 320 202.2 320 191.1C320 180.5 316.1 169.7 311.6 160.4C314.4 160.1 317.2 159.1 320 159.1C373 159.1 416 202.1 416 255.1C416 269.7 413.1 282.7 407.1 294.5L446.6 324.7C457.7 304.3 464 280.9 464 255.1C464 176.5 399.5 111.1 320 111.1C282.7 111.1 248.6 126.2 223.1 149.5zM320 480C239.2 480 174.5 443.2 127.4 399.4C80.62 355.1 49.34 304 34.46 268.3C31.18 260.4 31.18 251.6 34.46 243.7C44 220.8 60.29 191.2 83.09 161.5L177.4 235.8C176.5 242.4 176 249.1 176 255.1C176 335.5 240.5 400 320 400C338.7 400 356.6 396.4 373 389.9L446.2 447.5C409.9 467.1 367.8 480 320 480H320z"/></svg>
                    {{trans('vacancies','checking')}}
                </div>
                <!-- проверен -->
                <div v-else class="verified" >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M279.6 160.4C282.4 160.1 285.2 160 288 160C341 160 384 202.1 384 256C384 309 341 352 288 352C234.1 352 192 309 192 256C192 253.2 192.1 250.4 192.4 247.6C201.7 252.1 212.5 256 224 256C259.3 256 288 227.3 288 192C288 180.5 284.1 169.7 279.6 160.4zM480.6 112.6C527.4 156 558.7 207.1 573.5 243.7C576.8 251.6 576.8 260.4 573.5 268.3C558.7 304 527.4 355.1 480.6 399.4C433.5 443.2 368.8 480 288 480C207.2 480 142.5 443.2 95.42 399.4C48.62 355.1 17.34 304 2.461 268.3C-.8205 260.4-.8205 251.6 2.461 243.7C17.34 207.1 48.62 156 95.42 112.6C142.5 68.84 207.2 32 288 32C368.8 32 433.5 68.84 480.6 112.6V112.6zM288 112C208.5 112 144 176.5 144 256C144 335.5 208.5 400 288 400C367.5 400 432 335.5 432 256C432 176.5 367.5 112 288 112z"/></svg>
                </div>
            </template>

            <!-- количество откликов -->
            <div v-if="page === 'my_resumes'" class="response-vacancy">
                <a href="#">
                    <div class="response-num">
                        {{resume.respond_count}}
                    </div>
                    {{trans('vacancies','responses')}}
                </a>
            </div>

            <div class="clear-float"></div>
        </div>

        <!-- name -->
        <div class="line-div">
            <div class="font-weight-bold">
                <h3>
                    {{UpperCaseFirstCharacter(resume.contact.surname)}} {{UpperCaseFirstCharacter(resume.contact.name)}}
                </h3>
            </div>
        </div>

        <!-- salary -->
        <div class="line-div box-salary">
            <div class="font-weight-bold salary-vacancy">
                <span class="box-svg">
                    <svg class="svg-salary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M64 240C46.33 240 32 225.7 32 208C32 190.3 46.33 176 64 176H92.29C121.9 92.11 201.1 32 296 32H320C337.7 32 352 46.33 352 64C352 81.67 337.7 96 320 96H296C238.1 96 187.8 128.4 162.1 176H288C305.7 176 320 190.3 320 208C320 225.7 305.7 240 288 240H144.2C144.1 242.6 144 245.3 144 248V264C144 266.7 144.1 269.4 144.2 272H288C305.7 272 320 286.3 320 304C320 321.7 305.7 336 288 336H162.1C187.8 383.6 238.1 416 296 416H320C337.7 416 352 430.3 352 448C352 465.7 337.7 480 320 480H296C201.1 480 121.9 419.9 92.29 336H64C46.33 336 32 321.7 32 304C32 286.3 46.33 272 64 272H80.15C80.05 269.3 80 266.7 80 264V248C80 245.3 80.05 242.7 80.15 240H64z"/></svg>
                </span>
                <span>
                    {{salaryView(resume.salary)}}
                </span>
            </div>
            <div class="comment-vacancy"
                 v-if="resume.salary.comment !== null"
            >
                <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/>
                </svg>
                {{resume.salary.comment}}
            </div>
        </div>

        <!-- languages -->
        <div class="line-div">
            <div class="font-weight-bold languages-vacancy">
                <span class="box-svg">
                    <svg class="svg-languages" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M448 164C459 164 468 172.1 468 184V188H528C539 188 548 196.1 548 208C548 219 539 228 528 228H526L524.4 232.5C515.5 256.1 501.9 279.1 484.7 297.9C485.6 298.4 486.5 298.1 487.4 299.5L506.3 310.8C515.8 316.5 518.8 328.8 513.1 338.3C507.5 347.8 495.2 350.8 485.7 345.1L466.8 333.8C462.4 331.1 457.1 328.3 453.7 325.3C443.2 332.8 431.8 339.3 419.8 344.7L416.1 346.3C406 350.8 394.2 346.2 389.7 336.1C385.2 326 389.8 314.2 399.9 309.7L403.5 308.1C409.9 305.2 416.1 301.1 422 298.3L409.9 286.1C402 278.3 402 265.7 409.9 257.9C417.7 250 430.3 250 438.1 257.9L452.7 272.4L453.3 272.1C465.7 259.9 475.8 244.7 483.1 227.1H376C364.1 227.1 356 219 356 207.1C356 196.1 364.1 187.1 376 187.1H428V183.1C428 172.1 436.1 163.1 448 163.1L448 164zM160 233.2L179 276H140.1L160 233.2zM0 128C0 92.65 28.65 64 64 64H576C611.3 64 640 92.65 640 128V384C640 419.3 611.3 448 576 448H64C28.65 448 0 419.3 0 384V128zM320 384H576V128H320V384zM178.3 175.9C175.1 168.7 167.9 164 160 164C152.1 164 144.9 168.7 141.7 175.9L77.72 319.9C73.24 329.1 77.78 341.8 87.88 346.3C97.97 350.8 109.8 346.2 114.3 336.1L123.2 315.1H196.8L205.7 336.1C210.2 346.2 222 350.8 232.1 346.3C242.2 341.8 246.8 329.1 242.3 319.9L178.3 175.9z"/></svg>
                </span>
                <template v-for="(value, key) in resume.languages">
                    {{lang.lang[value].title}},
                </template>
            </div>
        </div>

        <!-- address -->
        <div class="line-div box-address">
            <div class="font-weight-bold address-vacancy">
                <span class="box-svg">
                    <svg class="svg-address" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2H168.3zM192 256C227.3 256 256 227.3 256 192C256 156.7 227.3 128 192 128C156.7 128 128 156.7 128 192C128 227.3 156.7 256 192 256z"/></svg>
                </span>
                <span>
                    <!-- Onsite, Remote-->
                    {{trans('vacancies',settings.type_employment[resume.type_employment])}}
                </span>
            </div>
            <div class="comment-vacancy">
                <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/>
                </svg>
                {{addressView(resume)}}
            </div>
        </div>

        <!-- для других страниц -->
        <template v-if="page !== 'my_resumes'">
            <!-- опыт -->
            <div class="line-div experience">
            <span class="box-svg">
                <svg class="svg-experience" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M448 80V128C448 172.2 347.7 208 224 208C100.3 208 0 172.2 0 128V80C0 35.82 100.3 0 224 0C347.7 0 448 35.82 448 80zM393.2 214.7C413.1 207.3 433.1 197.8 448 186.1V288C448 332.2 347.7 368 224 368C100.3 368 0 332.2 0 288V186.1C14.93 197.8 34.02 207.3 54.85 214.7C99.66 230.7 159.5 240 224 240C288.5 240 348.3 230.7 393.2 214.7V214.7zM54.85 374.7C99.66 390.7 159.5 400 224 400C288.5 400 348.3 390.7 393.2 374.7C413.1 367.3 433.1 357.8 448 346.1V432C448 476.2 347.7 512 224 512C100.3 512 0 476.2 0 432V346.1C14.93 357.8 34.02 367.3 54.85 374.7z"/></svg>
            </span>
                <span class="font-weight-bold">
                {{UpperCaseFirstCharacter( trans('vacancies',settings.work_experience[resume.experience]) )}}
            </span>
            </div>

            <!-- возраст -->
            <div class="line-div age-vacancy">
            <span class="box-svg">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM164.1 325.5C158.3 318.8 148.2 318.1 141.5 323.9C134.8 329.7 134.1 339.8 139.9 346.5C162.1 372.1 200.9 400 255.1 400C311.1 400 349.8 372.1 372.1 346.5C377.9 339.8 377.2 329.7 370.5 323.9C363.8 318.1 353.7 318.8 347.9 325.5C329.9 346.2 299.4 368 255.1 368C212.6 368 182 346.2 164.1 325.5H164.1zM176.4 176C158.7 176 144.4 190.3 144.4 208C144.4 225.7 158.7 240 176.4 240C194 240 208.4 225.7 208.4 208C208.4 190.3 194 176 176.4 176zM336.4 240C354 240 368.4 225.7 368.4 208C368.4 190.3 354 176 336.4 176C318.7 176 304.4 190.3 304.4 208C304.4 225.7 318.7 240 336.4 240z"/></svg>
            </span>
                <div class="font-weight-bold">
                    {{getDateDocumentString(resume.data_birth)}}
                </div>
            </div>

            <!-- образование -->
            <div class="line-div education-vacancy">
                <span class="box-svg">
                    <svg class="svg-education" viewBox="0 0 384 512" xmlns="http://www.w3.org/2000/svg">
                        <path d="M288 358.3c13.98-8.088 17.53-30.04 28.88-41.39c11.35-11.35 33.3-14.88 41.39-28.87c7.98-13.79 .1658-34.54 4.373-50.29C366.7 222.5 383.1 208.5 383.1 192c0-16.5-17.27-30.52-21.34-45.73c-4.207-15.75 3.612-36.5-4.365-50.29c-8.086-13.98-30.03-17.52-41.38-28.87c-11.35-11.35-14.89-33.3-28.87-41.39c-13.79-7.979-34.54-.1637-50.29-4.375C222.5 17.27 208.5 0 192 0C175.5 0 161.5 17.27 146.3 21.34C130.5 25.54 109.8 17.73 95.98 25.7C82 33.79 78.46 55.74 67.11 67.08C55.77 78.43 33.81 81.97 25.72 95.95C17.74 109.7 25.56 130.5 21.35 146.2C17.27 161.5 .0008 175.5 .0008 192c0 16.5 17.27 30.52 21.34 45.73c4.207 15.75-3.615 36.5 4.361 50.29C33.8 302 55.74 305.5 67.08 316.9c11.35 11.35 14.89 33.3 28.88 41.4c13.79 7.979 34.53 .1582 50.28 4.369C161.5 366.7 175.5 384 192 384c16.5 0 30.52-17.27 45.74-21.34C253.5 358.5 274.2 366.3 288 358.3zM112 192c0-44.27 35.81-80 80-80s80 35.73 80 80c0 44.17-35.81 80-80 80S112 236.2 112 192zM1.719 433.2c-3.25 8.188-1.781 17.48 3.875 24.25c5.656 6.75 14.53 9.898 23.12 8.148l45.19-9.035l21.43 42.27C99.46 507 107.6 512 116.7 512c.3438 0 .6641-.0117 1.008-.0273c9.5-.375 17.65-6.082 21.24-14.88l33.58-82.08c-53.71-4.639-102-28.12-138.2-63.95L1.719 433.2zM349.6 351.1c-36.15 35.83-84.45 59.31-138.2 63.95l33.58 82.08c3.594 8.797 11.74 14.5 21.24 14.88C266.6 511.1 266.1 512 267.3 512c9.094 0 17.23-4.973 21.35-13.14l21.43-42.28l45.19 9.035c8.594 1.75 17.47-1.398 23.12-8.148c5.656-6.766 7.125-16.06 3.875-24.25L349.6 351.1z"/>
                    </svg>
                </span>
                <div class="font-weight-bold">
                    {{UpperCaseFirstCharacter( trans('vacancies',settings.education[resume.education]) )}}
                </div>
            </div>

            <!-- Контакт лист -->
            <div v-if="contact_list !== undefined" class="card bg-light contacts-list">
                <div class="contacts-header">
                    <div class="contacts-title">
                        Контакт лист
                    </div>
                    <a href="#" class="btn btn-sm bg-teal">
                        <i class="fas fa-comments"></i>
                    </a>
                </div>
                <div class="card-body">

                    <div class="box-image">
                        <img alt="" class="img-fluid"
                             :src="`/${contact_list.avatar_url}`"
                        >
                        <div class="contacts-content">
                            <!-- name -->
                            <div class="font-weight-bold">
                                {{contact_list.full_name}}
                            </div>
                            <!-- position -->
                            <div class="font-weight-bold contacts-position">
                                {{contact_list.position}}
                            </div>
                        </div>
                    </div>


                    <!-- email -->
                    <div class="contacts-line">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M464 64C490.5 64 512 85.49 512 112C512 127.1 504.9 141.3 492.8 150.4L275.2 313.6C263.8 322.1 248.2 322.1 236.8 313.6L19.2 150.4C7.113 141.3 0 127.1 0 112C0 85.49 21.49 64 48 64H464zM217.6 339.2C240.4 356.3 271.6 356.3 294.4 339.2L512 176V384C512 419.3 483.3 448 448 448H64C28.65 448 0 419.3 0 384V176L217.6 339.2z"/></svg>
                        {{contact_list.email}}
                    </div>

                    <!-- skype -->
                    <div class="contacts-line">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M424.7 299.8c2.9-14 4.7-28.9 4.7-43.8 0-113.5-91.9-205.3-205.3-205.3-14.9 0-29.7 1.7-43.8 4.7C161.3 40.7 137.7 32 112 32 50.2 32 0 82.2 0 144c0 25.7 8.7 49.3 23.3 68.2-2.9 14-4.7 28.9-4.7 43.8 0 113.5 91.9 205.3 205.3 205.3 14.9 0 29.7-1.7 43.8-4.7 19 14.6 42.6 23.3 68.2 23.3 61.8 0 112-50.2 112-112 .1-25.6-8.6-49.2-23.2-68.1zm-194.6 91.5c-65.6 0-120.5-29.2-120.5-65 0-16 9-30.6 29.5-30.6 31.2 0 34.1 44.9 88.1 44.9 25.7 0 42.3-11.4 42.3-26.3 0-18.7-16-21.6-42-28-62.5-15.4-117.8-22-117.8-87.2 0-59.2 58.6-81.1 109.1-81.1 55.1 0 110.8 21.9 110.8 55.4 0 16.9-11.4 31.8-30.3 31.8-28.3 0-29.2-33.5-75-33.5-25.7 0-42 7-42 22.5 0 19.8 20.8 21.8 69.1 33 41.4 9.3 90.7 26.8 90.7 77.6 0 59.1-57.1 86.5-112 86.5z"/></svg>
                        {{contact_list.skype}}
                    </div>

                    <!-- phone -->
                    <div class="contacts-line">
                        <svg class="svg-phone" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M304 0H80C44.65 0 16 28.65 16 64v384c0 35.35 28.65 64 64 64h224c35.35 0 64-28.65 64-64V64c0-35.35-28.7-64-64-64zm16 448c0 8.822-7.178 16-16 16H80c-8.82 0-16-7.2-16-16v-80h256v80zm0-128H64V64c0-8.822 7.178-16 16-16h224c8.8 0 16 7.18 16 16v256zM160 432h64c8.836 0 16-7.164 16-16s-7.164-16-16-16h-64c-8.836 0-16 7.164-16 16s7.2 16 16 16z"/></svg>
                        {{contact_list.phone['phone'].replaceAll(/[(-)]/ig, ' ')}}
                        <template v-for="(value, key) in contact_list.phone['messengers']">
                            <div class="box-message" v-if="settings.contact_information[value] == 'Telegram'">
                                <svg class="svg-telegram" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248,8C111.033,8,0,119.033,0,256S111.033,504,248,504,496,392.967,496,256,384.967,8,248,8ZM362.952,176.66c-3.732,39.215-19.881,134.378-28.1,178.3-3.476,18.584-10.322,24.816-16.948,25.425-14.4,1.326-25.338-9.517-39.287-18.661-21.827-14.308-34.158-23.215-55.346-37.177-24.485-16.135-8.612-25,5.342-39.5,3.652-3.793,67.107-61.51,68.335-66.746.153-.655.3-3.1-1.154-4.384s-3.59-.849-5.135-.5q-3.283.746-104.608,69.142-14.845,10.194-26.894,9.934c-8.855-.191-25.888-5.006-38.551-9.123-15.531-5.048-27.875-7.717-26.8-16.291q.84-6.7,18.45-13.7,108.446-47.248,144.628-62.3c68.872-28.647,83.183-33.623,92.511-33.789,2.052-.034,6.639.474,9.61,2.885a10.452,10.452,0,0,1,3.53,6.716A43.765,43.765,0,0,1,362.952,176.66Z"/></svg>
                            </div>
                            <div class="box-message" v-if="settings.contact_information[value] == 'Viber'">
                                <svg class="svg-viber"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M444 49.9C431.3 38.2 379.9.9 265.3.4c0 0-135.1-8.1-200.9 52.3C27.8 89.3 14.9 143 13.5 209.5c-1.4 66.5-3.1 191.1 117 224.9h.1l-.1 51.6s-.8 20.9 13 25.1c16.6 5.2 26.4-10.7 42.3-27.8 8.7-9.4 20.7-23.2 29.8-33.7 82.2 6.9 145.3-8.9 152.5-11.2 16.6-5.4 110.5-17.4 125.7-142 15.8-128.6-7.6-209.8-49.8-246.5zM457.9 287c-12.9 104-89 110.6-103 115.1-6 1.9-61.5 15.7-131.2 11.2 0 0-52 62.7-68.2 79-5.3 5.3-11.1 4.8-11-5.7 0-6.9.4-85.7.4-85.7-.1 0-.1 0 0 0-101.8-28.2-95.8-134.3-94.7-189.8 1.1-55.5 11.6-101 42.6-131.6 55.7-50.5 170.4-43 170.4-43 96.9.4 143.3 29.6 154.1 39.4 35.7 30.6 53.9 103.8 40.6 211.1zm-139-80.8c.4 8.6-12.5 9.2-12.9.6-1.1-22-11.4-32.7-32.6-33.9-8.6-.5-7.8-13.4.7-12.9 27.9 1.5 43.4 17.5 44.8 46.2zm20.3 11.3c1-42.4-25.5-75.6-75.8-79.3-8.5-.6-7.6-13.5.9-12.9 58 4.2 88.9 44.1 87.8 92.5-.1 8.6-13.1 8.2-12.9-.3zm47 13.4c.1 8.6-12.9 8.7-12.9.1-.6-81.5-54.9-125.9-120.8-126.4-8.5-.1-8.5-12.9 0-12.9 73.7.5 133 51.4 133.7 139.2zM374.9 329v.2c-10.8 19-31 40-51.8 33.3l-.2-.3c-21.1-5.9-70.8-31.5-102.2-56.5-16.2-12.8-31-27.9-42.4-42.4-10.3-12.9-20.7-28.2-30.8-46.6-21.3-38.5-26-55.7-26-55.7-6.7-20.8 14.2-41 33.3-51.8h.2c9.2-4.8 18-3.2 23.9 3.9 0 0 12.4 14.8 17.7 22.1 5 6.8 11.7 17.7 15.2 23.8 6.1 10.9 2.3 22-3.7 26.6l-12 9.6c-6.1 4.9-5.3 14-5.3 14s17.8 67.3 84.3 84.3c0 0 9.1.8 14-5.3l9.6-12c4.6-6 15.7-9.8 26.6-3.7 14.7 8.3 33.4 21.2 45.8 32.9 7 5.7 8.6 14.4 3.8 23.6z"/></svg>
                            </div>
                            <div class="box-message" v-if="settings.contact_information[value] == 'WhatsApp'">
                                <svg class="svg-whatsapp"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>
                            </div>
                        </template>
                    </div>

                </div>
            </div>

            <!-- textarea -->
            <div class="box-textarea">
                <template v-if="page == 'show'">
                    <!-- Описание своего опыта -->
                    <div v-if="resume.text_experience !== null"
                         class="textarea-vacancy"
                    >
                        <h2 class="section-title">Описание опыта</h2>
                        <div v-html="resume.text_experience"></div>
                    </div>

                    <!-- Навыки и достижения -->
                    <div v-if="resume.text_achievements !== null"
                         class="textarea-vacancy"
                    >
                        <h2 class="section-title">Навыки и достижения</h2>
                        <div v-html="resume.text_achievements"></div>
                    </div>

                    <!-- Ожидания на новой работе -->
                    <div v-if="resume.text_wait !== null"
                         class="textarea-vacancy"
                    >
                        <h2 class="section-title">Ожидания на новой работе</h2>
                        <div v-html="resume.text_wait"></div>
                    </div>
                </template>
                <div v-else-if="page == 'search'"
                     class="textarea-vacancy"
                >
                    <div class="link-vacancy">
                        Подробнее
                        <svg viewBox="0 0 320 512" xmlns="http://www.w3.org/2000/svg">
                            <path d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </template>

        <!-- footer-resume -->
        <div v-if="page === 'my_resumes'" class="footer-vacancy">

            <!-- отображение прошедшего времени -->
            <div class="date-document">
                {{getDateDocumentString(resume.updated_at)}} назад
                <!-- вакансия закрыта -->
                <div class="close-document-fon"
                     v-if="resume.job_posting.status_name == 'hidden'"
                >
                    Резюме скрыто
                </div>
            </div>

            <div class="right-footer">
                <!-- статус -->
                <div class="mode-vacancy"
                     v-html="getStatus(resume.job_posting)"
                >
                </div>

                <!-- button -->
                <div class="button-vacancy">
                    <!-- Разместить -->
                    <button type="button" class="btn btn-block btn-outline-primary"
                            v-if="resume.job_posting.status_name == 'hidden'"
                            @click="changeStatus($event, resume.id, 0)"
                    >
                        {{trans('vacancies','post')}}
                    </button>
                    <!-- menu -->
                    <div class="btn-group dropleft">
                        <button type="button" class="btn btn-primary dropdown-toggle"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                        >
                            {{trans('vacancies','functions')}}
                        </button>
                        <div class="dropdown-menu">
                            <!-- скрыть -->
                            <a class="dropdown-item" href="#"
                               v-if="resume.job_posting.status_name == 'standard'"
                               @click="changeStatus($event, resume.id, 1)"
                            >
                                {{trans('vacancies','hide')}}
                            </a>
                            <!-- обновить -->
                            <a class="dropdown-item" href="#"
                               v-if="resume.job_posting.status_name == 'standard'"
                               @click="changeStatus($event, resume.id, 0)"
                            >
                                {{trans('vacancies','update')}}
                            </a>
                            <!-- редактировать -->
                            <a class="dropdown-item"
                               :href="`${lang.prefix_lang}private-office/resume/${resume.id}/edit`"
                            >
                                {{trans('vacancies','edit')}}
                            </a>
                            <!-- скопировать -->
                            <a class="dropdown-item" href="#"
                               @click="duplicateResume($event, resume.id)"
                            >
                                {{trans('vacancies','copy')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import translation from "../../../mixins/translation";
    import general_functions_mixin from "../../../mixins/general_functions_mixin";
    import date_mixin from "../../../mixins/date_mixin";
    import response_methods_mixin from "../../../mixins/response_methods_mixin";

    export default {
        mixins: [
            translation,
            general_functions_mixin,
            date_mixin,
            response_methods_mixin,
        ],
        data() {
            return {
            }
        },
        methods: {
            addressView(vacancyObj){
                let address_string = ''

                if(vacancyObj.country !== null){
                    address_string += vacancyObj.country.name+'.'
                }
                if(vacancyObj.region !== null){
                    address_string += ' ' + vacancyObj.region.name+'.'
                }
                if(vacancyObj.city !== null){
                    address_string += ' ' + vacancyObj.city.name+'.'
                }

                return address_string
            },
            salaryView(salaryObj){
                let salary_string = ''
                let arr_field = this.settings.salary[salaryObj.radio_name]
                $.each(arr_field, function(key, name) {
                    salary_string += salaryObj.inputs[name]
                    if( (key+1) < arr_field.length){
                        salary_string += ' - '
                    }
                })
                salary_string = salary_string == '' ? 0 : salary_string
                return salary_string
            },
            // статус и дни вакансии
            getStatus(statusObj){
                let html_status = '<div class="mode standard">'
                html_status += statusObj.status_name
                html_status += '</div>'

                if(statusObj.status_name == 'hidden'){
                    html_status += '<div class="balance-mode">'
                    html_status += '~ 0 дней'
                }
                else{
                    // прибавить месяц к дате пуюликации
                    let create_date = new Date(statusObj.create_time)
                    create_date.setMonth(create_date.getMonth() + 1)
                    // сколько осталось дней у публикации
                    let count_day = this.getDifferenceDays(create_date, Date.now())

                    html_status += '<div class="balance-mode standard">'
                    html_status += '~ '+count_day+' дней'
                }

                html_status += '</div>'

                return html_status
            },
            async changeStatus(event, id, index){
                event.stopPropagation()
                let data = {
                    id: id,
                    index: index
                };
                const response = await this.$http.post(`/private-office/resume/up-resume-status`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            location.reload()
                        }
                        // custom ошибки
                        else{
                            this.message(res.data.message, 'error', 10000, true);
                        }
                    })
                    // ошибки сервера
                    .catch(err => {
                        this.messageError(err)
                    })
            },
            async duplicateResume(event, id){
                event.stopPropagation()
                let data = {
                    id: id,
                };
                const response = await this.$http.post(`/private-office/resume/duplicate-resume`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            location.reload()
                        }
                        // custom ошибки
                        else{
                            this.message(res.data.message, 'error', 10000, true);
                        }
                    })
                    // ошибки сервера
                    .catch(err => {
                        this.messageError(err)
                    })
            },
        },
        props: [
            'resume',
            'settings',
            'lang',
            'contact_list',
            'page',
        ],
        mounted() {
            console.log(this.settings)
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../../sass/variables";
    svg {
        path {
            fill: #1d68a7;
        }
    }

    .contacts-header{
        padding: 0.75rem 1.25rem;
        background-color: rgba(32, 32, 32, 0.03);
        border-bottom: 1px solid rgba(32, 32, 32, 0.125);
        color: #6c757d;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .contacts-list{
        margin: 25px 0;
        width: 400px;
        box-shadow: none;
        .card-header{
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: space-between;
            align-content: flex-start;
            align-items: center;
        }
        .card-body{
            .box-image{
                display: flex;
                img{
                    margin-right: 10px;
                    width: 65px;
                    height: 80px;
                }
                .contacts-content{
                    .contacts-position{
                        font-weight: 300!important;
                    }
                }
            }
        }
        .contacts-line{
            font-size: 14px;
            display: flex;
            align-items: center;
            margin-top: 10px;
            svg{
                margin-right: 5px;
                path {
                    fill: #6c757d;
                }
            }
            .svg-phone{
                width: 18px;
            }
            .svg-telegram path {
                fill: #2197d0;
            }
            .svg-viber path {
                fill: #754d94;
            }
            .svg-whatsapp path {
                fill: #259a16;
            }
            .box-message svg{
                width: 16px;
                margin: 0 0 0 5px;
            }
        }
    }

    .textarea-vacancy {
        .link-vacancy {
            color: #1d68a7;
            display: inline;
            svg {
                width: 10px;
            }
        }
    }
    .footer-vacancy{
        .right-footer{
            display: flex;
            align-items: center;
            .button-vacancy{
                display: flex;
                margin-left: 20px;
                & > button {
                    margin-right: 15px;
                }
            }
        }
    }
    .img-logo {
        width: 120px;
        height: 150px;
        float: right;
        margin-bottom: -115px;
        outline: 1px solid #dee2e6;
    }
    .view-page{
        width: 100%;
    }
    .response-vacancy {
        text-align: center;
        font-weight: 600;
        line-height: 22px;
        margin-right: 11px;
        float: right;
    }
    .box-title {
        padding: 0;
        /*.title-vacancy {*/
        /*    margin: 0 5px 10px 0!important;*/
        /*    padding: 0;*/
        /*    line-height: 25px;*/
        /*    height: 25px;*/
        /*    font-size: 26px;*/
        /*    float: left;*/
        /*    max-width: 60%;*/
        /*}*/
        .company-vacancy {
            display: flex;
            flex-direction: column;
            align-items: center;
            float: right;
            margin-bottom: -95px;
            outline: 1px solid #dee2e6;
            max-width: 220px;

        }
        .no-verified,
        .verified{
            color: #f6993f;
            margin-left: 0px;
            height: 35px;
            float: left;
            svg {
                width: 16px;
                path{
                    fill: #f6993f;
                }
            }
        }
        .verified {
            svg {
                path{
                    fill: #38c172;
                }
            }
        }
    }
    .line-div {
        display: flex;
        margin-bottom: 5px;

        .font-weight-bold {
            font-weight: bold;
        }
        .link-vacancy {
            color: #1d68a7;
            svg {
                fill: #1d68a7;
            }
        }
    }
    .experience,
    .languages-vacancy,
    .salary-vacancy,
    .address-vacancy,
    .age-vacancy,
    .education-vacancy{
        display: flex;
        align-items: center;
    }
    .box-svg {
        width: 30px;
        display: block;
        line-height: 16px;
    }
    .box-address {
        max-width: 75%;
        .address-vacancy{
            white-space: nowrap;
        }
    }
    .comment-vacancy {
        display: flex;
        align-items: center;
        svg {
            width: 7px;
            margin: 0 5px;
        }
    }

    .svg-experience,
    .svg-salary,
    .svg-address{
        width: 18px;
    }
    .svg-languages {
        width: 23px;
    }
    .svg-education {
        width: 19px;
    }
    .box-salary {
        margin-top: 0;
    }


</style>





























