<template>
    <div class="forms">
        <h1 class="title_page card-body">{{trans('vacancies','my_vacancies')}}</h1>

        <div class="box-vacancy"
             v-for="(objVacancy, key) in user_data.vacancies" :key="key"
        >
            <!-- left -->
            <div class="left-site">
                <div class="box-title">
                    <a href="#" class="title-vacancy">
                        {{objVacancy.position.title}}
                    </a>
                    <div class="no-verified"
                         v-if="!objVacancy.published"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M150.7 92.77C195 58.27 251.8 32 320 32C400.8 32 465.5 68.84 512.6 112.6C559.4 156 590.7 207.1 605.5 243.7C608.8 251.6 608.8 260.4 605.5 268.3C592.1 300.6 565.2 346.1 525.6 386.7L630.8 469.1C641.2 477.3 643.1 492.4 634.9 502.8C626.7 513.2 611.6 515.1 601.2 506.9L9.196 42.89C-1.236 34.71-3.065 19.63 5.112 9.196C13.29-1.236 28.37-3.065 38.81 5.112L150.7 92.77zM223.1 149.5L313.4 220.3C317.6 211.8 320 202.2 320 191.1C320 180.5 316.1 169.7 311.6 160.4C314.4 160.1 317.2 159.1 320 159.1C373 159.1 416 202.1 416 255.1C416 269.7 413.1 282.7 407.1 294.5L446.6 324.7C457.7 304.3 464 280.9 464 255.1C464 176.5 399.5 111.1 320 111.1C282.7 111.1 248.6 126.2 223.1 149.5zM320 480C239.2 480 174.5 443.2 127.4 399.4C80.62 355.1 49.34 304 34.46 268.3C31.18 260.4 31.18 251.6 34.46 243.7C44 220.8 60.29 191.2 83.09 161.5L177.4 235.8C176.5 242.4 176 249.1 176 255.1C176 335.5 240.5 400 320 400C338.7 400 356.6 396.4 373 389.9L446.2 447.5C409.9 467.1 367.8 480 320 480H320z"/></svg>
                        {{trans('vacancies','pending')}}
                    </div>
                    <div class="verified" v-else>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M279.6 160.4C282.4 160.1 285.2 160 288 160C341 160 384 202.1 384 256C384 309 341 352 288 352C234.1 352 192 309 192 256C192 253.2 192.1 250.4 192.4 247.6C201.7 252.1 212.5 256 224 256C259.3 256 288 227.3 288 192C288 180.5 284.1 169.7 279.6 160.4zM480.6 112.6C527.4 156 558.7 207.1 573.5 243.7C576.8 251.6 576.8 260.4 573.5 268.3C558.7 304 527.4 355.1 480.6 399.4C433.5 443.2 368.8 480 288 480C207.2 480 142.5 443.2 95.42 399.4C48.62 355.1 17.34 304 2.461 268.3C-.8205 260.4-.8205 251.6 2.461 243.7C17.34 207.1 48.62 156 95.42 112.6C142.5 68.84 207.2 32 288 32C368.8 32 433.5 68.84 480.6 112.6V112.6zM288 112C208.5 112 144 176.5 144 256C144 335.5 208.5 400 288 400C367.5 400 432 335.5 432 256C432 176.5 367.5 112 288 112z"/></svg>
                    </div>
                </div>

                <div class="salary-vacancy">
                    <div class="salary">
                        {{salaryView(objVacancy.salary)}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M64 240C46.33 240 32 225.7 32 208C32 190.3 46.33 176 64 176H92.29C121.9 92.11 201.1 32 296 32H320C337.7 32 352 46.33 352 64C352 81.67 337.7 96 320 96H296C238.1 96 187.8 128.4 162.1 176H288C305.7 176 320 190.3 320 208C320 225.7 305.7 240 288 240H144.2C144.1 242.6 144 245.3 144 248V264C144 266.7 144.1 269.4 144.2 272H288C305.7 272 320 286.3 320 304C320 321.7 305.7 336 288 336H162.1C187.8 383.6 238.1 416 296 416H320C337.7 416 352 430.3 352 448C352 465.7 337.7 480 320 480H296C201.1 480 121.9 419.9 92.29 336H64C46.33 336 32 321.7 32 304C32 286.3 46.33 272 64 272H80.15C80.05 269.3 80 266.7 80 264V248C80 245.3 80.05 242.7 80.15 240H64z"/></svg>
                    </div>
                    <div class="description-salary"
                         v-if="objVacancy.salary.comment !== null"
                    >
                        ({{objVacancy.salary.comment}})
                    </div>
                </div>
                <!-- адрес -->
                <div class="address-vacancy">
                    {{addressView(objVacancy)}}
                </div>
                <!-- статус -->
                <div class="mode-vacancy"
                     v-html="getStatus(objVacancy.job_posting)"
                >
                </div>
            </div>
            <!-- right -->
            <div class="right-site">
                <!-- отклики -->
                <div class="response-vacancy">
                    <a href="#">
                        <div class="response-num">0</div>
                        {{trans('vacancies','responses')}}
                    </a>
                </div>
                <!-- button -->
                <div class="button-vacancy">
                    <!-- hidden to standard -->
                    <button type="button" class="btn btn-block btn-outline-primary"
                            v-if="objVacancy.job_posting.status_name == 'hidden'"
                            @click="changeStatus(objVacancy.id, 0)"
                    >
                        {{trans('vacancies','post')}}
                    </button>
                    <div class="btn-group dropleft">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{trans('vacancies','functions')}}
                        </button>
                        <div class="dropdown-menu">
                            <!-- скрыть -->
                            <a class="dropdown-item" href="#"
                               v-if="objVacancy.job_posting.status_name == 'standard'"
                               @click="changeStatus(objVacancy.id, 1)"
                            >
                                {{trans('vacancies','hide')}}
                            </a>
                            <!-- обновить -->
                            <a class="dropdown-item" href="#"
                               v-if="objVacancy.job_posting.status_name == 'standard'"
                               @click="changeStatus(objVacancy.id, 0)"
                            >
                                {{trans('vacancies','update')}}
                            </a>
                            <!-- редактировать -->
                            <a class="dropdown-item"
                               :href="`${lang.prefix_lang}vacancy/${objVacancy.id}/edit`"
                            >
                                {{trans('vacancies','edit')}}
                            </a>
                            <a class="dropdown-item" href="#"
                               @click="duplicateVacancy(objVacancy.id)"
                            >
                                {{trans('vacancies','copy')}}
                            </a>
                            <a class="dropdown-item" href="#"
                               @click="deleteVacancy(objVacancy.id)"
                            >
                                {{trans('vacancies','delete')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import translation from '../../mixins/translation'
    import response_methods_mixin from "../../mixins/response_methods_mixin";

    export default {
        mixins: [
            translation,
            response_methods_mixin,
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
                    address_string += vacancyObj.country.name
                }
                if(vacancyObj.region !== null){
                    address_string += ' ' + vacancyObj.region.name
                }
                if(vacancyObj.city !== null){
                    address_string += ' ' + vacancyObj.city.name
                }

                address_string += ' ' + vacancyObj.rest_address

                return address_string
            },
            // разница в днях
            getNumberOfDays(start, end) {
                const date1 = new Date(start);
                const date2 = new Date(end);
                // One day in milliseconds
                const oneDay = 1000 * 60 * 60 * 24;
                // Calculating the time difference between two dates
                const diffInTime = date1.getTime() - date2.getTime();
                // Calculating the no. of days between two dates
                const diffInDays = Math.round(diffInTime / oneDay);

                return diffInDays;
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
                    let count_day = this.getNumberOfDays(create_date, Date.now())

                    html_status += '<div class="balance-mode standard">'
                    html_status += '~ '+count_day+' дней'
                }

                html_status += '</div>'

                return html_status
            },
            async changeStatus(id, index){
                let data = {
                    id: id,
                    index: index
                };
                const response = await this.$http.post(`/vacancy/up-vacancy-status`, data)
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
            async duplicateVacancy(id){
                let data = {
                    id: id,
                };
                const response = await this.$http.post(`/vacancy/duplicate-vacancy`, data)
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
            async deleteVacancy(id){
                const response = await this.$http.destroy(`/vacancy/` + id, {})
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
            }
        },
        props: [
            'lang',   // масив названий и url языка
            'settings',
            'user_data',
        ],
        mounted() {
            // console.log(this.user_data)
            // console.log(this.settings)
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

.box-vacancy{
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    justify-content: space-between;
    align-content: flex-start;
    align-items: flex-start;
    border-bottom: 1px solid $border-style-grey;
    color: #666;
    line-height: 30px;
    padding: 15px 0px;
    .box-title{
        display: flex;
        & > div{
            margin-left: 10px;
            svg{
                width:16px;
            }
        }
    }
    .no-verified{
        color: $orange;
        svg{
            fill:$orange;
        }
    }
    .verified{
        color: $green;
        svg{
            fill:$green;
        }
    }
    .salary-vacancy{
        display: flex;
        .salary{
            color: $black;
            margin-right: 4px;
            white-space: nowrap;
            svg{
                width:12px;
                margin-bottom: 2px;
                path{
                    fill: $euro-color-blue;
                }
            }
        }
    }
    .right-site{
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-self: stretch;
        align-items: flex-end;
        .response-vacancy{
            text-align: center;
            font-weight: 600;
            line-height: 22px;
            margin-right: 5px;
        }
        .button-vacancy{
            display: flex;
            & > button{
                margin-right: 10px;
            }
        }
    }
}
</style>





























