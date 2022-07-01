<template>
    <div class="box-page box-offer">
        <!-- top panel -->
        <div class="top-panel bread-top-cabinet">
            <!-- обратная ссылка -->
            <div class="box-back-link">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="m166.5 424.5-143.1-152a23.94 23.94 0 0 1-6.562-16.5 23.94 23.94 0 0 1 6.562-16.5l143.1-152c9.125-9.625 24.31-10.03 33.93-.938 9.688 9.126 10.03 24.38.938 33.94l-128.4 135.5 128.4 135.5c9.094 9.562 8.75 24.75-.938 33.94-9.53 9.058-24.73 8.658-33.93-.942z"/></svg>

                <template v-if="respond['table'] === 'offer'">
                    <a :href="`${lang.prefix_lang}`">
                        {{trans('menu.menu','index')}}
                    </a>
                    <span class="bread-slash"> | </span>
                    <a :href="`${lang.prefix_lang}private-office`">
                        {{trans('menu.menu','cabinet')}}
                    </a>
                </template>
                <template v-else>
                    <a :href="`${lang.prefix_lang}offers`">
                        Чаты предложений
                    </a>
                </template>

            </div>

            <!-- search line -->
            <div v-if="respond['table'] === 'offer'" class="top-search">
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
        <!-- title -->
        <div class="search-panel">
            <h1 v-if="respond['table'] === 'offer'" class="title_page card-body">
                Предложения
            </h1>
            <h1 v-else class="title_page card-body">
                Архив предложений
            </h1>
        </div>
        <!-- No offers -->
        <div v-if="!content.length && respond['table'] === 'offer'" class="callout callout-warning">
            <b>Предложения отсутствуют.</b>
            <div>
                На этой странице отображаются ваши личные переписки с участниками сервиса. Создать чат с кем либо, возможно откликнувшись на документ, перейдя в документ на странице поиска
                «<a class="link-a" target="_blank"
                   :href="`${lang.prefix_lang}resume`"
                >Резюме</a>,
                <a class="link-a" target="_blank"
                   :href="`${lang.prefix_lang}vacancy`"
                >Вакансия</a>».
                Чат считается устаревшим спустя один месяц по дате последнего сообщения в нем и автоматически перемещается в «Архив предложений».
                Перейдя в «Архив предложений» вы всегда можете обратиться к чату. Продолжив общение, чат автоматически восстановится в основном каталоге «Предложения».
            </div>
        </div>
        <div v-else-if="content.length && respond['table'] === 'offer'" class="desc-helper-italic">
            Чат считается устаревшим спустя один месяц по дате последнего сообщения в нем и автоматически перемещается в «Архив предложений».
        </div>
        <div v-if="!content.length && respond['table'] === 'archive'" class="callout callout-warning">
            <b>Архивные чаты отсутствуют.</b>
            <div>
                На этой странице отображаются архивные записи вашей переписки с участниками сервиса.
                Чат считается устаревшим, спустя один месяц по дате последнего сообщения в нем и автоматически перемещается в этот архив.
                Продолжив общение, чат автоматически восстановится в основном каталоге «Предложения».
            </div>
        </div>
        <div v-else-if="content.length && respond['table'] === 'archive'" class="desc-helper-italic">
            Продолжив общение, чат автоматически восстановится в основном каталоге «Предложения».
        </div>

        <!-- documents -->
        <div class="bottom-search">
            <div v-for="(offer, key) in content" :key="key"
                 class="row box-vacancy"
                 :class="{'new-vacancy': (offer.one_user_id === user.id && offer.one_user_review === 0) || (offer.two_user_id === user.id && offer.two_user_review === 0)}"
                 @click.prevent="transitionToOffer(offer.alias)"
            >
                <!-- user -->
                <div class="col-sm-3">
                    <!-- Контакт лист -->
                    <offer_contact_list
                        :offer="offer"
                        :settings="respond['settings']"
                        :user="user"
                        :lang="lang"
                        :page="'offers'"
                        :table="respond['table']"
                    ></offer_contact_list>
                </div>
                <!-- text -->
                <div class="col-sm-9">
                    <div class="body-chat">
                        <!-- title chat -->
                        <div class='font-weight-bold title-chat'>
                            <!-- title -->
                            <div>{{offer.chat[0].title_chat}}</div>
                            <!-- buttons -->
                            <div v-if="respond['table'] === 'offer'" class="box-button">
                                <!-- не интересно -->
                                <span class="info-tooltip" data-toggle="tooltip" data-placement="top" data-trigger="hover"
                                      title="не интересно"
                                >
                                    <svg @click="addMessage($event, offer.id, 'not_interested')"
                                         class="svg-interest link-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M504.1 7.031c-9.375-9.375-24.56-9.375-33.94 0l-74.59 74.59C358 50.63 309.2 32 256 32 132.3 32 32 132.3 32 256c0 53.21 18.63 102 49.62 140.4L7.03 470.99c-9.375 9.375-9.375 24.56 0 33.94C11.72 509.7 17.84 512 24 512s12.28-2.344 16.97-7.031l74.59-74.59C153.1 461.4 202.8 480 256 480c123.7 0 224-100.3 224-224 0-53.21-18.63-102-49.62-140.4l74.59-74.59c9.33-9.42 9.33-24.6-.87-33.979zM80 256c0-97.05 78.95-176 176-176 39.88 0 76.59 13.49 106.1 35.93l-246.2 246.2C93.49 332.6 80 295.9 80 256zm352 0c0 97.05-78.95 176-176 176-39.88 0-76.59-13.49-106.1-35.93l246.2-246.2C418.5 179.4 432 216.1 432 256z"/></svg>
                                </span>
                                <!-- потребность решена -->
                                <span class="info-tooltip" data-toggle="tooltip" data-placement="top" data-trigger="hover"
                                      title="потребность решена"
                                >
                                    <svg @click="addMessage($event, offer.id, 'need_solved')"
                                         class="svg-end link-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M0 24C0 10.75 10.75 0 24 0h336c13.3 0 24 10.75 24 24s-10.7 24-24 24h-8v18.98c0 40.32-16.9 78.12-44.5 107.52L225.9 256l81.6 81.5C335.1 366 352 404.7 352 445v19h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H24c-13.25 0-24-10.7-24-24s10.75-24 24-24h8v-19c0-40.3 16.01-79 44.52-107.5L158.1 256l-81.58-81.5C48.01 145.1 32 107.3 32 66.98V48h-8C10.75 48 0 37.25 0 24zm304 42.98V48H80v18.98c0 27.58 10.96 54.02 30.5 73.52l81.5 81.6 81.5-81.6C293 121 304 94.56 304 66.98z"/></svg>
                                </span>
                                <!-- отправить в архив -->
                                <span class="info-tooltip" data-toggle="tooltip" data-placement="top" data-trigger="hover"
                                      title="отправить в архив"
                                >
                                    <svg @click="sendToArchive($event, offer.id, key)"
                                         class="svg-archive link-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M464 320h-96a23.964 23.964 0 0 0-21.47 13.28L321.2 384H190.8l-25.38-50.72C161.4 325.1 153.1 320 144 320H32c-17.67 0-32 14.33-32 32v96c0 35.35 28.65 64 64 64h384c35.35 0 64-28.65 64-64v-80c0-26.5-21.5-48-48-48zm0 128c0 8.822-7.178 16-16 16H64c-8.822 0-16-7.178-16-16v-80h81.16l25.38 50.72C158.6 426.9 166.9 432 176 432h160c9.094 0 17.41-5.125 21.47-13.28L382.8 368H464v80zM238.4 312.3c3.7 4.9 10.9 7.7 17.6 7.7s13.03-2.781 17.59-7.656l104-112c9-9.719 8.438-24.91-1.25-33.94-9.719-8.969-24.88-8.438-33.94 1.25L280 234.9V24c0-13.25-10.75-24-24-24s-24 10.75-24 24v210.9l-62.4-67.2c-9.1-10.6-24.2-10.3-33.9-1.3-10.6 9-10.3 24.2-1.3 33.9l104 112z"/></svg>
                                </span>
                            </div>
                        </div>

                        <!-- 1 не мой message -->
                        <template v-if="offer.chat[offer.chat.length-1].user_id !== user.id">
                            <div class="direct-chat-msg box-message left-message" :key="key">
                                <!-- message -->
                                <div class="direct-chat-text"
                                     :class="{'important_message': offer.chat[offer.chat.length-1].important_message == 1}"
                                >
                                    <!-- сопроводительный текст -->
                                    <div v-html="textChat(offer.chat[offer.chat.length-1].covering_letter)"></div>
                                    <!-- предложение документа -->
                                    <template v-if="offer.chat[offer.chat.length-1].my_type_document !== null">
                                        <div class='offer-document'>
                                            На Ваше
                                            <a target="_blank" class="link-a"
                                               @click.prevent="transitionToLink($event, lang.prefix_lang+offer.chat[offer.chat.length-1].your_offer_url)"
                                            >
                                                {{offer.chat[offer.chat.length-1].your_offer_title}}
                                            </a>
                                            предложение рассмотреть {{offer.chat[offer.chat.length-1].my_type_document}}
                                            <a target="_blank" class="link-a"
                                               @click.prevent="transitionToLink($event, lang.prefix_lang+offer.chat[offer.chat.length-1].my_offer_url)"
                                            >
                                                {{offer.chat[offer.chat.length-1].my_offer_title}}
                                            </a>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <!-- 2 мой message -->
                        <template v-else>
                            <div class="direct-chat-msg box-message right-message" :key="key">
                                <!-- статус просмотра -->
                                <div class="box-time-right">
                                    <span class="direct-chat-timestamp"
                                          :class="{'read-status': offer.chat[offer.chat.length-1].your_viewing == 1}"
                                    >
                                        {{offer.chat[offer.chat.length-1].your_viewing == 0 ? 'не прочитано' : 'прочитано'}}
                                    </span>
                                </div>
                                <!-- message -->
                                <div class="direct-chat-text my-chat-text"
                                     :class="{'important_message': offer.chat[offer.chat.length-1].important_message == 1}"
                                >
                                    <!-- сопроводительный текст -->
                                    <div v-html="textChat(offer.chat[offer.chat.length-1].covering_letter)"></div>
                                    <!-- предложение документа -->
                                    <template v-if="offer.chat[offer.chat.length-1].my_type_document !== null">
                                        <div class='offer-document'>
                                            На Его
                                            <a target="_blank" class="link-a"
                                               @click.prevent="transitionToLink($event, lang.prefix_lang+offer.chat[offer.chat.length-1].your_offer_url)"
                                            >
                                                {{offer.chat[offer.chat.length-1].your_offer_title}}
                                            </a>
                                            предложил рассмотреть {{offer.chat[offer.chat.length-1].my_type_document}}
                                            <a target="_blank" class="link-a"
                                               @click.prevent="transitionToLink($event, lang.prefix_lang+offer.chat[offer.chat.length-1].my_offer_url)"
                                            >
                                                {{offer.chat[offer.chat.length-1].my_offer_title}}
                                            </a>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>

                    </div>
                </div>
            </div>
        </div>

        <!-- link to archive -->
        <a v-if="archive_count > 0 && respond['table'] === 'offer'"
            class="link-a to-archive"
           :href="`${lang.prefix_lang}offers/archive`"
        >Архив предложений: {{archive_count}} </a>

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
            search_input_mixin,
            general_functions_mixin,
        ],
        components: {
            'offer_contact_list': offer_contact_list
        },
        data() {
            return {
                content: {},
                archive_count: 0,
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
            // <div class="alert alert-warning">Благодарю вас, но это предложение меня не интересует!</div>
            async addMessage(event, offer_id, text) {
                event.stopPropagation()
                let data = {
                    offer_id: offer_id,
                    important_message: 1,
                    text: text,
                };
                const response = await this.$http.post(`/offers/add-message`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            location.reload()
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
            async sendToArchive(event, offer_id, index){
                event.stopPropagation()
                let data = {
                    offer_id: offer_id,
                };
                const response = await this.$http.post(`/offers/send-to-archive`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            this.content.splice(index, 1)
                            this.archive_count++
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
            textChat(text) {
                let string = ""

                // текст чата
                if(text !== null){
                    // html и длина
                    let line = this.cutTags(text)
                    if(line.length > this.length_string) {
                        line = line.substring(0,this.length_string)+" ...";
                    }

                    string += "<div class='text-chat'>"+line+"</div>";
                }

                return string
            },
            transitionToOffer(alias){
                if(this.respond['table'] === 'offer'){
                    location.href = this.lang.prefix_lang+'offers/'+alias
                }
                else{
                    location.href = this.lang.prefix_lang+'offers/archive/'+alias
                }
            },
            transitionToLink(event, url){
                window.open(url)
                event.stopPropagation()
            },
        },
        props: [
            'user',
            'lang',
            'respond',
        ],
        mounted() {
            // console.log(this.user)
            // console.log(this.respond['offers'])

            this.content = this.respond['offers']
            this.archive_count = this.respond['count_archive']
            // инициализация динамических всплывающих подсказок
            $('body').tooltip({
                selector: '[data-toggle="tooltip"]'
            });
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .top-panel > div:first-child {
        display: flex;
        align-items: center;
    }
    .to-archive{
        margin: 18px auto 0 auto;
        border-bottom: 1px dashed;
    }
    .box-message{
        width: 80%;
        .direct-chat-text{
            margin: 5px 0 0 0;
            background-color: #f5f5f5;
        }
        .my-chat-text{
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

    .title-chat{
        font-size: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 10px;
    }
    .box-button{
        svg {
            width: 18px;
        }
        .svg-end{
            width: 13px;
        }
        .info-tooltip{
            min-width: 28px;
            display: inline-block;
            text-align: center;
        }
    }
    .read-status{
        color: #00670c;
    }
    .left-message{
        float: left;
    }
    .right-message{
        float: right;
    }
    .box-time-right{
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

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
    }
    .new-vacancy{
        background-color: #e5f1fd;
        /*outline: 2px solid #c0ddfb;*/
    }

</style>





























