export default {
    data() {
        return {}
    },
    methods: {
        urlNotQuery(){
            return window.location.protocol + '//' + window.location.hostname + window.location.pathname
        },
        urlPathname(){
            return window.location.pathname
        },
        // url для vacancy resume
        getGenerateUrlDocument(objDocument, prefix){
            let one_alias = objDocument.address.country.original_index
            let two_alias = (objDocument.address.region !== undefined) ? objDocument.address.region.original_index :
                (objDocument.address.city !== undefined) ? objDocument.address.city.original_index : ""

            return `${this.lang.prefix_lang+prefix}/${one_alias}/${two_alias}/${objDocument.alias}`
        },
        pageReload(){
            location.reload()
        },
        getGenerateBackLink(address = {}){
            let arrBackLink = []
            let url = this.urlPathname()
            let urlPrefixes = url.split('/')
            // удалить пустые елементы
            urlPrefixes = urlPrefixes.filter(function (el) {
                return (el !== "");
            });
            // удалить последний елемент (текущую страницу)
            urlPrefixes.pop()

            let langArr = []
            // выбрать только префиксы стран
            this.lang.lang.forEach((item, i, arr) => {
                langArr.push(item.alias)
            });

            // формирую масив BackLink
            for (let index = 0; index < urlPrefixes.length; index++) {
                // это локалицация страницы (/ru, /uk)
                if(index === 0 && langArr.indexOf(urlPrefixes[index]) !== -1){
                    arrBackLink.push({
                        url : url.substring(0, url.indexOf(urlPrefixes[index]) + urlPrefixes[index].length),
                        name : "Работа в Европе"
                    })
                    continue
                }
                // это локалицация страницы (/ default /en)
                else if(index === 0 && langArr.indexOf(urlPrefixes[index]) === -1){
                    arrBackLink.push({
                        url : '/',
                        name : "Работа в Европе"
                    })
                }

                // остальной адрес после локации
                if(urlPrefixes[index] === "vacancy"){
                    arrBackLink.push({
                        url : url.substring(0, url.indexOf(urlPrefixes[index]) + urlPrefixes[index].length),
                        name : "Вакансии Европы"
                    })
                }
                // url связан с вакансиями
                else if(url.indexOf("vacancy") !== -1){
                    let obj = this.checkPrefixLocation(urlPrefixes[index], address)
                    if(obj){
                        arrBackLink.push({
                            url : url.substring(0, url.indexOf(urlPrefixes[index]) + urlPrefixes[index].length),
                            name : `Работа в ${obj.translate}`
                        })
                    }
                }
            }

            console.log(arrBackLink)

            return arrBackLink
        },
        getTitlePage(){
            let url = this.urlPathname()
            let urlPrefixes = url.split('/')
            // удалить пустые елементы
            urlPrefixes = urlPrefixes.filter(function (el) {
                return (el !== "");
            });
            urlPrefixes.reverse()

            for (let index = 0; index < urlPrefixes.length; index++) {
                // страна или город
                if(index === 0){
                    let obj = this.checkPrefixLocation(urlPrefixes[index])
                    if(obj){
                        return `Работа в ${obj.translate}`
                        break
                    }
                }
                if(urlPrefixes[index] === "vacancy"){
                    return "Вакансии Европы"
                    break
                }
            }

            return "---"
        },
        // возвращает по префексу еллемент локации
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
