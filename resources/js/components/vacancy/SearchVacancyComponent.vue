<template>
    <div class="search-panel">
        <div class="left-site">
            <search_panel
                :settings="settings"
                @returnParent="updateData"
            ></search_panel>
        </div>

        <div class="right-site">

        </div>
    </div>
</template>

<script>
    import search_panel from './SearchPanelVacancyComponent.vue'

    export default {
        components: {
            'search_panel': search_panel,
        },
        mixins: [
        ],
        data() {
            return {
            }
        },
        methods: {
            updateData(data){
                console.log(data)
            }
        },
        props: [
            'settings',
        ],
        mounted() {
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .search-panel{
        display: flex;
        padding-top: 20px;

        .left-site{
            width: 25%;
        }
        .right-site{
            width: 75%;
        }
    }

</style>





























