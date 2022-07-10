<template>
    <div id="admin_panel">
        <!-- динамически подгружает переданный компонент -->
        <component
            v-bind:is="insertName()"
            :response="response"
        ></component>

    </div>
</template>

<script>

    import index_str from './center/Index.vue'
    import table_countries from './center/translate/TableCountries.vue'
    import table_regions from './center/translate/TableRegions.vue'

    export default {
        components: {
            'index-str': index_str,
            'table-countries': table_countries,
            'table-regions': table_regions,
        },
        data() {
            return {
                arrayCom: {
                    'index':'index-str',
                    'translate-countries':'table-countries',
                    'translate-regions':'table-regions',
                },
            }
        },
        methods: {
            insertName: function () {
                let url = location.pathname;
                if(url.indexOf('/admin-panel') !== -1){
                    url = url.slice(url.indexOf('/admin-panel')+13); // все что после
                    // передаю либо имя стартового компонента либо по url имени
                    return (url === '') ? this.arrayCom.index : this.arrayCom[(url.slice(url.indexOf('/')+1))];
                }

            }
        },
        props: [
            'response',
        ],
        mounted() {},
    }
</script>

<style scoped>




</style>


