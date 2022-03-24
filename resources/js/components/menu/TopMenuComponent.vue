<template>
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
            <li class="nav-item dropdown language-li">
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
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                    <i class="fas fa-th-large"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- / top menu -->
</template>

<script>

    export default {
        data() {
            return {
                lang_sort: [],
            }
        },
        props: [
            'lang',   // масив названий и url языка
        ],
        // хук - после отрисовки , доступ к данным
        mounted() {
            this.onlyNextLanguage();
        },
        methods: {
            onlyNextLanguage: function () { // отбор не показанных языков
                for (var index in this.lang.lang) {
                    if (this.lang.lang[index]['avatar'] !== this.lang.avatar) {
                        // добавить только следущие языки
                        this.lang_sort.push(this.lang.lang[index])
                    }
                }
            },
            changeLanguage: function () {

            },
        },

    }
</script>

<style scoped>

</style>
