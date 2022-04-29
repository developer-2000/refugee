<template>
    <div>
        <!-- top panel -->
        <div class="top-panel">
            <button class="btn btn-block btn-outline-primary" type="button">
                Откликнуться
            </button>
            <button class="btn btn-block btn-outline-primary" type="button">
                Найти похожие вакансии
            </button>

            <!-- кнопки закладок вакансий -->
            <bookmark_buttons
                :lang="lang"
                :vacancy="vacancy"
                :user="user"
                :which_button_show="'show_vacancy'"
            ></bookmark_buttons>
        </div>

        <!-- vacancy -->
        <div class="box-vacancies">
            <!-- title -->
            <div class="box-title-logo container-fluid">
                <div class="row">
                    <h2 class="col-sm-9 title-vacancy">
                        {{UpperCaseFirstCharacter(vacancy.position.title)}}
                    </h2>
                    <!-- company -->
                    <div class="col-sm-3 company-vacancy">
                        <img :src="vacancy.employer.logo.url" alt="Test image" class="img-logo">
                        <div class="font-weight-bold">
                            {{vacancy.employer.title}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- salary -->
            <div class="line-div">
                <div class="font-weight-bold salary-vacancy">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M64 240C46.33 240 32 225.7 32 208C32 190.3 46.33 176 64 176H92.29C121.9 92.11 201.1 32 296 32H320C337.7 32 352 46.33 352 64C352 81.67 337.7 96 320 96H296C238.1 96 187.8 128.4 162.1 176H288C305.7 176 320 190.3 320 208C320 225.7 305.7 240 288 240H144.2C144.1 242.6 144 245.3 144 248V264C144 266.7 144.1 269.4 144.2 272H288C305.7 272 320 286.3 320 304C320 321.7 305.7 336 288 336H162.1C187.8 383.6 238.1 416 296 416H320C337.7 416 352 430.3 352 448C352 465.7 337.7 480 320 480H296C201.1 480 121.9 419.9 92.29 336H64C46.33 336 32 321.7 32 304C32 286.3 46.33 272 64 272H80.15C80.05 269.3 80 266.7 80 264V248C80 245.3 80.05 242.7 80.15 240H64z"/></svg>
                    {{salaryView(vacancy.salary)}}
                </div>
                <div class="comment-vacancy"
                     v-if="vacancy.salary.comment !== null"
                >
                    <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/>
                    </svg>
                    {{vacancy.salary.comment}}
                </div>
            </div>
            <!-- languages -->
            <div class="line-div">
                <div class="font-weight-bold languages-vacancy">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M448 164C459 164 468 172.1 468 184V188H528C539 188 548 196.1 548 208C548 219 539 228 528 228H526L524.4 232.5C515.5 256.1 501.9 279.1 484.7 297.9C485.6 298.4 486.5 298.1 487.4 299.5L506.3 310.8C515.8 316.5 518.8 328.8 513.1 338.3C507.5 347.8 495.2 350.8 485.7 345.1L466.8 333.8C462.4 331.1 457.1 328.3 453.7 325.3C443.2 332.8 431.8 339.3 419.8 344.7L416.1 346.3C406 350.8 394.2 346.2 389.7 336.1C385.2 326 389.8 314.2 399.9 309.7L403.5 308.1C409.9 305.2 416.1 301.1 422 298.3L409.9 286.1C402 278.3 402 265.7 409.9 257.9C417.7 250 430.3 250 438.1 257.9L452.7 272.4L453.3 272.1C465.7 259.9 475.8 244.7 483.1 227.1H376C364.1 227.1 356 219 356 207.1C356 196.1 364.1 187.1 376 187.1H428V183.1C428 172.1 436.1 163.1 448 163.1L448 164zM160 233.2L179 276H140.1L160 233.2zM0 128C0 92.65 28.65 64 64 64H576C611.3 64 640 92.65 640 128V384C640 419.3 611.3 448 576 448H64C28.65 448 0 419.3 0 384V128zM320 384H576V128H320V384zM178.3 175.9C175.1 168.7 167.9 164 160 164C152.1 164 144.9 168.7 141.7 175.9L77.72 319.9C73.24 329.1 77.78 341.8 87.88 346.3C97.97 350.8 109.8 346.2 114.3 336.1L123.2 315.1H196.8L205.7 336.1C210.2 346.2 222 350.8 232.1 346.3C242.2 341.8 246.8 329.1 242.3 319.9L178.3 175.9z"/></svg>
                    <template v-for="(value, key) in vacancy.languages">
                        {{lang.lang[value].title}},
                    </template>
                </div>
            </div>
            <!-- address -->
            <div class="line-div">
                <div class="font-weight-bold address-vacancy">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2H168.3zM192 256C227.3 256 256 227.3 256 192C256 156.7 227.3 128 192 128C156.7 128 128 156.7 128 192C128 227.3 156.7 256 192 256z"/></svg>
                    <!--                            Onsite, Remote-->
                    {{settings.type_employment[vacancy.type_employment]}}
                </div>
                <div class="comment-vacancy">
                    <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/>
                    </svg>
                    {{addressView(vacancy)}}
                </div>
            </div>
            <!-- experience -->
            <div class="line-div experience">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M448 80V128C448 172.2 347.7 208 224 208C100.3 208 0 172.2 0 128V80C0 35.82 100.3 0 224 0C347.7 0 448 35.82 448 80zM393.2 214.7C413.1 207.3 433.1 197.8 448 186.1V288C448 332.2 347.7 368 224 368C100.3 368 0 332.2 0 288V186.1C14.93 197.8 34.02 207.3 54.85 214.7C99.66 230.7 159.5 240 224 240C288.5 240 348.3 230.7 393.2 214.7V214.7zM54.85 374.7C99.66 390.7 159.5 400 224 400C288.5 400 348.3 390.7 393.2 374.7C413.1 367.3 433.1 357.8 448 346.1V432C448 476.2 347.7 512 224 512C100.3 512 0 476.2 0 432V346.1C14.93 357.8 34.02 367.3 54.85 374.7z"/></svg>
                    {{settings.work_experience[vacancy.experience]}}
            </div>
            <!-- age worker -->
            <div class="line-div age-vacancy">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM164.1 325.5C158.3 318.8 148.2 318.1 141.5 323.9C134.8 329.7 134.1 339.8 139.9 346.5C162.1 372.1 200.9 400 255.1 400C311.1 400 349.8 372.1 372.1 346.5C377.9 339.8 377.2 329.7 370.5 323.9C363.8 318.1 353.7 318.8 347.9 325.5C329.9 346.2 299.4 368 255.1 368C212.6 368 182 346.2 164.1 325.5H164.1zM176.4 176C158.7 176 144.4 190.3 144.4 208C144.4 225.7 158.7 240 176.4 240C194 240 208.4 225.7 208.4 208C208.4 190.3 194 176 176.4 176zM336.4 240C354 240 368.4 225.7 368.4 208C368.4 190.3 354 176 336.4 176C318.7 176 304.4 190.3 304.4 208C304.4 225.7 318.7 240 336.4 240z"/></svg>
                <div class="font-weight-bold"
                     v-if="vacancy.vacancy_suitable.radio_name == 'set_age'"
                >
                    {{vacancy.vacancy_suitable.inputs.from}} - {{vacancy.vacancy_suitable.inputs.to}} years
                </div>
                <div class="comment-vacancy"
                     v-if="vacancy.vacancy_suitable.comment !== null"
                >
                    <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/>
                    </svg>
                    {{vacancy.vacancy_suitable.comment}}
                </div>
            </div>
            <!-- education -->
            <div class="line-div education-vacancy">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M288 358.3c13.98-8.088 17.53-30.04 28.88-41.39c11.35-11.35 33.3-14.88 41.39-28.87c7.98-13.79 .1658-34.54 4.373-50.29C366.7 222.5 383.1 208.5 383.1 192c0-16.5-17.27-30.52-21.34-45.73c-4.207-15.75 3.612-36.5-4.365-50.29c-8.086-13.98-30.03-17.52-41.38-28.87c-11.35-11.35-14.89-33.3-28.87-41.39c-13.79-7.979-34.54-.1637-50.29-4.375C222.5 17.27 208.5 0 192 0C175.5 0 161.5 17.27 146.3 21.34C130.5 25.54 109.8 17.73 95.98 25.7C82 33.79 78.46 55.74 67.11 67.08C55.77 78.43 33.81 81.97 25.72 95.95C17.74 109.7 25.56 130.5 21.35 146.2C17.27 161.5 .0008 175.5 .0008 192c0 16.5 17.27 30.52 21.34 45.73c4.207 15.75-3.615 36.5 4.361 50.29C33.8 302 55.74 305.5 67.08 316.9c11.35 11.35 14.89 33.3 28.88 41.4c13.79 7.979 34.53 .1582 50.28 4.369C161.5 366.7 175.5 384 192 384c16.5 0 30.52-17.27 45.74-21.34C253.5 358.5 274.2 366.3 288 358.3zM112 192c0-44.27 35.81-80 80-80s80 35.73 80 80c0 44.17-35.81 80-80 80S112 236.2 112 192zM1.719 433.2c-3.25 8.188-1.781 17.48 3.875 24.25c5.656 6.75 14.53 9.898 23.12 8.148l45.19-9.035l21.43 42.27C99.46 507 107.6 512 116.7 512c.3438 0 .6641-.0117 1.008-.0273c9.5-.375 17.65-6.082 21.24-14.88l33.58-82.08c-53.71-4.639-102-28.12-138.2-63.95L1.719 433.2zM349.6 351.1c-36.15 35.83-84.45 59.31-138.2 63.95l33.58 82.08c3.594 8.797 11.74 14.5 21.24 14.88C266.6 511.1 266.1 512 267.3 512c9.094 0 17.23-4.973 21.35-13.14l21.43-42.28l45.19 9.035c8.594 1.75 17.47-1.398 23.12-8.148c5.656-6.766 7.125-16.06 3.875-24.25L349.6 351.1z"/></svg>
                <div class="font-weight-bold">
                    {{settings.education[vacancy.education]}}
                </div>
            </div>
            <div class="textarea-vacancy">
                <b>Описание вакансии</b>
                <div v-html="vacancy.text_description"></div>
            </div>
            <div class="textarea-vacancy">
                <b>Условия работы</b>
                <div v-html="vacancy.text_working"></div>
            </div>
            <div class="textarea-vacancy">
                <b>Обязанности кандидата</b>
                <div v-html="vacancy.text_responsibilities"></div>
            </div>
        </div>
    </div>
</template>

<script>
    import general_functions_mixin from "../../mixins/general_functions_mixin.js";
    import bookmark_buttons from "./details/BookmarkButtonsVacancyComponent";

    export default {
        components: {
            'bookmark_buttons': bookmark_buttons,
        },
        mixins: [
            general_functions_mixin,
        ],
        data() {
            return {
            }
        },
        methods: {
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

                address_string += ' ' + vacancyObj.rest_address+'.'

                return address_string
            },
        },
        props: [
            'lang',   // масив названий и url языка
            'vacancy',
            'settings',
            'user',
        ],
        mounted() {
            console.log(this.vacancy)
            // console.log(this.lang)
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .top-panel{
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        border-bottom: 1px solid #dee2e6;
        background-color: #fff;
        padding: 15px 25px;
        display: flex;
        z-index: 1;
        button{
            width: auto;
            margin-right: 15px;
        }
    }
    .box-vacancies {
        background-color: #fff;
        padding: 25px;
        .box-title-logo{
            padding: 0;
            .title-vacancy{
                margin: 5px 0 10px;
                padding: 0;
                line-height: 25px;
                height: 25px;
                font-size: 26px;
            }
            .company-vacancy{
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .img-logo{
                width: 100px;
                float: right;
            }
            &>div:nth-child(1){
                svg{
                    width: 18px;
                    margin-right: 5px;
                    path{
                        fill: #1d68a7;
                    }
                }
            }
        }
        .line-div{
            display: flex;
            margin-bottom: 5px;
            .font-weight-bold{
                font-weight: bold;
            }
            .link-vacancy{
                color: #1d68a7;
                svg{
                    margin: 0 5px 0 0;
                    path{
                        fill: #1d68a7;
                    }
                }
            }
        }
        .age-vacancy{
            svg{
                margin-right: 10px;
                path{
                    fill: #1d68a7;
                }
            }
        }
        .comment-vacancy{
            display: flex;
            align-items: center;
            svg{
                width: 7px;
                margin: 0 5px;
                path{
                    fill: #1d68a7;
                }
            }
        }
        .education-vacancy{
            margin-bottom: 15px;
        }
        .education-vacancy,
        .experience,
        .address-vacancy,
        .salary-vacancy{
            svg{
                width: 18px;
                margin-right: 13px;
                path{
                    fill: #1d68a7;
                }
            }
        }
        .languages-vacancy{
            svg{
                width: 23px;
                margin-right: 8px;
                path{
                    fill: #1d68a7;
                }
            }
        }
    }

</style>





























