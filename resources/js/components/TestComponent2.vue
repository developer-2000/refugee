<template>
    <div>
        <!-- компонент подгрузки логотипа -->
        <load_logo :url="this.image_url" :id="this.id" ></load_logo>
    </div>
</template>

<script>
    import load_logo from './loadLogo'

    export default {
        components: {
            'load_logo': load_logo,
        },
        data() {
            return {
                image_url: '/img/avatars/default/man.jpg',
                id: 1,
            }
        },
        methods: {

        },
        mounted() {


        },
    }
</script>

<style lang="scss" scoped>
    @import "../../sass/variables";




</style>





























