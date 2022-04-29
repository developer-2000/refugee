<template>
    <!-- buttons
    action: 1 - действие в базе, 0 - обратное действие
    data-bool: 1 - первая кнопка действия, 0 - кнопка обратного действия
    data-id: содержит id vacancy
    -->
    <div class="panel-button">
        <!-- Сохранить -->
        <!-- 1 -->
        <button class="btn btn-block btn-outline-primary first-btn btn-sm" type="button"
                @click.prevent="changeButton($event, 'save_', 'save-two_', 'show_', 1)"
                data-bool="1"
                :data-id="vacancy.id"
                :id="`save_${vacancy.id}`"
        >
            <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                <path d="M244 84L255.1 96L267.1 84.02C300.6 51.37 347 36.51 392.6 44.1C461.5 55.58 512 115.2 512 185.1V190.9C512 232.4 494.8 272.1 464.4 300.4L283.7 469.1C276.2 476.1 266.3 480 256 480C245.7 480 235.8 476.1 228.3 469.1L47.59 300.4C17.23 272.1 0 232.4 0 190.9V185.1C0 115.2 50.52 55.58 119.4 44.1C164.1 36.51 211.4 51.37 244 84C243.1 84 244 84.01 244 84L244 84zM255.1 163.9L210.1 117.1C188.4 96.28 157.6 86.4 127.3 91.44C81.55 99.07 48 138.7 48 185.1V190.9C48 219.1 59.71 246.1 80.34 265.3L256 429.3L431.7 265.3C452.3 246.1 464 219.1 464 190.9V185.1C464 138.7 430.4 99.07 384.7 91.44C354.4 86.4 323.6 96.28 301.9 117.1L255.1 163.9z"/>
            </svg>
            Сохранить
        </button>
        <!-- 2 -->
        <button v-if="which_button_show == 'search_vacancy'"
                class="btn btn-block btn-outline-success btn-sm first-btn save-two" type="button"
                @click="transitionBookmark($event)"
                :id="`save-two_${vacancy.id}`"
        >
            <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 190.9V185.1C0 115.2 50.52 55.58 119.4 44.1C164.1 36.51 211.4 51.37 244 84.02L256 96L267.1 84.02C300.6 51.37 347 36.51 392.6 44.1C461.5 55.58 512 115.2 512 185.1V190.9C512 232.4 494.8 272.1 464.4 300.4L283.7 469.1C276.2 476.1 266.3 480 256 480C245.7 480 235.8 476.1 228.3 469.1L47.59 300.4C17.23 272.1 .0003 232.4 .0003 190.9L0 190.9z"/>
            </svg>
            В меню сохраненных
        </button>
        <!-- 3 -->
        <button v-else-if="which_button_show == 'show_vacancy'"
                class="btn btn-block btn-success first-btn save-two" type="button"
                @click.prevent="changeButton($event, 'save_', 'save-two_', 'show_', 0)"
                data-bool="0"
                :data-id="vacancy.id"
                :id="`save-two_${vacancy.id}`"
        >
            <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 190.9V185.1C0 115.2 50.52 55.58 119.4 44.1C164.1 36.51 211.4 51.37 244 84.02L256 96L267.1 84.02C300.6 51.37 347 36.51 392.6 44.1C461.5 55.58 512 115.2 512 185.1V190.9C512 232.4 494.8 272.1 464.4 300.4L283.7 469.1C276.2 476.1 266.3 480 256 480C245.7 480 235.8 476.1 228.3 469.1L47.59 300.4C17.23 272.1 .0003 232.4 .0003 190.9L0 190.9z"/>
            </svg>
            В меню сохраненных
        </button>
        <!-- Не показывать -->
        <!-- 1 -->
        <button class="btn btn-block btn-outline-primary btn-sm" type="button"
                @click.prevent="changeButton($event, 'show_', 'show-two_', 'save_', 1)"
                data-bool="1"
                :data-id="vacancy.id"
                :id="`show_${vacancy.id}`"
        >
            <svg viewBox="0 0 640 512" xmlns="http://www.w3.org/2000/svg">
                <path d="M150.7 92.77C195 58.27 251.8 32 320 32C400.8 32 465.5 68.84 512.6 112.6C559.4 156 590.7 207.1 605.5 243.7C608.8 251.6 608.8 260.4 605.5 268.3C592.1 300.6 565.2 346.1 525.6 386.7L630.8 469.1C641.2 477.3 643.1 492.4 634.9 502.8C626.7 513.2 611.6 515.1 601.2 506.9L9.196 42.89C-1.236 34.71-3.065 19.63 5.112 9.196C13.29-1.236 28.37-3.065 38.81 5.112L150.7 92.77zM189.8 123.5L235.8 159.5C258.3 139.9 287.8 128 320 128C390.7 128 448 185.3 448 256C448 277.2 442.9 297.1 433.8 314.7L487.6 356.9C521.1 322.8 545.9 283.1 558.6 256C544.1 225.1 518.4 183.5 479.9 147.7C438.8 109.6 385.2 79.1 320 79.1C269.5 79.1 225.1 97.73 189.8 123.5L189.8 123.5zM394.9 284.2C398.2 275.4 400 265.9 400 255.1C400 211.8 364.2 175.1 320 175.1C319.3 175.1 318.7 176 317.1 176C319.3 181.1 320 186.5 320 191.1C320 202.2 317.6 211.8 313.4 220.3L394.9 284.2zM404.3 414.5L446.2 447.5C409.9 467.1 367.8 480 320 480C239.2 480 174.5 443.2 127.4 399.4C80.62 355.1 49.34 304 34.46 268.3C31.18 260.4 31.18 251.6 34.46 243.7C44 220.8 60.29 191.2 83.09 161.5L120.8 191.2C102.1 214.5 89.76 237.6 81.45 255.1C95.02 286 121.6 328.5 160.1 364.3C201.2 402.4 254.8 432 320 432C350.7 432 378.8 425.4 404.3 414.5H404.3zM192 255.1C192 253.1 192.1 250.3 192.3 247.5L248.4 291.7C258.9 312.8 278.5 328.6 302 333.1L358.2 378.2C346.1 381.1 333.3 384 319.1 384C249.3 384 191.1 326.7 191.1 255.1H192z"/>
            </svg>
            Не показывать
        </button>
        <!-- 2 -->
        <button v-if="which_button_show == 'search_vacancy'"
                class="btn btn-block btn-outline-danger btn-sm show-two" type="button"
                @click="transitionHidden($event)"
                :id="`show-two_${vacancy.id}`"
        >
            <svg viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg">
                <path d="M160 256C160 185.3 217.3 128 288 128C358.7 128 416 185.3 416 256C416 326.7 358.7 384 288 384C217.3 384 160 326.7 160 256zM288 336C332.2 336 368 300.2 368 256C368 211.8 332.2 176 288 176C287.3 176 286.7 176 285.1 176C287.3 181.1 288 186.5 288 192C288 227.3 259.3 256 224 256C218.5 256 213.1 255.3 208 253.1C208 254.7 208 255.3 208 255.1C208 300.2 243.8 336 288 336L288 336zM95.42 112.6C142.5 68.84 207.2 32 288 32C368.8 32 433.5 68.84 480.6 112.6C527.4 156 558.7 207.1 573.5 243.7C576.8 251.6 576.8 260.4 573.5 268.3C558.7 304 527.4 355.1 480.6 399.4C433.5 443.2 368.8 480 288 480C207.2 480 142.5 443.2 95.42 399.4C48.62 355.1 17.34 304 2.461 268.3C-.8205 260.4-.8205 251.6 2.461 243.7C17.34 207.1 48.62 156 95.42 112.6V112.6zM288 80C222.8 80 169.2 109.6 128.1 147.7C89.6 183.5 63.02 225.1 49.44 256C63.02 286 89.6 328.5 128.1 364.3C169.2 402.4 222.8 432 288 432C353.2 432 406.8 402.4 447.9 364.3C486.4 328.5 512.1 286 526.6 256C512.1 225.1 486.4 183.5 447.9 147.7C406.8 109.6 353.2 80 288 80V80z"/>
            </svg>
            В меню спрятанных
        </button>
        <!-- 3 -->
        <button v-else-if="which_button_show == 'show_vacancy'"
                class="btn btn-block btn-danger show-two" type="button"
                @click.prevent="changeButton($event, 'show_', 'show-two_', 'save_', 0)"
                data-bool="0"
                :data-id="vacancy.id"
                :id="`show-two_${vacancy.id}`"
        >
            <svg viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg">
                <path d="M160 256C160 185.3 217.3 128 288 128C358.7 128 416 185.3 416 256C416 326.7 358.7 384 288 384C217.3 384 160 326.7 160 256zM288 336C332.2 336 368 300.2 368 256C368 211.8 332.2 176 288 176C287.3 176 286.7 176 285.1 176C287.3 181.1 288 186.5 288 192C288 227.3 259.3 256 224 256C218.5 256 213.1 255.3 208 253.1C208 254.7 208 255.3 208 255.1C208 300.2 243.8 336 288 336L288 336zM95.42 112.6C142.5 68.84 207.2 32 288 32C368.8 32 433.5 68.84 480.6 112.6C527.4 156 558.7 207.1 573.5 243.7C576.8 251.6 576.8 260.4 573.5 268.3C558.7 304 527.4 355.1 480.6 399.4C433.5 443.2 368.8 480 288 480C207.2 480 142.5 443.2 95.42 399.4C48.62 355.1 17.34 304 2.461 268.3C-.8205 260.4-.8205 251.6 2.461 243.7C17.34 207.1 48.62 156 95.42 112.6V112.6zM288 80C222.8 80 169.2 109.6 128.1 147.7C89.6 183.5 63.02 225.1 49.44 256C63.02 286 89.6 328.5 128.1 364.3C169.2 402.4 222.8 432 288 432C353.2 432 406.8 402.4 447.9 364.3C486.4 328.5 512.1 286 526.6 256C512.1 225.1 486.4 183.5 447.9 147.7C406.8 109.6 353.2 80 288 80V80z"/>
            </svg>
            В меню спрятанных
        </button>

        {{reactive_state_variable}}
        <span v-if="initialStateButtons(vacancy)"></span>

    </div>
