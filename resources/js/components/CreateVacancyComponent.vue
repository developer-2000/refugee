<template>
    <div class="forms create-page">

        <b-button v-b-tooltip.hover title="Tooltip directive content">
            Hover Me
        </b-button>

        <b-button id="tooltip-target-1">
            Hover Me
        </b-button>
        <b-tooltip target="tooltip-target-1" triggers="hover">
            I am tooltip <b>component</b> content!
        </b-tooltip>




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
                        <input type="text" id="position" class="form-control" maxlength="100"
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
                        <label for="сity">Город вакансии
                            <span class="mandatory-filling">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                            </span>
                        </label>
                        <select class="form-control select2" id="сity">
                            <option disabled="disabled" selected>Выбрать город</option>
                            <option>California</option>
                            <option>Delaware</option>
                            <option>Tennessee</option>
                            <option>Texas</option>
                            <option>Washington</option>
                        </select>
                        <div class="invalid-feedback" v-if="this.address.сity == null"> Пожалуйста, выберите хотя бы одну категорию. </div>
                    </div>

                    <!-- Street_house -->
                    <div class="form-group">
                        <label for="street_house">
                            Улица дом вакансии
                            <span class="mandatory-filling">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                            </span>
                        </label>
                        <input type="text" id="street_house" class="form-control" maxlength="100"
                               :class="{'is-invalid': $v.street_house.$error}"
                               v-model="street_house"
                               @blur="$v.street_house.$touch()"
                        >
                        <div class="invalid-feedback" v-if="!$v.street_house.required"> Пожалуйста, выберите хотя бы одну категорию. </div>
                    </div>
                </div>

                <div class="col-sm-8">
                    <div class="form-group" :class="{'border_error': (!this.objCategory.categories.length && this.objCategory.boolChecked == true)}">
                        <!-- Categories -->
                        <div>
                            <label for="categories">
                                Категория размещения вакансии
                                <span class="mandatory-filling">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                            </span>
                            </label>
                            <div class="container-fluid collection-checkbox" id="categories">
                                <div class="row">
                                    <template v-for="(array) in this.objCategory.categoriesArray">
                                        <div class="col-xl">
                                            <div v-for="(value, key) in array" :key="key">
                                                <input @change="checkCategory" class="form-check-input" name="category"
                                                       :id="`category_${key}`"
                                                       type="checkbox"
                                                       :value="key"
                                                >
                                                <label :for="`category_${key}`">{{value}}</label>
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
            </div>

            <!-- второй row -->
            <div class="row">
                <!-- Vacancy suitable -->
                <div class="col-sm-4">
                    <div class="form-group" :class="{'border_error': (!this.objSuitable.suitable.length && this.objSuitable.boolSuitable == true)}">
                        <label for="vacancy_suitable">
                            Вакансия подходит для
                            <span class="mandatory-filling">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                            </span>
                        </label>
                        <div id="vacancy_suitable">
                            <div>
                                <input class="form-check-input" name="vacancy_suitable" type="checkbox"
                                       id="vacancy_suitable_2"
                                       @change="vacancySuitable"
                                       value="2"
                                >
                                <label for="vacancy_suitable_2">до 25 лет</label>
                            </div>
                            <div>
                                <input class="form-check-input" name="vacancy_suitable" type="checkbox"
                                       id="vacancy_suitable_3"
                                       @change="vacancySuitable"
                                       value="3"
                                >
                                <label for="vacancy_suitable_3">от 25 до 40 лет</label>
                            </div>
                            <div>
                                <input class="form-check-input" name="vacancy_suitable" type="checkbox"
                                       id="vacancy_suitable_4"
                                       @change="vacancySuitable"
                                       value="4"
                                >
                                <label for="vacancy_suitable_4">от 40 лет и старше</label>
                            </div>
                            <div>
                                <input class="form-check-input" name="vacancy_suitable" type="checkbox"
                                       id="vacancy_suitable_1"
                                       @change="vacancySuitable"
                                       value="1"
                                >
                                <label for="vacancy_suitable_1">это не имеет значения</label>
                            </div>
                            <div>
                                <input class="form-check-input" name="vacancy_suitable" type="checkbox"
                                       id="vacancy_suitable_5"
                                       @change="vacancySuitable"
                                       value="5"
                                >
                                <label for="vacancy_suitable_5">свой вариант</label>
                            </div>
                            <div
                                v-if="(this.objSuitable.suitable.indexOf('5') != -1)">
                                <label for="commentary_age">Комментарий к возрасту</label>
                                <input type="text" id="commentary_age" class="form-control" maxlength="100"
                                       v-model="objSuitable.commentary_age"
                                >
                            </div>
                        </div>
                        <div class="invalid-feedback" :class="{'is-invalid visible': (!this.objSuitable.suitable.length && this.objSuitable.boolSuitable == true)}">
                            Пожалуйста, выберите хотя бы одну категорию.
                        </div>
                    </div>
                </div>
                <!-- type_employment -->
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="type_employment"> Вид занятости  </label>
                        <div id="type_employment">
                            <div class="icheck-primary">
                                <input type="radio" id="radioPrimary1" name="type_employment" value="1"
                                       v-model="type_employment">
                                <label for="radioPrimary1">локально, полная занятость</label>
                            </div>
                            <div class="icheck-primary">
                                <input type="radio" id="radioPrimary2" name="type_employment" value="2"
                                       v-model="type_employment">
                                <label for="radioPrimary2">локально, не полная занятость</label>
                            </div>
                            <div class="icheck-primary">
                                <input type="radio" id="radioPrimary3" name="type_employment" value="3"
                                       v-model="type_employment">
                                <label for="radioPrimary3">удаленно, полная занятость</label>
                            </div>
                            <div class="icheck-primary">
                                <input type="radio" id="radioPrimary4" name="type_employment" value="4"
                                       v-model="type_employment">
                                <label for="radioPrimary4">удаленно, не полная занятость</label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- salary -->
                <div class="col-sm-4">
                    <div class="form-group" :class="{border_error: this.salary.switchSalary }">
                        <label for="salary_accordion">
                            Зарплата
                            <span class="mandatory-filling">
                            <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                        </span>
                        </label>
                        <div id="salary_accordion">
                            <div class="card">
                                <!-- radio -->
                                <div class="card-header" id="headingOne">
                                    <div class="line_select" data-toggle="collapse" data-target="#range" aria-expanded="true" aria-controls="collapseOne">
                                        <input type="radio" id="salary_but1" name="salary_but" value="1"
                                               v-model="salary.salary_but"
                                               @change="checkSalary"
                                        >
                                        <label for="salary_but1">Диапазон</label>
                                    </div>
                                </div>
                                <!-- number -->
                                <div id="range" class="collapse show" aria-labelledby="headingOne" data-parent="#salary_accordion">
                                    <div class="card-body">
                                        <input type="number" placeholder="от" id="range_from" min="0" max="100000000"
                                               v-model="salary.range_from"
                                               @change="checkSalary"
                                        >
                                        -
                                        <input type="number" placeholder="до" id="range_to" min="0" max="100000000"
                                               v-model="salary.range_to"
                                               @change="checkSalary"
                                        >
                                        евро в месяц
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <!-- radio -->
                                <div class="card-header" id="headingTwo">
                                    <div class="line_select" data-toggle="collapse" data-target="#one_value" aria-expanded="false" aria-controls="collapseTwo">
                                        <input type="radio" id="salary_but2" name="salary_but" value="2"
                                               v-model="salary.salary_but"
                                               @change="checkSalary"
                                        >
                                        <label for="salary_but2">Одно значение</label>
                                    </div>
                                </div>
                                <!-- number -->
                                <div id="one_value" class="collapse" aria-labelledby="headingTwo" data-parent="#salary_accordion">
                                    <div class="card-body">
                                        <input type="number" placeholder="сумма" id="one_value_sum" min="0" max="100000000"
                                               v-model="salary.one_value_sum"
                                               @change="checkSalary"
                                        >
                                        евро в месяц
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <!-- radio -->
                                <div class="card-header" id="headingThree">
                                    <div class="line_select" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        <input type="radio" id="salary_but3" name="salary_but" value="3"
                                               v-model="salary.salary_but"
                                               @change="checkSalary"
                                        >
                                        <label for="salary_but3">Не указывать</label>
                                    </div> (не рекомендуется)
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#salary_accordion">
                                    <div class="card-body">
                                        <div class="bg-warning color-palette">
                                            Чтобы получить больше откликов, укажите зарплату.
                                            Когда соискатели знают, какую зарплату вы предлагаете, они более осознанно откликаются на вакансии.
                                            Так вы быстрее найдете подходящего сотрудника.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <label for="payroll_comment"> Комментарий к зарплате </label>
                        <input type="text" id="payroll_comment" class="form-control" maxlength="100"
                               v-model="salary.payroll_comment"
                        >
                        <div class="invalid-feedback" :class="{'is-invalid visible': this.salary.switchSalary}">
                            Пожалуйста, выберите хотя бы одну категорию.
                        </div>
                    </div>
                </div>
            </div>

            <!-- третий row -->
            <div class="row">
                <!-- work experience -->
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="work_experience">Опыт работы </label>
                        <select class="form-control select2" id="work_experience">
                            <option value="" selected>готовы взять без опыта</option>
                            <option value="">от 1 года</option>
                            <option value="">от 2 лет</option>
                            <option value="">от 5 лет</option>
                        </select>
                    </div>
                </div>
                <!-- Education -->
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="education">Образование</label>
                        <select class="form-control select2" id="education">
                            <option value="" selected>не имеет значения</option>
                            <option value="66">высшее</option>
                            <option value="67">неоконченное высшее</option>
                            <option value="68">среднее специальное</option>
                            <option value="69">среднее</option>
                        </select>
                    </div>
                </div>
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
            </div>

            <!-- четвертый row -->
            <div class="row">
                <!-- Требования к кандидату -->
                <div class="col-sm-4">
                    <div class="form-group">
                        <label> Требования к кандидату </label>
                        <ckeditor id="requirements_candidate"
                                  v-model="objTextarea.requirements_candidate"
                                  :config="objTextarea.editorConfig"
                        ></ckeditor>
                    </div>
                </div>
                <!-- Условия работы -->
                <div class="col-sm-4">
                    <div class="form-group">
                        <label> Условия работы </label>
                        <ckeditor id="working_conditions"
                                  v-model="objTextarea.working_conditions"
                                  :config="objTextarea.editorConfig"
                        ></ckeditor>
                    </div>
                </div>
                <!-- Обязанности кандидата -->
                <div class="col-sm-4">
                    <div class="form-group">
                        <label> Обязанности кандидата </label>
                        <ckeditor id="candidate_responsibilities"
                                  v-model="objTextarea.candidate_responsibilities"
                                  :config="objTextarea.editorConfig"
                        ></ckeditor>
                    </div>
                </div>
            </div>

            <!-- пятый row -->
            <div class="row">
                <!-- Отображение в вакансии контактов работодателя -->
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>
                            Отображать в вакансии контакты работодателя
                        </label>
                        <div id="disp_emp_cont_vacancy">
                            <div>
                                <input class="form-check-input" name="disp_emp_cont_vacancy" type="checkbox"
                                       id="disp_emp_cont_vacancy_1"
                                       @change="displayingEmployers"
                                       value="1"
                                >
                                <label for="disp_emp_cont_vacancy_1">Email</label>
                            </div>
                            <div>
                                <input class="form-check-input" name="disp_emp_cont_vacancy" type="checkbox"
                                       id="disp_emp_cont_vacancy_2"
                                       @change="displayingEmployers"
                                       value="2"
                                >
                                <label for="disp_emp_cont_vacancy_2">Мобильный номер тел.</label>
                            </div>
                            <div>
                                <input class="form-check-input" name="disp_emp_cont_vacancy" type="checkbox"
                                       id="disp_emp_cont_vacancy_3"
                                       @change="displayingEmployers"
                                       value="3"
                                >
                                <label for="disp_emp_cont_vacancy_3">Telegram</label>
                            </div>
                            <div>
                                <input class="form-check-input" name="disp_emp_cont_vacancy" type="checkbox"
                                       id="disp_emp_cont_vacancy_4"
                                       @change="displayingEmployers"
                                       value="4"
                                >
                                <label for="disp_emp_cont_vacancy_4">Viber</label>
                            </div>
                            <div>
                                <input class="form-check-input" name="disp_emp_cont_vacancy" type="checkbox"
                                       id="disp_emp_cont_vacancy_5"
                                       @change="displayingEmployers"
                                       value="5"
                                >
                                <label for="disp_emp_cont_vacancy_5">WhatsApp</label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Как можно откликнуться -->
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="how_respond">Как можно откликнуться</label>
                        <div id="how_respond">
                            <div class="icheck-primary">
                                <input type="radio" id="how_respond_1" name="how_respond" value="1"
                                       v-model="how_respond">
                                <label for="how_respond_1">Резюме обязательно</label>
                            </div>
                            <div class="icheck-primary">
                                <input type="radio" id="how_respond_2" name="how_respond" value="2"
                                       v-model="how_respond">
                                <label for="how_respond_2">Можно и без резюме</label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Размещение вакансии -->
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="how_respond">Размещение вакансии</label>
                        <div id="job_posting">
                            <div class="icheck-primary">
                                <input type="radio" id="job_posting_1" name="job_posting" value="1"
                                       v-model="job_posting">
                                <label for="job_posting_1">Стандарт (Вакансия будет размещена на месяц)</label>
                            </div>
                            <div class="icheck-primary">
                                <input type="radio" id="job_posting_2" name="job_posting" value="2"
                                       v-model="job_posting">
                                <label for="job_posting_2">Скрытая (Вакансия будет скрыта от соискателей)</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- button -->
            <div class="row footer-form">
                <div class="col-sm-4 offset-4 but-box">
                    <button type="submit" class="btn btn-block btn-outline-danger">Отменить</button>
                    <button type="submit" class="btn btn-block btn-primary "
                            :class="{'disabled': disableButton($v)}"
                            :disabled="$v.$invalid"
                    >{{ trans('auth','authorization') }}</button>
                </div>
            </div>


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
                type_employment: 1,
                how_respond: 1,
                job_posting: 1,
                salary: {
                    salary_but: 1,
                    range_from: null,
                    range_to: null,
                    one_value_sum: null,
                    switchSalary: false,
                    payroll_comment: null,
                },
                address: {
                    country: null,
                    region: null,
                    city: null,
                },
                objCategory: {
                    categories: [],
                    categoriesArray: '',
                    boolChecked: false,
                },
                objSuitable: {
                    suitable: [],
                    suitableArray: '',
                    boolSuitable: false,
                    commentary_age: '',
                },
                objTextarea: {
                    candidate_responsibilities: '',
                    working_conditions: '',
                    requirements_candidate: '',
                    editorConfig: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList' ]
                        ],
                    },
                },
                objDisplayEmpContVacancy: {
                    contacts: [],
                    contactsArray: '',
                    boolDisplay: false,
                },
            }
        },
        methods: {
            displayingEmployers(){
                this.objDisplayEmpContVacancy.boolDisplay = true;
                let checked = document.querySelectorAll('[name="disp_emp_cont_vacancy"]:checked');
                let selected = [];
                for (let i=0; i<checked.length; i++) {
                    selected.push(checked[i].value);
                }
                this.objDisplayEmpContVacancy.contacts = selected;
                console.log(selected)
            },
            vacancySuitable(){
                this.objSuitable.boolSuitable = true;
                let checked = document.querySelectorAll('[name="vacancy_suitable"]:checked');
                let selected = [];
                for (let i=0; i<checked.length; i++) {
                    selected.push(checked[i].value);
                }
                this.objSuitable.suitable = selected;
                console.log(selected)
            },
            checkCategory(){
                this.objCategory.boolChecked = true;
                let checked = document.querySelectorAll('[name="category"]:checked');
                let selected = [];
                for (let i=0; i<checked.length; i++) {
                    selected.push(checked[i].value);
                }
                this.objCategory.categories = selected;
                console.log(selected)
            },
            createVacancy(){

            },
            // разбить масив категорий на несколько
            createArrayCategories(){
                let count = 15
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
                $('#сity').on('select2:select', (e) => {
                    this.address.сity = e.params.data.text
                    console.log(this.address.сity)
                })
                // город
                $('#search_city').on('select2:select', (e) => {
                    this.search_city = e.params.data.text
                    console.log(this.search_city)
                })

            },
            checkSalary() {
                // выровнять последнее число по первому если оно меньше
                if(this.checkingInteger(this.salary.range_from) && this.checkingInteger(this.salary.range_to)){
                    if(parseInt(this.salary.range_from) > parseInt(this.salary.range_to)){
                        this.salary.range_to = this.salary.range_from
                    }
                }
                // если выбран сектор а поля не заполнены
                if(
                    (this.salary.salary_but == 1 &&
                        ((!this.salary.range_from || this.salary.range_from == '') || (!this.salary.range_to || this.salary.range_to == ''))) ||
                    (this.salary.salary_but == 2 && (!this.salary.one_value_sum || this.salary.one_value_sum == ''))
                ){
                    console.log('true')
                    this.salary.switchSalary = true
                    return true;
                }
                console.log('false')
                this.salary.switchSalary = false
                return false;
            },
            disableButton(v) {
                if(
                    v.$invalid ||
                    !this.objCategory.categories.length ||
                    !this.objSuitable.suitable.length ||
                    this.checkSalary()
                ){
                    return true;
                }
                return false;
            },
            checkingInteger(value) {
                if(parseInt(value) >= 0){
                    return true;
                }
                return false;
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

    label{
        cursor: pointer;
    }
    .form-group{
        padding: 5px 10px 20px;
        background: $back-form-group;
        position: relative;
        .invalid-feedback{
            position: absolute;
            bottom: 2px;
        }
    }
    .collection-checkbox{
        padding: 0;
        margin-left: -8px;
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
    #salary_accordion{
        .card{
            border: none;
            margin: 0 0 9px;
            border-radius: 0;
            box-shadow: none;
            background: none;
            .card-header{
                background: none;
                border-radius: 0;
                padding: 0;
                border: none;
                button{
                    border-radius: 0;
                    width: 100%;
                    text-align: left;
                    padding: 0;
                }
            }
            .card-body{
                padding: 0;
            }
        }
    }
    .bg-warning{
        background: #ffefbf !important;
        padding: 10px 14px;
        border: 1px solid #a3baff;
        border-radius: 3px;
    }
    #range input:nth-child(2),
    #one_value input{
        margin-right: 7px;
    }
    .line_select{
        display: initial;
    }
</style>





























