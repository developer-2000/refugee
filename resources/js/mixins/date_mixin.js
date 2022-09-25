
var moment = require('moment');

export default {

    data() {
        return {
            moment: moment,
            nameMonth: [
                'January',
                'February',
                'Martha',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'November',
                'December'
            ],

        }
    },
    methods: {
        // отображение прошедшего времени
        getDateDocumentString(date){
            const timeDiff = this.returnTimeDifference(new Date(), date)
            let timeMessage = "";

            if(timeDiff.years() > 0){
                timeMessage = timeDiff.years()+ ` ${this.getTitleDate('years', timeDiff.days())} `
            }
            // if(timeDiff.months() > 0){
            //     timeMessage += timeDiff.years()+ " месяц "
            // }
            else if(timeDiff.days() > 0){
                timeMessage = timeDiff.days()+ ` ${this.getTitleDate('days', timeDiff.days())} `
                if(timeDiff.hours() > 0){
                    timeMessage += timeDiff.hours()+ ` ${this.getTitleDate('hours', timeDiff.hours())} `
                }
            }
            else if(timeDiff.hours() > 0){
                timeMessage = timeDiff.hours()+ ` ${this.getTitleDate('hours', timeDiff.hours())} `
                if(timeDiff.minutes() > 0){
                    timeMessage += timeDiff.minutes()+ ` ${this.getTitleDate('minutes', timeDiff.minutes())} `
                }
            }
            else if(timeDiff.minutes() > 0){
                timeMessage = timeDiff.minutes()+ ` ${this.getTitleDate('minutes', timeDiff.minutes())} `
                if(timeDiff.seconds() > 0){
                    timeMessage += timeDiff.seconds()+ ` ${this.getTitleDate('seconds', timeDiff.seconds())} `
                }
            }
            else if(timeDiff.seconds() > 0){
                timeMessage += timeDiff.seconds()+ ` ${this.getTitleDate('seconds', timeDiff.seconds())} `
            }

            // если разница прошедшего времени одинакова
            if(timeMessage === ''){
                timeMessage = '1 '+this.trans('details.date_mixin','date').second[0]
            }

            return timeMessage
        },
        // выдать название времени соответствие цифре
        getTitleDate(period, num){
            const dateObj = this.trans('details.date_mixin','date')

            let index = ''
            let obj = {
                years : [
                    [[1,21,31,41,51,61,71,81,91], dateObj.year[0]],
                    [[2,3,4,22,23,24,32,33,34,42,43,44,52,53,54,62,63,64,72,73,74,82,83,84,92,93,94], dateObj.year[1]],
                    [[5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,15,16,17,18,19,20,25,26,27,28,29,30,35,36,37,38,39,40,45,46,47,48,49,50,55,56,57,58,59,60,65,66,67,68,69,70,75,76,77,78,79,80,85,86,87,88,89,90,95,96,97,98,99,100], dateObj.year[2]],
                ],
                days : [
                    [[1,21,31], dateObj.day[0]],
                    [[2,3,4,22,23,24], dateObj.day[1]],
                    [[5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,25,26,27,28,29,30], dateObj.day[2]]
                ],
                hours : [
                    [[1,21], dateObj.hour[0]],
                    [[2,3,4,22,23], dateObj.hour[1]],
                    [[5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20], dateObj.hour[2]]
                ],
                minutes : [
                    [[1,21,31,41,51], dateObj.minute[0]],
                    [[2,3,4,22,23,24,32,33,34,42,43,44,52,53,54], dateObj.minute[1]],
                    [[5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,25,26,27,28,29,30,35,36,37,38,39,40,45,46,47,48,49,50,55,56,57,58,59], dateObj.minute[2]]
                ],
                seconds : [
                    [[1,21,31,41,51], dateObj.second[0]],
                    [[2,3,4,22,23,24,32,33,34,42,43,44,52,53,54], dateObj.second[1]],
                    [[5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,25,26,27,28,29,30,35,36,37,38,39,40,45,46,47,48,49,50,55,56,57,58,59], dateObj.second[2]]
                ]
            }

            for (let i = 0; i < obj[period].length; i++) {
                index = obj[period][i][0].indexOf(num)
                if(index !== -1){
                    return obj[period][i][1]
                }
            }
        },
        // разница во-времени
        returnTimeDifference(now, date){
            // var utc = now.getTime() + (now.getTimezoneOffset() * 60000);
            let lastTime = new Date(date)
            // разница времени
            return moment.duration(now - lastTime)
        },
        // разница в днях у 2 дат
        getDifferenceDays(last, now) {
            const last_date = new Date(last);
            const now_date = new Date(now);
            // One day in milliseconds
            const oneDay = 1000 * 60 * 60 * 24;
            // разница в миллисекундах
            const diffInTime = last_date.getTime() - now_date.getTime();
            // сколько дней
            return Math.round(diffInTime / oneDay);
        },
        // разница в годах у 2 дат
        getDifferenceYears(last, now) {
            last = new Date(last).getFullYear()
            return now.getFullYear() - last
        },
        // вывести дату в формате - 22 June 2022
        getDateString(date){
            if(date == null){
                return "~"
            }
            let str = new Date(date);
            const num_month = str.getUTCMonth()

            return str.getDate()+" "+this.trans('details.date_mixin','name_month')[num_month]+" "+str.getFullYear()
        },
    },

}

