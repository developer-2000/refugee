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
        // вырезать &nbsp;
        cutNbsp(text){
            return text.replace(/&nbsp;/gi,"")
        },
        // убрать пробелы
        cutSpaces(text){
            return text.replace(/\s+/g,'')
        },
        // пробелы на подчеркивание и нижний регистор
        spacesUnderscoresLowercase(text){
            return text.replace(/\s/g, '_').toLowerCase()
        },
        // поиск значения в массиве объектов и возврат обьекта
        lookingValueInArrayObjects(property_name, property_value, arrSearch){
            let bool = false
            let response = arrSearch.find(obj => obj[property_name] == property_value)
            if(response !== undefined){
                bool = response
            }

            return bool
        },
        // поиск значения в массиве объектов и возврат index обьекта
        lookingValueInArrayObjectsReturnIndex(property_name, property_value, arrSearch){
            return  arrSearch.findIndex(obj => obj[property_name] == property_value)
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
            value = value.toLowerCase();
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
        // выбор имени компонента для динамик компонента
        reset_array(a) {
            // чилдрен присылает значение выбора компонента в масиве в виде обьекта
            this.$store.commit('tpSetComponent', (typeof a == 'object') ? a.num : a)
            // open/close modal
            if (typeof a !== 'object' && a !== 3) {
                this.$store.commit('tpSetMenuVisi')
            }
        },
        // строка в масив через разделитель
        convertStringToArray(text, once) {
            return text.split(once)
        },
        // вернет глобальные координаты елемента
        getCoords(elem) {
            // (1)
            var box = elem.getBoundingClientRect();

            var body = document.body;
            var docEl = document.documentElement;

            // (2)
            var scrollTop = window.pageYOffset || docEl.scrollTop || body.scrollTop;
            var scrollLeft = window.pageXOffset || docEl.scrollLeft || body.scrollLeft;

            // (3)
            var clientTop = docEl.clientTop || body.clientTop || 0;
            var clientLeft = docEl.clientLeft || body.clientLeft || 0;

            // (4)
            var top = box.top + scrollTop - clientTop;
            var left = box.left + scrollLeft - clientLeft;

            return {
                top: top,
                left: left
            }
        },
    },
}
