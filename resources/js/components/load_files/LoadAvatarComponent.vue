<template>
    <div class="load-logo">
        <!-- view avatar -->
        <img id="preload_img"
             :src="`/${avatar_url}`"
        >

        <div class="help-load-logo"
             @click="$refs.file_input.click()"
             v-show="bool_logo || avatar_url"
        >
            <div>{{description_text}}</div>
            <div class="update_logo">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M448 304H320v48h128c8.822 0 16 7.178 16 16v80c0 8.822-7.178 16-16 16H64c-8.822 0-16-7.178-16-16v-80c0-8.8 7.18-16 16-16h128v-48H64c-35.35 0-64 28.65-64 64v80c0 35.35 28.65 64 64 64h384c35.35 0 64-28.65 64-64v-80c0-35.3-28.7-64-64-64zM136.1 176.1 232 81.94V352c0 13.25 10.75 24 24 24s24-10.75 24-24V81.94l95.03 95.03C379.7 181.7 385.8 184 392 184s12.28-2.344 16.97-7.031c9.375-9.375 9.375-24.56 0-33.94l-136-136c-9.375-9.375-24.56-9.375-33.94 0l-136 136c-9.375 9.375-9.375 24.56 0 33.94s24.57 9.331 33.07-.869zM432 408c0-13.26-10.75-24-24-24s-24 10.7-24 24c0 13.25 10.75 24 24 24s24-10.7 24-24z"/></svg>
                {{update_avatar_text}}
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
                avatar_url: '',
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
                    this.$emit('load_avatar', { file: file })
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
            'update_avatar_url',
            'update_avatar_text',
            'description_text',
        ],
        watch: {
            update_avatar_url(val) {
                this.avatar_url = val
            },
        },
        mounted() {
            this.avatar_url = this.update_avatar_url === null ? '' : this.update_avatar_url
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .load-logo{
        display: flex;
        align-items: center;
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



</style>





























