<template>
    <div>

        <!-- страны работы -->
        <div v-if="checkAllSearchDocumentPage" class="box-links">
            <h2>
                {{trans('details.back_url','countries_work_in_europe')}}
            </h2>
            <ul>
                <li v-for="(country, key) in respond.obj_countries" :key="key"
                    class="flag-li"
                    :class="{'left-flag': (key+1)%2 !== 0 }"
                >
                    <a :href="`${urlNotQuery()}/${country.original_index}`" class="flag">
                        <b>{{country.translate}}</b>
                        <template v-if="checkWordInUrl('vacancy')">
                            <img :alt="`${trans('details.back_url','work_in')} ${country.translate}`" :src="`/img/flags/${country.original_index}.jpg`">
                        </template>
                        <template v-else-if="checkWordInUrl('resume')">
                            <img :alt="`${trans('details.back_url','employees_in')} ${country.translate}`" :src="`/img/flags/${country.original_index}.jpg`">
                        </template>
                    </a>
                </li>
            </ul>
        </div>

        <!-- города страны -->
        <div v-if="checkNowCountryPage" class="box-links">
            <template v-if="checkWordInUrl('vacancy')">
                <h2>{{trans('details.back_url','cities_work_in')}} {{respond.now_country.translate}}</h2>
            </template>
            <template v-else-if="checkWordInUrl('resume')">
                <h2>{{trans('details.back_url','employee_cities_in')}} {{respond.now_country.translate}}</h2>
            </template>

            <ul>
                <li v-for="(city, key) in respond.cities_country" :key="key"
                    :class="{'left-city': (key+1)%2 !== 0 }"
                >
                    <a :href="urlNotQuery()+'/'+city.original_index" class="city back-url-link">
                        <b>{{city.translate}}</b>
                    </a>
                </li>
            </ul>
        </div>

    </div>
</template>

<script>
    import localisation_functions_mixin from '../../../mixins/localisation_functions_mixin'
    import general_functions_mixin from "../../../mixins/general_functions_mixin.js";
    import translation from '../../../mixins/translation'
    import response_methods_mixin from "../../../mixins/response_methods_mixin";
    import url_mixin from "../../../mixins/url_mixin";
    import top_panel from "../../../mixins/vacancy_resume/top_panel_vacancy_resume_mixin";

    export default {
        mixins: [
            localisation_functions_mixin,
            translation,
            response_methods_mixin,
            general_functions_mixin,
            url_mixin,
        ],
        data() {
            return {
                timerId: 1,
                locationSearch: window.location.search,
                objSalary: {
                    // переключатель поиска и отмены у 2 типов - checkbox и кнопки
                    check: false,
                    // искать по checkbox - true по нему, false по цифрам
                    without_salary_checkbox: false,
                    from: 0,
                    to: 99999,
                },
                objCheckSuitable:{
                    check:false,
                    suitable_from: 18,
                    suitable_to: 60,
                },
                index_employment: null,
                experience: null,
                education: null,
                arrLanguages:[],
            }
        },
        methods: {

        },
        computed: {
            checkAllSearchDocumentPage() {
                let urlArr = this.getArrPrefixesUrl().reverse()
                if(urlArr[0] !== undefined){
                    if(urlArr[0] == 'vacancy' || urlArr[0] == 'resume'){
                        return true
                    }
                }

                return false
            },
            // проверка является ли префикс страной
            checkNowCountryPage() {
                let urlArr = this.getArrPrefixesUrl().reverse()
                if(this.respond.now_country !== null && urlArr[0] !== undefined){
                    if(this.respond.now_country.original_index === urlArr[0]){
                        return true
                    }
                }

                return false
            },
        },
        props: [
            'lang',   // масив названий и url языка
            'respond',
            'page'
        ],
        mounted() {

        },
    }
</script>

