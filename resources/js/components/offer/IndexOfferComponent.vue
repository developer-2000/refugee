<template>
    <div class="box-page">
        <!-- обратная ссылка -->
        <div class="top-panel bread-top-cabinet">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="m166.5 424.5-143.1-152a23.94 23.94 0 0 1-6.562-16.5 23.94 23.94 0 0 1 6.562-16.5l143.1-152c9.125-9.625 24.31-10.03 33.93-.938 9.688 9.126 10.03 24.38.938 33.94l-128.4 135.5 128.4 135.5c9.094 9.562 8.75 24.75-.938 33.94-9.53 9.058-24.73 8.658-33.93-.942z"/></svg>
            <a :href="`${lang.prefix_lang}private-office`">
                {{trans('menu.menu','cabinet')}}
            </a>
            <span class="bread-slash"> | </span>
        </div>
        <!-- title -->
        <h1 class="title_page card-body">
            Предложения
        </h1>

        <div class="bottom-search">

                <!-- document -->
                <div class="row box-vacancy"
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

    export default {
        mixins: [
            translation,
        ],
        components: {
            'offer_contact_list': offer_contact_list
        },
        data() {
            return {
                length_string: 250,
            }
        },
        methods: {
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
                        string += "<div class='font-weight-bold offer-document'>Предложение рассмотреть "+chat.type_document+"</div>"
                    }
                    else if(chat.user_id === this.user.id){
                        string += "<div class='font-weight-bold offer-document'>Вы: предложили к рассмотрению "+chat.type_document+"</div>"
                    }
                }

                // текст чата
                if(chat.covering_letter !== null){
                    // html и длина
                    let line = chat.covering_letter.replace(regex, " ")
                    if(line.length > this.length_string) {
                        line = line.substring(0,this.length_string)+" ...";
                    }

                    if(chat.user_id !== this.user.id){
                        string += line
                    }
                    else if(chat.user_id === this.user.id){
                        string += "<div class='font-weight-bold offer-document'>Вы:</div>"+line
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
            console.log(this.user)
            console.log(this.offers)
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .box-vacancy {
        padding: 10px 5px;
        .body-chat{
            font-size: 14px;
        }
        .title-chat{
            font-size: 3rem;
        }
    }

</style>





























