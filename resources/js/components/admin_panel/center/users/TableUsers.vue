<template>
    <div id="table_page">

        <!-- Title -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            Пользователи
                        </h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-12">
                        <div class="card">
                            <!-- header (buttons) -->
                            <div class="card-header">
                                <div class="left-card-header">
                                    <!-- сбросить все-->
                                    <a v-if="locationSearch !== ''"
                                       href="javascript:void(0)"
                                       @click="clearQuery()"
                                    > Сбросить фильтры </a>
                                </div>
                                <div class="right-card-header">
                                </div>
                            </div>

                            <!-- body -->
                            <div class="row card-body">

                                <!-- Table 1 -->
                                <table id="main-table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="col-sm-1">id</th>
                                            <th class="col-sm-3">auth email</th>
                                            <th class="col-sm-1">тип авторизации</th>
                                            <th class="col-sm-1">активация email</th>
                                            <th class="col-sm-1">наказание</th>
                                            <th class="col-sm-1">права</th>
                                            <th class="col-sm-2">создан</th>
                                            <th class="col-sm-2">меню</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- search tr -->
                                        <tr>
                                            <!-- user id -->
                                            <td>
                                                <div class="input-group input-group-sm search-tr-div">
                                                    <input type="text" class="form-control"
                                                           v-model="search_user_id"
                                                    >
                                                    <span class="input-group-append">
                                                        <button @click="searchUser()" type="button" class="btn btn-block btn-primary">
                                                            <svg class="svg-search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352c79.5 0 144-64.5 144-144s-64.5-144-144-144S64 128.5 64 208s64.5 144 144 144z"/></svg>
                                                        </button>
                                                    </span>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr v-if="users.data !== undefined" v-for="(user, key) in users.data" :key="key">

                                            <td class="table-placement" colspan="8">
                                                <div :id="`accordionExample_${key}`" class="accordion" >
                                                    <div class="card">

                                                        <!-- Table 2 -->
                                                        <table class="table-document" :id="`table-document_${key}`" :data-index="key">
                                                            <tr class="row">
                                                                <td class="col-sm-1">{{user.id}}</td>
                                                                <td class="col-sm-3">{{user.email}}</td>
                                                                <td class="col-sm-1" v-html="getTypeAuth(user)"></td>
                                                                <td class="col-sm-1">
                                                                    <svg :class="`small-dot ${getStatus(user.email_verified_at)}`" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M320 256c0 88.37-71.63 160-160 160S0 344.37 0 256 71.63 96 160 96s160 71.6 160 160z"/></svg>
                                                                </td>
                                                                <td class="col-sm-1">
                                                                    <svg :class="`small-dot ${getStatus(user.punished)}`" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M320 256c0 88.37-71.63 160-160 160S0 344.37 0 256 71.63 96 160 96s160 71.6 160 160z"/></svg>
                                                                </td>
                                                                <td class="col-sm-1"
                                                                    :class="{'warning-text': user.permission[0].name === 'user','success-text': user.permission[0].name === 'admin'}"
                                                                >
                                                                    {{user.permission[0].name}}
                                                                </td>
                                                                <td class="col-sm-2">{{getDateString(user.created_at)}}</td>
                                                                <!-- button menu -->
                                                                <td class="col-sm-2 box-button">
                                                                    <!-- Accordion Contact -->
                                                                    <a  :data-target="`#dataContact_${key}`"
                                                                        :aria-controls="`dataContact_${key}`"
                                                                        class="link-a" href="javascript:void(0)"
                                                                        data-toggle="collapse"  aria-expanded="true"
                                                                        @click="elementBorder(`table-document_${key}`)"
                                                                    >
                                                                        Инфо user
                                                                    </a>
                                                                    <!-- button active account -->
                                                                    <a v-if="user.punished === 0"
                                                                       @click="confirm(1, user.id, 'Заблокировать пользователя ?')"
                                                                       class="link-a" href="javascript:void(0)">
                                                                        Заблокировать
                                                                    </a>
                                                                    <a v-else
                                                                       @click="confirm(0, user.id, 'Разаблокировать пользователя ?')"
                                                                       class="link-a" href="javascript:void(0)">
                                                                        Разблокировать
                                                                    </a>
                                                                    <div>
                                                                        Компания
                                                                    </div>
                                                                    <a :href="`/admin-panel/vacancies?user_id=${user.id}`"
                                                                       class="link-a" target="_blank"
                                                                    >Вакансии</a>
                                                                    <div>
                                                                        Резюме
                                                                    </div>

                                                                </td>
                                                            </tr>
                                                        </table>

                                                        <!-- dataContact Accordion -->
                                                        <div :id="`dataContact_${key}`"
                                                             :aria-labelledby="`heading_${key}`"
                                                             :data-parent="`#accordionExample_${key}`"
                                                             class="collapse">
                                                            <div class="card-body">

                                                                <!-- Table 3 -->
                                                                <table class="table-contact" :id="`table-contact_${key}`">
                                                                    <thead>
                                                                    <tr class="row">
                                                                        <th class="col-sm-1">аватар</th>
                                                                        <th class="col-sm-2">имя</th>
                                                                        <th class="col-sm-2">должность</th>
                                                                        <th class="col-sm-2">контакт email</th>
                                                                        <th class="col-sm-1">skype</th>
                                                                        <th class="col-sm-2">phone</th>
                                                                        <th class="col-sm-2">месенджеры</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr class="row">
                                                                        <td class="col-sm-1">
                                                                            <img v-if="user.contact.avatar !== null"
                                                                                 :src="`/${user.contact.avatar.url}`"
                                                                                 class="img-fluid" >
                                                                            <span v-else>~</span>
                                                                        </td>
                                                                        <td class="col-sm-2">
                                                                            <template v-if="user.contact.full_name !== null && user.contact.full_name !== ' '">
                                                                                {{user.contact.full_name}}
                                                                            </template>
                                                                            <span v-else>~</span>
                                                                        </td>
                                                                        <td class="col-sm-2">
                                                                            <template v-if="user.contact.position !== null">
                                                                                {{user.contact.position.title}}
                                                                            </template>
                                                                            <span v-else>~</span>
                                                                        </td>
                                                                        <td class="col-sm-2">
                                                                            <template v-if="user.contact.email !== null">
                                                                                {{user.contact.email}}
                                                                            </template>
                                                                            <span v-else>~</span>
                                                                        </td>
                                                                        <td class="col-sm-1">
                                                                            <template v-if="user.contact.skype !== null">
                                                                                {{user.contact.skype}}
                                                                            </template>
                                                                            <span v-else>~</span>
                                                                        </td>
                                                                        <td class="col-sm-2">
                                                                            <template v-if="user.contact.phone !== null">
                                                                                {{user.contact.phone}}
                                                                            </template>
                                                                            <span v-else>~</span>
                                                                        </td>
                                                                        <td class="col-sm-2">

                                                                            <template v-if="user.contact.messengers != null"
                                                                                      v-for="(value, key) in user.contact.messengers"
                                                                            >
                                                                                <div class="box-message" v-if="response.contact_information[value] == 'Telegram'">
                                                                                    <svg class="svg-telegram" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248,8C111.033,8,0,119.033,0,256S111.033,504,248,504,496,392.967,496,256,384.967,8,248,8ZM362.952,176.66c-3.732,39.215-19.881,134.378-28.1,178.3-3.476,18.584-10.322,24.816-16.948,25.425-14.4,1.326-25.338-9.517-39.287-18.661-21.827-14.308-34.158-23.215-55.346-37.177-24.485-16.135-8.612-25,5.342-39.5,3.652-3.793,67.107-61.51,68.335-66.746.153-.655.3-3.1-1.154-4.384s-3.59-.849-5.135-.5q-3.283.746-104.608,69.142-14.845,10.194-26.894,9.934c-8.855-.191-25.888-5.006-38.551-9.123-15.531-5.048-27.875-7.717-26.8-16.291q.84-6.7,18.45-13.7,108.446-47.248,144.628-62.3c68.872-28.647,83.183-33.623,92.511-33.789,2.052-.034,6.639.474,9.61,2.885a10.452,10.452,0,0,1,3.53,6.716A43.765,43.765,0,0,1,362.952,176.66Z"/></svg>
                                                                                </div>
                                                                                <div class="box-message" v-if="response.contact_information[value] == 'Viber'">
                                                                                    <svg class="svg-viber"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M444 49.9C431.3 38.2 379.9.9 265.3.4c0 0-135.1-8.1-200.9 52.3C27.8 89.3 14.9 143 13.5 209.5c-1.4 66.5-3.1 191.1 117 224.9h.1l-.1 51.6s-.8 20.9 13 25.1c16.6 5.2 26.4-10.7 42.3-27.8 8.7-9.4 20.7-23.2 29.8-33.7 82.2 6.9 145.3-8.9 152.5-11.2 16.6-5.4 110.5-17.4 125.7-142 15.8-128.6-7.6-209.8-49.8-246.5zM457.9 287c-12.9 104-89 110.6-103 115.1-6 1.9-61.5 15.7-131.2 11.2 0 0-52 62.7-68.2 79-5.3 5.3-11.1 4.8-11-5.7 0-6.9.4-85.7.4-85.7-.1 0-.1 0 0 0-101.8-28.2-95.8-134.3-94.7-189.8 1.1-55.5 11.6-101 42.6-131.6 55.7-50.5 170.4-43 170.4-43 96.9.4 143.3 29.6 154.1 39.4 35.7 30.6 53.9 103.8 40.6 211.1zm-139-80.8c.4 8.6-12.5 9.2-12.9.6-1.1-22-11.4-32.7-32.6-33.9-8.6-.5-7.8-13.4.7-12.9 27.9 1.5 43.4 17.5 44.8 46.2zm20.3 11.3c1-42.4-25.5-75.6-75.8-79.3-8.5-.6-7.6-13.5.9-12.9 58 4.2 88.9 44.1 87.8 92.5-.1 8.6-13.1 8.2-12.9-.3zm47 13.4c.1 8.6-12.9 8.7-12.9.1-.6-81.5-54.9-125.9-120.8-126.4-8.5-.1-8.5-12.9 0-12.9 73.7.5 133 51.4 133.7 139.2zM374.9 329v.2c-10.8 19-31 40-51.8 33.3l-.2-.3c-21.1-5.9-70.8-31.5-102.2-56.5-16.2-12.8-31-27.9-42.4-42.4-10.3-12.9-20.7-28.2-30.8-46.6-21.3-38.5-26-55.7-26-55.7-6.7-20.8 14.2-41 33.3-51.8h.2c9.2-4.8 18-3.2 23.9 3.9 0 0 12.4 14.8 17.7 22.1 5 6.8 11.7 17.7 15.2 23.8 6.1 10.9 2.3 22-3.7 26.6l-12 9.6c-6.1 4.9-5.3 14-5.3 14s17.8 67.3 84.3 84.3c0 0 9.1.8 14-5.3l9.6-12c4.6-6 15.7-9.8 26.6-3.7 14.7 8.3 33.4 21.2 45.8 32.9 7 5.7 8.6 14.4 3.8 23.6z"/></svg>
                                                                                </div>
                                                                                <div class="box-message" v-if="response.contact_information[value] == 'WhatsApp'">
                                                                                    <svg class="svg-whatsapp"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>
                                                                                </div>
                                                                            </template>

                                                                            <span v-if="user.contact.messengers == null">~</span>

                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>

                                                                <!-- buttons -->
                                                                <div class="but-box">
                                                                    <button type="submit" class="btn btn-block btn-warning"
                                                                            @click="cancelDocument(`dataContact_${key}`)"
                                                                    >
                                                                        Свернуть
                                                                    </button>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>

                                <div v-if="users.data !== undefined && !users.data.length" class="image-not-found"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <pagination
            v-if="users.last_page > 1"
            :pagination="users"
            @paginate="urlReload"
            :offset="1"
        >
        </pagination>

        <confirm_component
            :lang="lang"
            ref="child_confirm"
            @confirm='respondConfirm'
        ></confirm_component>

    </div>
