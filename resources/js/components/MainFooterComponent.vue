<template>

    <div class="container footer">
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-12 left_footer">
                Copyright &copy; {{getSiteAgeYears()}}
                <a :href="urlNotQuery()" rel="nofollow"> {{ app_name }} </a>
            </div>
            <div class="col-xl-9 col-lg-8 col-md-12 right_footer">
                <ul class="footer-ul">
                    <li>
                        <a :href="`${lang.prefix_lang}feedback`" rel="nofollow">
                            {{trans('pages.feedback','feedback')}}
                        </a>
                    </li>
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
                let count = this.getDifferenceYears(now_year+"-01-01 00:00:00", new Date())
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

    .footer{
        background-color: #fff;
        width: 100%;
        padding: 0;

        .left_footer{
            border-right: 1px solid #dee2e6;
            padding-right: 15px;
            line-height: 40px;
        }
        .right_footer{
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: flex-end;
            align-content: flex-start;
            align-items: center;
        }
    }

    .footer-ul{
        display: flex;
        li{
            margin-left: 20px;
        }
    }

    @media (max-width: 992px) {
        .footer{
            .left_footer{
                border: none;
                text-align: center;
            }
            .right_footer{
                justify-content: center;
            }
        }
    }
    @media (max-width: 768px){
        .footer{
            padding: 10px 0;
            .right_footer{
                ul{
                    flex-direction: column;
                    align-items: center;
                }
            }
        }
        .footer-ul li {
            margin: 5px 0;
        }
    }

</style>





























