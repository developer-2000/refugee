<template>
    <div class="forms box-page">
        <!-- обратная ссылка -->
        <div class="top-panel bread-top-cabinet">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="m166.5 424.5-143.1-152a23.94 23.94 0 0 1-6.562-16.5 23.94 23.94 0 0 1 6.562-16.5l143.1-152c9.125-9.625 24.31-10.03 33.93-.938 9.688 9.126 10.03 24.38.938 33.94l-128.4 135.5 128.4 135.5c9.094 9.562 8.75 24.75-.938 33.94-9.53 9.058-24.73 8.658-33.93-.942z"/></svg>
            <a :href="`${lang.prefix_lang}private-office/resume/my-resumes`">
                Мои резюме
            </a>
            <span class="bread-slash"> | </span>
        </div>
        <!-- title -->
        <h1 v-if="resume_id == null" class="title_page card-body">
            Создать резюме
        </h1>
        <h1 v-else class="title_page card-body">
            Редактровать резюме
        </h1>

        <form action="" method="post">

            <!-- первый row -->
            <div class="row">
                <div class="col-sm-4 one-one-box">

                    <!-- Position -->
                    <div class="form-group">
                        <label for="position">
                            {{trans('vacancies','job_name')}}
                            <span class="mandatory-filling">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                            </span>
                            <span class="info-tooltip" data-toggle="tooltip" data-trigger="click"
                                  :title="`${trans('vacancies','title_position')}`"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464zM256 336c-18 0-32 14-32 32s13.1 32 32 32c17.1 0 32-14 32-32S273.1 336 256 336zM289.1 128h-51.1C199 128 168 159 168 198c0 13 11 24 24 24s24-11 24-24C216 186 225.1 176 237.1 176h51.1C301.1 176 312 186 312 198c0 8-4 14.1-11 18.1L244 251C236 256 232 264 232 272V288c0 13 11 24 24 24S280 301 280 288V286l45.1-28c21-13 34-36 34-60C360 159 329 128 289.1 128z"/></svg>
                            </span>
                        </label>
                        <input type="text" id="position" class="form-control" maxlength="100" autocomplete="off"
                               :placeholder="`${trans('vacancies','example_hairdresser')}`"
                               :class="{'is-invalid': $v.position.$error}"
                               v-model="position"
                               @blur="$v.position.$touch()"
                               @keyup="searchPosition($event.target.value)"
                        >
                        <div class="block_position_list">
                            <div class="dropdown-menu" id="position_list">
                                <div class="dropdown-item"
                                     v-for="(value, key) in position_list" :key="key"
                                     @click="setValuePosition(value)"
                                >
                                    {{value}}
                                </div>
                            </div>
                        </div>
                        <div class="invalid-feedback" v-if="!$v.position.required">
                            {{trans('vacancies','job_title')}}
                        </div>
                    </div>

                    <!-- Country -->
                    <div class="form-group">
                        <label for="country">
                            Страна поиска работы
                            <span class="mandatory-filling">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                            </span>
                        </label>
                        <select class="form-control select2" id="country">
                            <option disabled="disabled" selected>
                                {{trans('vacancies','select_country')}}
                            </option>
                            <template v-for="(array, key) in objLocations.load_countries">
                                <!-- в случае редиктирования -->
                                <template v-if="objLocations.country == array.code" >
                                    <option :value="array.code" :key="key" selected>{{array.name}}</option>
                                </template>
                                <template v-else>
                                    <option :value="array.code" :key="key">{{array.name}}</option>
                                </template>
                            </template>
                        </select>
                    </div>

                    <!-- Region -->
                    <div class="form-group" v-if="objLocations.load_regions">
                        <label for="region">
                            Регион поиска работы
                            <span class="mandatory-filling">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                            </span>
                        </label>
                        <select class="form-control select2" id="region"
                                @change="changeSelect($event.target.value, 'region')"
                        >
                            <option disabled="disabled" selected>
                                {{trans('vacancies','select_region')}}
                            </option>
                            <template v-for="(array, key) in objLocations.load_regions">
                                <!-- в случае редиктирования -->
                                <template v-if="objLocations.region == array.code" >
                                    <option :value="array.code" :key="key" selected>{{array.name}}</option>
                                </template>
                                <template v-else>
                                    <option :value="array.code" :key="key">{{array.name}}</option>
                                </template>
                            </template>
                        </select>
                    </div>

                    <!-- City -->
                    <div class="form-group" v-if="objLocations.load_cities">
                        <label for="city">
                            Город поиска работы
                            <span class="mandatory-filling">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                            </span>
                        </label>
                        <select class="form-control select2" id="city"
                                @change="changeSelect($event.target.value, 'city')"
                        >
                            <option disabled="disabled" selected>
                                {{trans('vacancies','select_city')}}
                            </option>
                            <template v-for="(array, key) in objLocations.load_cities">
                                <!-- в случае редиктирования -->
                                <template v-if="objLocations.city == array.code" >
                                    <option :value="array.code" :key="key" selected>{{array.name}}</option>
                                </template>
                                <template v-else>
                                    <option :value="array.code" :key="key">{{array.name}}</option>
                                </template>
                            </template>
                        </select>
                    </div>

                    <!-- Дата рождения -->
                    <div class="form-group">
                        <label for="datemask">
                            Дата рождения
                            <span class="mandatory-filling">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                            </span>
                        </label>
                        <i>(месяц/день/год)</i>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input id="datemask" type="text" class="form-control" data-inputmask-alias="datetime"
                                   data-inputmask-inputformat="mm/dd/yyyy" data-mask
                                   :value="data_birth"
                                   @keyup="checkInsertDate($event)"
                                   :class="{'is-invalid': $v.data_birth.$error}"
                                   @blur="$v.data_birth.$touch()"
                            >
                            <div class="invalid-feedback" v-if="!$v.data_birth.required">
                                Пожалуйста, укажите дату своего рождения
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-sm-8">
                    <!-- Categories -->
                    <div class="form-group"
                         :class="{'border_error': (!this.objCategory.categories.length && this.objCategory.boolChecked == true)}"
                    >
                        <div>
                            <label for="categories">
                                {{trans('vacancies','category_resume_posting')}}
                                <span class="mandatory-filling">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                            </span>
                                <span class="info-tooltip" data-toggle="tooltip" data-trigger="click"
                                      :title="`${trans('vacancies','title_categories')}`"
                                >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464zM256 336c-18 0-32 14-32 32s13.1 32 32 32c17.1 0 32-14 32-32S273.1 336 256 336zM289.1 128h-51.1C199 128 168 159 168 198c0 13 11 24 24 24s24-11 24-24C216 186 225.1 176 237.1 176h51.1C301.1 176 312 186 312 198c0 8-4 14.1-11 18.1L244 251C236 256 232 264 232 272V288c0 13 11 24 24 24S280 301 280 288V286l45.1-28c21-13 34-36 34-60C360 159 329 128 289.1 128z"/></svg>
                            </span>
                            </label>
                            <div class="container-fluid collection-checkbox" id="categories">
                                <div class="row">
                                    <template v-for="(array, key) in this.objCategory.categoriesArray">
                                        <div class="col-xl">
                                            <div v-for="(valueArr, key2) in array" :key="key2">
                                                <input class="form-check-input" name="category" type="checkbox"
                                                       @change="checkCategory"
                                                       :id="`category_${valueArr[0]}`"
                                                       :value="valueArr[0]"
                                                >
                                                <label class="target-label"
                                                       :for="`category_${valueArr[0]}`"
                                                >
                                                    {{trans('vacancies',valueArr[1])}}
                                                </label>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div class="invalid-feedback" :class="{'is-invalid visible': (!this.objCategory.categories.length && this.objCategory.boolChecked == true)}">
                            {{trans('vacancies','least_category')}}
                        </div>
                    </div>
                </div>
            </div>

            <!-- второй row -->
            <div class="row">
                <!-- Зарплата -->
                <div class="col-sm-4">
                    <div class="form-group height-element"
                         :class="{border_error: objSalary.switchSalary }"
                    >
                        <label for="salary_accordion">
                            {{trans('vacancies','salary')}}
                            <span class="mandatory-filling">
                            <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                        </span>
                            <span class="info-tooltip" data-toggle="tooltip" data-trigger="click"
                                  title="Укажите желаемую зарплату, на которую вы хотите претендовать. При указании зарплаты в диапазоне, работодатель быстрее откликаются на резюме."
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464zM256 336c-18 0-32 14-32 32s13.1 32 32 32c17.1 0 32-14 32-32S273.1 336 256 336zM289.1 128h-51.1C199 128 168 159 168 198c0 13 11 24 24 24s24-11 24-24C216 186 225.1 176 237.1 176h51.1C301.1 176 312 186 312 198c0 8-4 14.1-11 18.1L244 251C236 256 232 264 232 272V288c0 13 11 24 24 24S280 301 280 288V286l45.1-28c21-13 34-36 34-60C360 159 329 128 289.1 128z"/></svg>
                            </span>
                        </label>
                        <div id="salary_accordion">

                            <div class="card">
                                <!-- radio -->
                                <div class="card-header" id="headingOne">
                                    <div
                                        class="line_select"
                                        data-toggle="collapse"
                                        data-target="#range"
                                        aria-expanded="true"
                                        aria-controls="collapseOne"
                                    >
                                        <input type="radio" id="range_1" name="salary_but" value="range"
                                               v-model="objSalary.salary_but"
                                               @change="checkSalary"
                                        >
                                        <label for="range_1" class="target-label">
                                            {{trans('vacancies','range')}}
                                        </label>
                                    </div>
                                </div>
                                <!-- number -->
                                <div
                                    id="range"
                                    class="collapse show"
                                    aria-labelledby="headingOne"
                                    data-parent="#salary_accordion"
                                >
                                    <div class="card-body">
                                        <input type="number" min="0" max="100000000"
                                               :placeholder="`${trans('vacancies',this.settings.salary.range[0])}`"
                                               v-model="objSalary.from"
                                               @change="checkSalary"
                                        >
                                        -
                                        <input type="number" min="0" max="100000000"
                                               :placeholder="`${trans('vacancies',this.settings.salary.range[1])}`"
                                               v-model="objSalary.to"
                                               @blur="checkSalary"
                                        >
                                        <i>{{trans('vacancies','euro_per_month')}}</i>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <!-- radio -->
                                <div class="card-header" id="headingTwo">
                                    <div
                                        class="line_select"
                                        data-toggle="collapse"
                                        data-target="#single_value"
                                        aria-expanded="false"
                                        aria-controls="collapseTwo"
                                    >
                                        <input
                                            type="radio"
                                            id="single_value1"
                                            name="salary_but"
                                            value="single_value"
                                            v-model="objSalary.salary_but"
                                            @change="checkSalary"
                                        >
                                        <label for="single_value1" class="target-label">
                                            {{trans('vacancies','single_value')}}
                                        </label>
                                    </div>
                                </div>
                                <!-- number -->
                                <div
                                    id="single_value"
                                    class="collapse"
                                    aria-labelledby="headingTwo"
                                    data-parent="#salary_accordion"
                                >
                                    <div class="card-body">
                                        <input type="number" min="0" max="100000000"
                                               :placeholder="`${trans('vacancies',this.settings.salary.single_value[0])}`"
                                               v-model="objSalary.salary_sum"
                                               @change="checkSalary"
                                        >
                                        <i>{{trans('vacancies','euro_per_month')}}</i>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- comment for salary -->
                        <div>
                            <label for="payroll_comment">{{trans('vacancies','salary_comment')}}</label>
                            <input type="text" id="payroll_comment" class="form-control" maxlength="100"
                                   :placeholder="`${trans('vacancies','data_entry')}`"
                                   v-model="objSalary.salary_comment"
                            >
                        </div>

                        <!-- error for salary -->
                        <div class="invalid-feedback" :class="{'is-invalid visible': objSalary.switchSalary}">
                            Пожалуйста, укажите желаемую зарплату
                        </div>

                    </div>
                </div>
                <!-- Вид занятости -->
                <div class="col-sm-4">
                    <div class="form-group height-element">
                        <label for="type_employment">{{trans('vacancies','type_employment')}}</label>
                        <div id="type_employment">
                            <div class="icheck-primary" v-for="(value, key) in this.settings.type_employment" :key="key">
                                <input type="radio" name="type_employment"
                                       :id="`radio_primary_${key}`"
                                       :value="`${key}`"
                                       v-model="type_employment">
                                <label class="target-label"
                                       :for="`radio_primary_${key}`"
                                >
                                    {{trans('vacancies',value)}}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- владение языками -->
                <div class="col-sm-4">
                    <div class="form-group height-element"
                         :class="{border_error: !objLanguage.languages.length }"
                    >
                        <label for="language">
                            Владение языками
                            <span class="mandatory-filling">
                            <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                        </span>
                            <span class="info-tooltip" data-toggle="tooltip" data-trigger="click"
                                  title="Примите решение оптимально. Даже если один из языков вызывает сомнения, вы всегда сможете это обговорить с работодателем."
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464zM256 336c-18 0-32 14-32 32s13.1 32 32 32c17.1 0 32-14 32-32S273.1 336 256 336zM289.1 128h-51.1C199 128 168 159 168 198c0 13 11 24 24 24s24-11 24-24C216 186 225.1 176 237.1 176h51.1C301.1 176 312 186 312 198c0 8-4 14.1-11 18.1L244 251C236 256 232 264 232 272V288c0 13 11 24 24 24S280 301 280 288V286l45.1-28c21-13 34-36 34-60C360 159 329 128 289.1 128z"/></svg>
                            </span>
                        </label>

                        <select class="form-control select2" id="language" multiple="multiple" data-placeholder="Выбрать">
                            <template v-for="(obj, index) in lang.lang">
                                <!-- в случае редиктирования -->
                                <template v-if="objLanguage.languages.indexOf(index) !== -1" >
                                    <option :value="index" :key="index" selected>{{obj.title}}</option>
                                </template>
                                <template v-else>
                                    <option :value="index" :key="index">{{obj.title}}</option>
                                </template>
                            </template>
                        </select>
                        <div class="invalid-feedback" :class="{'is-invalid visible': !objLanguage.languages.length}">
                            Пожалуйста укажите языки владения
                        </div>
                    </div>
                </div>
            </div>

            <!-- третий row -->
            <div class="row">

                <!-- Образование -->
                <div class="col-sm-4">
                    <div class="form-group height-element2">
                        <label for="education">{{trans('vacancies','education_1')}}</label>
                        <select class="form-control" id="education"
                                v-model="education"
                        >
                            <template v-for="(value, key) in this.settings.education">
                                <option :value="`${key}`">
                                    {{trans('vacancies',value)}}
                                </option>
                            </template>
                        </select>
                    </div>
                </div>
                <!-- Размещение резюме -->
                <div class="col-sm-4">
                    <div class="form-group height-element2">
                        <label for="job_posting">
                            Размещение резюме
                            <span class="info-tooltip" data-toggle="tooltip" data-trigger="click"
                                  title="Если вы пока не готовы показывать это резюме соискателям, выберете настройку Скрытая. Эту настройку всегда можно изменить в редактировании."
                            >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464zM256 336c-18 0-32 14-32 32s13.1 32 32 32c17.1 0 32-14 32-32S273.1 336 256 336zM289.1 128h-51.1C199 128 168 159 168 198c0 13 11 24 24 24s24-11 24-24C216 186 225.1 176 237.1 176h51.1C301.1 176 312 186 312 198c0 8-4 14.1-11 18.1L244 251C236 256 232 264 232 272V288c0 13 11 24 24 24S280 301 280 288V286l45.1-28c21-13 34-36 34-60C360 159 329 128 289.1 128z"/></svg>
                            </span>
                        </label>
                        <div id="job_posting">
                            <div class="icheck-primary"
                                 v-for="(value, key) in this.settings.job_status" :key="key"
                            >
                                <input type="radio" name="job_posting"
                                       :id="`job_posting_${key}`"
                                       :value="`${key}`"
                                       v-model="job_posting">
                                <label class="target-label"
                                       :for="`job_posting_${key}`"
                                >
                                    {{trans('vacancies',value)}}
                                </label>
                            </div>
                            <!--                            Размещено на сайте и Скрытая -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- четвертый row -->
            <div class="row">
                <!-- Опыт работы -->
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="work_experience">
                            {{trans('vacancies','work_experience')}}
                        </label>
                        <i>
                            Укажите общее количество лет опыта
                        </i>
                        <select class="form-control" id="work_experience"
                                v-model="experience"
                        >
                            <template v-for="(value, key) in this.settings.work_experience">
                                <option :value="`${key}`">
                                    {{trans('vacancies',value)}}
                                </option>
                            </template>
                        </select>

                        <label>
                            Опишите свой опыт
                            <span class="info-tooltip" data-toggle="tooltip" data-trigger="click"
                                  title="Очень важно рассказать подробно в какие периоды и на каких должностях вы работали. Какие методы или технологии использовали. Работодатель всегда первым делом ознакамливается с этой информацией."
                            >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464zM256 336c-18 0-32 14-32 32s13.1 32 32 32c17.1 0 32-14 32-32S273.1 336 256 336zM289.1 128h-51.1C199 128 168 159 168 198c0 13 11 24 24 24s24-11 24-24C216 186 225.1 176 237.1 176h51.1C301.1 176 312 186 312 198c0 8-4 14.1-11 18.1L244 251C236 256 232 264 232 272V288c0 13 11 24 24 24S280 301 280 288V286l45.1-28c21-13 34-36 34-60C360 159 329 128 289.1 128z"/></svg>
                            </span>
                        </label>
                        <ckeditor v-model="objTextarea.textarea_experience"
                                  :config="objTextarea.editorConfig1"
                        ></ckeditor>
                    </div>
                </div>
                <!-- Ожидания от вакансии -->
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>
                            Ожидания от вакансии
                            <span class="info-tooltip" data-toggle="tooltip" data-trigger="click"
                                  title="Опишите чего ждете, на что способны и чем не желаете заниматься."
                            >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464zM256 336c-18 0-32 14-32 32s13.1 32 32 32c17.1 0 32-14 32-32S273.1 336 256 336zM289.1 128h-51.1C199 128 168 159 168 198c0 13 11 24 24 24s24-11 24-24C216 186 225.1 176 237.1 176h51.1C301.1 176 312 186 312 198c0 8-4 14.1-11 18.1L244 251C236 256 232 264 232 272V288c0 13 11 24 24 24S280 301 280 288V286l45.1-28c21-13 34-36 34-60C360 159 329 128 289.1 128z"/></svg>
                            </span>
                        </label>
                        <ckeditor v-model="objTextarea.textarea_wait"
                                  :config="objTextarea.editorConfig2"
                        ></ckeditor>
                    </div>
                </div>
                <!-- Свои достижения -->
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>
                            Свои достижения
                            <span class="info-tooltip" data-toggle="tooltip" data-trigger="click"
                                  title="Максимально подробно. Этим вы сможете заинтересовать больше работодателей."
                            >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464zM256 336c-18 0-32 14-32 32s13.1 32 32 32c17.1 0 32-14 32-32S273.1 336 256 336zM289.1 128h-51.1C199 128 168 159 168 198c0 13 11 24 24 24s24-11 24-24C216 186 225.1 176 237.1 176h51.1C301.1 176 312 186 312 198c0 8-4 14.1-11 18.1L244 251C236 256 232 264 232 272V288c0 13 11 24 24 24S280 301 280 288V286l45.1-28c21-13 34-36 34-60C360 159 329 128 289.1 128z"/></svg>
                            </span>
                        </label>
                        <ckeditor v-model="objTextarea.textarea_achievements"
                                  :config="objTextarea.editorConfig3"
                        ></ckeditor>
                    </div>
                </div>
            </div>

            <!-- button -->
            <div class="row footer-form">
                <div class="col-sm-4 offset-4 but-box">
                    <!-- button create -->
                    <template v-if="resume_id === null">
                        <a href="/" class="btn btn-block btn-outline-danger btn-lg">
                            {{trans('vacancies','cancel')}}
                        </a>
                        <button type="submit" class="btn btn-block btn-primary btn-lg"
                                :class="{'disabled': disableButton($v)}"
                                :disabled="disableButton($v)"
                                @click.prevent="createResume"
                        >
                            {{trans('vacancies','save')}}
                        </button>
                    </template>
                    <!-- button update -->
                    <template v-else>
                        <a :href="`${lang.prefix_lang}private-office/resume/my-resumes`"
                           class="btn btn-block btn-outline-danger btn-lg">
                            {{trans('vacancies','cancel')}}
                        </a>
                        <button type="submit" class="btn btn-block btn-primary btn-lg"
                                :class="{'disabled': disableButton($v)}"
                                :disabled="disableButton($v)"
                                @click.prevent="updateResume"
                        >
                            {{trans('vacancies','update_vacancy')}}
                        </button>
                    </template>
                </div>
            </div>

        </form>
    </div>
