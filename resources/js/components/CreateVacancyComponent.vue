<template>
    <div class="forms create-page">
        <h1 class="title_page card-body">Создать вакансию</h1>
        <form @submit.prevent="createVacancy" action="" method="post">

            <!-- первый row -->
            <div class="row">
                <div class="col-sm-4">
                    <!-- Position -->
                    <div class="form-group">
                        <label for="position">
                            Название должности
                            <span class="mandatory-filling">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                            </span>
                        </label>
                        <input type="text" id="position" class="form-control"
                               :class="{'is-invalid': $v.position.$error}"
                               v-model="position"
                               @blur="$v.position.$touch()"
                        >
                        <div class="invalid-feedback" v-if="!$v.position.required"> Пожалуйста, выберите хотя бы одну категорию. </div>
                    </div>

                    <!-- Country -->
                    <div class="form-group">
                        <label for="country">Страна вакансии
                            <span class="mandatory-filling">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                            </span>
                        </label>
                        <select class="form-control select2" id="country">
                            <option disabled="disabled" selected>Выбрать страну</option>
                            <option>California</option>
                            <option>Delaware</option>
                            <option>Tennessee</option>
                            <option>Texas</option>
                            <option>Washington</option>
                        </select>
                        <div class="invalid-feedback" v-if="this.address.country == null"> Пожалуйста, выберите хотя бы одну категорию. </div>
                    </div>

                    <!-- Region -->
                    <div class="form-group">
                        <label for="region">Регион вакансии
                            <span class="mandatory-filling">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                            </span>
                        </label>
                        <select class="form-control select2" id="region">
                            <option disabled="disabled" selected>Выбрать регион</option>
                            <option>California</option>
                            <option>Delaware</option>
                            <option>Tennessee</option>
                            <option>Texas</option>
                            <option>Washington</option>
                        </select>
                        <div class="invalid-feedback" v-if="this.address.region == null"> Пожалуйста, выберите хотя бы одну категорию. </div>
                    </div>

                    <!-- City -->
                    <div class="form-group">
                        <label for="sity">Город вакансии
                            <span class="mandatory-filling">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                            </span>
                        </label>
                        <select class="form-control select2" id="sity">
                            <option disabled="disabled" selected>Выбрать город</option>
                            <option>California</option>
                            <option>Delaware</option>
                            <option>Tennessee</option>
                            <option>Texas</option>
                            <option>Washington</option>
                        </select>
                        <div class="invalid-feedback" v-if="this.address.sity == null"> Пожалуйста, выберите хотя бы одну категорию. </div>
                    </div>

                    <!-- Street_house -->
                    <div class="form-group">
                        <label for="street_house">
                            Улица дом вакансии
                            <span class="mandatory-filling">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                            </span>
                        </label>
                        <input type="text" id="street_house" class="form-control"
                               :class="{'is-invalid': $v.street_house.$error}"
                               v-model="street_house"
                               @blur="$v.street_house.$touch()"
                        >
                        <div class="invalid-feedback" v-if="!$v.street_house.required"> Пожалуйста, выберите хотя бы одну категорию. </div>
                    </div>
                </div>

                <div class="form-group col-sm-8">
                    <!-- Categories -->
                    <div :class="{'border_error': (!this.objCategory.categories.length && this.objCategory.boolChecked == true)}">
                        <label for="categories">
                            Категория размещения вакансии
                            <span class="mandatory-filling">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                            </span>
                        </label>
                        <div class="container collection-checkbox" id="categories">
                            <div class="row">
                                <template v-for="(array) in this.objCategory.categoriesArray">
                                    <div class="col-xl">
                                        <div v-for="(value, key) in array" :key="key">
                                            <input @change="checkCategory" class="form-check-input" name="category"
                                                   type="checkbox"
                                                   :value="key"
                                            >
                                            <label class="form-check-label">{{value}}</label>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="invalid-feedback" :class="{'is-invalid visible': (!this.objCategory.categories.length && this.objCategory.boolChecked == true)}">
                        Пожалуйста, выберите хотя бы одну категорию.
                    </div>
                </div>
            </div>

            <!-- второй row -->
            <div class="row">
                <!-- Search city -->
                <div class="col-sm-4">
                    <div class="form-group">
                        <!-- 1 -->
                        <div class="checkbox-box">
                            <input class="form-check-input" id="checkbox_city" type="checkbox"
                                   v-model="checkbox_city"
                            >
                            <label for="checkbox_city">Искать кандидатов в другом городе</label>
                        </div>
                        <!-- 2 -->
                        <div class="search-city" v-show="checkbox_city" >
                            <label for="search_city">Город для поиска {{this.search_city}}</label>
                            <select class="form-control select2" id="search_city">
                                <option disabled="disabled" selected>Выбрать город поиска</option>
                                <option>California</option>
                                <option>Delaware</option>
                                <option>Tennessee</option>
                                <option>Texas</option>
                                <option>Washington</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- type_employment -->
                <div class="col-sm-4 form-group">
                    <label for="type_employment">
                        Вид занятости
                        <span class="mandatory-filling">
                            <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                        </span>
                    </label>
                    <div class="container collection-checkbox" id="type_employment">
                        <div class="icheck-primary">
                            <input type="radio" id="radioPrimary1" name="type_employment" value="1"
                                   v-model="type_employment">
                            <label for="radioPrimary1">локально, полная занятость</label>
                        </div>
                        <div class="icheck-primary">
                            <input type="radio" id="radioPrimary2" name="type_employment" value="2"
                                   v-model="type_employment">
                            <label for="radioPrimary2">локально, полная занятость 2</label>
                        </div>
                        <div class="icheck-primary">
                            <input type="radio" id="radioPrimary3" name="type_employment" value="3"
                                   v-model="type_employment">
                            <label for="radioPrimary3">локально, полная занятость 3</label>
                        </div>
                        <div class="icheck-primary">
                            <input type="radio" id="radioPrimary4" name="type_employment" value="4"
                                   v-model="type_employment">
                            <label for="radioPrimary4">локально, полная занятость 4</label>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit"
                    :class="{'btn btn-block btn-primary disabled': ($v.$invalid || !this.objCategory.categories.length), 'btn btn-block btn-primary btn-flat': (!$v.$invalid && this.objCategory.categories.length)}"
                    :disabled="$v.$invalid"
            >{{ trans('auth','authorization') }}</button>

        </form>
    </div>
