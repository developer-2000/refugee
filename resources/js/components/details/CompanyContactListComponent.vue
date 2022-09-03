<template>
    <div class="card bg-light contacts-list">

        <!-- header -->
        <div class="contacts-header">
            <h3 class="card-title h3-bg-teal">
                {{trans('details.contacts','communication_contacts')}}
            </h3>
            <a href="javascript:void(0)" class="btn btn-sm bg-teal"
               @click="openChat()"
            >
                <svg class="svg-comments" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M144 208C126.3 208 112 222.2 112 239.1C112 257.7 126.3 272 144 272s31.1-14.25 31.1-32S161.8 208 144 208zM256 207.1c-17.75 0-31.1 14.25-31.1 32s14.25 31.1 31.1 31.1s31.1-14.25 31.1-31.1S273.8 207.1 256 207.1zM368 208c-17.75 0-31.1 14.25-31.1 32s14.25 32 31.1 32c17.75 0 31.99-14.25 31.99-32C400 222.2 385.8 208 368 208zM256 31.1c-141.4 0-255.1 93.12-255.1 208c0 47.62 19.91 91.25 52.91 126.3c-14.87 39.5-45.87 72.88-46.37 73.25c-6.624 7-8.373 17.25-4.624 26C5.818 474.2 14.38 480 24 480c61.49 0 109.1-25.75 139.1-46.25c28.87 9 60.16 14.25 92.9 14.25c141.4 0 255.1-93.13 255.1-207.1S397.4 31.1 256 31.1zM256 400c-26.75 0-53.12-4.125-78.36-12.12l-22.75-7.125L135.4 394.5c-14.25 10.12-33.87 21.38-57.49 29c7.374-12.12 14.37-25.75 19.87-40.25l10.62-28l-20.62-21.87C69.81 314.1 48.06 282.2 48.06 240c0-88.25 93.24-160 207.1-160s207.1 71.75 207.1 160S370.8 400 256 400z"/></svg>
            </a>
        </div>
        <!-- body -->
        <div class="contacts-body">
            <div class="box-image">
                <img alt="" class="img-fluid"
                     :src="`/${contact_list.avatar_url}`"
                >
                <ul class="contacts-content">
                    <!-- name -->
                    <li><b>{{contact_list.full_name}}</b></li>
                    <!-- position -->
                    <li v-if="contact_list.position !== null" class="contacts-position"><b>{{contact_list.position}}</b></li>
                    <li v-else class="not-specified">
                        {{trans('details.contacts','position_not_specified')}}
                    </li>
                </ul>
            </div>

            <ul>
                <!-- email -->
                <li class="contacts-line">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M464 64C490.5 64 512 85.49 512 112C512 127.1 504.9 141.3 492.8 150.4L275.2 313.6C263.8 322.1 248.2 322.1 236.8 313.6L19.2 150.4C7.113 141.3 0 127.1 0 112C0 85.49 21.49 64 48 64H464zM217.6 339.2C240.4 356.3 271.6 356.3 294.4 339.2L512 176V384C512 419.3 483.3 448 448 448H64C28.65 448 0 419.3 0 384V176L217.6 339.2z"/></svg>

                    <div v-if="!objBoolContacts.bool_show_email"
                         class="target-label"
                         @click="messageNotReceived('bool_show_email')"
                    >
                        {{trans('details.contacts','show_email')}}
                    </div>
                    <template v-else-if="objBoolContacts.bool_show_email">
                        <div v-if="contact_list.email !== null"
                             class="link-a"
                             @click="copyText($event.target,trans('details.contacts','email_copied_clipboard'))"
                        >{{contact_list.email}}</div>
                        <div v-else class="not-specified">
                            {{trans('details.contacts','not_specified')}}
                        </div>
                    </template>
                </li>

                <!-- skype -->
                <li class="contacts-line">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M424.7 299.8c2.9-14 4.7-28.9 4.7-43.8 0-113.5-91.9-205.3-205.3-205.3-14.9 0-29.7 1.7-43.8 4.7C161.3 40.7 137.7 32 112 32 50.2 32 0 82.2 0 144c0 25.7 8.7 49.3 23.3 68.2-2.9 14-4.7 28.9-4.7 43.8 0 113.5 91.9 205.3 205.3 205.3 14.9 0 29.7-1.7 43.8-4.7 19 14.6 42.6 23.3 68.2 23.3 61.8 0 112-50.2 112-112 .1-25.6-8.6-49.2-23.2-68.1zm-194.6 91.5c-65.6 0-120.5-29.2-120.5-65 0-16 9-30.6 29.5-30.6 31.2 0 34.1 44.9 88.1 44.9 25.7 0 42.3-11.4 42.3-26.3 0-18.7-16-21.6-42-28-62.5-15.4-117.8-22-117.8-87.2 0-59.2 58.6-81.1 109.1-81.1 55.1 0 110.8 21.9 110.8 55.4 0 16.9-11.4 31.8-30.3 31.8-28.3 0-29.2-33.5-75-33.5-25.7 0-42 7-42 22.5 0 19.8 20.8 21.8 69.1 33 41.4 9.3 90.7 26.8 90.7 77.6 0 59.1-57.1 86.5-112 86.5z"/></svg>
                    <div class="target-label"
                         v-if="!objBoolContacts.bool_show_skype"
                         @click="messageNotReceived('bool_show_skype')"
                    >
                        {{trans('details.contacts','show_skype')}}
                    </div>
                    <template v-else-if="objBoolContacts.bool_show_skype">
                        <div v-if="contact_list.skype !== null"
                             class="link-a"
                             @click="copyText($event.target,trans('details.contacts','skype_copied_clipboard'))"
                        >{{contact_list.skype}}</div>
                        <div v-else class="not-specified">
                            {{trans('details.contacts','not_specified')}}
                        </div>
                    </template>
                </li>

                <!-- phone -->
                <li class="contacts-line">
                    <svg class="svg-phone" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M304 0H80C44.65 0 16 28.65 16 64v384c0 35.35 28.65 64 64 64h224c35.35 0 64-28.65 64-64V64c0-35.35-28.7-64-64-64zm16 448c0 8.822-7.178 16-16 16H80c-8.82 0-16-7.2-16-16v-80h256v80zm0-128H64V64c0-8.822 7.178-16 16-16h224c8.8 0 16 7.18 16 16v256zM160 432h64c8.836 0 16-7.164 16-16s-7.164-16-16-16h-64c-8.836 0-16 7.164-16 16s7.2 16 16 16z"/></svg>
                    <div class="target-label"
                         v-if="!objBoolContacts.bool_show_phone"
                         @click="messageNotReceived('bool_show_phone')"
                    >
                        {{trans('details.contacts','show_number')}}
                    </div>
                    <template v-else-if="objBoolContacts.bool_show_phone">
                        <div v-if="contact_list.phone['phone'] !== null"
                           class="link-a"
                           @click="copyText($event.target,trans('details.contacts','number_copied_clipboard'))"
                        >{{contact_list.phone['phone'].replaceAll(/[(-)]/ig, ' ')}}</div>
                        <div v-else class="not-specified">
                            {{trans('details.contacts','not_specified')}}
                        </div>
                        <template v-for="(value, key) in contact_list.phone['messengers']">
                            <div class="box-message" v-if="settings.contact_information[value] == 'Telegram'">
                                <svg class="svg-telegram" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248,8C111.033,8,0,119.033,0,256S111.033,504,248,504,496,392.967,496,256,384.967,8,248,8ZM362.952,176.66c-3.732,39.215-19.881,134.378-28.1,178.3-3.476,18.584-10.322,24.816-16.948,25.425-14.4,1.326-25.338-9.517-39.287-18.661-21.827-14.308-34.158-23.215-55.346-37.177-24.485-16.135-8.612-25,5.342-39.5,3.652-3.793,67.107-61.51,68.335-66.746.153-.655.3-3.1-1.154-4.384s-3.59-.849-5.135-.5q-3.283.746-104.608,69.142-14.845,10.194-26.894,9.934c-8.855-.191-25.888-5.006-38.551-9.123-15.531-5.048-27.875-7.717-26.8-16.291q.84-6.7,18.45-13.7,108.446-47.248,144.628-62.3c68.872-28.647,83.183-33.623,92.511-33.789,2.052-.034,6.639.474,9.61,2.885a10.452,10.452,0,0,1,3.53,6.716A43.765,43.765,0,0,1,362.952,176.66Z"/></svg>
                            </div>
                            <div class="box-message" v-if="settings.contact_information[value] == 'Viber'">
                                <svg class="svg-viber"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M444 49.9C431.3 38.2 379.9.9 265.3.4c0 0-135.1-8.1-200.9 52.3C27.8 89.3 14.9 143 13.5 209.5c-1.4 66.5-3.1 191.1 117 224.9h.1l-.1 51.6s-.8 20.9 13 25.1c16.6 5.2 26.4-10.7 42.3-27.8 8.7-9.4 20.7-23.2 29.8-33.7 82.2 6.9 145.3-8.9 152.5-11.2 16.6-5.4 110.5-17.4 125.7-142 15.8-128.6-7.6-209.8-49.8-246.5zM457.9 287c-12.9 104-89 110.6-103 115.1-6 1.9-61.5 15.7-131.2 11.2 0 0-52 62.7-68.2 79-5.3 5.3-11.1 4.8-11-5.7 0-6.9.4-85.7.4-85.7-.1 0-.1 0 0 0-101.8-28.2-95.8-134.3-94.7-189.8 1.1-55.5 11.6-101 42.6-131.6 55.7-50.5 170.4-43 170.4-43 96.9.4 143.3 29.6 154.1 39.4 35.7 30.6 53.9 103.8 40.6 211.1zm-139-80.8c.4 8.6-12.5 9.2-12.9.6-1.1-22-11.4-32.7-32.6-33.9-8.6-.5-7.8-13.4.7-12.9 27.9 1.5 43.4 17.5 44.8 46.2zm20.3 11.3c1-42.4-25.5-75.6-75.8-79.3-8.5-.6-7.6-13.5.9-12.9 58 4.2 88.9 44.1 87.8 92.5-.1 8.6-13.1 8.2-12.9-.3zm47 13.4c.1 8.6-12.9 8.7-12.9.1-.6-81.5-54.9-125.9-120.8-126.4-8.5-.1-8.5-12.9 0-12.9 73.7.5 133 51.4 133.7 139.2zM374.9 329v.2c-10.8 19-31 40-51.8 33.3l-.2-.3c-21.1-5.9-70.8-31.5-102.2-56.5-16.2-12.8-31-27.9-42.4-42.4-10.3-12.9-20.7-28.2-30.8-46.6-21.3-38.5-26-55.7-26-55.7-6.7-20.8 14.2-41 33.3-51.8h.2c9.2-4.8 18-3.2 23.9 3.9 0 0 12.4 14.8 17.7 22.1 5 6.8 11.7 17.7 15.2 23.8 6.1 10.9 2.3 22-3.7 26.6l-12 9.6c-6.1 4.9-5.3 14-5.3 14s17.8 67.3 84.3 84.3c0 0 9.1.8 14-5.3l9.6-12c4.6-6 15.7-9.8 26.6-3.7 14.7 8.3 33.4 21.2 45.8 32.9 7 5.7 8.6 14.4 3.8 23.6z"/></svg>
                            </div>
                            <div class="box-message" v-if="settings.contact_information[value] == 'WhatsApp'">
                                <svg class="svg-whatsapp"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>
                            </div>
                        </template>
                    </template>
                </li>
            </ul>

        </div>

    </div>