</template>

<script>
    import general_functions_mixin from "../../../mixins/general_functions_mixin.js";
    import response_methods_mixin from "../../../mixins/response_methods_mixin";

    export default {
        mixins: [
            general_functions_mixin,
            response_methods_mixin,
        ],
        data() {
            return {
                reactive_state_variable: '1',
            }
        },
        methods: {
            async bookmarkVacancy(vacancy_id, action){
                let data = {
                    vacancy_id: vacancy_id,
                    action: action,
                };
                const response = await this.$http.post(`/private-office/vacancy/bookmark-vacancy`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            // console.log(res)
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
            async hideVacancyInSearch(vacancy_id, action){
                let data = {
                    vacancy_id: vacancy_id,
                    action: action,
                };
                const response = await this.$http.post(`/private-office/vacancy/hide-vacancy-search`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            // console.log(res)
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
            // изначальное состояние кнопок Сохранить и Спрятать
            initialStateButtons(vacancy){
                // вакансия добавлена в избранное (true/false)
                let saved_bool = this.lookingValueInArrayObjects('vacancy_id', vacancy.id, vacancy.id_saved_vacancies)
                let show_bool = this.lookingValueInArrayObjects('vacancy_id', vacancy.id, vacancy.id_not_shown_vacancies)
                let property_value = vacancy.id

                if(saved_bool){
                    $("#save_"+property_value).css('display','none').prop( "disabled", true )
                    $("#show_"+property_value).css('display','none').prop( "disabled", true )
                    $("#show-two_"+property_value).css('display','none').prop( "disabled", true )
                }
                else if(show_bool){
                    $("#save_"+property_value).css('display','none').prop( "disabled", true )
                    $("#save-two_"+property_value).css('display','none').prop( "disabled", true )
                    $("#show_"+property_value).css('display','none').prop( "disabled", true )
                }
                else{
                    $("#save-two_"+property_value).css('display','none').prop( "disabled", true )
                    $("#show-two_"+property_value).css('display','none').prop( "disabled", true )
                }

                this.reactive_state_variable = ''
                return false
            },
            // меняет кнопки Сохранить на В меню сохраненных и обратно
            // меняет кнопки Не показывать на Показывать вакансию и обратно
            changeButton(event, but1, but2, but3, action){
                // не авторизован
                if(this.user == null){
                    this.checkAuth(this.lang.prefix_lang+'vacancy')
                    event.stopPropagation()
                    return false
                }

                let vacancy_id = $(event.target).attr('data-id')
                // спрятал другие, себя изменил
                if($(event.target).attr('data-bool') == '1'){
                    $("#"+but2+vacancy_id).css('display','flex')
                    $("#"+but1+vacancy_id).css('display','none')
                    $("#"+but3+vacancy_id).css('display','none')

                    // я сразу disable
                    $("#"+but1+vacancy_id).prop( "disabled", true );
                    // сосед сразу disable
                    $("#"+but3+vacancy_id).prop( "disabled", true );
                    // рядом через время not disable
                    setTimeout(() => {
                        $("#"+but2+vacancy_id).prop( "disabled", false );
                    }, 500);
                }
                // показал другие, себя изменил
                else{
                    $("#"+but2+vacancy_id).css('display','none')
                    $("#"+but1+vacancy_id).css('display','flex')
                    $("#"+but3+vacancy_id).css('display','flex')

                    // рядом сразу disable
                    $("#"+but2+vacancy_id).prop( "disabled", true );
                    // я и сосед через время not disable
                    setTimeout(() => {
                        $("#"+but1+vacancy_id).prop( "disabled", false );
                        $("#"+but3+vacancy_id).prop( "disabled", false );
                    }, 500);
                }

                // что делать с этой вакансией
                if(but1 == 'save_'){
                    this.bookmarkVacancy(vacancy_id, action)
                }
                else if(but1 == 'show_'){
                    this.hideVacancyInSearch(vacancy_id, action)
                }

                // остановить распространение события click наверх родителю
                event.stopPropagation()
            },
            // переход в закладки сохраненных
            transitionBookmark(event){
                location.href = this.lang.prefix_lang+'private-office/vacancy/bookmark-vacancies'
                event.stopPropagation()
            },
            transitionHidden(event){
                location.href = this.lang.prefix_lang+'private-office/vacancy/hidden-vacancies'
                event.stopPropagation()
            },
        },
        props: [
            'lang',
            'vacancy',
            'user',
            'which_button_show',
        ],
    }
</script>

<style scoped lang="scss">
    @import "../../../../sass/variables";

    .panel-button{
        display: flex;
        justify-content: flex-end;
        /*margin: 15px 0 0;*/
        button{
            width: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            &:hover svg path{
                fill: white;
            }
            svg{
                width: 17px;
                margin-right: 5px;
                path{
                    transition: fill 0.15s ease-in-out;
                }
            }
        }
        .first-btn{
            margin-right: 15px;
            svg{
                width: 14px;
            }
        }
        .save-two {
            svg{
                width: 14px;
            }
        }
        .show-two {
            svg{
                width: 15px;
            }
        }
    }

</style>





























