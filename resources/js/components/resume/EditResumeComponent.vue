<template>
    <div class="forms box-page">
        <!-- обратная ссылка -->
        <div class="top-panel bread-top-cabinet">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="m166.5 424.5-143.1-152a23.94 23.94 0 0 1-6.562-16.5 23.94 23.94 0 0 1 6.562-16.5l143.1-152c9.125-9.625 24.31-10.03 33.93-.938 9.688 9.126 10.03 24.38.938 33.94l-128.4 135.5 128.4 135.5c9.094 9.562 8.75 24.75-.938 33.94-9.53 9.058-24.73 8.658-33.93-.942z"/></svg>
            <a :href="`${lang.prefix_lang}private-office/resume/my-resumes`">
                {{trans('vacancies','my_resume')}}
            </a>
            <span class="bread-slash"> | </span>
        </div>
        <!-- title -->
        <h1 v-if="resume_id == null" class="title_page card-body">
            {{trans('vacancies','create_resume2')}}
        </h1>
        <h1 v-else class="title_page card-body">
            {{trans('vacancies','edit_resume')}}
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
                               :placeholder="trans('vacancies','example_hairdresser')"
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
                            {{trans('vacancies','job_search_country')}}
                            <span class="mandatory-filling">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                            </span>
                        </label>
                        <select class="form-control select2" id="country">
                            <option disabled="disabled" selected>
                                {{trans('vacancies','select_country')}}
                            </option>
                            <template v-for="(obj, key) in objLocations.load_countries">
                                <!-- в случае редактирования -->
                                <template v-if="objLocations.country == obj.prefix" >
                                    <option :value="obj.prefix.toLowerCase()" :key="key" selected
                                    >{{obj.translate}}</option>
                                </template>
                                <template v-else>
                                    <option :value="obj.prefix.toLowerCase()" :key="key"
                                    >{{obj.translate}}</option>
                                </template>
                            </template>
                        </select>
                    </div>

                    <!-- Region -->
                    <div class="form-group" v-if="objLocations.load_regions">
                        <label for="region">
                            {{trans('vacancies','job_search_region')}}
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
                            <template v-for="(obj, index) in objLocations.load_regions">
                                <!-- в случае редиктирования -->
                                <template v-if="objLocations.region == obj.code_region" >
                                    <option :value="obj.code_region" :key="index" selected
                                    >{{obj.translate}}</option>
                                </template>
                                <template v-else>
                                    <option :value="obj.code_region" :key="index"
                                    >{{obj.translate}}</option>
                                </template>
                            </template>
                        </select>
                    </div>

                    <!-- City -->
                    <div class="form-group" v-if="objLocations.load_cities">
                        <label for="city">
                            {{trans('vacancies','job_search_city')}}
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
                            <template v-for="(obj, index) in objLocations.load_cities">
                                <!-- в случае редиктирования -->
                                <template v-if="objLocations.city == obj.original_index" >
                                    <option :value="obj.original_index" :key="index" selected
                                    >{{obj.translate}}</option>
                                </template>
                                <template v-else>
                                    <option :value="obj.original_index" :key="index"
                                    >{{obj.translate}}</option>
                                </template>
                            </template>
                        </select>
                    </div>


                    <!-- Дата рождения -->
                    <div class="form-group">
                        <label for="datemask">
                            {{trans('vacancies','date_of_birth')}}
                            <span class="mandatory-filling">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                            </span>
                        </label>
                        <i>
                            {{trans('vacancies','month_day_year')}}
                        </i>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M112 0c8.8 0 16 7.164 16 16v48h192V16c0-8.836 7.2-16 16-16s16 7.164 16 16v48h32c35.3 0 64 28.65 64 64v320c0 35.3-28.7 64-64 64H64c-35.35 0-64-28.7-64-64V128c0-35.35 28.65-64 64-64h32V16c0-8.836 7.2-16 16-16zm304 192H312v72h104v-72zm0 104H312v80h104v-80zm0 112H312v72h72c17.7 0 32-14.3 32-32v-40zm-136-32v-80H168v80h112zM168 480h112v-72H168v72zm-32-104v-80H32v80h104zM32 408v40c0 17.7 14.33 32 32 32h72v-72H32zm0-144h104v-72H32v72zm136 0h112v-72H168v72zM384 96H64c-17.67 0-32 14.3-32 32v32h384v-32c0-17.7-14.3-32-32-32z"/></svg>
                                </span>
                            </div>
                            <input id="datemask" type="text" class="form-control" data-inputmask-alias="datetime"
                                   data-inputmask-inputformat="mm/dd/yyyy" data-mask
                                   :value="data_birth"
                                   @keyup="checkInsertDate($event)"
                                   :class="{'is-invalid': $v.data_birth.$error}"
                                   @blur="$v.data_birth.$touch()"
                            >
                            <div class="invalid-feedback" v-if="!$v.data_birth.required">
                                {{trans('vacancies','please_enter_your_date')}}
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
                                {{trans('vacancies','resume_placement_category')}}
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
                                  :title="trans('vacancies','specify_desired_salary_vacancy')"
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
                                   :placeholder="trans('vacancies','data_entry')"
                                   v-model="objSalary.salary_comment"
                            >
                        </div>

                        <!-- error for salary -->
                        <div class="invalid-feedback" :class="{'is-invalid visible': objSalary.switchSalary}">
                            {{trans('vacancies','please_indicate_your_salary')}}
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
                            {{trans('vacancies',"language_skills")}}
                            <span class="mandatory-filling">
                            <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                        </span>
                            <span class="info-tooltip" data-toggle="tooltip" data-trigger="click"
                                  :title="trans('vacancies','make_best_decision')"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464zM256 336c-18 0-32 14-32 32s13.1 32 32 32c17.1 0 32-14 32-32S273.1 336 256 336zM289.1 128h-51.1C199 128 168 159 168 198c0 13 11 24 24 24s24-11 24-24C216 186 225.1 176 237.1 176h51.1C301.1 176 312 186 312 198c0 8-4 14.1-11 18.1L244 251C236 256 232 264 232 272V288c0 13 11 24 24 24S280 301 280 288V286l45.1-28c21-13 34-36 34-60C360 159 329 128 289.1 128z"/></svg>
                            </span>
                        </label>

                        <select class="form-control select2" id="language" multiple="multiple"
                                :data-placeholder="trans('vacancies','select')"
                        >
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
                            {{trans('vacancies',"please_indicate_languages")}}
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
                            {{trans('vacancies',"placement_resume")}}
                            <span class="info-tooltip" data-toggle="tooltip" data-trigger="click"
                                  :title="trans('vacancies','if_you_not_yet_ready')"
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
                            {{trans('vacancies','enter_total_number_experience')}}
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
                            {{trans('vacancies','describe_your_experience')}}
                            <span class="info-tooltip" data-toggle="tooltip" data-trigger="click"
                                  :title="trans('vacancies','it_very_important_tell')"
                            >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464zM256 336c-18 0-32 14-32 32s13.1 32 32 32c17.1 0 32-14 32-32S273.1 336 256 336zM289.1 128h-51.1C199 128 168 159 168 198c0 13 11 24 24 24s24-11 24-24C216 186 225.1 176 237.1 176h51.1C301.1 176 312 186 312 198c0 8-4 14.1-11 18.1L244 251C236 256 232 264 232 272V288c0 13 11 24 24 24S280 301 280 288V286l45.1-28c21-13 34-36 34-60C360 159 329 128 289.1 128z"/></svg>
                            </span>
                        </label>
                        <ckeditor v-model="objTextarea.textarea_experience"
                                  :config="objTextarea.editorConfig1"
                        ></ckeditor>
                    </div>
                </div>
                <!-- Ожидания на новой работе -->
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>
                            {{trans('vacancies','expectations_new_job')}}
                            <span class="info-tooltip" data-toggle="tooltip" data-trigger="click"
                                  :title="trans('vacancies','describe_what_expect')"
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
                            {{trans('vacancies','your_achievements')}}
                            <span class="info-tooltip" data-toggle="tooltip" data-trigger="click"
                                  :title="trans('vacancies','maximum_detail')"
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
                    <a :href="`${lang.prefix_lang}private-office/resume/my-resumes`"
                       class="btn btn-block btn-outline-danger btn-lg">
                        {{trans('vacancies','cancel')}}
                    </a>
                    <!-- button create -->
                    <button v-if="resume_id === null" type="submit" class="btn btn-block btn-primary btn-lg"
                            :class="{'disabled': disableButton($v)}"
                            :disabled="disableButton($v)"
                            @click.prevent="createResume"
                    >
                        {{trans('vacancies','save')}}
                    </button>
                    <!-- button update -->
                    <button v-else type="submit" class="btn btn-block btn-primary btn-lg"
                            :class="{'disabled': disableButton($v)}"
                            :disabled="disableButton($v)"
                            @click.prevent="updateResume"
                    >
                        {{trans('vacancies','update_vacancy')}}
                    </button>
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
                const response = await this.$http.post(`/private-office/resume`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
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
                    country: this.returnTargetLocalisation(this.objLocations.load_countries, this.objLocations.country.toUpperCase(), 'prefix'),
                    region: this.returnTargetLocalisation(this.objLocations.load_regions, this.objLocations.region, 'code_region'),
                    city: this.returnTargetLocalisation(this.objLocations.load_cities, this.objLocations.city, 'original_index'),
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
                this.objLocations.country = this.resume.country.local.prefix

                if(this.resume.region != null){
                    this.loadRegions();
                    this.objLocations.region = this.resume.region.local.code_region

                    setTimeout(() => {
                        if(this.resume.city != null) {
                            this.loadCity()

                            setTimeout(() => {
                                this.objLocations.city = this.resume.city.local.original_index
                            }, 500);
                        }
                    }, 1500);
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





