</template>

<script>
    import {required} from 'vuelidate/lib/validators'
    import translation from '../mixins/translation'

    export default {
        mixins: [
            translation,
        ],
        data() {
            return {
                position: '',
                street_house: null,
                checkbox_city: false,
                search_city: null,
                type_employment: null,
                address: {
                    country: null,
                    region: null,
                    sity: null,
                },
                objCategory: {
                    categories: [],
                    categoriesArray: '',
                    boolChecked: false,
                },
            }
        },
        methods: {
            checkCategory(){
                this.objCategory.boolChecked = true;
                let checked = document.querySelectorAll('[name="category"]:checked');
                let selected = [];
                for (let i=0; i<checked.length; i++) {
                    selected.push(checked[i].value);
                }
                this.objCategory.categories = selected;
                // if(!this.objCategory.categories.length){
                //     $('.border_error').css('border','1px solid red')
                // }
                // else{
                //     $('.border_error').css('border','none')
                // }
                console.log(selected)
            },
            createVacancy(){

            },
            // разбить масив категорий на несколько
            createArrayCategories(){
                let count = 18
                let tick = 0
                this.objCategory.categoriesArray = [];
                this.settings.categories.forEach((value, index) => {
                    if((index % count) == 0){
                        this.objCategory.categoriesArray[tick] = [];
                        tick++
                    }
                    this.objCategory.categoriesArray[(tick-1)].push(value);
                });
                console.log(this.objCategory.categoriesArray)
            },
            initializationFunc() {
                this.createArrayCategories()
                // страна
                $('#country').on('select2:select', (e) => {
                    this.address.country = e.params.data.text
                    console.log(this.address.country)
                })
                // регион
                $('#region').on('select2:select', (e) => {
                    this.address.region = e.params.data.text
                    console.log(this.address.region)
                })
                // город
                $('#sity').on('select2:select', (e) => {
                    this.address.sity = e.params.data.text
                    console.log(this.address.sity)
                })
                // город
                $('#search_city').on('select2:select', (e) => {
                    this.search_city = e.params.data.text
                    console.log(this.search_city)
                })

            },
        },
        props: [
            'lang',   // масив названий и url языка
            'settings',
        ],
        mounted() {
            this.initializationFunc()
            // console.log(this.settings)
        },
        validations: {
            position: {
                required,
            },
            street_house: {
                required,
            },
            type_employment: {
                required,
            },
        }
    }
</script>

<style scoped lang="scss">
    @import "resources/sass/_variables";

    .form-group{
        padding: 3px 10px 20px;
        background: $back-form-group;
        position: relative;
        .invalid-feedback{
            position: absolute;
            bottom: 2px;
        }
    }
    .collection-checkbox{
        padding: 0px 25px 0 0;
    }
    .visible{
        display: block;
    }
    .search-city{
        margin-top: 18px;
    }
    .search-city > span{
        width: 100%!important;
    }
    .border_error{
        border:1px solid red;
    }
</style>
