<template>
    <div class="box-drop-file" @dragover="dragover" @dragleave="dragleave" @drop="drop">

        <input type="file" id="file" ref="file" @change="onChange" />

        <!-- title box -->
        <label class="label-drop" @click="targetInputFile">
            <svg class="drop-icon" xmlns="http://www.w3.org/2000/svg" width="50" height="43" viewBox="0 0 50 43"><path d="M48.4 26.5c-.9 0-1.7.7-1.7 1.7v11.6h-43.3v-11.6c0-.9-.7-1.7-1.7-1.7s-1.7.7-1.7 1.7v13.2c0 .9.7 1.7 1.7 1.7h46.7c.9 0 1.7-.7 1.7-1.7v-13.2c0-1-.7-1.7-1.7-1.7zm-24.5 6.1c.3.3.8.5 1.2.5.4 0 .9-.2 1.2-.5l10-11.6c.7-.7.7-1.7 0-2.4s-1.7-.7-2.4 0l-7.1 8.3v-25.3c0-.9-.7-1.7-1.7-1.7s-1.7.7-1.7 1.7v25.3l-7.1-8.3c-.7-.7-1.7-.7-2.4 0s-.7 1.7 0 2.4l10 11.6z"></path></svg>
            <div v-if="!this.filelist.length">
                Выбрать файл или перенести его сюда.
                <i class="description-drop">
                    Файлы .pdf, .docx, .doc, .txt до 2 Mb
                </i>
            </div>
            <!-- name file -->
            <ul v-else class="mt-4">
                <li class="text-sm p-1" v-for="file in filelist">
                    {{file.name}}
                    <svg @click="clearArrFiles($event, filelist.indexOf(file))"
                         class="xmark-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                    ><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256 7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256l118.2 119z"/></svg>
                </li>
            </ul>
        </label>

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
                filelist: [],
                format_files: ['.pdf', '.docx', '.doc', '.txt'],
            }
        },
        methods: {
            load_resume() {
                this.$emit('load_resume', this.filelist)
            },
            dragover(event) {
                event.preventDefault();
            },
            dragleave(event) { },
            drop(event) {
                event.preventDefault();
                this.$refs.file.files = event.dataTransfer.files;
                this.onChange();
            },
            onChange() {
                this.filelist = [this.$refs.file.files[0]];
                this.filelist = this.filterDelete(this.filelist);
                this.load_resume()
            },
            // удалить если превышает 2 Мб или не тот формат файла
            filterDelete(file) {
                let pol_mb = 2097152;
                let name = file[0].name

                if (file[0].size > pol_mb){
                    file = []
                    this.message('File ' + name + ' exceeded the allowable size 2 Mb', 'error', 5000, false, true);
                }
                if (!this.hasExtension(name)) {
                    file = []
                    this.message('File ' + name + ' unacceptable. allowed (pdf, docx, doc, txt)', 'error', 5000, false, true);
                }
                return file
            },
            // проверка разширения у файла
            hasExtension(name) {
                return (new RegExp('(' + this.format_files.join('|').replace(/\./g, '\\.') + ')$')).test(name);
            },
            // выборка файла с hdd
            targetInputFile() {
                $('#file').click()
            },
            clearArrFiles(e, i) {
                this.filelist.splice(i, 1);
                this.load_resume()
                e.stopPropagation()
            },
        },
        props: [
            'arr_files',
        ],
        mounted() {
            this.filelist = this.arr_files
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .box-drop-file {
        outline: 2px dashed #92b0b3;
        outline-offset: -10px;
        font-size: 14px;
        background-color: #c8dadf;
        position: relative;
        width: 400px;
        height: 200px;
        transition: outline-offset .15s ease-in-out, background-color .15s linear;
        #file {
            display: none;
        }
        .label-drop{
            width: 100%;
            text-align: center;
            padding: 35px 20px 0;
            color: #1d68a7;
            .drop-icon{
                width: 100%;
                height: 30px;
                fill: #92b0b3;
                display: block;
                margin-bottom: 20px;
            }
            .xmark-icon{
                fill: red;
                width: 13px;
                margin-left: 5px;
                cursor: pointer;
            }
        }
        .description-drop{
            width: 100%;
            text-align: center;
            display: block;
            color: #5a6d6f;
            font-weight: 300;
        }
    }


</style>





























