<template>
    <div class="soc">
        <!-- google -->
        <div @click="loginWithGoogle()" class="soc_google" data-network="google">
            <img src="//d1ayxb9ooonjts.cloudfront.net/8bc625062aeffa94729b9336243bed9d.svg">
        </div>
        <!-- facebook -->
        <div @click="loginWithFacebook()" class="soc_facebook" data-network="facebook">
            <img src="//d1ayxb9ooonjts.cloudfront.net/0e5903c8a59540fefb8d56fe51863bb0.svg">
        </div>
        <!-- linkedin -->
        <div @click="loginWithLinkedin()" class="soc_linkedin" data-network="linkedin">
            <img src="/img/custom/linkedin_48_48.png">
        </div>
        <!-- twitter -->
<!--        <div @click="loginWithTwitter()" class="soc_twitter" data-network="twitter">-->
<!--            <img src="//d3h5jhobc20ump.cloudfront.net/b8221293363ccb5ce7460067acbe55f5.svg">-->
<!--        </div>-->

    </div>
</template>

<script>

    export default {
        data: function(){
            return {}
        },
        methods: {
            loginWithGoogle() {
                this.localstorageSave()
                window.location.href = '/user/google/redirect'
            },
            loginWithFacebook() {
                this.localstorageSave()
                window.location.href = '/user/facebook/redirect'
            },
            loginWithLinkedin() {
                this.localstorageSave()
                window.location.href = '/user/linkedin/redirect'
            },
            localstorageSave() {
                let value = localStorage.getItem('url_click_no_auth')
                if(value === null){
                    localStorage.setItem('url_click_no_auth', window.location.href)
                }
            },
        },
        mounted() {
            // console.log(window.location.href)

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
        .soc_google, .soc_facebook, .soc_twitter, .soc_linkedin {
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
        .soc_linkedin {
            img{
                width: 28px;
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
        .soc_linkedin {
            border: 1px solid #0a66c2;
            &:hover {
                border-color: #0478ec;
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