</template>

<script>
    import translation from "../../mixins/translation";
    import general_functions_mixin from "../../mixins/general_functions_mixin";
    import response_methods_mixin from "../../mixins/response_methods_mixin";

    export default{
        mixins: [
            translation,
            general_functions_mixin,
            response_methods_mixin,
        ],
        data() {
            return {
                switch_contact: false,
                objBoolContacts: {
                    bool_show_phone: false,
                    bool_show_skype: false,
                    bool_show_email: false,
                },
            }
        },
        methods : {
            // переключение стиля card header
            changeCardStatus(e){
                this.switch_contact = !this.switch_contact
                let str_id = $(e.currentTarget).attr("data-id")
                let header_elem = $("#"+str_id)
                if (! header_elem.hasClass("card-header-active") ) {
                    header_elem.addClass( "card-header-active" )
                }
                else{
                    header_elem.removeClass( "card-header-active" )
                }
            },
            // скопировать в буфер
            copyText(el, message){
                this.copyToClipboard(el)
                this.message(message, 'success', 5000, false);
            },
            messageNotReceived(bool_element){
                // для не авторизованных
                if(!this.checkAuth(window.location)){
                    return false
                }

                if(!this.contact_list.access.received_respond){
                    this.message(this.trans('details.contacts','you_not_have_access') , 'success', 20000, true);
                }
                else{
                    // показать email или skype или phone
                    this.objBoolContacts[bool_element] = true
                }
            },
            openChat(){
                // для не авторизованных
                if(!this.checkAuth(window.location)){
                    return false
                }
                if(this.contact_list.offer_url === null){
                    this.message(this.trans('details.contacts','your_chat_exist'), 'success', 20000, true);
                }
                else{
                    window.open(this.lang.prefix_lang+this.contact_list.offer_url)
                }
            },
            checkAuth(url) {
                // не авторизован
                if(this.user == null){
                    this.reset_array(0)
                    $('#authModal').modal('toggle')
                    localStorage.setItem('url_click_no_auth', url)
                    return false
                }

                return true
            },
        },
        props: [
            'settings',
            'user',
            'lang',
            'contact_list',
        ],
        mounted() {
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .svg-comments{
        fill: #34662f;
    }
    .contacts-list{
        margin: 25px 0;
        box-shadow: none;
        background-color: #c8dadf;
        .contacts-header{
            color: #444;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1.25rem;
            background-color: rgba(32, 32, 32, 0.03);
            .h3-bg-teal{
                margin: 0;
                font-size: 16px;
            }
            .bg-teal{
                animation: flicker 1.5s infinite; /* Параметры анимации */
                background: none !important;
                &:active{
                    background: none !important;
                }
            }
            @keyframes flicker {
                from { border-color: #199d76; }
                to { border-color: #20c997; }
            }
        }

        .contacts-body{
            padding: 1.25rem;
            .box-image{
                display: flex;
                img{
                    margin-right: 10px;
                    width: 65px;
                    height: 80px;
                }
                .contacts-content{
                    .contacts-position{
                        font-weight: 300!important;
                    }
                }
            }
            .contacts-line{
                font-size: 14px;
                display: flex;
                align-items: center;
                margin-top: 10px;
                svg{
                    margin-right: 5px;
                    path {
                        fill: #6c757d;
                    }
                }
                .svg-phone{
                    width: 18px;
                }
                .svg-telegram path {
                    fill: #2197d0;
                }
                .svg-viber path {
                    fill: #754d94;
                }
                .svg-whatsapp path {
                    fill: #259a16;
                }
                .box-message svg{
                    width: 16px;
                    margin: 0 0 0 5px;
                }
            }
        }
    }
    .not-specified {
        font-style: italic;
        border-bottom: 1px dashed #444;
        font-size: 14px;
    }


</style>
