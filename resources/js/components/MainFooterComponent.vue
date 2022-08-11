<template>

    <div class="search-panel container footer">
        <div class="left_footer">
            Copyright &copy; {{getSiteAgeYears()}}
            <a :href="urlNotQuery()" rel="nofollow"> {{ app_name }} </a>
        </div>
        <div class="right_footer">
            <ul class="footer-ul">
                <li>
                    <a :href="`${lang.prefix_lang}cookie-police`" rel="nofollow">
                        {{ trans('cookie','cookie_policy') }}
                    </a>
                </li>
                <li>
                    <a :href="`${lang.prefix_lang}terms-use`" rel="nofollow">
                        {{ trans('cookie','terms_use') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>

    import translation from "../mixins/translation";
    import url_mixin from "../mixins/url_mixin";
    import date_mixin from "../mixins/date_mixin";

    export default {
        mixins: [
            translation,
            url_mixin,
            date_mixin
        ],
        data() {
            return {
            }
        },
        methods: {
            getSiteAgeYears(){
                let now_year = 2022
                let count = this.getDifferenceYears(2022+"-01-01 00:00:00", new Date())
                if(count > 0){
                    return now_year+"-"+(now_year+count)
                }
                return now_year
            },
        },
        props: [
            'lang',
            'app_name',
        ],
        mounted() {

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





























