<template>
    <div class="load-logo">
        <!-- view logo -->
        <div class="box-logo"
             v-show="!bool_logo"
             @click="$refs.file_input.click()"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M176 160c17.62 0 32-14.38 32-32s-14.38-32-32-32-32 14.38-32 32 14.4 32 32 32zm135.1-24.9c-2.1-4.4-7.1-7.1-12.4-7.1s-10.35 2.672-13.31 7.125L231.8 215.4l-12.2-16.8c-3-4.2-7.8-6.6-12.9-6.6s-9.9 2.4-13 6.6l-46.67 64a15.997 15.997 0 0 0-1.334 16.68C148.5 284.6 153.1 288 160 288h224c5.9 0 11.32-3.246 14.11-8.449a16.01 16.01 0 0 0-.795-16.43L311.1 135.1zM447.1.004h-384c-35.25 0-64 28.75-64 63.1v287.1c0 35.25 28.75 63.1 64 63.1h96v83.98c0 9.836 11.02 15.55 19.12 9.7l124.9-93.68h144c35.25 0 64-28.75 64-63.1V63.1C511.1 28.75 483.2.004 447.1.004zM464 352c0 8.75-7.25 16-16 16H288l-80 60v-60H64c-8.75 0-16-7.25-16-16V64c0-8.75 7.25-16 16-16h384c8.75 0 16 7.25 16 16v288z"/></svg>
            <span>200х100px в .jpg, .jpeg, .png</span>
        </div>

        <img id="preload_img" src="" v-show="bool_logo">

        <div class="help-load-logo"
             @click="$refs.file_input.click()"
             v-show="bool_logo"
        >
            <div>200х100px в .jpg, .jpeg, .png</div>
            <div class="update_logo">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M448 304H320v48h128c8.822 0 16 7.178 16 16v80c0 8.822-7.178 16-16 16H64c-8.822 0-16-7.178-16-16v-80c0-8.8 7.18-16 16-16h128v-48H64c-35.35 0-64 28.65-64 64v80c0 35.35 28.65 64 64 64h384c35.35 0 64-28.65 64-64v-80c0-35.3-28.7-64-64-64zM136.1 176.1 232 81.94V352c0 13.25 10.75 24 24 24s24-10.75 24-24V81.94l95.03 95.03C379.7 181.7 385.8 184 392 184s12.28-2.344 16.97-7.031c9.375-9.375 9.375-24.56 0-33.94l-136-136c-9.375-9.375-24.56-9.375-33.94 0l-136 136c-9.375 9.375-9.375 24.56 0 33.94s24.57 9.331 33.07-.869zM432 408c0-13.26-10.75-24-24-24s-24 10.7-24 24c0 13.25 10.75 24 24 24s24-10.7 24-24z"/></svg>
                Изменить логотип
            </div>
        </div>

        <input type="file" ref="file_input" @change="fileSelected" style="display:none;" />
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
                format_files: ['.jpg', '.jpeg', '.png'],
                bool_logo: false,
            }
        },
        methods: {
            fileSelected (e) {
                let file = document.querySelector('input[type=file]').files[0];
                file = this.filterDelete(file);

                if(file != ''){
                    let preview = document.querySelector('#preload_img');
                    let reader = new FileReader;
                    // url загруженного
                    reader.onload = function() {
                        preview.src = reader.result;
                    };

                    reader.readAsDataURL(file);
                    // отдать файл родителю
                    this.$emit('load_logotype', { file: file })
                    this.bool_logo = true
                }
            },
            // удалить если превышает 0.5 мб или не тот формат файла
            filterDelete(file) {
                let pol_mb = 524288;
                let name = file.name

                if (file.size > pol_mb){
                    file = ''
                    this.message('File ' + name + ' exceeded the allowable size 0.5 mb', 'error', 5000, false, true);
                }
                if (!this.hasExtension(name)) {
                    file = ''
                    this.message('File ' + name + ' unacceptable. allowed (.jpg, .jpeg, .png)', 'error', 5000, false, true);
                }

                return file
            },
            // проверка разширения у файла
            hasExtension(name) {
                return (new RegExp('(' + this.format_files.join('|').replace(/\./g, '\\.') + ')$')).test(name);
            },
        },
        props: [
            'lang',
        ],
        mounted() {
            // this.resizeableImage($('.resize-image'));
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .load-logo{
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: flex-start;
        align-content: flex-start;
        align-items: center;
        .box-logo{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 200px;
            height: 100px;
            border: 1px solid #ced4da;
            border-radius: 3px;
            background: white;
            cursor: pointer;
            svg{
                path{
                    fill: #495057;
                }
            }
            span{
                font-weight: 600;
                font-size: 12px;
                color: #495057;
            }
        }
        #preload_img {
            width: 200px;
            height: 100px;
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



</style>





























