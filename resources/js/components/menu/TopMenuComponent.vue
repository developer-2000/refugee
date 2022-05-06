<template>
    <div class="background-top-menu">
        <div class="container">
            <!-- top menu -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Menu -->
                <ul class="navbar-nav">
                    <!-- Logo -->
                    <li class="nav-item d-sm-inline-block">
                        <a :href="`${lang.prefix_lang}`" class="brand-link">
                            <img alt="" src="/img/custom/logo-site.gif">
                            <div class="box-logo-title">
                                <div class="brand-text font-weight-light">
                                    {{this.logo_text.uk}}
                                </div>
                                <div class="brand-text font-weight-light">
                                    {{this.logo_text.en}}
                                </div>
                            </div>
                        </a>
                    </li>
                    <!-- button open/close sidebar-->
                    <li id="left-sidebar" class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                            <i class="fas fa-bars"></i>
                        </a>
                    </li>
                    <!-- Menu -->
                    <li class="nav-item d-none d-sm-inline-block button-navbar">
                        <a href="index3.html" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block button-navbar">
                        <a href="#" class="nav-link">Contact</a>
                    </li>
                    <li class="nav-item dropdown nav-item d-none d-sm-inline-block button-navbar">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            Работа
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" @click.prevent="checkAuth(lang.prefix_lang+'private-office/vacancy/create')">Добавить вакансию</a>
                            <a class="dropdown-item" :href="`${lang.prefix_lang}vacancy`">Найти вакансию</a>
                            <a class="dropdown-item" href="#">Добавить резюме</a>
                            <a class="dropdown-item" href="#">Найти резюме</a>
                        </div>
                    </li>
                </ul>
                <!-- / Menu -->

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <!-- Language menu -->
                    <li class="nav-item dropdown button-menu">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <img :src="this.lang.avatar" class="lang_flag" alt="flag language">
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <div v-for="item in this.lang_sort" :key="item.title">
                                <a class="dropdown-item"
                                   :href="`${lang.prefix_lang}language/${item.alias}`"
                                >
                                    <img :src="item.avatar" class="lang_flag" alt="flag language">
                                    {{item.title}}
                                </a>
                                <div class="dropdown-divider"></div>
                            </div>
                        </div>
                    </li>
                    <!-- Authorization -->
                    <li class="nav-item button-menu button-auth"
                        v-if="!user"
                    >
                        <a class="nav-link" href="#" data-toggle="modal" data-target="#authModal"
                           @click.prevent="reset_array(0)"
                        > {{ trans('menu.top','authorization') }} </a>
                        <span>/</span>
                        <a class="nav-link" href="#" data-toggle="modal" data-target="#authModal"
                           @click.prevent="reset_array(1)"
                        > {{ trans('menu.top','registration') }} </a>
                    </li>

                    <!-- user menu -->
                    <li class="nav-item dropdown user-menu"
                        v-if="user"
                    >
                        <a class="nav-link user-avatar" data-toggle="dropdown" href="#">
                            <img v-if="user.path_avatar" :src="user.path_avatar" alt="">
                            <img v-else src="/img/avatars/man.jpg" alt="">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M310.6 246.6l-127.1 128C176.4 380.9 168.2 384 160 384s-16.38-3.125-22.63-9.375l-127.1-128C.2244 237.5-2.516 223.7 2.438 211.8S19.07 192 32 192h255.1c12.94 0 24.62 7.781 29.58 19.75S319.8 237.5 310.6 246.6z"/></svg>
                        </a>
                        <!-- dropdown -->
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <!-- Private office -->
                            <a class="dropdown-item"
                               :href="`${lang.prefix_lang}private-office`"
                            >
                                <span class="svg-cabinet">
                                    <svg viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><path d="m224 224c0-35.3 28.7-64 64-64s64 28.7 64 64-28.7 64-64 64-64-28.7-64-64zm-48 176c0-44.2 35.8-80 80-80h64c44.2 0 80 35.8 80 80 0 8.8-7.2 16-16 16h-192c-8.8 0-16-7.2-16-16zm288-258.1v-85.9c0-13.25 10.7-24.9 24-24.9s24 11.65 24 24.9v126.6l55.5 47.1c10.1 8.6 11.4 23.7 2.8 33.8s-23.7 11.4-33.8 2.8l-24.5-20.8v186.5c0 44.2-35.8 80-80 80h-288c-44.18 0-80-35.8-80-80v-186.5l-24.47 20.8c-10.11 8.6-25.25 7.3-33.83-2.8-8.576-10.1-7.334-25.2 2.773-33.8l264.03-224c8.9-7.6 22.1-7.6 31 0l160.5 136.2zm-320 322.1h288c17.7 0 32-14.3 32-32v-227.2l-176-149.33-176 149.33v227.2c0 17.7 14.3 32 32 32z"/></svg>
                                </span>
                                Личный кабинет
                            </a>
                            <!-- Logout -->
                            <a class="dropdown-item"
                               :href="`${lang.prefix_lang}user/logout`"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M160 416H96c-17.67 0-32-14.33-32-32V128c0-17.67 14.33-32 32-32h64c17.67 0 32-14.33 32-32S177.7 32 160 32H96C42.98 32 0 74.98 0 128v256c0 53.02 42.98 96 96 96h64c17.67 0 32-14.33 32-32S177.7 416 160 416zM502.6 233.4l-128-128c-12.51-12.51-32.76-12.49-45.25 0c-12.5 12.5-12.5 32.75 0 45.25L402.8 224H192C174.3 224 160 238.3 160 256s14.31 32 32 32h210.8l-73.38 73.38c-12.5 12.5-12.5 32.75 0 45.25s32.75 12.5 45.25 0l128-128C515.1 266.1 515.1 245.9 502.6 233.4z"/></svg>
                                Sign out
                            </a>
                        </div>
                    </li>

                </ul>
            </nav>
            <!-- / top menu -->
        </div>

        <!-- Modal -->
        <div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-labelledby="authModalTitle" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <!-- динамически отображает компонент после клика кнопок -->
                    <component
                        :reset_p="reset_pass"
                        :lang="lang"
                        :code_change_password="code_change_password"
                        @reset_pass="func_reset_pass"
                        @login='reset_array'
                        v-bind:is="this.$store.getters.tpGetComponent"
                        class="tab"
                    ></component>
                </div>
            </div>
        </div>
        <!-- / Modal -->
    </div>
