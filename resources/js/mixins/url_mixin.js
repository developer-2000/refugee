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
        // проверка существования подстроки в url
        checkWordInUrl(word){
            let url = this.urlPathname()
            if(url.indexOf(word) !== -1){
                return true
            }

            return false
        },
        // вернет масив префиксов url
        getArrPrefixesUrl(){
            let url = this.urlPathname()
            let urlPrefixes = url.split('/')
            // удалить пустые елементы
            urlPrefixes = urlPrefixes.filter(function (el) {
                return (el !== "");
            });

            return urlPrefixes
        },

    },
}
