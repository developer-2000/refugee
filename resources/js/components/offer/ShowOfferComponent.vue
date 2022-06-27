<template>
    <div class="box-page">
        <!-- обратная ссылка -->
        <div class="top-panel bread-top-cabinet">
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
        </div>
        <!-- document -->
        <div class="bottom-search">
            <div class="box-show">

                <!-- user -->
                <div class="left-site">
                    <!-- Контакт лист -->
                    <offer_contact_list
                        :offer="offer"
                        :settings="settings"
                        :user="user"
                        :lang="lang"
                        :page="'offer'"
                    ></offer_contact_list>
                </div>

                <!-- text -->
                <div class="right-site">

                    <!-- вывод сообщений -->
                    <template v-for="(chat, key) in content.chat">

                        <!-- 1 не мой message -->
                        <template v-if="chat.user_id !== user.id">
                            <div class="direct-chat-msg box-message left-message"
                                 :class="[
                                     {'your-new-message': chat.your_viewing == 0},
                                     {'important_message': chat.important_message == 1}
                                     ]"
                                 :key="key"
                            >
                                <!-- time -->
                                <div class="box-time-left">
                                    <span class="direct-chat-timestamp">
                                        {{chat.date_create}}
                                    </span>
                                </div>
                                <!-- message -->
                                <div class="direct-chat-text">
                                    <!-- сопроводительный текст -->
                                    <div v-html="chat.covering_letter"></div>
                                    <!-- предложение документа -->
                                    <template v-if="chat.my_type_document !== null">
                                        <div class='offer-document'>
                                            На Ваше
                                            <a target="_blank" class="link-a" :href="lang.prefix_lang+chat.your_offer_url">
                                                {{chat.your_offer_title}}
                                            </a>
                                            предложение рассмотреть {{chat.my_type_document}}
                                            <a target="_blank" class="link-a" :href="lang.prefix_lang+chat.my_offer_url">
                                                {{chat.my_offer_title}}
                                            </a>
                                        </div>
                                    </template>

                                </div>
                            </div>
                        </template>

                        <!-- 2 мой message -->
                        <template v-else>
                            <div class="direct-chat-msg box-message right-message" :key="key">
                                <!-- time -->
                                <div class="box-time-right">
                                    <!-- delete message -->
                                    <svg v-if="chat.your_viewing === 0"
                                         @click="deleteElement(key)"
                                         title="удалить сообщение" data-toggle="tooltip" data-placement="top" data-trigger="hover"
                                         class="delete-svg right-message" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M400.8 128c-8.285 0-15.2 6.324-15.94 14.58L356 465.4c-.6 8.2-7.6 14.6-15.9 14.6H107.9c-8.27 0-15.27-6.4-15.9-14.6L63.16 142.6c-.73-8.3-7.65-14.6-15.93-14.6-9.4 0-16.78 8.1-15.94 17.4l28.84 322.8C62.38 493 83 512 107.9 512h232.3c24.88 0 45.5-19 47.75-43.75l28.84-322.8c.71-9.35-6.59-17.45-15.99-17.45zM432 64h-96l-33.63-44.75C293.4 7.125 279.1 0 264 0h-80c-15.1 0-29.4 7.125-38.4 19.25L112 64H16C7.201 64 0 71.2 0 80s7.201 16 16 16h416c8.8 0 16-7.2 16-16s-7.2-16-16-16zm-280 0 19.25-25.62C174.3 34.38 179 32 184 32h80c5 0 9.75 2.375 12.75 6.375L296 64H152zm-3.3 299.3c6.242 6.246 16.37 6.254 22.62 0L224 310.6l52.69 52.69c6.242 6.246 16.37 6.254 22.62 0 6.25-6.25 6.25-16.38 0-22.62L246.6 288l52.69-52.69c6.25-6.25 6.25-16.38 0-22.62s-16.38-6.25-22.62 0L224 265.4l-52.7-52.7c-6.25-6.25-16.38-6.25-22.62 0s-6.25 16.38 0 22.62L201.4 288l-52.69 52.69c-6.31 6.21-6.31 16.41-.01 22.61z"/></svg>
                                    <!-- update message -->
                                    <svg v-if="chat.your_viewing === 0 && chat.important_message === 0"
                                         @click="selectTextForUpdate(key)"
                                         title="редактировать сообщение" data-toggle="tooltip" data-placement="top" data-trigger="hover"
                                         class="edit-svg right-message" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M432 320c-8.836 0-16 7.164-16 16v112c0 17.67-14.33 32-32 32H64c-17.67 0-32-14.33-32-32V128c0-17.67 14.33-32 32-32h112c8.8 0 16-7.16 16-16s-7.2-16-16-16H63.1C28.65 64 0 92.65 0 128v320c0 35.35 28.65 64 63.1 64h319.1c35.35 0 63.1-28.65 63.1-64l2.7-112c0-8.8-7.2-16-16-16zm65.9-277.81-28.13-28.14C460.397 4.677 448.11-.01 435.83-.01s-24.57 4.688-33.94 14.06L162.4 253.6c-8.9 8.9-15 20.3-17.5 32.7l-16.66 83.35c-1.516 7.584 4.378 14.36 11.72 14.36.785 0 1.586-.076 2.399-.238l83.35-16.67a63.979 63.979 0 0 0 32.7-17.5l239.5-239.5C516.7 91.33 516.7 60.94 497.9 42.19zM235.8 326.1a31.87 31.87 0 0 1-16.35 8.748l-53.93 10.79L176.3 292.6a31.898 31.898 0 0 1 8.754-16.36l178.3-178.3 50.76 50.76L235.8 326.1zM475.3 87.45l-38.62 38.62-50.76-50.76 38.62-38.62c4.076-4.076 8.838-4.686 11.31-4.686s7.236.61 11.31 4.686l28.13 28.14c4.11 4.07 4.71 8.83 4.71 11.31 0 2.47-.6 7.23-4.7 11.31z"/></svg>
                                    <!-- time -->
                                    <span class="direct-chat-timestamp right-message">
                                        {{chat.date_create}}
                                    </span>
                                </div>
                                <!-- message -->
                                <div class="direct-chat-text my-chat-text"
                                     :class="{'important_message': chat.important_message == 1}"
                                >
                                    <!-- сопроводительный текст -->
                                    <div v-html="chat.covering_letter"></div>
                                    <!-- предложение документа -->
                                    <template v-if="chat.my_type_document !== null">
                                        <div class='offer-document'>
                                            На Его
                                            <a target="_blank" class="link-a" :href="lang.prefix_lang+chat.your_offer_url">
                                                {{chat.your_offer_title}}
                                            </a>
                                            предложил рассмотреть {{chat.my_type_document}}
                                            <a target="_blank" class="link-a" :href="lang.prefix_lang+chat.my_offer_url">
                                                {{chat.my_offer_title}}
                                            </a>
                                        </div>
                                    </template>

                                </div>
                            </div>
                        </template>

                        <div class="clearfix"></div>

                    </template>

                    <!-- ckeditor -->
                    <div id="box-ckeditor">
                        <label v-if="!objChat.bool_update">
                            Написать сообщение
                        </label>
                        <label v-else>
                            Обновить сообщение
                        </label>
                        <ckeditor v-model="objTextarea.textarea_letter"
                                  :config="objTextarea.editorConfig1"
                        ></ckeditor>

                        <div v-if="objChat.bool_update" class="button-update">
                            <button type="submit" class="btn btn-block btn-outline-danger btn-lg"
                                    @click.prevent="cancelUpdate"
                            >
                                Отмена
                            </button>
                            <button type="submit" class="btn btn-block btn-primary btn-lg"
                                    @click.prevent="updateMessage"
                                    :class="{'disabled': disableButton()}"
                                    :disabled="disableButton()"
                            >
                                Обновить
                            </button>
                        </div>

                        <button v-else type="submit" class="btn btn-block btn-primary btn-lg button-create"
                                @click.prevent="addMessage"
                                :class="{'disabled': disableButton()}"
                                :disabled="disableButton()"
                        >
                            Отправить
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
    import search_input_mixin from "../../mixins/search_input_mixin";
    import general_functions_mixin from "../../mixins/general_functions_mixin";

    export default {
        mixins: [
            translation,
            response_methods_mixin,
            general_functions_mixin,
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
            }
        },
        methods: {
            async addMessage() {
                let data = {
                    offer_id: this.offer.id,
                    text: this.objTextarea.textarea_letter,
                };
                const response = await this.$http.post(`/offers/add-message`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            this.content.chat.push(res.data.message);
                            this.objTextarea.textarea_letter = ''
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
            async updateMessage() {
                let data = {
                    offer_id: this.offer.id,
                    text: this.objTextarea.textarea_letter,
                    index: this.objChat.index,
                };
                const response = await this.$http.post(`/offers/update-message`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            // console.log(res.data.message)
                            // this.content.chat.push(res.data.message);
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
                        this.messageError(err)
                    })
            },
            // отметить просмотр сообщений собеседника
            async registerViewedCompanion() {
                let data = {
                    offer_id: this.offer.id,
                };
                const response = await this.$http.post(`/offers/register-viewed-companion`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            // console.log(res.data.message)
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
                    offer_id: this.offer.id,
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
                        this.messageError(err)
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
        },
        props: [
            'user',
            'lang',
            'offer',
            'settings',
        ],
        mounted() {
            this.content = this.offer
            // отметить просмотр сообщений собеседника
            this.registerViewedCompanion()

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

    .box-message{
        width: 70%;
        .direct-chat-text{
            margin: 5px 0 0 0;
            background-color: #f5f5f5;
        }
    }

    .direct-chat-timestamp{
        font-size: 12px;
    }
    .box-show {
        display: flex;
        padding-top: 15px;
        .left-site{
            width: 25%;
        }
        .right-site{
            width: 75%;
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

</style>





























