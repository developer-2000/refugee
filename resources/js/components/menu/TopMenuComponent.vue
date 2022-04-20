<template>
    <div>
        <!-- top menu -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Menu -->
            <ul class="navbar-nav">
                <!-- Logo -->
                <li class="nav-item d-sm-inline-block">
                    <a :href="`${lang.prefix_lang}`" class="brand-link">
                        <span class="brand-text font-weight-light">
                            {{this.logo_text.uk}}
                        </span>
                        <span class="brand-text font-weight-light">
                            {{this.logo_text.en}}
                        </span>
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
                        <a class="dropdown-item" href="#" @click.prevent="checkAuth(lang.prefix_lang+'vacancy/create')">Добавить вакансию</a>
                        <a class="dropdown-item" :href="`${lang.prefix_lang}job-search`">Найти вакансию</a>
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
                            <a class="dropdown-item"
                               :href="`${lang.prefix_lang}vacancy/my-vacancies`"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M320 336c0 8.844-7.156 16-16 16h-96C199.2 352 192 344.8 192 336V288H0v144C0 457.6 22.41 480 48 480h416c25.59 0 48-22.41 48-48V288h-192V336zM464 96H384V48C384 22.41 361.6 0 336 0h-160C150.4 0 128 22.41 128 48V96H48C22.41 96 0 118.4 0 144V256h512V144C512 118.4 489.6 96 464 96zM336 96h-160V48h160V96z"/></svg>
                                Мои вакансии
                            </a>
                            <a href="#" class="dropdown-item">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M286.3 155.1C287.4 161.9 288 168.9 288 175.1C288 183.1 287.4 190.1 286.3 196.9L308.5 216.7C315.5 223 318.4 232.1 314.7 241.7C312.4 246.1 309.9 252.2 307.1 257.2L304 262.6C300.1 267.6 297.7 272.4 294.2 277.1C288.5 284.7 278.5 287.2 269.5 284.2L241.2 274.9C230.5 283.8 218.3 290.9 205 295.9L198.1 324.9C197 334.2 189.8 341.6 180.4 342.8C173.7 343.6 166.9 344 160 344C153.1 344 146.3 343.6 139.6 342.8C130.2 341.6 122.1 334.2 121 324.9L114.1 295.9C101.7 290.9 89.5 283.8 78.75 274.9L50.53 284.2C41.54 287.2 31.52 284.7 25.82 277.1C22.28 272.4 18.98 267.5 15.94 262.5L12.92 257.2C10.13 252.2 7.592 247 5.324 241.7C1.62 232.1 4.458 223 11.52 216.7L33.7 196.9C32.58 190.1 31.1 183.1 31.1 175.1C31.1 168.9 32.58 161.9 33.7 155.1L11.52 135.3C4.458 128.1 1.62 119 5.324 110.3C7.592 104.1 10.13 99.79 12.91 94.76L15.95 89.51C18.98 84.46 22.28 79.58 25.82 74.89C31.52 67.34 41.54 64.83 50.53 67.79L78.75 77.09C89.5 68.25 101.7 61.13 114.1 56.15L121 27.08C122.1 17.8 130.2 10.37 139.6 9.231C146.3 8.418 153.1 8 160 8C166.9 8 173.7 8.418 180.4 9.23C189.8 10.37 197 17.8 198.1 27.08L205 56.15C218.3 61.13 230.5 68.25 241.2 77.09L269.5 67.79C278.5 64.83 288.5 67.34 294.2 74.89C297.7 79.56 300.1 84.42 304 89.44L307.1 94.83C309.9 99.84 312.4 105 314.7 110.3C318.4 119 315.5 128.1 308.5 135.3L286.3 155.1zM160 127.1C133.5 127.1 112 149.5 112 175.1C112 202.5 133.5 223.1 160 223.1C186.5 223.1 208 202.5 208 175.1C208 149.5 186.5 127.1 160 127.1zM484.9 478.3C478.1 479.4 471.1 480 464 480C456.9 480 449.9 479.4 443.1 478.3L423.3 500.5C416.1 507.5 407 510.4 398.3 506.7C393 504.4 387.8 501.9 382.8 499.1L377.4 496C372.4 492.1 367.6 489.7 362.9 486.2C355.3 480.5 352.8 470.5 355.8 461.5L365.1 433.2C356.2 422.5 349.1 410.3 344.1 397L315.1 390.1C305.8 389 298.4 381.8 297.2 372.4C296.4 365.7 296 358.9 296 352C296 345.1 296.4 338.3 297.2 331.6C298.4 322.2 305.8 314.1 315.1 313L344.1 306.1C349.1 293.7 356.2 281.5 365.1 270.8L355.8 242.5C352.8 233.5 355.3 223.5 362.9 217.8C367.6 214.3 372.5 210.1 377.5 207.9L382.8 204.9C387.8 202.1 392.1 199.6 398.3 197.3C407 193.6 416.1 196.5 423.3 203.5L443.1 225.7C449.9 224.6 456.9 224 464 224C471.1 224 478.1 224.6 484.9 225.7L504.7 203.5C511 196.5 520.1 193.6 529.7 197.3C535 199.6 540.2 202.1 545.2 204.9L550.5 207.9C555.5 210.1 560.4 214.3 565.1 217.8C572.7 223.5 575.2 233.5 572.2 242.5L562.9 270.8C571.8 281.5 578.9 293.7 583.9 306.1L612.9 313C622.2 314.1 629.6 322.2 630.8 331.6C631.6 338.3 632 345.1 632 352C632 358.9 631.6 365.7 630.8 372.4C629.6 381.8 622.2 389 612.9 390.1L583.9 397C578.9 410.3 571.8 422.5 562.9 433.2L572.2 461.5C575.2 470.5 572.7 480.5 565.1 486.2C560.4 489.7 555.6 492.1 550.6 496L545.2 499.1C540.2 501.9 534.1 504.4 529.7 506.7C520.1 510.4 511 507.5 504.7 500.5L484.9 478.3zM512 352C512 325.5 490.5 304 464 304C437.5 304 416 325.5 416 352C416 378.5 437.5 400 464 400C490.5 400 512 378.5 512 352z"/></svg>
                                Настройки
                            </a>
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
    import translation from '../../mixins/translation'

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
            translation
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
    .dropdown-menu{
        padding: 0!important;
    }
    .dropdown-item{
        padding: 8px 10px;
        display: flex;
        svg{
            margin-right: 7px;
            path{
                fill: $svg-icon;
            }
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

    /*min-width: 175px;*/

</style>
