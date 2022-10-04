export default {
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
        addressView(obj){
            let address_string = ''

            address_string += obj.address.country.translate+'.'

            if(obj.address.region !== undefined && obj.address.region !== null){
                address_string += ' ' + obj.address.region.translate+'.'
            }
            if(obj.address.city !== undefined){
                address_string += ' ' + obj.address.city.translate+'.'
            }
            if(obj.rest_address !== undefined){
                address_string += ' ' + obj.rest_address+'.'
            }

            return address_string
        },
        viewStatus(job_posting){
            let html_status = '<div class="mode standard">'
            let count_day = this.getStatusInDay(job_posting)

            // hidden
            if(count_day <= 0){
                html_status += this.settings.job_status[1]
                html_status += '</div> <div class="balance-mode">'
                html_status += "&nbsp;0 "+this.getTitleDate('days', 0)
            }
            // standard
            else{
                html_status += this.settings.job_status[0]
                html_status += '</div> <div class="balance-mode standard">'
                html_status += '~ '+count_day+` ${this.getTitleDate('days', count_day)} `
            }

            html_status += '</div>'

            return html_status
        },
        // вернет разницу в днях статуса документа
        getStatusInDay(job_posting){
            // прибавить к дате публикации дни жизни
            let create_date = new Date(job_posting.create_time)
            create_date.setDate(create_date.getDate() +  + this.settings.lifetime_days_job_status['standard']);

            // сколько осталось дней у публикации
            return this.getDifferenceDays(create_date, Date.now())
        },
        countRespond(statistic){
            if(statistic !== null){
                return statistic['respond']
            }
            return 0
        },
    },
    mounted() {

    },
}