</template>

<script>
    import general_functions_mixin from "../../../../mixins/general_functions_mixin";
    import response_methods_mixin from "../../../../mixins/response_methods_mixin";
    import admin_translate_location_mixin from "../../../../mixins/admin/admin_translate_location_mixin";
    import pagination from "../../../details/PaginationComponent";
    import date_mixin from "../../../../mixins/date_mixin";
    import translation from "../../../../mixins/translation";
    import template_resume_vacancy_mixin from "../../../../mixins/template_resume_vacancy_mixin";
    import confirm_component from "../../../details/ConfirmComponent";

    export default {
        mixins: [
            translation,
            date_mixin,
            general_functions_mixin,
            response_methods_mixin,
            admin_translate_location_mixin,
            template_resume_vacancy_mixin
        ],
        components: {
            'pagination': pagination,
            'confirm_component': confirm_component
        },
        data() {
            return {
                settings: [],
                users: [],
                typeAuth: ["Social network", "Password"],
                cssAction: [
                    "active",
                    "not-active"
                ],
                user_id: [],
                punished: [],
                search_user_id: '',
                locationSearch: window.location.search,
            }
        },
        methods: {
            async setBlock(){
                let data = {
                    user_id: this.user_id,
                    punished: this.punished,
                };
                const response = await this.$http.post(`/admin-panel/users/set-punished`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            this.changeObj()
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
            // после проверки
            changeObj(){
                for(let i = 0; i < this.users.data.length; i++){
                    if(this.users.data[i].id === this.user_id){
                        this.users.data[i].punished = this.punished
                        break
                    }
                }
            },
            getTypeAuth(user){
                if(user.oauth_type !== null){
                    return this.typeAuth[0]
                }
                return this.typeAuth[1]
            },
            getStatus(value){
                if(value){
                    return this.cssAction[0]
                }
                return this.cssAction[1]
            },
            confirm(punished, user_id, quest){
                this.user_id = user_id
                this.punished = punished
                this.$refs.child_confirm.openModal({
                    title:"Блокировка пользователя",
                    text:quest,
                })
            },
            respondConfirm() {
                this.setBlock()
            },
            searchUser() {
                let params = new URLSearchParams(window.location.search)
                params.delete('user_id')
                this.search_user_id = parseInt(this.search_user_id)

                // categories
                if(this.search_user_id !== '' && Number.isInteger(this.search_user_id)){
                    params.set('user_id',this.search_user_id)
                }

                params.sort()
                let query = (params.toString() == '') ? '' : '?'+params.toString()

                location.href = window.location.pathname+query
            },
            clearQuery(){
                window.location.href = location.protocol + '//' + location.host + location.pathname
            },
            cancelDocument(id_name){
                $('#'+id_name).collapse('hide')
            },
            elementBorder(table_id){
                // убрать выдиление везде
                let arrTable = document.querySelectorAll(".target-border")
                for(let i = 0; i < arrTable.length; i++){
                    // parent table
                    arrTable[i].classList.remove('target-border')
                    // children table
                    let index = $(arrTable[i]).attr("data-index")
                    $("#table-contact_"+index).removeClass('target-border2')
                }

                // выдилить target table
                let targetTable = document.querySelector("#"+table_id)
                if(targetTable !== null){
                    targetTable.classList.add('target-border')

                    let index = $("#"+table_id).attr("data-index")
                    $("#table-contact_"+index).addClass('target-border2')
                }
            },
        },
        props: [
            'lang',
            'response',
        ],
        mounted() {
            this.users = this.response.users

            this.$nextTick(function () {})

            // console.log(this.response)
            console.log(this.users.data)
        },
    }
</script>

<style scoped lang="scss">

    .target-border{
        outline: 1px solid #3490dc;
        margin: 2px 1px;
    }
    .target-border2{
        border-top: 1px solid #3490dc;
        border-right: 1px solid #3490dc;
        border-left: 1px solid #3490dc;
    }
    #main-table{
        .card{
            border: none;
            box-shadow: none;
            border-radius: 0;
            margin: 0;
        }
        .table-placement{
            padding: 0;
        }
        .card-body{
            padding: 0!important;
        }
        table{
            td{
                border: 1px solid #dee2e6;
                padding: 0.75rem;
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                align-content: center;
            }
            .box-button{
                justify-content: flex-start;
                flex-direction: column;
            }
        }
        .but-box{
            display: flex;
            justify-content: center;
            padding: 35px 0;
            button{
                max-width: 160px;
                margin-right: 20px;
            }
        }
    }
    .row{
        margin: 0;
    }
    .small-dot{
        width: 12px;
    }
    .active{
        fill: #3d9970;
    }
    .not-active{
        fill: #dc3545;
    }
    .table-contact{
        width: 100%;
        margin: -2px 0 0;
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

</style>