</template>

<script>
    import {required} from 'vuelidate/lib/validators'
    import translation from '../../mixins/translation'
    import response_methods_mixin from "../../mixins/response_methods_mixin";
    import localisation_functions_mixin from "../../mixins/localisation_functions_mixin";
    import create_resume_vacancy_mixin from "../../mixins/create_resume_vacancy_mixin";
    import general_functions_mixin from "../../mixins/general_functions_mixin";

    export default {
        mixins: [
            translation,
            response_methods_mixin,
            localisation_functions_mixin,
            general_functions_mixin,
            create_resume_vacancy_mixin
        ],
        data() {
            return {
                resume_id: null,
                position: '',
                position_list: [],
                data_birth: '',
                experience: 0,
                education: 0,
                type_employment: 0,
                job_posting: 0,
                objTextarea: {
                    textarea_experience: '',
                    textarea_wait: '',
                    textarea_achievements: '',
                    editorConfig1: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList', 'Link' ]
                        ],
                    },
                    editorConfig2: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList', 'Link' ]
                        ],
                    },
                    editorConfig3: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList', 'Link' ]
                        ],
                    },
                },
                objSalary: {
                    salary_but: "range",
                    from: 0,
                    to: 1000,
                    salary_sum: 0,
                    switchSalary: false,
                    salary_comment: null,
                },
                objLanguage: {
                    languages: [0],
                },
            }
        },
        methods: {
            async createResume(){
                this.alignNumbers(this.objSalary,'from','to')
                let data = this.getValuesFields()
                // console.log(data)
                const response = await this.$http.post(`/private-office/resume`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            // console.log(res)
                            location.href = this.lang.prefix_lang+'private-office/resume/my-resumes'
                        }
                        // custom ошибки
                        else{
                            this.message(res.data.message, 'error', 10000, true);
                        }
                    })
                    // ошибки сервера
                    .catch(err => {
                        this.messageError(err)
                    })
            },
            async searchPosition(value){
                if(!value.length){
                    $('#position_list').removeClass('show')
                    return false
                }

                let data = {
                    value: value,
                };
                const response = await this.$http.post(`/private-office/vacancy/search-position`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            // вернет только опубликованные
                            if(res.data.message.position.length){
                                this.position_list = res.data.message.position
                                $('#position_list').addClass('show')
                            }
                            else{
                                $('#position_list').removeClass('show')
                            }
                        }
                        // custom ошибки
                        else{ }
                    })
                    // ошибки сервера
                    .catch(err => {
                        // this.messageError(err)
                    })
            },
            async updateResume(){
                this.alignNumbers(this.objSalary,'from','to')
                let data = this.getValuesFields()
                const response = await this.$http.put(`/private-office/resume/`+this.resume_id, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            // console.log(res.data.message)
                            location.href = this.lang.prefix_lang+'private-office/resume/my-resumes'
                        }
                        // custom ошибки
                        else{
                            this.message(res.data.message, 'error', 10000, true);
                        }
                    })
                    // ошибки сервера
                    .catch(err => {
                        this.messageError(err)
                    })
            },
            disableButton(v) {
                if(
                    v.$invalid ||
                    this.objLocations.country === null ||
                    !this.objCategory.categories.length ||
                    this.checkSalary() ||
                    !this.objLanguage.languages.length
                ){
                    return true;
                }
                return false;
            },
            // коррекция даты
            checkInsertDate(e){
                let value = e.target.value
                let IPOdate = new Date()
                if( !isNaN( IPOdate.setTime(Date.parse(value)) ) ){
                    // let date = new Date(value)
                    this.data_birth = value
                }
                else{
                    this.data_birth = ''
                }
            },
            getValuesFields(){
                return {
                    position: this.position,
                    country: this.returnFoundObject(this.objLocations.load_countries, this.objLocations.country),
                    region: this.returnFoundObject(this.objLocations.load_regions, this.objLocations.region),
                    city: this.returnFoundObject(this.objLocations.load_cities, this.objLocations.city),
                    data_birth: this.data_birth,
                    categories: this.objCategory.categories,
                    salary_but: this.objSalary.salary_but,              // Зарплата
                    from: this.objSalary.from,
                    to: this.objSalary.to,
                    salary_sum: this.objSalary.salary_sum,
                    salary_comment: this.objSalary.salary_comment,
                    type_employment: this.type_employment,              // Вид занятости
                    languages: this.objLanguage.languages,              // языки
                    education: this.education,                          // Образование
                    job_posting : this.job_posting,                     // Размещение резюме
                    experience: this.experience,                        // опыт работы
                    text_experience: this.objTextarea.textarea_experience,
                    text_wait: this.objTextarea.textarea_wait,                 // Ожидания от вакансии
                    text_achievements: this.objTextarea.textarea_achievements, // Свои достижения
                };
            },
            // в случае редактирования вакансии
            setValuesFields(){
                if(this.resume == null){
                    return false
                }

                this.resume_id = this.resume.id
                this.position = this.resume.position.title
                // Location
                this.objLocations.load_countries = this.settings.obj_countries
                this.objLocations.country = this.resume.country.code
                this.loadRegions();
                if(this.resume.region !== null){
                    this.objLocations.region = this.resume.region.code
                    setTimeout(() => {
                        this.loadCity()
                    }, 500);
                }
                if(this.resume.city !== null){
                    this.objLocations.city = this.resume.city.code
                }
                // день рождения
                this.data_birth = this.resume.data_birth
                // категория резюме
                this.objCategory.categories = this.resume.categories
                var input = ''
                for(let i=0; i<this.objCategory.categories.length; i++) {
                    input = document.querySelector('#category_'+this.objCategory.categories[i])
                    input.checked = true
                }
                this.objCategory.boolChecked = true
                // Зарплата
                this.objSalary.salary_but = this.resume.salary.radio_name
                this.objSalary.from = this.resume.salary.inputs.from
                this.objSalary.to = this.resume.salary.inputs.to
                this.objSalary.salary_sum = this.resume.salary.inputs.salary_sum
                this.objSalary.salary_comment = this.resume.salary.comment
                $('#'+this.objSalary.salary_but).collapse('show');
                // Вид занятости
                this.type_employment = this.resume.type_employment
                // языки
                this.objLanguage.languages = this.resume.languages
                // Образование
                this.education = this.resume.education
                // Размещение резюме
                this.job_posting = this.settings.job_status.indexOf(this.resume.job_posting.status_name)
                // опыт работы
                this.experience = this.resume.experience
                this.objTextarea.textarea_experience = this.resume.text_experience
                // Ожидания от вакансии
                this.objTextarea.textarea_wait = this.resume.text_wait
                // Свои достижения
                this.objTextarea.textarea_achievements = this.resume.text_achievements
            },
        },
        props: [
            'lang',
            'settings',
            'resume',
        ],
        mounted() {
            this.initializationFunc()
            // Код, который будет запущен только после отрисовки всех представлений
            this.$nextTick(function () {
                this.setValuesFields()
            })
        },
        validations: {
            position: {
                required,
            },
            data_birth: {
                required,
            },
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .block_position_list{
        position: relative;
        #position_list{
            width: 100%;
            padding: 0;
            cursor: pointer;
            top: -3px;
            & > div{
                padding: 1px 12px;
            }
        }
    }
    label{
        cursor: pointer;
    }
    .form-group{
        padding: 5px 10px 15px;
        background: $back-form-group;
        position: relative;
        .invalid-feedback{
            margin-bottom: -13px;
            padding: 3px 0px 1px 0px;
        }
    }
    .visible{
        display: block;
    }
    .border_error{
        border:1px solid red;
    }
    #work_experience{
        margin-bottom: 10px;
    }
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
            padding: 0 0 0 2px;
            min-height: 31px;
        }
    }
    .one-one-box{
        display: flex;
        flex-direction: column;
        & > div:last-child {
            flex-grow: 3;
        }
    }
    .height-element{
        height: 95%;
    }
    .height-element2{
        height: 90%;
    }


</style>





























