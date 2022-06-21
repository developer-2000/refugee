<template>
    <div class="box-page">
        <!-- обратная ссылка -->
        <div class="top-panel bread-top-cabinet">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="m166.5 424.5-143.1-152a23.94 23.94 0 0 1-6.562-16.5 23.94 23.94 0 0 1 6.562-16.5l143.1-152c9.125-9.625 24.31-10.03 33.93-.938 9.688 9.126 10.03 24.38.938 33.94l-128.4 135.5 128.4 135.5c9.094 9.562 8.75 24.75-.938 33.94-9.53 9.058-24.73 8.658-33.93-.942z"/></svg>
            <a :href="`${lang.prefix_lang}private-office`">
                {{trans('menu.menu','cabinet')}}
            </a>
            <span class="bread-slash"> | </span>
        </div>
        <!-- title -->
        <h1 class="title_page card-body">
            {{trans('company','create_your_company')}}
        </h1>

        <div class="bottom-search">

                <!-- document -->
                <div class="box-vacancy"
                     v-for="(offer, key) in offers" :key="key"
                     :id="`v${key}`"
                >

fgh


                </div>


        </div>
    </div>
</template>

<script>
    import translation from "../../mixins/translation";

    export default {
        mixins: [
            translation,
        ],
        components: {
        },
        data() {
            return {
            }
        },
        methods: {
        },
        computed: {
        },
        props: [
            'lang',
            'offers',
        ],
        mounted() {

        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";


</style>





























