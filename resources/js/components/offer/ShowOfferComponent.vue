<template>
    <div class="box-page">

        <!-- обратная ссылка -->
        <div class="top-panel bread-top-cabinet">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="m166.5 424.5-143.1-152a23.94 23.94 0 0 1-6.562-16.5 23.94 23.94 0 0 1 6.562-16.5l143.1-152c9.125-9.625 24.31-10.03 33.93-.938 9.688 9.126 10.03 24.38.938 33.94l-128.4 135.5 128.4 135.5c9.094 9.562 8.75 24.75-.938 33.94-9.53 9.058-24.73 8.658-33.93-.942z"/></svg>

            <template v-if="respond['table'] === 'offer'">
                <a :href="`${lang.prefix_lang}offers`">
                    {{trans('pages.offer','suggestion_chats')}}
                </a>
                <span class="bread-slash"> | </span>
                <a :href="`${lang.prefix_lang}private-office`">
                    {{trans('menu.menu','cabinet')}}
                </a>
            </template>
            <template v-else>
                <a :href="`${lang.prefix_lang}offers/archive`">
                    {{trans('pages.offer','offer_archive')}}
                </a>
            </template>

        </div>

        <!-- document -->
        <div class="bottom-search">
            <div class="row box-show">

                <!-- user -->
                <div class="col-sm-12 col-md-4 left-site">
                    <!-- Контакт лист -->
                    <offer_contact_list
                        :offer="respond['offer']"
                        :settings="respond['settings']"
                        :user="user"
                        :lang="lang"
                        :page="'offer'"
                        :table="respond['table']"
                    ></offer_contact_list>
                </div>

                <!-- text -->
                <div class="col-sm-12 col-md-8 right-site">

                    <!-- вывод сообщений -->
                    <template v-for="(chat, key) in content.chat">

                        <!-- 1 НЕ мой message -->
                        <div v-if="chat.user_id !== user.id"
                             class="direct-chat-msg box-message left-message"
                             :class="{'important_message': chat.important_message == 1}"
                             :key="key"
                        >
                            <!-- time -->
                            <div class="box-time-left">
                                <span class="direct-chat-timestamp">
                                    {{getDateString(chat.date_create)}}
                                </span>
                            </div>
                            <!-- message -->
                            <div class="direct-chat-text">

                                <!-- текст сообщения и кнопочный message -->
                                <div v-html="textChat(chat.covering_letter)"></div>

                                <!-- предложение документа -->
                                <div v-if="chat.my_type_document !== null"
                                     class='offer-document'
                                >
                                    {{trans('pages.offer','for_your')}}
                                    <a class="link-a" href="javascript:void(0)"
                                       @click.prevent="transitionToLink($event, chat.your_offer_url)"
                                    >
                                        {{chat.your_offer_title}}
                                    </a>
                                    {{trans('pages.offer','proposal_consider')}} {{chat.my_type_document}}
                                    <a class="link-a" href="javascript:void(0)"
                                       @click.prevent="transitionToLink($event, chat.my_offer_url)"
                                    >
                                        {{chat.my_offer_title}}
                                    </a>
                                </div>

                            </div>
                        </div>

                        <!-- 2 МОЙ message -->
                        <div v-else
                             class="direct-chat-msg box-message right-message"
                             :key="key"
                        >
                            <!-- time -->
                            <div class="box-time-right">
                                <template v-if="respond['table'] === 'offer'">
                                    <!-- delete message -->
                                    <span v-if="chat.your_viewing === 0"
                                          class="info-tooltip" data-placement="top" data-toggle="tooltip" data-trigger="hover"
                                          :title="trans('pages.offer','delete_message')"
                                    >
                                        <svg @click="deleteElement(key)"
                                         class="delete-svg right-message link-svg"
                                         viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M424 80h-74.38l-34-56.75C306.9 8.875 291.3 0 274.4 0H173.6c-16.88 0-32.5 8.875-41.25 23.25L98.38 80H24C10.75 80 0 90.74 0 104c0 13.3 10.75 24 24 24h8l21.21 339c1.5 25.3 22.52 45 47.89 45h245.8c25.38 0 46.4-19.75 47.9-45L416 128h8c13.3 0 24-10.7 24-24 0-13.26-10.7-24-24-24zM173.6 48h100.8l19.25 32H154.4l19.2-32zm173.3 416H101.1L80.13 128h287.8L346.9 464zM143 384.1c9.373 9.371 24.56 9.379 33.94 0l47.03-47.03L271 384.1c9.373 9.371 24.56 9.379 33.94 0 9.375-9.375 9.375-24.56 0-33.94L257.9 304l47.03-47.03c9.375-9.375 9.375-24.56 0-33.94s-24.56-9.375-33.94 0l-47.03 47.03L176.1 223c-9.375-9.375-24.56-9.375-33.94 0s-9.375 24.56 0 33.94L190.1 304l-47.03 47.03c-9.37 9.37-9.37 24.57-.07 33.07z"/></svg>
                                    </span>
                                    <!-- update message -->
                                    <span v-if="chat.your_viewing === 0 && chat.important_message === 0"
                                          class="info-tooltip" data-placement="top" data-toggle="tooltip" data-trigger="hover"
                                          :title="trans('pages.offer','edit_post')"
                                    >
                                    <svg @click="selectTextForUpdate(key)"
                                         class="edit-svg right-message link-svg"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"/></svg>
                                </span>
                                </template>
                                <!-- time -->
                                <span class="direct-chat-timestamp right-message">
                                    {{getDateString(chat.date_create)}}
                                </span>
                            </div>
                            <!-- message -->
                            <div class="direct-chat-text my-chat-text"
                                 :class="{'important_message': chat.important_message == 1}"
                            >
                                <!-- текст сообщения и кнопочный message -->
                                <div v-html="textChat(chat.covering_letter)"></div>

                                <!-- предложение документа -->
                                <div v-if="chat.my_type_document !== null"
                                     class='offer-document'
                                >
                                    {{trans('pages.offer','you_suggested_considering')}} {{chat.my_type_document}}
                                    <a class="link-a" href="javascript:void(0)"
                                       @click.prevent="transitionToLink($event, chat.my_offer_url)"
                                    >
                                        {{chat.my_offer_title}}
                                    </a>
                                    {{trans('pages.offer','on_his')}}
                                    <a class="link-a" href="javascript:void(0)"
                                       @click.prevent="transitionToLink($event, chat.your_offer_url)"
                                    >
                                        {{chat.your_offer_title}}
                                    </a>
                                </div>

                            </div>
                        </div>

                        <div class="clearfix"></div>

                    </template>

                    <!-- ckeditor -->
                    <div id="box-ckeditor">
                        <label v-if="!objChat.bool_update">
                            {{trans('pages.offer','write_message')}}
                        </label>
                        <label v-else>
                            {{trans('pages.offer','update_message')}}
                        </label>
                        <ckeditor v-model="objTextarea.textarea_letter"
                                  :config="objTextarea.editorConfig1"
                        ></ckeditor>

                        <div v-if="objChat.bool_update" class="button-update">
                            <button type="submit" class="btn btn-block btn-outline-danger btn-lg"
                                    @click.prevent="cancelUpdate"
                            >
                                {{trans('pages.offer','cancel')}}
                            </button>
                            <button type="submit" class="btn btn-block btn-primary btn-lg"
                                    @click.prevent="updateMessage"
                                    :class="{'disabled': disableButton()}"
                                    :disabled="disableButton()"
                            >
                                {{trans('pages.offer','refresh')}}
                            </button>
                        </div>

                        <button v-else type="submit" class="btn btn-block btn-primary btn-lg button-create"
                                @click.prevent="addMessage"
                                :class="{'disabled': disableButton()}"
                                :disabled="disableButton()"
                        >
                            {{trans('pages.offer','send')}}
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</template>

