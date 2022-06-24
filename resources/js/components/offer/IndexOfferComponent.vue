<template>
    <div class="box-page">

        <div class="top-panel bread-top-cabinet">
            <!-- обратная ссылка -->
            <div class="box-back-link">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="m166.5 424.5-143.1-152a23.94 23.94 0 0 1-6.562-16.5 23.94 23.94 0 0 1 6.562-16.5l143.1-152c9.125-9.625 24.31-10.03 33.93-.938 9.688 9.126 10.03 24.38.938 33.94l-128.4 135.5 128.4 135.5c9.094 9.562 8.75 24.75-.938 33.94-9.53 9.058-24.73 8.658-33.93-.942z"/></svg>
                <a :href="`${lang.prefix_lang}`">
                    {{trans('menu.menu','index')}}
                </a>
                <span class="bread-slash"> | </span>
                <a :href="`${lang.prefix_lang}private-office`">
                    {{trans('menu.menu','cabinet')}}
                </a>
            </div>

            <!-- search line -->
            <div class="top-search">
                <div class="form-group">
                    <div class="box-position">

                        <input type="text" class="form-control" maxlength="100" autocomplete="off"
                               v-model="position"
                               @keyup="searchNamePosition($event.target.value)"
                               @keydown="enterKey"
                               placeholder="имя, должность"
                        >

                        <svg @click="clearSearch"
                             class="x-mark-clear" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256 7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256l118.2 119z"/></svg>

                        <!-- подсказка -->
                        <div class="block_position_list">
                            <div class="dropdown-menu" id="position_list">
                                <div class="dropdown-item"
                                     v-for="(value, key) in position_list" :key="key"
                                     @click="setValuePosition(value)"
                                >
                                    {{value}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-block btn-primary"
                            @click="urlReload"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="m504.1 471-134-134c29-35.5 45-80.2 45-129 0-114.9-93.13-208-208-208S0 93.13 0 208s93.12 208 207.1 208c48.79 0 93.55-16.91 129-45.04l134 134c5.6 4.74 11.8 7.04 17.9 7.04s12.28-2.344 16.97-7.031c9.33-9.369 9.33-24.569-.87-33.969zM48 208c0-88.22 71.78-160 160-160s160 71.78 160 160-71.78 160-160 160S48 296.2 48 208z"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="search-panel">
            <!-- title -->
            <h1 class="title_page card-body">
                Предложения
            </h1>
        </div>

        <div class="bottom-search">

                <!-- document -->
                <div class="row box-vacancy"
                     :class="{'new-vacancy': (offer.one_user_id === user.id && offer.one_user_review === 0) || (offer.two_user_id === user.id && offer.two_user_review === 0)}"
                     v-for="(offer, key) in offers" :key="key"
                     :id="`v${key}`"
                >

                    <!-- user -->
                    <div class="col-sm-4">
                        <!-- Контакт лист -->
                        <offer_contact_list
                            :offer="offer"
                            :settings="settings"
                            :user="user"
                            :lang="lang"
                            :page="'offers'"
                        ></offer_contact_list>
                    </div>

                    <!-- text -->
                    <div class="col-sm-8">
                        <div class="body-chat" v-html="textOutput(offer.chat)"></div>
                    </div>

                </div>

        </div>
    </div>
</template>

<script>
    import translation from "../../mixins/translation";
    import offer_contact_list from "../details/OfferContactListComponent";
    import response_methods_mixin from "../../mixins/response_methods_mixin";
    import search_input_mixin from "../../mixins/search_input_mixin";

    export default {
        mixins: [
            translation,
            response_methods_mixin,
            search_input_mixin
        ],
        components: {
            'offer_contact_list': offer_contact_list
        },
        data() {
            return {
                length_string: 250,
                position: '',
                position_list: [],
                name_query: 'search',
                name_url: 'offers',
            }
        },
        methods: {
            // поиск похожих заголовков
            async searchNamePosition(value){
                if(!value.length){
                    $('.x-mark-clear').css('display','none')
                    $('#position_list').removeClass('show')
                    return false
                }
                $('.x-mark-clear').css('display','block')
                let data = {
                    value: value,
                };
                const response = await this.$http.post(`/offers/search-name-position`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            // вернет только опубликованные
                            if(res.data.message.arraySearch.length){
                                this.position_list = res.data.message.arraySearch
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
            textOutput(chat) {
                let string = ""
                let title_chat = chat[0].title_chat
                chat = chat[chat.length-1]
                let regex = /( |<([^>]+)>)/ig

                // title chat
                string += "<div class='font-weight-bold title-chat'>"+title_chat+"</div>"

                // сообщение о документе
                if(chat.type_document !== null){
                    if(chat.user_id !== this.user.id){
                        string += "<div class='offer-document'>Предложение рассмотреть "+chat.type_document+"</div>"
                    }
                    else if(chat.user_id === this.user.id){
                        string += "<div class='offer-document'>Вы: предложили к рассмотрению "+chat.type_document+"</div>"
                    }
                }

                // текст чата
                if(chat.covering_letter !== null){
                    // html и длина
                    let line = chat.covering_letter.replace(regex, " ")
                    if(line.length > this.length_string) {
                        line = line.substring(0,this.length_string)+" ...";
                    }

                    // text чата
                    if(chat.user_id !== this.user.id){
                        string += "<div class='text-chat'>"+line+"</div>";
                    }
                    else if(chat.user_id === this.user.id){
                        string += "<div class='text-chat'> <span class='font-weight-bold'>Вы:</span> "+line+"</div>";
                    }
                }

                return string
                // console.log(chat)
            },
        },
        props: [
            'user',
            'lang',
            'offers',
            'settings',
        ],
        mounted() {
            // console.log(this.user)
            // console.log(this.offers)

        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .top-search {
        width: 75%;
        background-color: #fff;
        button svg{
            width: 20px;
            path{
                fill: white;
            }
        }
        .form-group {
            display: flex;
            margin: 0;
            .box-position {
                min-width: 77%;
                position: relative;
                input{
                    border-radius: 4px 0 0 4px;
                    font-size: 18px;
                    height: 38px;
                    padding-right: 45px;
                }
                .x-mark-clear{
                    position: absolute;
                    top: 1px;
                    right: 1px;
                    width: 45px;
                    padding: 6px 15px 6px 15px;
                    cursor: pointer;
                    display: none;
                    margin: 0;
                    path{
                        fill: #ff4747;
                    }
                    &:hover{
                        background-color: #f1f1f1;
                    }
                }
            }
            button{
                border-radius: 0 4px 4px 0;
                min-width: 23%;
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

    .box-back-link{
        width: 25%;
    }
    .search-panel{
        margin: 0 -15px;
        .title_page{
            padding: 15px;
        }

    }


    .box-vacancy {
        padding: 10px 5px;
        .body-chat{
            font-size: 14px;
        }
        .title-chat{
            font-size: 3rem;
        }
    }
    .new-vacancy{
        background-color: #e5f1fd;
        /*outline: 2px solid #c0ddfb;*/
    }

</style>





























