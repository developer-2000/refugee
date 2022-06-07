export default {
    data() {
        return {
        }
    },
    methods: {
        // вырезает теги html из текста
        cutTags(text){
            let regex = /<\/?[^>]+(>|$)/gi
            return text.replace(regex, "")
        },
        // поиск значения в массиве объектов
        lookingValueInArrayObjects(property_name, property_value, arrSearch){
            let bool = false
            let response = arrSearch.find(obj => obj[property_name] == property_value)
            if(response !== undefined){
                bool = response
            }

            return bool
        },
        // открытие модалки авторизации в случае не авторизованности
        checkAuth(url) {
            // 0 = авторизация
            this.$store.commit('tpSetComponent', 0)
            $('#authModal').modal('toggle')
            localStorage.setItem('url_click_no_auth', url)
        },
        // проверка на integer
        checkingInteger(value) {
            if(parseInt(value) >= 0){
                return true;
            }
            return false;
        },
        // первый в Верхний регистр
        UpperCaseFirstCharacter(value) {
            if (typeof value !== 'string') {
                return ''
            }
            return value.charAt(0).toUpperCase() + value.slice(1)
        },
        // скопировать в буфер обмена
        copyToClipboard(el) {
            let $tmp = $("<textarea>");
            $("body").append($tmp);
            $tmp.val($(el).text()).select();
            document.execCommand("copy");
            $tmp.remove();
        },
    },
}
