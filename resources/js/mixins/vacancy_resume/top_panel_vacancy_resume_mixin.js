
export default {
    data() {
        return {

        }
    },
    methods: {
        // Вернет масив для BackLink (хлебных крошек)
        getGenerateBackLink(address = {}){
            let arrBackLink = []
            let url = this.urlPathname()
            // вернет масив префиксов url
            const urlPrefixes = this.getArrPrefixesUrl()
            // удалить последний елемент (текущую страницу)
            urlPrefixes.pop()

            // страница не имеет префикса языка (не имеет префикса раздела)
            if(!urlPrefixes.length){
                arrBackLink = this.getIndexPage(arrBackLink, "")
            }

            // формирую масив BackLink
            for (let index = 0; index < urlPrefixes.length; index++) {

                if(index === 0){
                    arrBackLink = this.getIndexPage(arrBackLink, urlPrefixes[index])
                }
                // основной поиск вакансий
                if(urlPrefixes[index] === "vacancy"){
                    arrBackLink.push({
                        url : url.substring(0, url.indexOf(urlPrefixes[index]) + urlPrefixes[index].length),
                        name : "Вакансии Европы"
                    })
                }
                // url связан с вакансиями
                else if(this.checkWordInUrl("vacancy")){
                    // возвращает по префексу обьект локации
                    let obj = this.checkPrefixLocation(urlPrefixes[index], address)
                    if(obj){
                        arrBackLink.push({
                            url : url.substring(0, url.indexOf(urlPrefixes[index]) + urlPrefixes[index].length),
                            name : `Работа в ${obj.translate}`
                        })
                    }
                }
                // основной поиск резюме
                else if(urlPrefixes[index] === "resume"){
                    arrBackLink.push({
                        url : url.substring(0, url.indexOf(urlPrefixes[index]) + urlPrefixes[index].length),
                        name : "Сотрудники Европы"
                    })
                }
                // url связан с resume
                else if(this.checkWordInUrl("resume")){
                    // возвращает по префексу обьект локации
                    let obj = this.checkPrefixLocation(urlPrefixes[index], address)
                    if(obj){
                        arrBackLink.push({
                            url : url.substring(0, url.indexOf(urlPrefixes[index]) + urlPrefixes[index].length),
                            name : `Сотрудники в ${obj.translate}`
                        })
                    }
                }
            }

            return arrBackLink
        },
        // Вернет строку title страницы
        getTitlePage(){
            // вернет масив префиксов url
            const urlPrefixes = this.getArrPrefixesUrl()
            urlPrefixes.reverse()

            for (let index = 0; index < urlPrefixes.length; index++) {
                // страна или город
                if(index === 0){
                    // возвращает по префексу обьект локации
                    let obj = this.checkPrefixLocation( decodeURI(urlPrefixes[index]) )
                    if(obj){
                        if(this.checkWordInUrl("vacancy")){
                            return `Работа в ${obj.translate}`
                        }
                        else{
                            return `Сотрудники в ${obj.translate}`
                        }
                        break
                    }
                }

                if(urlPrefixes[index] === "vacancy"){
                    return "Вакансии Европы"
                    break
                }
                else if(urlPrefixes[index] === "resume"){
                    return "Сотрудники Европы"
                    break
                }
            }

            return "---"
        },

        getIndexPage(arrBackLink, prefix){
            let url = this.urlPathname()
            let langArr = []
            // выбрать только префиксы стран
            this.lang.lang.forEach((item, i, arr) => {
                langArr.push(item.alias)
            });

            // это локалицация страницы (/ru, /uk)
            if(langArr.indexOf(prefix) !== -1){
                arrBackLink.push({
                    url : url.substring(0, url.indexOf(prefix) + prefix.length),
                    name : "Работа в Европе"
                })
            }
            // это локалицация страницы (/ default /en)
            else{
                arrBackLink.push({
                    url : '/',
                    name : "Работа в Европе"
                })
            }

            return arrBackLink
        },

        // возвращает по префексу обьект локации
        checkPrefixLocation(prefix, address = {}){
            let country = (this.respond['now_country'] !== undefined) ? this.respond['now_country'] :
                (address.country !== undefined) ? address.country : null
            let region = (this.respond['now_region'] !== undefined) ? this.respond['now_region'] :
                (address.region !== undefined) ? address.region : null
            let city = (this.respond['now_city'] !== undefined) ? this.respond['now_city'] :
                (address.city !== undefined) ? address.city : null

            if(country !== null){
                if(country.original_index === prefix){
                    return country
                }
            }
            if(city !== null){
                if(city.original_index === prefix){
                    return city
                }
            }
            if(region !== null){
                if(region.original_index === prefix){
                    return region
                }
            }

            return false
        },
    },
}

