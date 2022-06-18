<template>
    <div class="box-page">
        <!-- обратная ссылка -->
        <div class="top-panel bread-top-cabinet">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="m166.5 424.5-143.1-152a23.94 23.94 0 0 1-6.562-16.5 23.94 23.94 0 0 1 6.562-16.5l143.1-152c9.125-9.625 24.31-10.03 33.93-.938 9.688 9.126 10.03 24.38.938 33.94l-128.4 135.5 128.4 135.5c9.094 9.562 8.75 24.75-.938 33.94-9.53 9.058-24.73 8.658-33.93-.942z"/></svg>
            <a :href="`${lang.prefix_lang}private-office`">
                {{trans('menu.menu','cabinet')}}
            </a>
            <span class="bread-slash"> | </span>
        </div>
        <!-- title -->
        <h1 class="title_page card-body"
            v-if="this.company_id == null"
        >
            {{trans('company','create_your_company')}}
        </h1>
        <h1 v-else class="title_page card-body">
            {{trans('company','update_company_data')}}
        </h1>

        <div class="desc-helper-italic">
            {{trans('company','about_company')}}
        </div>

        <!-- первый row -->
        <div class="row">
            <div class="col-sm-4 one-one-box">

                <!-- Название компании -->
                <div class="form-group">
                    <label for="position">
                        {{trans('company','company_name')}}
                        <span class="mandatory-filling">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                        </span>
                        <span class="info-tooltip" data-toggle="tooltip" data-trigger="click"
                              title="sss"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464zM256 336c-18 0-32 14-32 32s13.1 32 32 32c17.1 0 32-14 32-32S273.1 336 256 336zM289.1 128h-51.1C199 128 168 159 168 198c0 13 11 24 24 24s24-11 24-24C216 186 225.1 176 237.1 176h51.1C301.1 176 312 186 312 198c0 8-4 14.1-11 18.1L244 251C236 256 232 264 232 272V288c0 13 11 24 24 24S280 301 280 288V286l45.1-28c21-13 34-36 34-60C360 159 329 128 289.1 128z"/></svg>
                        </span>
                    </label>
                    <input type="text" id="position" class="form-control" maxlength="100" autocomplete="off"
                           :placeholder="trans('company','for_example_star')"
                           :class="{'is-invalid': $v.position.$error}"
                           v-model="position"
                           @blur="$v.position.$touch()"
                           @keyup="transliteration($event.target.value)"
                    >
                    <div class="invalid-feedback" v-if="!$v.position.required">
                        {{trans('company','please_enter_name')}}
                    </div>
                </div>

                <!-- Транслитерация названия -->
                <div v-if="company_id === null"
                    class="form-group"
                >
                    <label>
                        {{trans('company','company_name_transliteration')}}
                        <span class="mandatory-filling">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                        </span>
                        <span class="info-tooltip" data-toggle="tooltip" data-trigger="click"
                              title="Транслитерация – это уникальная строка в url адресе, ссылающаяся на вашу компанию. Благодаря ей вы всегда можете поделится ссылкой с друзьями или коллегами. Это легко, быстро и удобно."
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464zM256 336c-18 0-32 14-32 32s13.1 32 32 32c17.1 0 32-14 32-32S273.1 336 256 336zM289.1 128h-51.1C199 128 168 159 168 198c0 13 11 24 24 24s24-11 24-24C216 186 225.1 176 237.1 176h51.1C301.1 176 312 186 312 198c0 8-4 14.1-11 18.1L244 251C236 256 232 264 232 272V288c0 13 11 24 24 24S280 301 280 288V286l45.1-28c21-13 34-36 34-60C360 159 329 128 289.1 128z"/></svg>
                        </span>
                    </label>
                    <i class="desc-i">Внимание! Транслитерация создаётся и изменению не подлежит. Примите решение как она будет писаться.</i>
                    <input type="text" id="position_transliteration" class="form-control" maxlength="100" autocomplete="off"
                           :placeholder="trans('company','enter_transliteration')"
                           :class="{'is-invalid': $v.position_transliteration.$error}"
                           v-model="position_transliteration"
                           @blur="$v.position_transliteration.$touch()"
                           @keyup="transliteration($event.target.value)"
                    >
                    <div class="invalid-feedback" v-if="!$v.position_transliteration.required">
                        {{trans('company','please_enter_least')}}
                    </div>
                    <div class="invalid-feedback" v-if="!$v.position_transliteration.uniqTranslit">
                        {{trans('company','this_transliteration')}}
                    </div>
                </div>

                <!-- Country -->
                <div class="form-group">
                    <label for="country">
                        {{trans('company','company_country')}}
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
                        {{trans('company','company_region')}}
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
                        {{trans('company','company_city')}}
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

                <!-- Остальной адрес -->
                <div class="form-group" v-if="objLocations.bool_rest_address">
                    <label for="rest_address">
                        {{trans('company','remaining_address')}}
                        <span class="mandatory-filling">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                        </span>
                    </label>
                    <input type="text" id="rest_address" class="form-control" maxlength="100"
                           :placeholder="trans('company','specify')"
                           :class="{'is-invalid': $v.rest_address.$error}"
                           v-model="rest_address"
                           @blur="$v.rest_address.$touch()"
                    >
                    <div class="invalid-feedback" v-if="!$v.rest_address.required">
                        {{trans('company','please_indicate_street')}}
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
                            {{trans('company','categories_activity_company')}}
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
                    <div class="invalid-feedback"
                         :class="{'is-invalid visible': (!this.objCategory.categories.length && this.objCategory.boolChecked == true)}"
                    >
                        {{trans('company','please_select_category')}}
                    </div>
                </div>
            </div>
        </div>

        <!-- второй row -->
        <div class="row two-row">
            <!-- Налоговый номер -->
            <div class="col-sm-4">
                <div class="form-group height-element">
                    <label for="position">
                        {{trans('company','company_tax_number')}}
                        <span class="mandatory-filling">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                            </span>
                        <span class="info-tooltip" data-toggle="tooltip" data-trigger="click"
                              :title="`${trans('vacancies','title_position')}`"
                        >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464zM256 336c-18 0-32 14-32 32s13.1 32 32 32c17.1 0 32-14 32-32S273.1 336 256 336zM289.1 128h-51.1C199 128 168 159 168 198c0 13 11 24 24 24s24-11 24-24C216 186 225.1 176 237.1 176h51.1C301.1 176 312 186 312 198c0 8-4 14.1-11 18.1L244 251C236 256 232 264 232 272V288c0 13 11 24 24 24S280 301 280 288V286l45.1-28c21-13 34-36 34-60C360 159 329 128 289.1 128z"/></svg>
                            </span>
                    </label>
                    <input type="text" id="company_tax_number" class="form-control" maxlength="100" autocomplete="off"
                           :placeholder="trans('company','enter_number')"
                           :class="{'is-invalid': $v.company_tax_number.$error}"
                           v-model="company_tax_number"
                           @blur="$v.company_tax_number.$touch()"
                    >
                    <div class="invalid-feedback" v-if="!$v.company_tax_number.required">
                        {{trans('company','please_enter_your_number')}}
                    </div>
                </div>
            </div>
            <!-- Сайт компании -->
            <div class="col-sm-4">
                <div class="form-group height-element">
                    <label for="site_company">
                        {{trans('company','company_website')}}
                    </label>
                    <input type="text" id="site_company" class="form-control" maxlength="150" autocomplete="off"
                           :placeholder="trans('company','for_example_great')"
                           v-model="site_company"
                    >
                </div>
            </div>
            <!-- Дата основания-->
            <div class="col-sm-4">
                <div class="form-group height-element">
                    <label for="data_foundation">
                        {{trans('company','data_foundation')}} (месяц/день/год)
                    </label>
                    <div class="input-group" id="data_foundation">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input id="datemask" type="text" class="form-control" data-inputmask-alias="datetime"
                               data-inputmask-inputformat="mm/dd/yyyy" data-mask
                               :value="founding_date"
                               @keyup="checkInsertDate($event)"
                        >
                    </div>
                </div>
            </div>
        </div>

        <!-- третий row -->
        <div class="row">
            <!-- Соц сети -->
            <div class="col-sm-6">
                <div class="form-group height-element">
                    <label for="social-network">
                        {{trans('company','social_networks_company')}}
                    </label>

                    <div class="card" id="social-network">
                        <!-- buttons -->
                        <div class="box-card-header">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                     aria-controls="facebook_box" data-target="#facebook_box" aria-expanded="false" data-toggle="collapse"
                                     @click="switchSvg($event)"
                                     :class="{'svg-action': facebook_input}"
                                ><path d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="instagram-svg"
                                     aria-controls="instagram_box" data-target="#instagram_box" aria-expanded="false" data-toggle="collapse"
                                     @click="switchSvg($event)"
                                     :class="{'svg-action': instagram_input}"
                                ><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"
                                     aria-controls="telegram_box" data-target="#telegram_box" aria-expanded="false" data-toggle="collapse"
                                     @click="switchSvg($event)"
                                     :class="{'svg-action': telegram_input}"
                                ><path d="M248,8C111.033,8,0,119.033,0,256S111.033,504,248,504,496,392.967,496,256,384.967,8,248,8ZM362.952,176.66c-3.732,39.215-19.881,134.378-28.1,178.3-3.476,18.584-10.322,24.816-16.948,25.425-14.4,1.326-25.338-9.517-39.287-18.661-21.827-14.308-34.158-23.215-55.346-37.177-24.485-16.135-8.612-25,5.342-39.5,3.652-3.793,67.107-61.51,68.335-66.746.153-.655.3-3.1-1.154-4.384s-3.59-.849-5.135-.5q-3.283.746-104.608,69.142-14.845,10.194-26.894,9.934c-8.855-.191-25.888-5.006-38.551-9.123-15.531-5.048-27.875-7.717-26.8-16.291q.84-6.7,18.45-13.7,108.446-47.248,144.628-62.3c68.872-28.647,83.183-33.623,92.511-33.789,2.052-.034,6.639.474,9.61,2.885a10.452,10.452,0,0,1,3.53,6.716A43.765,43.765,0,0,1,362.952,176.66Z"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="twitter-svg"
                                     aria-controls="twitter_box" data-target="#twitter_box" aria-expanded="false" data-toggle="collapse"
                                     @click="switchSvg($event)"
                                     :class="{'svg-action': twitter_input}"
                                ><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"/></svg>
                        </div>
                        <!-- inputs -->
                        <div class="box-card-collapse">
                            <!-- facebook -->
                            <div class="collapse multi-collapse" id="facebook_box"
                                 :class="{'show': facebook_input}"
                            >
                                <div class="card-body">
                                    <label for="facebook_input">
                                        Facebook
                                    </label>
                                    <input type="text" id="facebook_input" class="form-control" maxlength="150" autocomplete="off"
                                           :placeholder="trans('company','enter_link_account')"
                                           v-model="facebook_input"
                                           @change="checkInvalid($event, 'facebook.com')"
                                    >
                                    <div class="invalid-feedback">
                                        {{trans('company','field_only_for')}}{{trans('company','facebook_links')}}
                                    </div>
                                </div>
                            </div>
                            <!-- Instagram -->
                            <div class="collapse multi-collapse" id="instagram_box"
                                 :class="{'show': instagram_input}"
                            >
                                <div class="card-body">
                                    <label for="instagram_input">
                                        Instagram
                                    </label>
                                    <input type="text" id="instagram_input" class="form-control" maxlength="150" autocomplete="off"
                                           :placeholder="trans('company','enter_link_account')"
                                           v-model="instagram_input"
                                           @change="checkInvalid($event, 'instagram.com')"
                                    >
                                    <div class="invalid-feedback">
                                        {{trans('company','field_only_for')}}{{trans('company','instagram_links')}}
                                    </div>
                                </div>
                            </div>
                            <!-- Telegram -->
                            <div class="collapse multi-collapse" id="telegram_box"
                                 :class="{'show': telegram_input}"
                            >
                                <div class="card-body">
                                    <label for="telegram_input">
                                        Telegram
                                    </label>
                                    <input type="text" id="telegram_input" class="form-control" maxlength="150" autocomplete="off"
                                           :placeholder="trans('company','enter_link_account')"
                                           v-model="telegram_input"
                                           @change="checkInvalid($event, 't.me')"
                                    >
                                    <div class="invalid-feedback">
                                        {{trans('company','field_only_for')}}{{trans('company','telegram_links')}}
                                    </div>
                                </div>
                            </div>
                            <!-- Twitter -->
                            <div class="collapse multi-collapse" id="twitter_box"
                                 :class="{'show': twitter_input}"
                            >
                                <div class="card-body">
                                    <label for="Twitter_input">
                                        Twitter
                                    </label>
                                    <input type="text" id="twitter_input" class="form-control" maxlength="150" autocomplete="off"
                                           :placeholder="trans('company','enter_link_account')"
                                           v-model="twitter_input"
                                           @change="checkInvalid($event, 'twitter.com')"
                                    >
                                    <div class="invalid-feedback">
                                        {{trans('company','field_only_for')}}{{trans('company','twitter_links')}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Количество сотрудников -->
            <div class="col-sm-6">
                <div class="form-group height-element">
                    <label for="work_experience">
                        {{trans('company','number_employees_company')}}
                    </label>
                    <select class="form-control" id="work_experience"
                            v-model="count_working"
                    >
                        <template v-for="(value, key) in this.settings.count_working">
                            <option :value="`${key}`">
                                {{trans('company',value)}}
                            </option>
                        </template>
                    </select>
                </div>
            </div>
        </div>

        <!-- четвертый row -->
        <div class="row row-youtube">
            <!-- youtube address -->
            <div class="col-sm-12">
                <div class="form-group height-element">
                    <div class="box-link-youtube">
                        <label>
                            {{trans('company','company_video')}} (Youtube)
                        </label>
                        <div id="input_youtube">
                            <div class="input-group input-group">
                                <input type="text" class="form-control input_youtube" maxlength="100" autocomplete="off" placeholder="Ввести адрес">
                                <span class="input-group-append">
                                    <button class="btn btn-warning btn-flat" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M432 64h-96l-33.63-44.75C293.4 7.125 279.1 0 264 0h-80c-15.1 0-29.4 7.125-38.4 19.25L112 64H16C7.201 64 0 71.2 0 80c0 8.799 7.201 16 16 16h416c8.801 0 16-7.201 16-16 0-8.8-7.2-16-16-16zm-280 0 19.25-25.62C174.3 34.38 179 32 184 32h80c5 0 9.75 2.375 12.75 6.375L296 64H152zm248 64c-8.8 0-16 7.2-16 16v288c0 26.47-21.53 48-48 48H112c-26.47 0-48-21.5-48-48V144c0-8.8-7.16-16-16-16s-16 7.2-16 16v288c0 44.1 35.89 80 80 80h224c44.11 0 80-35.89 80-80V144c0-8.8-7.2-16-16-16zM144 416V192c0-8.844-7.156-16-16-16s-16 7.2-16 16v224c0 8.844 7.156 16 16 16s16-7.2 16-16zm96 0V192c0-8.844-7.156-16-16-16s-16 7.2-16 16v224c0 8.844 7.156 16 16 16s16-7.2 16-16zm96 0V192c0-8.844-7.156-16-16-16s-16 7.2-16 16v224c0 8.844 7.156 16 16 16s16-7.2 16-16z"/></svg>
                                    </button>
                                </span>
                                <div class="invalid-feedback">
                                    {{trans('company','field_only_for')}}{{trans('company','youtube_links')}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Добавить адрес -->
                    <div class="add-address"
                         v-if="youtubeObj.tick_youtube < 3"
                         @click="addInputYoutube()"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M352 232h-72v-72c0-13.26-10.74-24-23.1-24S232 146.7 232 160v72h-72c-13.3 0-24 10.7-24 24 0 13.25 10.75 24 24 24h72v72c0 13.25 10.75 24 24 24s24-10.7 24-24v-72h72c13.3 0 24-10.7 24-24s-10.7-24-24-24zM256 0C114.6 0 0 114.6 0 256s114.6 256 256 256 256-114.6 256-256S397.4 0 256 0zm0 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208-93.3 208-208 208z"/></svg>
                        {{trans('company','add_address')}}
                    </div>
                </div>
            </div>
        </div>

        <!-- пятый row -->
        <div class="row row-about-company">
            <!-- Описание компании -->
            <div class="col-sm-12">
                <div class="form-group">
                    <label>
                        {{trans('company','company_description')}}
                        <span class="info-tooltip" data-toggle="tooltip" data-trigger="click"
                              :title="`${trans('vacancies','title_vacancy_description')}`"
                        >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464zM256 336c-18 0-32 14-32 32s13.1 32 32 32c17.1 0 32-14 32-32S273.1 336 256 336zM289.1 128h-51.1C199 128 168 159 168 198c0 13 11 24 24 24s24-11 24-24C216 186 225.1 176 237.1 176h51.1C301.1 176 312 186 312 198c0 8-4 14.1-11 18.1L244 251C236 256 232 264 232 272V288c0 13 11 24 24 24S280 301 280 288V286l45.1-28c21-13 34-36 34-60C360 159 329 128 289.1 128z"/></svg>
                        </span>
                    </label>
                    <ckeditor v-model="objTextarea.about_company"
                              :config="objTextarea.editorConfig1"
                    ></ckeditor>
                </div>
            </div>
        </div>

        <!-- logotype -->
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>
                        {{trans('company','company_logo')}}
                    </label>
                    <!-- компонент подгрузки логотипа -->
                    <load_image_canvas_component
                        :url="update_logotype_url"
                        :format_files="format_files"
                        update_avatar_text="Изменить логотип"
                        description_text="Расширение файлов: .jpg, .jpeg, .png"
                        width="200"
                        height="100"
                        @parent="returnFile"
                        @error_format="errorFormat"
                    ></load_image_canvas_component>
                </div>
            </div>
        </div>

        <!-- button -->
        <div class="row footer-form">
            <div class="col-sm-4 offset-4 but-box">
                <!-- cancel -->
                <a :href="`${lang.prefix_lang}private-office`"
                   class="btn btn-block btn-outline-danger btn-lg">
                    {{trans('vacancies','cancel')}}
                </a>
                <!-- button create -->
                <template v-if="company_id == null">
                    <button type="submit" class="btn btn-block btn-primary btn-lg"
                            :class="{'disabled': disableButton($v)}"
                            :disabled="disableButton($v)"
                            @click.prevent="createCompany"
                    >
                        {{trans('vacancies','save')}}
                    </button>
                </template>
                <!-- button update -->
                <template v-else>
                    <button type="submit" class="btn btn-block btn-primary btn-lg"
                            :class="{'disabled': disableButton($v)}"
                            :disabled="disableButton($v)"
                            @click.prevent="updateCompany"
                    >
                        {{trans('vacancies','update_vacancy')}}
                    </button>
                </template>
            </div>
        </div>

    </div>
</template>

<script>
    import {required} from 'vuelidate/lib/validators'
    import translation from "../../mixins/translation";
    import localisation_functions_mixin from "../../mixins/localisation_functions_mixin";
    import response_methods_mixin from "../../mixins/response_methods_mixin";
    import load_image_canvas_component from "../load_files/LoadImageCanvasComponent";

    export default {
        mixins: [
            translation,
            localisation_functions_mixin,
            response_methods_mixin,
        ],
        components: {
            load_image_canvas_component
        },
        data() {
            return {
                company_id: null,
                objTextarea: {
                    about_company: '',
                    editorConfig1: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList' ]
                        ],
                    },
                },
                imageObj:{
                    load_logotype: null,
                    image_name: null,
                },
                update_logotype_url: 'img/company/default/company-default.jpg',
                company_tax_number: '',
                twitter_input: '',
                telegram_input: '',
                instagram_input: '',
                facebook_input: '',
                position: '',
                site_company: '',
                position_transliteration: '',
                rest_address: null,
                count_working: 0,
                founding_date: '',
                youtubeObj: {
                    bool_youtube: false,
                    input_youtube: {},
                    tick_youtube: 0,
                    dynamic_id: 0,
                },
                format_files: ['.jpg', '.jpeg', '.png'],
            }
        },
        methods: {
            async createCompany(){
                let data = this.getValuesFields()
                data.alias = this.position_transliteration
                const response = await this.$http.post(`/private-office/company`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            location.href = this.lang.prefix_lang+'private-office'
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
            async updateCompany(){
                let data = this.getValuesFields()
                data.company_id = this.company_id
                const response = await this.$http.post(`/private-office/company/update`, data)
                    .then(res => {
                        if(this.checkSuccess(res)){
                            location.href = this.lang.prefix_lang+'private-office'
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
            transliteration(original) {
                let arrEn = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z']
                let arrNum = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0']
                let arrSymbols = ['_', '-', ' ']
                let string = ''
                let symbol = ''

                for (let i = 0; i < original.length; ++i ) {
                    symbol = original[i].toLowerCase()
                    if(arrEn.indexOf(symbol) !== -1 || arrNum.indexOf(symbol) !== -1 || arrSymbols.indexOf(symbol) !== -1){
                        string += (symbol == ' ') ? '-' : symbol
                    }
                }
                this.position_transliteration = string
                this.$v.position_transliteration.$touch()
            },
            switchSvg(e) {
                let element = $(e.currentTarget)
                if(element.hasClass('svg-action')){
                    element.removeClass('svg-action')
                }
                else{
                    element.addClass('svg-action')
                }
            },
            disableButton(v) {
                // v.$invalid
                if(
                    !v.position.required ||
                    !v.rest_address.required ||
                    !v.company_tax_number.required ||
                    (this.company_id === null && (!v.position_transliteration.required || !v.position_transliteration.uniqTranslit)) ||
                    !this.objCategory.categories.length
                ){
                    return true;
                }
                return false;
            },
            getValuesFields(){
                let obj = {
                    country: this.returnFoundObject(this.objLocations.load_countries, this.objLocations.country),
                    region: this.returnFoundObject(this.objLocations.load_regions, this.objLocations.region),
                    city: this.returnFoundObject(this.objLocations.load_cities, this.objLocations.city),
                    categories: this.objCategory.categories,
                    youtube_links: this.addYoutubeArr(),
                    title: this.position,
                    rest_address: this.rest_address,
                    tax_number: this.company_tax_number,
                    founding_date: this.founding_date,
                    facebook_social: this.checkDomain(this.facebook_input, 'facebook.com') ? this.facebook_input : '',
                    instagram_social: this.checkDomain(this.instagram_input, 'instagram.com') ? this.instagram_input : '',
                    telegram_social: this.checkDomain(this.telegram_input, 't.me') ? this.telegram_input : '',
                    twitter_social: this.checkDomain(this.twitter_input, 'twitter.com') ? this.twitter_input : '',
                    site_company: this.site_company,
                    count_working: this.count_working,
                    about_company: this.objTextarea.about_company,
                }

                let image = {
                    name:this.imageObj.image_name,
                    file:this.imageObj.load_logotype
                }
                obj.image = this.imageObj.load_logotype !== null ? JSON.stringify(image) : this.imageObj.load_logotype

                return obj
            },
            // коррекция даты
            checkInsertDate(e){
                let value = e.target.value
                let IPOdate = new Date()
                if( !isNaN( IPOdate.setTime(Date.parse(value)) ) ){
                    // let date = new Date(value)
                    this.founding_date = value
                }
                else{
                    this.founding_date = ''
                }
            },
            // проверка строки на корректный url с нужным доменом
            checkDomain(address, searched_domain){
                let prefixArray = [
                    ['https://'],
                    ['www.'],
                ]
                address = address === null ? '' : address
                prefixArray.push([searched_domain.toLowerCase()])
                let first, check = ''
                let bool_youtube = false

                for(let i = 0; i < prefixArray.length; i++){
                    first = address.substring(0,prefixArray[i][0].length)
                    check = address.substring(prefixArray[i][0].length)
                    // первый префикс сопоставлен
                    if(first.toLowerCase() == prefixArray[i][0]){
                        address = check
                        if(first == searched_domain){
                            bool_youtube = true
                        }
                    }
                }

            return bool_youtube
            },
            checkInvalid(e, searched_domain){
                let bool_youtube = this.checkDomain(e.target.value, searched_domain)

                if(!bool_youtube){
                    $(e.target).addClass('is-invalid')
                }
                else{
                    $(e.target).removeClass('is-invalid')
                }
            },
            // добавить поле youtube по событию add
            addInputYoutube(){
                if(this.youtubeObj.tick_youtube >= 3){
                    return false
                }

                let elem = this.youtubeObj.input_youtube.attr('id', "input_youtube_"+this.youtubeObj.dynamic_id)
                $(elem).children('.input-group').children('.input-group-append').children('button').attr('data-id', "input_youtube_"+this.youtubeObj.dynamic_id)

                $('.box-link-youtube').append( elem.clone() );
                this.youtubeObj.tick_youtube++
                this.youtubeObj.dynamic_id++
            },
            addYoutubeArr(){
                let arr = []
                for (const item of document.querySelectorAll('.input_youtube')) {
                    if(this.checkDomain(item.value, 'youtube.com')){
                        arr.push(item.value)
                    }
                }

                return arr
            },
            returnFile(file){
                this.imageObj.load_logotype = file.canvas
                this.imageObj.image_name = file.name
            },
            errorFormat(name) {
                this.message('File ' + name + ' unacceptable. allowed (.jpg, .jpeg, .png)', 'error', 5000, false, true);
            },
        },
        computed: {
            initializationFunc() {
                this.createArrayCategories()
                this.objLocations.load_countries = this.settings.obj_countries
                this.youtubeObj.input_youtube = $('#input_youtube').remove()
                this.addInputYoutube()
                // проверка вводимых данных в поле youtube
                $(document).on("input", "input.input_youtube", (e) => {
                    this.checkInvalid(e, 'youtube.com')
                });
                // удалить youtube link по событию delete
                $(document).on("click", ".box-link-youtube button", (e) => {
                    let id = $(e.currentTarget).attr('data-id')
                    $("#"+id).remove()
                    this.youtubeObj.tick_youtube--
                });
            },
            // в случае редактирования company
            setValuesFields(){
                if(this.company == null){
                    return false
                }

                this.company_id = this.company.id
                this.position = this.company.title
                this.rest_address = this.company.rest_address
                this.company_tax_number = this.company.tax_number
                this.founding_date = this.company.founding_date === null ? '' : this.company.founding_date
                this.facebook_input = this.company.facebook_social
                this.instagram_input = this.company.instagram_social
                this.telegram_input = this.company.telegram_social
                this.twitter_input = this.company.twitter_social
                this.site_company = this.company.site_company === null ? '' : this.company.site_company
                this.count_working = this.company.count_working_company
                this.objTextarea.about_company = this.company.about_company

                if(this.company.image !== null){
                    this.update_logotype_url = this.company.image.url
                }

                // Location
                this.objLocations.load_countries = this.settings.obj_countries
                this.objLocations.country = this.company.country.code
                this.loadRegions();
                if(this.company.region != null){
                    this.objLocations.region = this.company.region.code
                    setTimeout(() => {
                        this.loadCity()

                        setTimeout(() => {
                            if(this.company.city != null){
                                this.objLocations.city = this.company.city.code
                            }
                            this.objLocations.bool_rest_address = true
                        }, 1500);
                        this.rest_address = this.company.rest_address

                    }, 1500);
                }
                // if(this.company.city != null){
                //     this.objLocations.city = this.company.city.code
                // }
                // setTimeout(() => {
                //     this.objLocations.bool_rest_address = true
                // }, 1000);
                // this.rest_address = this.company.rest_address

                // categories
                this.objCategory.categories = this.company.categories
                var input = '';
                for(let i=0; i<this.objCategory.categories.length; i++) {
                    input = document.querySelector('#category_'+this.objCategory.categories[i]);
                    input.checked = true;
                }
                this.objCategory.boolChecked = true;

                // youtube
                if(Array.isArray(this.company.youtube_links) && this.company.youtube_links.length){
                    // добавить поля
                    for(let i = 1; i < this.company.youtube_links.length; i++){
                        this.addInputYoutube()
                    }
                    // заполнить поля
                    let tick = 0
                    for (const item of document.querySelectorAll('.input_youtube')) {
                        item.value = this.company.youtube_links[tick]
                        tick++
                    }
                }

            },
        },
        props: [
            'lang',
            'settings',
            'company',
        ],
        mounted() {
            this.initializationFunc
            // инициализация всплывающих подсказок
            $('[data-toggle="tooltip"]').tooltip();
            // Код, который будет запущен только после отрисовки всех представлений
            this.$nextTick( () => {
                this.setValuesFields
            })
        },
        validations: {
            position: {
                required,
            },
            position_transliteration: {
                required,
                // проверка на повторение в базе
                uniqTranslit: function(newEmail) {
                    // если поле пустое - не выводи эту ошибку
                    if (newEmail === '') return true

                    return new Promise((resolve, reject) => {
                        $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
                        $.ajax({
                            url: "/private-office/company/check-transliteration",
                            method: "POST",
                            data: {
                                alias: this.position_transliteration
                            },
                            success: (response) => {
                                if(response?.message && response.message){
                                    resolve(false)
                                }
                                else{
                                    resolve(true)
                                }
                            }
                        });
                    })
                }
            },
            rest_address: {
                required,
            },
            company_tax_number: {
                required,
            },
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .input-group-append{
        svg{
            width: 15px;
            path{
                fill: #393939;
            }
        }
    }
    .box-link-youtube{
        & > div{
            margin-bottom: 13px;
        }
        .invalid-feedback{
            margin-bottom: -7px!important;
        }
    }
    .add-address{
        width: 155px;
        font-weight: 600;
        font-size: 14px;
        color: #495057;
        display: flex;
        align-items: center;
        margin: 8px 0 -16px 0;
        cursor: pointer;
        padding-bottom: 7px;
        svg{
            width: 18px;
            margin-right: 5px;
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
    .two-row{
        padding-bottom: 10px;
    }
    .visible {
        display: block;
    }
    .border_error{
        border:1px solid red;
    }
    .row-about-company,
    .row-youtube{
        margin-top: 10px;
    }
    .height-element{
        height: 95%;
    }
    #social-network{
        svg{
            width: 27px;
            margin-right: 10px;
            cursor: pointer;
            path{
                fill: #444;
            }
            &:hover{
                path{
                    fill: #2e4961;
                }
            }
        }
        .instagram-svg{
            width: 25px;
        }
        .twitter-svg{
            width: 28px;
        }
        .svg-action{
            path{
                fill: #0057a5;
            }
        }
    }
    .card{
        border: none;
        margin: 0 0 9px;
        border-radius: 0;
        box-shadow: none;
        background: none;
        .multi-collapse{
            margin-top: 10px;
        }
        .card-body{
            padding: 0 0 0 2px;
            min-height: 31px;
        }
    }
    .box-card-header{
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: flex-start;
        align-content: flex-start;
        align-items: flex-start;
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
    label{
        cursor: pointer;
    }
    .target-label{
        color: $color-a-blue;
        font-weight: 500!important;
    }
    .one-one-box{
        display: flex;
        flex-direction: column;
        & > div:last-child {
            flex-grow: 3;
        }
    }
    /*.one-one-box > div:last-child {*/
    /*    flex-grow: 3;*/
    /*}*/

</style>





























