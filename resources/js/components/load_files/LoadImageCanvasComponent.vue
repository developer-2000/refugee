<template>
    <div class="load-file">
        <!-- отображение image -->
        <div v-show="!bool_button_canvas"
             class="box-view-photo"
        >
            <!-- отображение image -->
            <img id="view-photo"
                 :src="`/${image_url}`"
            >
            <div class="help-load-logo"
                 @click="clickViewPhoto"
            >
                <div>{{description_text}}</div>
                <div class="update_logo">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M448 304H320v48h128c8.822 0 16 7.178 16 16v80c0 8.822-7.178 16-16 16H64c-8.822 0-16-7.178-16-16v-80c0-8.8 7.18-16 16-16h128v-48H64c-35.35 0-64 28.65-64 64v80c0 35.35 28.65 64 64 64h384c35.35 0 64-28.65 64-64v-80c0-35.3-28.7-64-64-64zM136.1 176.1 232 81.94V352c0 13.25 10.75 24 24 24s24-10.75 24-24V81.94l95.03 95.03C379.7 181.7 385.8 184 392 184s12.28-2.344 16.97-7.031c9.375-9.375 9.375-24.56 0-33.94l-136-136c-9.375-9.375-24.56-9.375-33.94 0l-136 136c-9.375 9.375-9.375 24.56 0 33.94s24.57 9.331 33.07-.869zM432 408c0-13.26-10.75-24-24-24s-24 10.7-24 24c0 13.25 10.75 24 24 24s24-10.7 24-24z"/></svg>
                    {{update_avatar_text}}
                </div>
            </div>
        </div>


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
                @returnName="setName"
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
            <!-- buttons -->
            <div class="box-button">
                <button class="btn btn-block btn-outline-danger" type="button"
                        @click="bool_button_canvas = false"
                >
                    Отменить
                </button>

                <button class="btn btn-block btn-outline-primary" type="button"
                        @click="confirmCanvas"
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
    import translation from "../../mixins/translation";

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
                    width: 0,
                    height: 0,
                    borderRadius: 0,
                    bool_scale: true,
                    bool_rotation: false,
                },
                bool_button_canvas: false,
                image_url: '',
                image_name: null,
            }
        },
        methods: {
            confirmCanvas() {
                // выбрать готовый canvas
                let img = this.$refs.vueavatar.getImageScaled();
                let canvas_base64 = img.toDataURL("image/png");
                // вернуть file
                this.$emit('parent', {
                    canvas: canvas_base64,
                    name: this.image_name
                });
                // показать image
                $('#view-photo').attr('src', canvas_base64)
                // спрятать canvas
                this.bool_button_canvas = false
            },
            onImageReady() {
                this.scale = this.optionsCanvas.scale
                this.rotation = this.optionsCanvas.rotation
            },
            // canvas подтвержден
            selectFile(bool) {
                this.bool_button_canvas = bool;
            },
            clickViewPhoto() {
                $('#file').click();
            },
            setName(name) {
                this.image_name = name
            },
        },
        props: [
            'url',
            'update_avatar_text',
            'description_text',
            'width',
            'height',
        ],
        watch: {
            url (val) {
                this.image_url = val;
            }
        },
        mounted() {
            this.image_url = this.url
            this.optionsCanvas.width = parseInt(this.width)
            this.optionsCanvas.height = parseInt(this.height)
            $('#view-photo').css({"width":this.width,"height":this.height})
        },

    }
</script>

<style lang="scss" scoped>

    .load-file{
        .box-view-photo{
            display: flex;
            align-items: center;
        }

        #preload_img {
            width: 120px;
            height: 150px;
        }
        .help-load-logo{
            background: whitesmoke;
            border-radius: 5px;
            padding: 14px 20px;
            margin-left: 15px;
            color: #495057;
            font-weight: 600;
            font-size: 14px;
            .update_logo{
                display: flex;
                flex-direction: row;
                flex-wrap: nowrap;
                justify-content: flex-start;
                align-content: flex-start;
                align-items: center;
                cursor: pointer;
                svg{
                    width: 14px;
                    margin-right: 8px;
                    path{
                        fill: #495057;
                    }
                }
                &:hover{
                    color: #1e5da1;
                    svg{
                        path{
                            fill: #1e5da1;
                        }
                    }
                }
            }
        }
    }
    .box-canvas{
        text-align: center;
        width: 320px;
        margin: 0 auto;
        .box-button{
            display: flex;
            margin: 15px 0;
            button:first-child{
                margin-right: 35px;
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

</style>
