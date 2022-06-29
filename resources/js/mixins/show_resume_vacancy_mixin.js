export default {
    data() {
        return {

        }
    },
    methods: {
        cancelRespond(){
            this.respond_bool = false
            this.scrollUp()
        },
        scrollUp(){
            $('html, body').animate({scrollTop: 0},500);
        },
        goToDialog(offer){
            if(offer !== null){
                location.href = this.lang.prefix_lang+'offers/'+offer.alias
            }
        },
        // выбор имени компонента для динамик компонента
        reset_array: function (a) {
            // чилдрен присылает значение выбора компонента в масиве в виде обьекта
            this.$store.commit('tpSetComponent', (typeof a == 'object') ? a.num : a)
            // open/close modal
            if (typeof a !== 'object' && a !== 3) {
                this.$store.commit('tpSetMenuVisi')
            }
        },
        checkAuth(url) {
            // не авторизован
            if(this.user == null){
                this.reset_array(0)
                $('#authModal').modal('toggle')
                localStorage.setItem('url_click_no_auth', url)
                return false
            }
            return true
        },
        // скрол винз к respond
        scrollRespond(){
            if(this.checkAuth(window.location.pathname)){
                this.respond_bool = true
                setTimeout(() => {
                    const el = document.getElementById('box-respond');
                    $('html,body').animate({
                        scrollTop:$(el).offset().top+"px"
                    }, 500, 'linear');
                }, 500);
            }
        },
    },
    mounted() {

    },
}