<style scoped lang="scss">
    @import "../../../../sass/variables";

    .box-links{
        margin-top: 30px;
        background-color: rgba(32, 32, 32, 0.03);
        outline: 1px solid #dee2e6;
        padding: 10px;
        h2{
            text-align: center;
            margin-bottom: 20px;
        }
        ul{
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: flex-start;
            align-content: flex-start;
            align-items: flex-start;
            max-height: 410px;
            overflow-y: scroll;
            margin-right: -10px;
            li{
                margin: 1px 0 10px 1px;
            }
            .flag-li{
                outline: 1px solid rgba(32, 32, 32, 0.03);
                &:hover{
                    outline: 1px solid #78baff;
                }
            }
            .left-flag, .left-city{
                margin-right: 14px;
            }
            .flag {
                margin: 0;
                position: relative;
                display: inline-block;
                b {
                    position: absolute;
                    bottom: 0;
                    width: 100%;
                    background: rgba(255, 255, 255, 0.8);
                    color: #444;
                    text-align: center;
                    padding: 3px 0 3px 0;
                    line-height: 17px;
                }
                img {
                    width: 115px;
                }
            }
            .left-city{

            }
            .city{
                b {
                    color: #444;
                    line-height: 17px;
                }
            }
        }
    }
    .card-header > .card-tools {
        float: none;
        margin: 0;
    }
    .box-search{
        .card-header{
            padding: 8px 13px;
            border-radius: 0;
            border: 1px solid #2176bd;
            height: 50px;
            .card-tools{
                float: none;
                margin: 0;
                height: 100%;
                button{
                    height: 100%;
                    color: #2176bd;
                    position: static;
                    padding: 0;
                    margin: 0;
                    width: 100%;
                    display: flex;
                    flex-direction: row;
                    justify-content: space-between;
                    align-content: center;
                    align-items: center;
                    i{
                        color: #2176bd;
                    }
                    &:hover i{
                        color: #165a93;
                    }
                    h3{
                        margin: 0;
                    }
                }
            }
        }
        .card-header-active{
            border: none;
            background-color: #1d68a7;
            .card-tools{
                button{
                    color: #fff;
                    i{
                        color: rgba(255,255,255,.8);
                    }
                    &:hover i{
                        color: #fff;
                    }
                }
            }
        }
    }
    #suitable,
    #salary {
        display: flex;
        align-items: center;
        input {
            width: 83px;
            margin: 0 5px;
            &:nth-child(1) {
                margin-left: 0;
            }
        }
    }
    .svg-button{
        width: 25px;
        margin-left: 10px;
    }
    .svg-button-check{
        path{
            fill: #28a745;
        }
        &:hover{
            path{
                fill: #23923c;
            }
        }
    }
    .svg-button-clear{
        path{
            fill: #dc3545;
        }
        &:hover{
            path{
                fill: #ad2733;
            }
        }
    }
    .but-reset-all{
        width: 150px;
        text-align: center;
        display: block;
        margin: -25px auto 10px;
        font-size: 19px;
        color: #3490dc;
        text-decoration: none;
        border-bottom: 1px dashed #3490dc;
        line-height: 25px;
        &:hover{
            border-bottom: 1px dashed #0268bc;
            color: #0268bc;
        }
    }
    .form-group{
        margin: 0 0 4px 0;
    }
    .card{
        width: 100%;
        border: none;
        box-shadow: none;
        margin-bottom: 3px;
        .card-body{
            padding: 10px 12px 8px;
            border-left: 1px solid #c0ddfb;
            border-right: 1px solid #c0ddfb;
            border-bottom: 1px solid #c0ddfb;
        }
    }
    .checkbox-box {
        margin: 0;
        display: flex;
        label {
            cursor: pointer;
            margin: 0 0 0 6px;
        }
    }
    .box-div{
        margin-bottom: 10px;
    }
    .salary{
        .checkbox-box{
            margin-bottom: 10px;
        }
    }
    .target-label{
        color: $color-a-blue;
        font-weight: 500!important;
    }

</style>





























