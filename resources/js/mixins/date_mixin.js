var moment = require('moment');

export default {
    data() {
        return {
            moment: moment,
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
                timeMessage = '1 секунда'
            }

            return timeMessage
        },
        // выдать название времени соответствие цифре
        getTitleDate(period, num){
            let index = ''
            let obj = {
                years : [
                    [[1,21,31,41,51,61,71,81,91], 'год'],
                    [[2,3,4,22,23,24,32,33,34,42,43,44,52,53,54,62,63,64,72,73,74,82,83,84,92,93,94], 'года'],
                    [[5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,15,16,17,18,19,20,25,26,27,28,29,30,35,36,37,38,39,40,45,46,47,48,49,50,55,56,57,58,59,60,65,66,67,68,69,70,75,76,77,78,79,80,85,86,87,88,89,90,95,96,97,98,99,100], 'лет'],
                ],
                days : [
                    [[1,21,31], 'день'],
                    [[2,3,4,22,23,24], 'дня'],
                    [[5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,25,26,27,28,29,30], 'дней']
                ],
                hours : [
                    [[1,21], 'час'],
                    [[2,3,4,22,23], 'часа'],
                    [[5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20], 'часов']
                ],
                minutes : [
                    [[1,21,31,41,51], 'минута'],
                    [[2,3,4,22,23,24,32,33,34,42,43,44,52,53,54], 'минуты'],
                    [[5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,25,26,27,28,29,30,35,36,37,38,39,40,45,46,47,48,49,50,55,56,57,58,59], 'минут']
                ],
                seconds : [
                    [[1,21,31,41,51], 'секунда'],
                    [[2,3,4,22,23,24,32,33,34,42,43,44,52,53,54], 'секунды'],
                    [[5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,25,26,27,28,29,30,35,36,37,38,39,40,45,46,47,48,49,50,55,56,57,58,59], 'секунд']
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
    },

}

