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
            console.log(lang)
            if (!lang.messages[((this.lang.lang_local + '.') + path)]) {
                return lang.messages[('en.' + path)][key];
            }

            return lang.messages[((this.lang.lang_local + '.') + path)][key];
        }
    },

}
