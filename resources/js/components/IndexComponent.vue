<template>
    <div class="search-panel container">
        <div class="box-title-panel">
            <h1 class="title_page">
                Лучший сайт по поиску и предоставлению работы в Европе
            </h1>

            <div class="box-flags">
                <a :href="`${lang.prefix_lang}vacancy`" class="flag">
                    <b>Найти работу</b>
                    <img alt="european flag" src="/img/custom/european flag.jpg">
                </a>
                <a :href="`${lang.prefix_lang}resume`" class="flag">
                    <b>Найти работника</b>
                    <img alt="ukrainian flag" src="/img/custom/ukrainian flag.jpg">
                </a>

            </div>

            <h2 class="title_page">
                Поиск вакансий работодателей
            </h2>

            <!-- search input line -->
            <search_title_panel
                :lang="lang"
                :respond="respond"
                :prefix="prefix_url"
            ></search_title_panel>
        </div>
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
                prefix_url: 'vacancy',
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
        .box-flags{
            text-align: center;
            margin: 25px 0;
            .flag{
                margin: 0 15px;
                position: relative;
                display: inline-block;
                /*opacity: 0.5;*/
                b{
                    position: absolute;
                    bottom: 0px;
                    width: 100%;
                    padding: 10px 0;
                    background: rgba(255 255 255 / 0.8);
                    color: #444;
                }
                img{
                    width: 200px;
                }
            }
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





























