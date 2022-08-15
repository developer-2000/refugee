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
            <svg class="svg-linkedin" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"/></svg>
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

    .svg-linkedin{
        fill:#0078d4;
    }
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
