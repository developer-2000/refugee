<template>
    <div id="table_page">

        <!-- input для замены -->
        <div class="box-change-value">
            <input type="text" class="form-control input-change">
            <button type="button" class="btn btn-block btn-primary button-change">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"/></svg>
            </button>
        </div>

        <!-- Title -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            Переводы регионов
                        </h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">

                    <div class="col-12">
                        <div class="card">

                            <!-- header -->
                            <div class="card-header">
                                <!-- кнопки языков -->
                                <button v-for="(array, prefix) in response.lang_arr" :key="prefix"
                                        @click="transitionToLanguage('/admin-panel/translate-regions', prefix)"
                                        type="button" class="btn btn-block btn-flat"
                                        :class="{'btn-primary': prefix === response.translate_lang,'btn-outline-primary': prefix !== response.translate_lang}"
                                >
                                    {{response.lang_arr[prefix][3].title}}
                                </button>

                            </div>

                            <!-- body -->
                            <div class="row card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th class="col-sm-2">
                                            <!-- префиксы стран -->
                                            <div class="form-group">
                                                <select class="form-control" id="prefix_country"
                                                        @change="selectCountry($event, '/admin-panel/translate-regions')"
                                                >
                                                    <option selected :value="null"> Префиксы стран </option>
                                                    <template v-for="(value, key) in response.prefix_counties">
                                                        <!-- в случае обновления страницы -->
                                                        <option v-if="value == country" :value="value" :key="key" selected>
                                                            {{value}}
                                                        </option>
                                                        <option v-else :value="value" :key="key">
                                                            {{value}}
                                                        </option>
                                                    </template>
                                                </select>
                                            </div>
                                        </th>
                                        <th class="col-sm-2">error свойства перевода</th>
                                        <th class="col-sm-2">свойство локации</th>
                                        <th class="col-sm-2">свойство в переводе</th>
                                        <th class="col-sm-2">перевод</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(array, key) in regions.data" :key="key">
                                        <td>{{array.prefix}}</td>

                                        <td v-if="array.error_index !== undefined">
                                            <div v-for="(value, index) in array.error_index" :key="index" >
                                                {{value}}
                                            </div>
                                        </td>
                                        <td v-else></td>

                                        <td>{{array.original_index}}</td>
                                        <!-- свойство в переводе -->
                                        <td :id="`td-property-${key}`">
                                            <div :id="`div-property-${key}`">
                                                {{array.translate_index}}
                                                <svg @click="insertField(`property-${key}`, array.translate_index, array.prefix, 'property', array.translate_index)"
                                                     class="edit-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"/></svg>
                                            </div>
                                        </td>
                                        <!-- перевод -->
                                        <td :id="`td-translate-${key}`">
                                            <div v-if="array.original_index == array.translate_index"
                                                 :id="`div-translate-${key}`"
                                            >
                                                <span>{{array.translate}}</span>
                                                <svg @click="insertField(`translate-${key}`, array.translate, array.prefix, 'translate', array.translate)"
                                                     class="edit-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"/></svg>
                                                <!-- copy -->
                                                <svg @click="copyText($event, array.prefix)" class="svg-copy" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M64 464H288C296.8 464 304 456.8 304 448V384H352V448C352 483.3 323.3 512 288 512H64C28.65 512 0 483.3 0 448V224C0 188.7 28.65 160 64 160H128V208H64C55.16 208 48 215.2 48 224V448C48 456.8 55.16 464 64 464zM160 64C160 28.65 188.7 0 224 0H448C483.3 0 512 28.65 512 64V288C512 323.3 483.3 352 448 352H224C188.7 352 160 323.3 160 288V64zM224 304H448C456.8 304 464 296.8 464 288V64C464 55.16 456.8 48 448 48H224C215.2 48 208 55.16 208 64V288C208 296.8 215.2 304 224 304z"/></svg>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </section>

        <pagination
            v-if="regions.last_page > 1"
            :pagination="regions"
            @paginate="urlReload"
            :offset="1"
        >
        </pagination>

    </div>
</template>

<script>
    import general_functions_mixin from "../../../../mixins/general_functions_mixin";
    import response_methods_mixin from "../../../../mixins/response_methods_mixin";
    import admin_translate_location_mixin from "../../../../mixins/admin/admin_translate_location_mixin";
    import pagination from "../../../details/PaginationComponent";

    export default {
        mixins: [
            general_functions_mixin,
            response_methods_mixin,
            admin_translate_location_mixin
        ],
        components: {
            'pagination': pagination,
        },
        data() {
            return {
                regions: [],
            }
        },
        methods: {
            async updateDb(){
                let data = {
                    translate_lang: this.response.translate_lang,
                    value: this.objChangeElement.value,
                    country: this.objChangeElement.country,
                    row: this.objChangeElement.row, // property, translate
                    old_property: this.objChangeElement.old_property, // при смене property - старое значение
                    old_value: this.objChangeElement.old_value,       // при смене value - старое значение
                };
                const response = await this.$http.post(`/admin-panel/translate-regions/update`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            location.reload();
                        }
                    })
                    // ошибки сервера
                    .catch(err => {
                        // this.messageError(err)
                    })
            },
        },
        props: [
            'response',
        ],
        mounted() {
            this.input_box = $('.box-change-value').remove()
            this.regions = this.response.regions

            this.clickChangeButton()

            // Код, который будет запущен только после отрисовки всех представлений
            this.$nextTick(function () {
                this.setValuesFields()
            })
        },
    }
</script>

<style scoped lang="scss">

    .box-change-value{
        display: flex;
        width: 320px;
        margin: 0 auto;
        .input-change{
            border-radius: 4px 0 0 4px;
            font-size: 18px;
            height: 38px;
            padding-right: 30px;
        }
        .button-change{
            border-radius: 0 4px 4px 0;
            width: 50px;
            font-size: 18px;
            height: 38px;
            line-height: 0;
            svg{
                fill: white;
            }
        }
    }

</style>

