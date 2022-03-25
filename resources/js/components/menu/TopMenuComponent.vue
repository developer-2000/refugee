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
                <!-- Auth -->
                <li class="nav-item button-menu">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#authModal">
                        {{ trans('menu.top','authorization') }}
                    </a>
                </li>
                <!-- / Auth -->
            </ul>
        </nav>
        <!-- / top menu -->


        <!-- Modal -->
        <div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-labelledby="authModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="authModalTitle">Авторизация</h5>
<!--                        <button type="button" class="close" @click="visibleModal">-->
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!--                    <div class="modal-body">-->
                    <!--                        ...-->
                    <!--                    </div>-->
                    <!--                    <div class="modal-footer">-->
                    <!--                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
                    <!--                        <button type="button" class="btn btn-primary">Save changes</button>-->
                    <!--                    </div>-->
                    <!-- ТЕЛО В МОДАЛКЕ     ===============================  -->
                    <!-- динамически отображает компонент после клика кнопок -->
                    <component
                        :reset_p="reset_pass"
                        @reset_pass="func_reset_pass"
                        @login='reset_array'
                        v-bind:is="this.$store.getters.tpGetComponent"
                        class="tab"
                    ></component>
                    <!-- / ТЕЛО В МОДАЛКЕ =============================== -->
                </div>
            </div>
        </div>
        <!-- / Modal -->
    </div>

</template>

<script>
    import translation from '../../mixins/translation'

    import ImpAuth from '../auth/ExampleAuth.vue'
    // import ImpSign from '../auth/ExampleSign.vue'
    // import ImpResp from '../auth/ExampleResp.vue'
    // import ImpNewPass from '../auth/ExampleNewPass.vue'
    // import ImpSuccessSign from '../auth/ExampleSuccessSign.vue'

    export default {
        components: {
            'comAuth': ImpAuth,
            // 'comSign': ImpSign,
            // 'comResp': ImpResp,
            // 'comNewPass': ImpNewPass,
            // 'comSuccessSign': ImpSuccessSign,
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
        ],
        methods: {
            onlyNextLanguage: function () { // отбор не показанных языков
                for (var index in this.lang.lang) {
                    if (this.lang.lang[index]['avatar'] !== this.lang.avatar) {
                        // добавить только следущие языки
                        this.lang_sort.push(this.lang.lang[index])
                    }
                }
            },
            // выбор имени компонента
            reset_array: function (a) {

                // чилдрен присылает значение выбора компонента в масиве в виде обьекта
                this.$store.commit('tpSetComponent', (typeof a == 'object') ? a.num : a)

                if (typeof a !== 'object' && a !== 3) {
                    this.$store.commit('tpSetMenuVisi')
                }
            },
            func_reset_pass(value) {
                this.reset_pass = value;
            },
        },
        mounted() {
            this.onlyNextLanguage();
        },
    }
</script>

<style scoped>

</style>
