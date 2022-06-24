
export default {
    data() {
        return {

        }
    },
    methods: {
        urlReload(obj){
            let params = new URLSearchParams(window.location.search)
            params.delete('page')
            // page
            if(obj.page != undefined && obj.page != null){
                params.set('page',obj.page)
            }
            // search
            if(this.position == ''){
                params.delete(this.name_query)
            }
            else{
                params.set(this.name_query,this.position)
            }
            params.sort()
            let query = (params.toString() == '') ? '' : '?'+params.toString()
            location.href = this.lang.prefix_lang+this.name_url+query
        },
        clearSearch(){
            let params = new URLSearchParams(window.location.search)
            this.position = ''
            this.position_list = []
            $('.dropdown-menu').removeClass('show')
            if(params.has(this.name_query)){
                this.urlReload({})
            }
            $('.x-mark-clear').css('display','none')
        },
        enterKey(e){
            if(e.code == 'Enter'){
                this.urlReload({})
            }
        },
        setValuePosition(value){
            $('#position_list').removeClass('show')
            this.position = value
        },
    },
    mounted() {
        const params = new URLSearchParams(window.location.search)
        if(params.has(this.name_query)){
            this.position = params.get(this.name_query)
            $('.x-mark-clear').css('display','block')
        }
    },
}

