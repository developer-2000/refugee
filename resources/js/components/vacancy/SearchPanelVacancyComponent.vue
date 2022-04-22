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

                <div class="form-group location-grope">
                    <!-- Country -->
                    <div class="box-div">
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
                    <div class="box-div" v-if="objLocations.load_regions">
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
                    <div v-if="objLocations.load_cities">
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
                    <select class="form-control select2" id="categories" multiple="multiple" data-placeholder="Выбрать">
                        <template v-for="(value, index) in settings.categories">
                            <option :value="index" :key="index">{{value}}</option>
                        </template>
                    </select>
                </div>
            </div>
        </div>

        <!-- Suitable -->
        <div class="card card-primary suitable">
            <!-- header -->
            <div class="card-header">
                <h3 class="card-title">Возраст соискателя</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- body -->
            <div class="card-body">

                <div class="form-group">
                    <!-- 1 -->
                    <div class="checkbox-box">
                        <input class="form-check-input" id="checkbox_suit" type="checkbox"
                               v-model="objCheckSuitable.check"
                        >
                        <label for="checkbox_suit" class="target-label">
                            установить возраст
                        </label>
                    </div>
                    <!-- 2 -->
                    <div class="box-suitable" v-if="objCheckSuitable.check">
                        <input :placeholder="`${trans('vacancies','from')}`"
                               max="100000000" min="0" type="number"
                               @blur="checkSuitable"
                               v-model="objCheckSuitable.suitable_from"
                        >
                        -
                        <input :placeholder="`${trans('vacancies','to')}`"
                               max="100000000" min="0" type="number"
                               @blur="checkSuitable"
                               v-model="objCheckSuitable.suitable_to"
                        >
                        лет
                    </div>
                </div>

            </div>
        </div>

        <!-- Employment -->
        <div class="card card-primary suitable">
            <!-- header -->
            <div class="card-header">
                <h3 class="card-title">Вид занятости</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- body -->
            <div class="card-body">
                <div class="form-group">
                    <select class="form-control" id="employment"
                            @change="changeSelect($event.target.value, 'employment')"
                    >
                        <option :value="null" selected>
                            Выбрать
                        </option>
                        <template v-for="(value, key) in settings.type_employment">
                            <option :value="key" :key="key">{{value}}</option>
                        </template>
                    </select>
                </div>
            </div>
        </div>

        <!-- Salary -->
        <div class="card card-primary salary">
            <!-- header -->
            <div class="card-header">
                <h3 class="card-title">
                    {{trans('vacancies','salary')}}
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- body -->
            <div class="card-body">
                <div class="form-group">
                    <!-- 1 -->
                    <div class="checkbox-box">
                        <input class="form-check-input" id="salary_checkbox" type="checkbox"
                               v-model="objSalary.salary_checkbox"
                        >
                        <label for="salary_checkbox" class="target-label">
                           c не указанной зарплатой
                        </label>
                    </div>
                    <!-- 2 -->
                    <label for="salary">
                        {{UpperCaseFirstCharacter(trans('vacancies','euro_per_month'))}}
                    </label>
                    <div class="box-suitable" id="salary">
                        <input :placeholder="`${trans('vacancies','from')}`"
                               type="number" min="0" max="100000000"
                               @blur="salaryLineToEmpty"
                               @change="salaryLineToEmpty"
                               v-model="objSalary.from"
                        >
                        -
                        <input :placeholder="`${trans('vacancies','to')}`"
                               max="100000000" min="0" type="number"
                               @blur="salaryLineToEmpty"
                               @change="salaryLineToEmpty"
                               v-model="objSalary.to"
                        >
                    </div>


                </div>
            </div>
        </div>

        <!-- Experience -->
        <div class="card card-primary suitable">
            <!-- header -->
            <div class="card-header">
                <h3 class="card-title">{{trans('vacancies','work_experience')}}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- body -->
            <div class="card-body">
                <div class="form-group">
                    <select class="form-control"
                            v-model="experience"
                    >
                        <option :value="null" selected>
                            Выбрать
                        </option>
                        <template v-for="(value, key) in this.settings.work_experience">
                            <option :value="`${key}`">
                                {{trans('vacancies',value)}}
                            </option>
                        </template>
                    </select>
                </div>
            </div>
        </div>

        <!-- Education -->
        <div class="card card-primary suitable">
            <!-- header -->
            <div class="card-header">
                <h3 class="card-title">{{trans('vacancies','education_1')}}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- body -->
            <div class="card-body">
                <div class="form-group">
                    <select class="form-control"
                            v-model="education"
                    >
                        <option :value="null" selected>
                            Выбрать
                        </option>
                        <template v-for="(value, key) in this.settings.education">
                            <option :value="`${key}`">
                                {{trans('vacancies',value)}}
                            </option>
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
                objSalary: {
                    from: null,
                    to: null,
                    salary_checkbox: false,
                },
                objCheckSuitable:{
                    check:false,
                    suitable_from: 18,
                    suitable_to: 60,
                },
                index_employment: null,
                experience: null,
                education: null,
            }
        },
        methods: {
            returnParent() {
                this.$emit('returnParent', {
                    objLocations: this.objLocations,
                })
            },
            checkSuitable() {
                if(!this.checkingInteger(this.objCheckSuitable.suitable_from)){
                    this.objCheckSuitable.suitable_from = 0
                }
                else if(!this.checkingInteger(this.objCheckSuitable.suitable_to)){
                    this.objCheckSuitable.suitable_to = 0
                }
            },
        },
        props: [
            'lang',   // масив названий и url языка
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

    .form-group{
        margin: 0 0 4px 0;
    }
    .card{
        width: 100%;
        border-radius: 3px 3px 0px 0px;
        border: none;
        /*border-bottom: 1px solid #ffdf9b;*/
        /*border-right: 1px solid #c0ddfb;*/
        box-shadow: none;
        .card-header{
            padding: 4px 13px;
            h3{
                margin: 2px 0 0 0;
            }
            button{
                margin: 0;
                padding: 0 10px 0 5px;
            }
        }
        .card-body{
            padding: 10px 12px 8px;
            border-left: 1px solid #c0ddfb;
            border-right: 1px solid #c0ddfb;
            border-bottom: 1px solid #c0ddfb;
        }
    }
    .suitable{
        .card-body{
            padding: 10px 12px 7px;
        }
        .box-suitable{
            margin-top: 5px;
        }
    }
    .checkbox-box {
        margin: 0;
        display: flex;
        label {
            cursor: pointer;
            margin: 0 0 0 6px;
        }
    }
    .box-div{
        margin-bottom: 10px;
    }
    .salary{
        .checkbox-box{
            margin-bottom: 10px;
        }
    }
    .target-label{
        color: $color-a-blue;
        font-weight: 500!important;
    }

</style>





























