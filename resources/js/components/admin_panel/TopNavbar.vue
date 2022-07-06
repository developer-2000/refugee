<template>
    <!-- Navbar -->
    <nav id="navbar" class="main-header navbar navbar-expand navbar-white navbar-light">

        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li id="left_salaska_button"
                @click="widthContent()"
                class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>


        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/admin-panel/auth/logout"
                >
                    Logout
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->
</template>

<script>

    export default {

        data() {
            return { }
        },
        methods: {
            widthContent() {

                let action = setInterval(function () {
                    let widFot = parseInt($('.main-footer').css('marginLeft')) + 16;
                    $('#app .block_content').css('marginLeft',widFot+'px');
                }, 50);

                setTimeout(() => {
                    clearInterval(action);
                }, 1000);

            },
        },
        props: [

        ],
        mounted() { },

    }
</script>

<style scoped>



</style>

