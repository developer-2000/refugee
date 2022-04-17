<template>
    <div class="box-search">

        <!-- Location -->
        <div class="card card-primary">
            <!-- header -->
            <div class="card-header">
                <h3 class="card-title">Локация</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- body -->
            <div class="card-body">
                <!-- Country -->
                <div class="form-group">
                    <label for="country">
                        Страна поиска
                    </label>
                    <select class="form-control select2" id="country">
                        <option disabled="disabled" selected>
                            Выбрать
                        </option>
                        <template v-for="(array, key) in settings.obj_countries">
                            <option :value="array.code" :key="key">{{array.name}}</option>
                        </template>
                    </select>
                </div>
                <!-- Region -->
                <div class="form-group" v-if="objLocations.load_regions">
                    <label for="region">
                        Регион поиска
                    </label>
                    <select class="form-control select2" id="region"
                            @change="changeSelect($event.target.value, 'region')"
                    >
                        <option disabled="disabled" selected>
                            Выбрать
                        </option>
                        <template v-for="(array, key) in objLocations.load_regions">
                            <option :value="array.code" :key="key">{{array.name}}</option>
                        </template>
                    </select>
                </div>
                <!-- City -->
                <div class="form-group" v-if="objLocations.load_cities">
                    <label for="city">
                        Город поиска
                    </label>
                    <select class="form-control select2" id="city"
                            @change="changeSelect($event.target.value, 'city')"
                    >
                        <option disabled="disabled" selected>
                            Выбрать
                        </option>
                        <template v-for="(array, key) in objLocations.load_cities">
                            <option :value="array.code" :key="key">{{array.name}}</option>
                        </template>
                    </select>
                </div>
            </div>
        </div>

        <!-- Categories -->
        <div class="card card-primary">
            <!-- header -->
            <div class="card-header">
                <h3 class="card-title">Категории</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- body -->
            <div class="card-body">

                <div class="form-group">
                    <label for="categories">
                        Категории
                    </label>
                    <select class="form-control select2" id="categories" multiple="multiple" data-placeholder="Выбрать">
                        <template v-for="(value, index) in settings.categories">
                            <option :value="index" :key="index">{{value}}</option>
                        </template>
                    </select>
                </div>

            </div>
        </div>


<!--        <button type="button" @click="returnParent">Передать родителю</button>-->
    </div>
</template>

<script>
    import localisation_functions_mixin from '../../mixins/localisation_functions_mixin'
    import translation from '../../mixins/translation'
    import response_methods_mixin from "../../mixins/response_methods_mixin";

    export default {
        mixins: [
            localisation_functions_mixin,
            translation,
            response_methods_mixin,
        ],
        data() {
            return {

            }
        },
        methods: {
            returnParent() {
                this.$emit('returnParent', {
                    objLocations: this.objLocations,
                })
            }
        },
        props: [
            'settings'
        ],
        mounted() {

            // категории
            $('#categories').on('select2:select', (e) => {
                this.objCategory.categories.push(e.params.data.id);
            })
            $('#categories').on("select2:unselect", (e) => {
                // удалить этот елемент
                this.objCategory.categories.splice(this.objCategory.categories.indexOf(e.params.data.id), 1)
                // отключить раскрытие после удаления
                if (!e.params.originalEvent) {
                    return;
                }
                e.params.originalEvent.stopPropagation();
            });
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .card{
        width: 100%;
        border-radius: 3px 3px 0px 0px;
        border: none;
        border-bottom: 1px solid #ffdf9b;
        border-right: 1px solid #c0ddfb;
        box-shadow: none;
        .card-header{
            h3{
                margin: 2px 0 0 0;
            }
            button{
                margin: 0;
                padding: 0 5px 0 5px;
            }
        }
        .card-body{
            padding: 10px 12px 0;
        }

    }


</style>





























