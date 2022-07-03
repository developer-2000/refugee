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

            if(obj.country !== null){
                address_string += obj.country.alias+'.'
            }
            if(obj.region !== null){
                address_string += ' ' + obj.region.alias+'.'
            }
            if(obj.city !== null){
                address_string += ' ' + obj.city.alias+'.'
            }

            if(obj.rest_address !== undefined){
                address_string += ' ' + obj.rest_address+'.'
            }

            return address_string
        },
        // статус и дни
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
    },
    mounted() {

    },
}
