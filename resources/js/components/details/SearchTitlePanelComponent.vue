<template>
    <div class="top-search">
        <div class="form-group">

            <div class="left-search">
                <!-- input search -->
                <div class="box-position">

                    <input type="text" class="form-control" maxlength="100" autocomplete="off"
                           :placeholder="trans('vacancies','search')"
                           v-model="position"
                           @keyup="searchPosition($event.target.value)"
                           @keydown="enterKey2"
                    >

                    <svg @click="clearSearch2" class="x-mark-clear" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256 7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256l118.2 119z"/></svg>

                    <!-- подсказка -->
                    <div class="block_position_list">
                        <div class="dropdown-menu" id="position_list">
                            <div class="dropdown-item"
                                 v-for="(value, key) in position_list" :key="key"
                                 @click="selectHelp(value)"
                            >
                                {{value}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="right-search">
                <!-- Display -->
                <div class="box-display">
                    <div @click="viewSelectCountry()" class="display-select one-select link-a">
                        {{objLocations.country_translate}}
                        <svg class="svg-caret-down" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M310.6 246.6l-127.1 128C176.4 380.9 168.2 384 160 384s-16.38-3.125-22.63-9.375l-127.1-128C.2244 237.5-2.516 223.7 2.438 211.8S19.07 192 32 192h255.1c12.94 0 24.62 7.781 29.58 19.75S319.8 237.5 310.6 246.6z"/></svg>
                    </div>
                    <div @click="viewSelectCity()" class="display-select two-select link-a">
                        {{objLocations.region_translate}}
                        <svg class="svg-caret-down" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M310.6 246.6l-127.1 128C176.4 380.9 168.2 384 160 384s-16.38-3.125-22.63-9.375l-127.1-128C.2244 237.5-2.516 223.7 2.438 211.8S19.07 192 32 192h255.1c12.94 0 24.62 7.781 29.58 19.75S319.8 237.5 310.6 246.6z"/></svg>
                    </div>
                </div>

                <div class="box-select">
                    <!-- Country -->
                    <select class="form-control select2" id="country-title-panel">
                        <option :value="null" selected class="options-default">
                            {{trans('vacancies','search_country')}}
                        </option>
                        <option v-for="(obj, key) in respond.obj_countries" :key="key"
                                :value="[obj.original_index, obj.translate]"
                        >{{obj.translate}}</option>
                    </select>

                    <!-- Region -->
                    <select class="form-control select2 region-select" id="region-title-panel">
                        <option :value="null" selected class="options-default">
                            {{trans('vacancies','search_region')}}
                        </option>
                        <option v-for="(obj, index) in respond.regions_country" :key="index"
                                :value="[obj.code_region, obj.original_index, obj.translate]"
                        >{{obj.translate}}</option>
                    </select>

                    <!-- City -->
                    <select class="form-control select2" id="city-title-panel">
                        <option :value=null selected class="options-default">
                            {{trans('vacancies','search_city')}}
                        </option>
                        <option v-for="(obj, index) in objLocations.load_cities" :key="index"
                                :value="[obj.original_index,obj.translate]"
                        >{{obj.translate}}</option>
                    </select>
                </div>

                <!-- button search -->
                <button type="button" class="btn btn-block btn-primary"
                        @click="urlReload2"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="m504.1 471-134-134c29-35.5 45-80.2 45-129 0-114.9-93.13-208-208-208S0 93.13 0 208s93.12 208 207.1 208c48.79 0 93.55-16.91 129-45.04l134 134c5.6 4.74 11.8 7.04 17.9 7.04s12.28-2.344 16.97-7.031c9.33-9.369 9.33-24.569-.87-33.969zM48 208c0-88.22 71.78-160 160-160s160 71.78 160 160-71.78 160-160 160S48 296.2 48 208z"/></svg>
                </button>
            </div>

        </div>
    </div>
</template>

<script>
    import translation from "../../mixins/translation";
    import response_methods_mixin from "../../mixins/response_methods_mixin";
    import search_input_mixin from "../../mixins/search_input_mixin";

    export default {
        mixins: [
            translation,
            response_methods_mixin,
            search_input_mixin
        ],
        data() {
            return {
                position_list: [],
                position: '',
                name_query: 'position', // ищет этот query в url
                prefix_url: '',
                clear_selection: "",
            }
        },
        methods: {
            async searchPosition(value){
                if(!value.length){
                    $('.x-mark-clear').css('display','none')
                    $('#position_list').removeClass('show')
                    return false
                }
                $('.x-mark-clear').css('display','block')
                let data = {
                    value: value,
                };
                const response = await this.$http.post(`/private-office/vacancy/search-position`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            // вернет только опубликованные
                            if(res.data.message.position.length){
                                this.position_list = res.data.message.position
                                $('#position_list').addClass('show')
                            }
                            else{
                                $('#position_list').removeClass('show')
                            }
                        }
                        // custom ошибки
                        else{

                        }
                    })
                    // ошибки сервера
                    .catch(err => {
                        // this.messageError(err)
                    })
            },
            initializeData(){
                // выбрать из url поиск
                const params = new URLSearchParams(window.location.search)
                if(params.has('position')){
                    this.position = params.get('position')
                }

                // закрытие подсказки
                let menuBtn = $("#position_list")
                $(document).click((e) => {
                    if (!menuBtn.is(e.target)) {
                        menuBtn.removeClass('show')
                    }
                })

                this.clear_selection = this.trans('vacancies','clear_selection')
            }
        },
        props: [
            'lang',
            'respond',
            'prefix',
        ],
        created: function(){
            this.prefix_url = this.prefix
        },
        mounted() {
            this.initializeData();
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .top-search{
        .box-display{
            display: flex;
            border-top: 1px solid #ced4da;
            z-index: 1;
            background: white;
            border-bottom: 1px solid #ced4da;
            .display-select{
                display: flex;
                flex-direction: row;
                flex-wrap: nowrap;
                justify-content: flex-start;
                align-content: flex-start;
                align-items: center;
                height: 36px;
                padding: 0 15px 0 0;
                cursor: pointer;
                white-space: nowrap;
                .svg-caret-down{
                    width: 7px;
                    fill: #3490dc;
                    margin-left: 8px;
                }
            }
            .one-select, .two-select{
                display: none;
            }
            .one-select{
                padding-left: 5px;
            }
        }
        .form-group{
            display: flex;
            margin: 0;
            .left-search{
                width: 100%;
            }
            .right-search{
                /*width: 50%;*/
                display: flex;
            }
            .box-position{
                width: 100%;
                position: relative;
                input{
                    border-radius: 4px 0 0 4px;
                    font-size: 18px;
                    height: 38px;
                    padding-right: 44px;
                    border-left: 1px solid #ced4da;
                    border-top: 1px solid #ced4da;
                    border-bottom: 1px solid #ced4da;
                    border-right: none;
                }
                .x-mark-clear{
                    position: absolute;
                    top: 1px;
                    right: 0px;
                    fill: #ff4747;
                    width: 45px;
                    padding: 6px 15px 6px 15px;
                    cursor: pointer;
                    display: none;
                    &:hover{
                        fill: #f72e2e;
                    }
                }
            }
            .region-select{
                border-radius: 0;
                margin: 0 5px 0 0;
                /*width: 186px;*/
                border: 1px solid #ced4da;
                &:focus{
                    box-shadow: none;
                }
            }
            button{
                border-radius: 0 4px 4px 0;
                min-width: 75px;
                max-width: 75px;
                font-size: 18px;
                height: 38px;
                line-height: 0;
            }
        }
        .block_position_list{
            position: relative;
            #position_list{
                width: 100%;
                padding: 0;
                cursor: pointer;
                top: -3px;
                & > div{
                    padding: 1px 12px;
                }
            }
        }
    }

    @media (max-width: 568px) {
        .form-group{
            flex-direction: column;
            .box-select{
                width: 100%;
            }
        }
        .top-search .form-group .box-position input{
            border-right: 1px solid #ced4da;
            border-radius: 4px;
            margin-bottom: 10px;
        }
    }

</style>





























