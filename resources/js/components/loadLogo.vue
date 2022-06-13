<template>
    <div>

<!--        loadLogo-->
<!--        <div :style="url_image('img/avatars/default/man.jpg')"-->
        <div @click="clickViewPhoto" id="view-photo"></div>

        <div v-show="bool_button_canvas"
             class="box-canvas"
        >
            <!-- компонент -->
            <canvas-functional
                :width=optionsCanvas.width
                :height=optionsCanvas.height
                :rotation=optionsCanvas.rotation
                :scale=optionsCanvas.scale
                :borderRadius=optionsCanvas.borderRadius
                ref="vueavatar"
                @vue-avatar-editor:image-ready="onImageReady"
                @parent="selectFile"
            >
            </canvas-functional>

            <!-- регуляторы -->
            <div class="control_logo">
                <div v-if="optionsCanvas.bool_scale" class="box-scale">
                    <label> {{optionsCanvas.scale}} : scale x <br>
                        <input type="range" min=1 max=3 step=0.02 v-model='optionsCanvas.scale' />
                    </label>
                </div>
                <div v-if="optionsCanvas.bool_rotation" class="box-rotation">
                    <label> {{optionsCanvas.rotation}} : rotation ° <br>
                        <input type="range" min=0 max=360 step=1 v-model='optionsCanvas.rotation' />
                    </label>
                </div>
            </div>

            <div class="box-button">
                <button class="btn btn-block btn-outline-warning" type="button"
                        @click="bool_button_canvas = false"
                >
                    Отменить
                </button>

                <button class="btn btn-block btn-outline-primary" type="button"
                        @click="saveClicked"
                        :disabled="!bool_button_canvas"
                >
                    Подтвердить
                </button>
            </div>
        </div>

    </div>
</template>

<script>

    import canvasFunctional from './CanvasFunctional.vue'
    import translation from "../mixins/translation";

    export default {
        mixins: [
            translation,
        ],
        components: {
            canvasFunctional,
        },
        data() {
            return {
                optionsCanvas: {
                    rotation: 0,
                    scale: 1,
                    width: 120,
                    height: 150,
                    borderRadius: 0,
                    bool_scale: true,
                    bool_rotation: false,
                },
                bool_button_canvas: false,
                image_url: '',
            }
        },
        methods: {
            saveClicked() {
                var img = this.$refs.vueavatar.getImageScaled();
                console.log(img)

                let canvas_base64 = img.toDataURL("image/png");

                console.log(canvas_base64)

                $('#view-photo').css('backgroundImage', `url("${canvas_base64}")`)

                this.bool_button_canvas = false

                // $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
                //
                // $.ajax({
                //     url     : '/cabinet/worker/profile/load_logo',
                //     type    : 'POST',
                //     contentType: 'application/x-www-form-urlencoded',
                //     data    : {
                //         convas: convas_base64,
                //         id: this.id
                //     },
                //     dataType: 'json',
                //     success : (resp) => {
                //         // добавить в масив загруженых файлов (puth созданного)
                //         if (resp.sms[0] == 1){
                //             this.filesFinish.push(resp.sms[1]);
                //             this.image_url = resp.sms[1];
                //             this.bool_select_file = false;
                //
                //             this.$store.dispatch('snacActivBar', {
                //                 'text': lang.get('worker_profile.f92'),
                //                 'color': 0,
                //                 'close': false,
                //             });
                //
                //         }
                //         if (resp.sms[0] == 0){
                //             this.$store.dispatch('snacActivBar', {
                //                 'text': resp.sms[1],
                //                 'color': 2,
                //                 'close': false,
                //             });
                //         }
                //     },
                //     error: function( error ) {
                //         console.log('error1', error)
                //     }
                // });


            },
            onImageReady() {
                this.scale = this.optionsCanvas.scale
                this.rotation = this.optionsCanvas.rotation
            },
            url_image(url) {
                if (url !== undefined){
                    url = url.replace(/\\/g,"/");
                    return 'background-image: url("/'+url+'")';
                }
            },
            // canvas подтвержден
            selectFile(val) {
                this.bool_button_canvas = val;
            },
            clickViewPhoto() {
                $('#file').click();
            },
        },
        props: [
            'url',
        ],
        watch: {
            url (val) {
                this.image_url = val;
            }
        },
        mounted() {
            this.image_url = this.url;
            if(this.image_url !== null){
                $('#view-photo').css('backgroundImage', `url("${this.image_url}")`)
            }
        },

    }
</script>


<style lang="scss" scoped>

    .box-canvas{
        text-align: center;
        .box-button{
            display: flex;
            button:first-child{
                margin-right: 10px;
            }
        }
    }
    .control_logo{
        text-align: center;
        margin-top: 25px;
    }
    .footer_modal button{
        width: 100%;
    }
    #view-photo{
        margin: 0px auto 15px;
        border: 2px solid #EBECEE;
        box-sizing: border-box;
        /*border-radius: 100px;*/
        width: 120px;
        height: 150px;
        cursor: pointer;
        background-size: cover;
        background-repeat: no-repeat;
    }
    #view-photo:hover{
        border: 2px dashed #AEAEAE;
    }
</style>