<script>
    import translation from "../../mixins/translation";
    import offer_contact_list from "../details/OfferContactListComponent";
    import response_methods_mixin from "../../mixins/response_methods_mixin";
    import general_functions_mixin from "../../mixins/general_functions_mixin";
    import date_mixin from "../../mixins/date_mixin";

    export default {
        mixins: [
            translation,
            response_methods_mixin,
            general_functions_mixin,
            date_mixin
        ],
        components: {
            'offer_contact_list': offer_contact_list
        },
        data() {
            return {
                objTextarea: {
                    textarea_letter: '',
                    editorConfig1: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList', 'Link' ]
                        ],
                    },
                },
                objChat: {
                    bool_update: false, // для отображения нужных button
                    index: null,
                },
                content: {},
                iconMessage:["not_interested", "need_solved"],
            }
        },
        methods: {
            async addMessage() {
                let data = {
                    offer_id: (this.respond['table'] === 'offer') ? this.respond['offer'].id : this.respond['offer'].table_id,
                    text: this.objTextarea.textarea_letter,
                };
                let url = (this.respond['table'] === 'offer') ? this.lang.prefix_lang+'offers/add-message' : this.lang.prefix_lang+'offers/archive/add-message'
                const response = await this.$http.post(url, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            if(this.respond['table'] === 'offer'){
                                this.content.chat.push(res.data.message);
                                this.objTextarea.textarea_letter = ''
                            }
                            else{
                                location.href = this.lang.prefix_lang+'offers'
                            }
                        }
                        // custom ошибки
                        else{
                            this.message(res.data.message, 'error', 10000, true);
                        }
                    })
                    // ошибки сервера
                    .catch(err => {
                        location.href = this.lang.prefix_lang+'offers'
                    })
            },
            async updateMessage() {
                let data = {
                    offer_id: this.respond['offer'].id,
                    text: this.objTextarea.textarea_letter,
                    index: this.objChat.index,
                };
                const response = await this.$http.post(`/offers/update-message`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            this.content.chat[this.objChat.index]['covering_letter'] = this.objTextarea.textarea_letter;
                            this.objTextarea.textarea_letter = ''
                            this.objChat.bool_update = false
                        }
                        // custom ошибки
                        else{
                            if(res.data.message === 'reload'){
                                location.reload()
                            }
                            else{
                                this.message(res.data.message, 'error', 10000, true);
                            }
                        }
                    })
                    // ошибки сервера
                    .catch(err => {
                        location.href = this.lang.prefix_lang+'offers'
                    })
            },
            // отметить просмотр сообщений собеседника
            async registerViewedCompanion() {
                let data = {
                    offer_id: this.respond['offer'].id,
                };
                const response = await this.$http.post(`/offers/register-viewed-companion`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){

                        }
                        // custom ошибки
                        else{
                            this.message(res.data.message, 'error', 10000, true);
                        }
                    })
                    // ошибки сервера
                    .catch(err => {
                        this.messageError(err)
                    })
            },
            // удалить указаный елемент
            async deleteElement(index) {
                let data = {
                    offer_id: this.respond['offer'].id,
                    index: index,
                };
                const response = await this.$http.post(`/offers/delete`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            this.content.chat.splice(index, 1)
                        }
                        // custom ошибки
                        else{
                            if(res.data.message === 'reload'){
                                location.reload()
                            }
                            else{
                                this.message(res.data.message, 'error', 10000, true);
                            }
                        }
                    })
                    // ошибки сервера
                    .catch(err => {
                        location.href = this.lang.prefix_lang+'offers'
                    })
            },
            // выбрать текст из чата для update
            selectTextForUpdate(index) {
                this.objTextarea.textarea_letter = this.content.chat[index].covering_letter
                this.objChat.bool_update = true
                this.objChat.index = index
                const el = document.getElementById('box-ckeditor');
                $('html,body').animate({
                    scrollTop:$(el).offset().top+"px"
                }, 500, 'linear');
            },
            cancelUpdate() {
                this.objTextarea.textarea_letter = ''
                this.objChat.bool_update = false
                this.objChat.index = null
            },
            // cкролит к первому не прочитанному собеседника или к последнему общего
            scrollToElement() {
                let element = null
                const your_new_message = document.querySelectorAll('.your-new-message')
                if(your_new_message.length){
                    element = your_new_message[0]
                }
                else{
                    element = document.querySelectorAll('.box-message')
                    element = element[element.length-1]
                }

                setTimeout(function() {
                    $('html,body').animate({
                        scrollTop:$(element).offset().top-100+"px"
                    }, 0);
                }, 200);

            },
            disableButton() {
                // вырезать теги
                let line = this.cutTags(this.objTextarea.textarea_letter)
                // вырезать &nbsp;
                line = this.cutNbsp(line)
                // убрать пробелы
                line = this.cutSpaces(line)

                if( !line.length ){
                    return true;
                }
                return false;
            },
            transitionToLink(event, url){
                // это резюме сайта
                if(this.convertStringToArray(url, ".")[1] === undefined){
                    window.open(this.lang.prefix_lang+url)
                }
                // это файл
                else{
                    window.open("/"+url)
                }

                event.stopPropagation()
            },
            textChat(text) {

                // текст чата
                if(text !== null){
                    if(this.iconMessage.indexOf(text) !== -1){
                        text = this.trans('pages.offer',`${text}_2`)
                    }
                }

                return text
            },
        },
        props: [
            'user',
            'lang',
            'respond',
        ],
        mounted() {
            this.content = this.respond['offer']
            // отметить просмотр сообщений собеседника
            if(this.respond['table'] === 'offer'){
                this.registerViewedCompanion()
            }
            // инициализация динамических всплывающих подсказок
            $('body').tooltip({
                selector: '[data-toggle="tooltip"]'
            });
        },
        updated() {
            this.scrollToElement()
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .box-page{
        padding: 15px 15px 50px;
    }

    .bread-top-cabinet{
        border: none;
        padding: 20px 15px!important;
    }
    .box-message{
        width: 70%;
        .direct-chat-text{
            margin: 5px 0 0 0;
            background-color: #f5f5f5;
        }
    }
    .important_message {
        .direct-chat-text{
            border-color: #d6d6d6;
            color: #948b36;
            background-color: #fffbdb;
        }
    }
    .direct-chat-timestamp{
        font-size: 12px;
    }
    .box-show {
        display: flex;
        padding-top: 15px;
        .left-site{

        }
        .right-site{
            .left-message{
                float: left;
            }
            .right-message{
                float: right;
                .my-chat-text{
                    /*color: #fff;*/
                    margin: 5px 0 0 0;
                    &::before {
                        right: -6px;
                        border-left-color: #d2d6de;
                        border-right: none;
                    }
                    &::after {
                        visibility: hidden;
                    }
                }
                .important_message{
                    border-color: #d6d6d6;
                    color: #948b36;
                    background-color: #fffbdb;
                }
            }

            #box-ckeditor{
                margin-top: 50px;
                .button-create{
                    width: 135px;
                    margin: 25px 0 10px auto;
                }
                .button-update{
                    display: flex;
                    flex-direction: row;
                    flex-wrap: nowrap;
                    justify-content: flex-end;
                    align-content: flex-start;
                    align-items: center;
                    margin: 25px 0 10px auto;
                    button{
                        width: 135px;
                    }
                    button:first-child{
                        margin-right: 20px;
                    }
                }
            }
        }
    }
    .info-tooltip{
        min-width: 28px;
        display: inline-block;
        text-align: center;
    }
    .edit-svg,
    .delete-svg{
        padding: 5px;
        fill: #0065cb;
        cursor: pointer;
        width: 28px;
        margin: 0 5px;
        &:hover{
            fill: #0c85ff;
        }
    }
    .delete-svg{
        width: 27px;
    }
    .edit-svg{
        margin: 0 5px 0 0;
    }
    .box-time-left{
        display: flex;
        align-items: center;
    }
    .box-time-right{
        display: flex;
        justify-content: flex-end;
        align-items: center;
        .direct-chat-timestamp{
            margin-left: 5px;
        }
    }

    @media (max-width: 768px){
        .box-show {
            .right-site{
                margin-top: 50px;
            }
        }
    }

</style>





























