
export default {
    data() {
        return {
            last_target: null,
            country: null,
            input_box: '',
            div_change: '',
            objChangeElement: {
                value: '',
                country: '',
                row: '',
                old_property: '',
                old_value: '',
            }
        }
    },
    methods: {
        // показ input
        insertField(prefix, value, country, row, old=''){
            this.div_change = 'div-'+prefix
            this.objChangeElement.country = country
            this.objChangeElement.row = row
            this.objChangeElement.old_property = (row === 'property') ? old : ''
            this.objChangeElement.old_value = (row === 'translate') ? old : ''

            $('#'+this.div_change).css({'display':'none'});
            $('#td-'+prefix).append(this.input_box.clone());
            $('.input-change').val(value);
        },
        // выборка страны - сортировка
        selectCountry(event, url){
            let params = new URLSearchParams(window.location.search)
            params.delete('country')
            params.delete('page')

            if(event.target.value){
                params.set('country', event.target.value.toString())
            }
            params.sort()
            let query = (params.toString() == '') ? '' : '?'+params.toString()

            location.href = url+query
        },
        // переход по клику на button языка
        transitionToLanguage(url, prefix){
            let params = new URLSearchParams(window.location.search)
            params.delete('language')

            params.set('language', prefix)
            params.sort()
            let query = (params.toString() == '') ? '' : '?'+params.toString()

            location.href = url+query
        },
        // paginate
        urlReload(obj){
            let params = new URLSearchParams(window.location.search)
            params.delete('page')
            // page
            if(obj.page != undefined && obj.page != null){
                params.set('page',obj.page)
            }
            params.sort()
            let query = (params.toString() == '') ? '' : '?'+params.toString()
            let full_url = window.location.protocol + '//' + window.location.hostname + window.location.pathname+query
            location.href = full_url
        },
        clickChangeButton(){
            $( "body" ).on( "click", ".button-change", (e) => {
                $('#'+this.div_change).css({'display':'block'});
                this.objChangeElement.value = $('.input-change').val()
                $('.box-change-value').remove();
                this.updateDb();
            });
        },
        // после обновления страницы
        setValuesFields(){
            const params = new URLSearchParams(window.location.search)
            if(params.has('country')){
                this.country = params.get('country')
            }
        },
        // скопировать в буфер обмена
        copyText(e, prefix) {
            let elem = $(e.target);
            // show insert svg
            elem.siblings('.svg-insert').addClass('visible-svg')
            elem.addClass('svg-target')
            if(this.last_target !== null){
                this.last_target.removeClass('svg-target')
            }
            this.last_target = elem

            let $tmp = $("<textarea>");
            $("body").append($tmp);
            // copy text
            let text = elem.siblings('span').text()
            $tmp.val(text).select();
            // $tmp.val(text+" страна "+prefix).select();
            document.execCommand("copy");
            $tmp.remove();
        },
    },

}

