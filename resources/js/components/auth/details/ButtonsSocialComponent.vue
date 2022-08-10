<template>
    <div class="soc">
        <!-- google -->
        <div @click="loginWithGoogle()" class="soc_google" data-network="google">
            <img src="//d1ayxb9ooonjts.cloudfront.net/8bc625062aeffa94729b9336243bed9d.svg">
        </div>
        <div @click="loginWithFacebook()" class="soc_facebook" data-network="facebook">
            <img src="//d1ayxb9ooonjts.cloudfront.net/0e5903c8a59540fefb8d56fe51863bb0.svg">
        </div>
        <div class="soc_twitter" data-network="twitter">
            <img src="//d3h5jhobc20ump.cloudfront.net/b8221293363ccb5ce7460067acbe55f5.svg">
        </div>
    </div>
</template>

<script>

    export default {
        data: function(){
            return {}
        },
        methods: {
            loginWithGoogle() {
                window.location.href = '/user/google/redirect'
            },
            loginWithFacebook() {
                window.location.href = '/user/facebook/redirect'
            },
        },
    }
</script>

<style scoped lang="scss">

    .soc {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: space-around;
        align-content: stretch;
        align-items: flex-start;
        width: 100%;
        .soc_google, .soc_facebook, .soc_twitter {
            border: 1px solid #4285F4;
            width: 90px;
            background-color: white;
            height: 40px;
            padding: 0;
            border-radius: 3px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }
        .soc_google, .soc_facebook, .soc_twitter {
            img{
                width: 20px;
            }
        }
        .soc_google:hover {
            border-color: #0d43c0;
            background-color: #f9f9f9;
        }
        .soc_facebook {
            border: 1px solid #3C5A99;
            &:hover {
                border-color: #28406a;
                background-color: #f9f9f9;
            }
        }
        .soc_twitter {
            border: 1px solid #16aae5;
            &:hover {
                border-color: #157aa4;
                background-color: #f9f9f9;
            }
        }
    }

</style>
