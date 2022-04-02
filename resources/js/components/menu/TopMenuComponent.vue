<template>
    <div>
        <!-- top menu -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Menu -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
                <li class="nav-item dropdown nav-item d-none d-sm-inline-block">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                        Dropdown link
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Link 1</a>
                        <a class="dropdown-item" href="#">Link 2</a>
                        <a class="dropdown-item" href="#">Link 3</a>
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
                            <a :href="'/language/' + item.alias"
                               class="dropdown-item"
                            >
                                <img :src="item.avatar" class="lang_flag" alt="flag language">
                                {{item.title}}
                            </a>
                            <div class="dropdown-divider"></div>
                        </div>
                    </div>
                </li>
                <!-- / Language menu -->
                <!-- Sign in up -->
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
                <!-- / Sign in up -->
                <!-- Sign out -->
                <li class="nav-item button-menu button-auth"
                    v-else
                >
<!--                    <a class="nav-link" href="#">-->
                    <a class="nav-link" href="/user/logout">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M160 416H96c-17.67 0-32-14.33-32-32V128c0-17.67 14.33-32 32-32h64c17.67 0 32-14.33 32-32S177.7 32 160 32H96C42.98 32 0 74.98 0 128v256c0 53.02 42.98 96 96 96h64c17.67 0 32-14.33 32-32S177.7 416 160 416zM502.6 233.4l-128-128c-12.51-12.51-32.76-12.49-45.25 0c-12.5 12.5-12.5 32.75 0 45.25L402.8 224H192C174.3 224 160 238.3 160 256s14.31 32 32 32h210.8l-73.38 73.38c-12.5 12.5-12.5 32.75 0 45.25s32.75 12.5 45.25 0l128-128C515.1 266.1 515.1 245.9 502.6 233.4z"/>
                        </svg>
                    </a>
                </li>
                <!-- / Sign out -->
            </ul>
        </nav>
        <!-- / top menu -->

        <!-- Modal -->
        <div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-labelledby="authModalTitle" aria-hidden="true">
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
            'lang',   // масив названий и url языка
            'user',
            'code_change_password',
        ],
        methods: {
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
        },
        mounted() {
            this.onlyNextLanguage();
            this.openModalChangePassword();
        },
    }
</script>

<style scoped>

</style>
