var Lang = require('lang.js');
import translations from '../vue-translations.js';
var lang = new Lang();
lang.setMessages(translations);

export default {
    data() {
        return {}
    },
    methods: {
        trans: function (path, key) {
            // console.log('tyt')

            // если нет этого языка файла перевода - покажи en строку
            if (!lang.messages[((this.lang.lang_local + '.') + path)]) {
                return lang.messages[('en.' + path)][key];
            }

            return lang.messages[((this.lang.lang_local + '.') + path)][key];
        }
    },

}