</template>

<script>
    import translation_mixin from '../../mixins/translation'

    import ImpAuth from '../auth/ExampleAuth.vue'
    import ImpSign from '../auth/ExampleSign.vue'
    import ImpResp from '../auth/ExampleResp.vue'
    import ImpChangePassword from '../auth/ChangePassword.vue'

    export default {
        components: {
            'comAuth': ImpAuth,
            'comSign': ImpSign,
            'comResp': ImpResp,
            'comChangePassword': ImpChangePassword,
        },
        mixins: [
            translation_mixin,
        ],
        data() {
            return {
                lang_sort: [],
                reset_pass: true, // глобал для компонента ImpNewPass
            }
        },
        props: [
            'logo_text',
            'lang',   // масив названий и url языка
            'user',
            'code_change_password',
        ],
        methods: {
            deleteStorage: () => {
                localStorage.removeItem('url_click_no_auth')
            },
            // отбор названий не показанных языков
            onlyNextLanguage: function () {
                for (var index in this.lang.lang) {
                    if (this.lang.lang[index]['avatar'] !== this.lang.avatar) {
                        // добавить только следущие языки
                        this.lang_sort.push(this.lang.lang[index])
                    }
                }
            },
            // выбор имени компонента для динамик компонента
            reset_array: function (a) {
                // чилдрен присылает значение выбора компонента в масиве в виде обьекта
                this.$store.commit('tpSetComponent', (typeof a == 'object') ? a.num : a)
                // open/close modal
                if (typeof a !== 'object' && a !== 3) {
                    this.$store.commit('tpSetMenuVisi')
                }
            },
            func_reset_pass(value) {
                this.reset_pass = value;
            },
            openModalChangePassword() {
                if(this.code_change_password !== 0){
                    this.reset_array(3)
                    $('#authModal').modal('toggle')
                }
            },
            checkAuth(url) {
                // не авторизован
                if(this.user == null){
                    this.reset_array(0)
                    $('#authModal').modal('toggle')
                    localStorage.setItem('url_click_no_auth', url)
                }
                else{
                    location.href = url;
                }
            },
            urlTransitions() {
                let value = localStorage.getItem('url_click_no_auth')
                if(value !== null){
                    this.deleteStorage()
                    location.href = value;
                }
            },
            initializationFunc() {
                this.onlyNextLanguage()
                this.openModalChangePassword()
                this.urlTransitions()

                $('#authModal').on('hidden.bs.modal', (e) => {
                    this.deleteStorage()
                })
            },
        },
        mounted() {
            this.initializationFunc()
        },
    }
</script>

<style scoped lang="scss">
    @import "resources/sass/_variables";

    .background-top-menu{
        background-color: #fff;
        border-bottom: 1px solid #dee2e6;
    }
    .main-header {
        border: none;
    }
    .navbar {
        padding: 0.5rem 5px;
    }
    .dropdown-menu{
        padding: 0!important;
    }
    .dropdown-item{
        padding: 8px 10px;
        display: flex;
        align-items: center;
        svg{
            margin-right: 7px;
            path{
                fill: $svg-icon;
            }
        }
        .svg-cabinet svg{
            width: 25px;
            margin-left: -3px;
            margin-right: 5px;
        }
        img{
            margin-right: 7px;
        }
    }
    .user-menu{
        .user-avatar{
            display: flex;
            align-items: center;
            img{
                width:38px;
            }
            svg{
                width: 9px;
                margin-left: 4px;
                path{
                    fill: $svg-icon;
                }
            }
        }
        .dropdown-menu{
            width:auto;
        }
    }

</style>
