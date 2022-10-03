<template>
    <div id="auth" class="login-box">
        <!-- Авторизация -->
        <div class="card">

            <!-- Logo -->
            <div class="box-logo">
                <a href="/ru" class="brand-link">
                    <img alt="site logo" src="/img/custom/logo-site.gif">
                    <div class="box-logo-title">
                        <div class="brand-text font-weight-light">
                            {{this.logo_text.uk}}
                        </div>
                        <div class="brand-text font-weight-light">
                            {{this.logo_text.en}}
                        </div>
                    </div>
                </a>
            </div>





            <!-- form -->
            <div class="card-body login-card-body">
                <form action="#" @submit.prevent="signIn">
                    <!-- Email -->
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email"
                               v-model="email"
                        >
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <!-- Password -->
                    <div class="input-group mb-3">

                        <input type="password" class="form-control" placeholder="Password"
                               v-model="password"
                        >
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <!-- button -->
                    <button
                        type="submit"
                        class="btn btn-block"
                        :class="{'btn-default disabled': disableButton(), 'btn-flat btn-primary': !disableButton()}"
                    >
                        Авторизация
                    </button>

                </form>
            </div>

        </div>
    </div>
</template>

<script>

    import response_methods_mixin from "../../mixins/response_methods_mixin";

    export default {
        mixins: [
            response_methods_mixin,
        ],
        data() {
            return {
                email: '',
                password: '',
            }
        },
        props: [
            'logo_text',
        ],
        methods: {
            async signIn(){
                let data = {
                    email: this.email,
                    password: this.password,
                }
                const response = await this.$http.post(`/admin-panel/auth/sign-in`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            location.reload();
                        }
                        // custom ошибки
                        else{
                            // this.message(res.data.message, 'error', 10000, true);
                        }
                    })
                    // ошибки сервера
                    .catch(err => {
                        this.messageError(err)
                    })

            },
            disableButton() {
                if(!this.email.length || !this.password.length){
                    return true;
                }
                return false;
            },
        },
        mounted() { },
    }
</script>

<style scoped lang="scss">

    .brand-link {
        position: absolute!important;
        width: 100%!important;
        .box-logo-title div:nth-child(1) {
            color: rgba(253,230,45,1);
        }
        .box-logo-title div:nth-child(2) {
            color: rgba(0,123,255,1);
        }
    }
    #auth{
        margin: 10% auto 0px;
        cursor: default;
    }
    button{
        margin: 30px 0px 10px;
    }
    .box-logo {
        position: relative!important;
        width: 100%!important;
        height: 50px;
    }
    .box-logo:hover {
        color: #444;
        text-decoration: none;
    }
</style>
