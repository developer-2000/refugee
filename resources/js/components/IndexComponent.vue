<template>
    <div class="search-panel container">
        <h1 class="title_page">
            {{trans('vacancies','job_search')}}
        </h1>

        <!-- search input line -->
        <search_title_panel
            :lang="lang"
            :respond="respond"
        ></search_title_panel>


    </div>
</template>

<script>

    import search_title_panel from './details/SearchTitlePanelComponent'
    import translation from "../mixins/translation";

    export default {
        components: {
            'search_title_panel': search_title_panel,
        },
        mixins: [
            translation,
        ],
        data() {
            return {
            }
        },
        methods: {
        },
        props: [
            'lang',
            'respond',
        ],
        mounted() {

        },
    }
</script>

<style scoped lang="scss">
    @import "../../sass/variables";

    .search-panel{
        display: flex;
        flex-direction: column;
        background-color: #fff;
        width: 100%;
        padding: 0;
        .title_page {
            padding: 15px;
        }

        .bottom-search{
            display: flex;
            padding: 30px 15px 0;
            .left-site{
                min-width: 77%;
                .box-vacancy{
                    margin-right: 15px;
                    .box-title-logo{
                        display: flex;
                        justify-content: space-between;
                        .title-vacancy{
                            margin: 5px 0 10px;
                            padding: 0;
                            line-height: 25px;
                            height: 25px;
                            font-size: 26px;
                        }
                        .img-logo{
                            width: 100px;
                        }
                    }
                    .line-div{
                        display: flex;
                        margin-bottom: 5px;
                        .font-weight-bold{
                            font-weight: bold;
                        }
                    }
                    .address-comment{
                        display: flex;
                        align-items: center;
                        svg{
                            width: 7px;
                            margin: 0 5px;
                        }
                    }

                }
            }
            .right-site{
                min-width: 23%;
            }
        }
    }

</style>





























