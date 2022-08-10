<template>
<!--    <div class="search-panel container">-->
    <div class="search-panel container footer">


            <div class="left_footer">
                Copyright &copy; 2022
                <a :href="urlNotQuery()" rel="nofollow"> {{ app_name }} </a>
            </div>
            <div class="right_footer">
                <ul class="footer-ul">
                    <li>
                        <a :href="`${lang.prefix_lang}cookie-police`" rel="nofollow">Политика Cookie</a>
                    </li>
                    <li>
                        <a :href="`${lang.prefix_lang}terms_use`" rel="nofollow">Условия использования</a>
                    </li>
                </ul>

            </div>


    </div>
</template>

<script>

    import translation from "../mixins/translation";
    import url_mixin from "../mixins/url_mixin";

    export default {
        mixins: [
            translation,
            url_mixin,
        ],
        data() {
            return {
            }
        },
        methods: {
        },
        props: [
            'lang',
            'app_name',
        ],
        mounted() {
            console.log(this.app_name)
        },
    }
</script>

<style scoped lang="scss">
    @import "../../sass/variables";

    .search-panel{
        flex-direction: row;
    }
    .footer{
        display: flex;
        .left_footer{
            border-right: 1px solid #dee2e6;
            padding-right: 15px;
            line-height: 40px;
        }
        .right_footer{
            flex: 1 1 auto;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: flex-end;
            align-content: center;
            align-items: flex-start;
        }
    }

    .footer-ul{
        display: flex;
        li{
            margin-left: 20px;
        }
    }

</style>





























