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
        <h1 v-if="this.contact == null" class="title_page card-body">
            {{trans('contact','fill_information')}}
        </h1>
        <h1 v-else class="title_page card-body">
            {{trans('contact','update_information')}}
        </h1>

        <!-- desc page -->
        <div class="desc-helper-italic">
            {{trans('contact','specified_information_displayed')}}
        </div>

        <!-- первый row -->
        <div class="row">
            <div class="col-sm-4">
                <!-- имя -->
                <div class="form-group">
                    <label for="name">
                        {{trans('contact','your_name')}}
                        <span class="mandatory-filling">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                        </span>
                    </label>
                    <input type="text" id="name" class="form-control" maxlength="100" autocomplete="off"
                           :placeholder="trans('contact','enter_name')"
                           :class="{'is-invalid': $v.name.$error}"
                           v-model="name"
                           @blur="$v.name.$touch()"
                    >
                    <div class="invalid-feedback" v-if="!$v.name.required">
                        {{trans('contact','enter_your_name')}}
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <!-- фамилия -->
                <div class="form-group">
                    <label for="surname">
                        {{trans('contact','your_last_name')}}
                        <span class="mandatory-filling">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                        </span>
                    </label>
                    <input type="text" id="surname" class="form-control" maxlength="100" autocomplete="off"
                           :placeholder="trans('contact','enter_last_name')"
                           :class="{'is-invalid': $v.surname.$error}"
                           v-model="surname"
                           @blur="$v.surname.$touch()"
                    >
                    <div class="invalid-feedback" v-if="!$v.surname.required">
                        {{trans('contact','please_enter_your_last')}}
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <!-- Должность -->
                <div class="form-group">
                    <label for="position">
                        {{trans('contact','position')}}
                    </label>
                    <input type="text" id="position" class="form-control" maxlength="100" autocomplete="off"
                           :placeholder="trans('contact','enter_position')"
                           v-model="position"
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
                </div>
            </div>
        </div>

        <!-- второй row -->
        <div class="row">
            <!-- email -->
            <div class="col-sm-6">
                <div class="form-group">
                    <label>
                        {{trans('contact','email')}}
                        <span class="info-tooltip" data-toggle="tooltip" data-trigger="click"
                              :title="trans('contact','serves_job_seeker')"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464zM256 336c-18 0-32 14-32 32s13.1 32 32 32c17.1 0 32-14 32-32S273.1 336 256 336zM289.1 128h-51.1C199 128 168 159 168 198c0 13 11 24 24 24s24-11 24-24C216 186 225.1 176 237.1 176h51.1C301.1 176 312 186 312 198c0 8-4 14.1-11 18.1L244 251C236 256 232 264 232 272V288c0 13 11 24 24 24S280 301 280 288V286l45.1-28c21-13 34-36 34-60C360 159 329 128 289.1 128z"/></svg>
                        </span>
                    </label>
                    <input type="email" id="email" class="form-control" maxlength="100" autocomplete="off"
                           :placeholder="trans('contact','enter_email')"
                           v-model="email"
                    >
                </div>
            </div>

            <!-- Skype -->
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="skype">
                        Skype
                    </label>
                    <input type="text" id="skype" class="form-control" maxlength="100" autocomplete="off"
                           :placeholder="trans('contact','enter_skype')"
                           v-model="skype"
                    >
                </div>
            </div>
        </div>

        <!-- третий row -->
        <div class="row">
            <!-- Telephone -->
            <div class="col-sm-12 telephone">
                <div class="form-group">
                    <div class="box-left-right">
                        <div class="left-phone">
                            <!-- title -->
                            <label>
                                {{trans('contact','phone')}}
                                <span class="info-tooltip" data-toggle="tooltip" data-trigger="click"
                                      :title="trans('contact','expand_way_contact')"
                                >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464zM256 336c-18 0-32 14-32 32s13.1 32 32 32c17.1 0 32-14 32-32S273.1 336 256 336zM289.1 128h-51.1C199 128 168 159 168 198c0 13 11 24 24 24s24-11 24-24C216 186 225.1 176 237.1 176h51.1C301.1 176 312 186 312 198c0 8-4 14.1-11 18.1L244 251C236 256 232 264 232 272V288c0 13 11 24 24 24S280 301 280 288V286l45.1-28c21-13 34-36 34-60C360 159 329 128 289.1 128z"/></svg>
                            </span>
                            </label>
                            <!-- view -->
                            <div class="view-phone">
                                {{telObj.view_phone}}
                            </div>
                            <!-- inputs -->
                            <div class="box-input-tel">
                                <!-- 1 Код страны и региона -->
                                <span class="minus-tel">+</span>
                                <div class="box-prefix-tel code_country">
                                    <label for="code_country" class="target-label">
                                        {{trans('contact','country_code')}}
                                    </label>
                                    <input type="text" id="code_country" class="form-control" maxlength="100" autocomplete="off"
                                           :placeholder="trans('contact','enter_code')"
                                           :class="{'is-invalid': !checkingInteger(telObj.code_country) && telObj.bool_target_input}"
                                           @keyup="enterCodeTelephon($event.target.value, 'code_country')"
                                    >
                                </div>

                                <!-- 2 Код оператора -->
                                <span class="minus-tel">(</span>
                                <div class="box-prefix-tel operator_code">
                                    <label for="operator_code" class="target-label">
                                        {{trans('contact','operator_code')}}
                                    </label>
                                    <input type="text" id="operator_code" class="form-control" maxlength="100" autocomplete="off"
                                           :placeholder="trans('contact','enter_code')"
                                           :class="{'is-invalid': !checkingInteger(telObj.operator_code) && telObj.bool_target_input}"
                                           @keyup="enterCodeTelephon($event.target.value, 'operator_code')"
                                    >
                                </div>
                                <span class="minus-tel">)</span>

                                <!-- 3 Номер телефона -->
                                <div class="box-prefix-tel phone_number">
                                    <label for="phone_number" class="target-label">
                                        {{trans('contact','phone_number')}}
                                    </label>
                                    <input type="text" id="phone_number" class="form-control" maxlength="100" autocomplete="off"
                                           :placeholder="trans('contact','enter_phone')"
                                           :class="{'is-invalid': !checkingInteger(telObj.phone_number) && telObj.bool_target_input}"
                                           @keyup="enterCodeTelephon($event.target.value, 'phone_number')"
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Месенджеры -->
                        <div class="right-phone">
                            <label>
                                {{trans('contact','messengers_communication')}}
                            </label>
                            <div v-for="(value, key) in this.settings.contact_information" :key="key">
                                <input class="form-check-input" name="checkbox-messenger" type="checkbox"
                                       :id="`checkbox-messenger_${key}`"
                                       @change="checkboxMessenger"
                                       :value="`${key}`"
                                >
                                <label :for="`checkbox-messenger_${key}`" class="target-label">
                                    {{value}}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- avatar -->
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>
                        Аватар пользователя
                    </label>
                    <!-- компонент подгрузки аватар -->
                    <load_image_canvas_component
                        :url="update_avatar_url"
                        :format_files="format_files"
                        update_avatar_text="Изменить аватар"
                        description_text="Расширение файлов: .jpg, .jpeg, .png"
                        width="120"
                        height="150"
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
                <!-- button update -->
                <button type="submit" class="btn btn-block btn-primary btn-lg"
                            :class="{'disabled': disableButton($v)}"
                            :disabled="disableButton($v)"
                            @click.prevent="updateContact"
                    >
                        {{trans('vacancies','update_vacancy')}}
                    </button>
            </div>
        </div>

    </div>
</template>

<script>
    import {email, required} from 'vuelidate/lib/validators'
    import translation from "../../mixins/translation";
    import response_methods_mixin from "../../mixins/response_methods_mixin";
    import general_functions_mixin from "../../mixins/general_functions_mixin";
    import load_image_canvas_component from "../load_files/LoadImageCanvasComponent";

    export default {
        components: {
            load_image_canvas_component
        },
        mixins: [
            translation,
            response_methods_mixin,
            general_functions_mixin,
        ],
        data() {
            return {
                contact_id:null,
                name:'',
                surname:'',
                position:'',
                email:'',
                skype:'',
                telObj:{
                    code_country: '',
                    operator_code: '',
                    phone_number: '',
                    view_phone: "+...(...).......",
                    checkbox_messenger: [],
                    bool_target_input: false,
                    bool_all_filled: true,
                },
                position_list: [],
                load_avatar: null,
                update_avatar_url: null,
                image_name: null,
                format_files: ['.jpg', '.jpeg', '.png'],
            }
        },
        methods: {
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
                        else{

                        }
                    })
                    // ошибки сервера
                    .catch(err => {
                        // this.messageError(err)
                    })
            },
            async updateContact(){
                let data = this.getValuesFields()
                data.contact_id = this.contact_id

                const response = await this.$http.post(`/private-office/contact-information/update`, data)
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
            enterCodeTelephon(value, variable){
                this.telObj.bool_target_input = true
                this.telObj.bool_all_filled = true
                this.telObj[variable] = value
                this.telObj.bool_error = this.checkingInteger(value)

                // отображение номера
                if(!this.telObj.bool_error){
                    this.telObj.view_phone = "+...(...)......."
                }
                else{
                    this.telObj.view_phone = "+"+this.telObj.code_country+"("+this.telObj.operator_code+")"+this.telObj.phone_number
                }
                // проверка заполнености всех input
                if(!this.checkingInteger(this.telObj.code_country) || !this.checkingInteger(this.telObj.operator_code) || !this.checkingInteger(this.telObj.phone_number)){
                    this.telObj.bool_all_filled = false
                }
            },
            checkboxMessenger(){
                let checked = document.querySelectorAll('[name="checkbox-messenger"]:checked');
                let selected = [];
                for (let i=0; i<checked.length; i++) {
                    selected.push(parseInt(checked[i].value));
                }
                this.telObj.checkbox_messenger = selected;
            },
            disableButton(v) {
                if(v.$invalid){
                    return true;
                }
                return false;
            },
            getValuesFields(){
                let obj = {
                    name: this.name,
                    surname: this.surname,
                    position: this.position,
                    email: this.email,
                    skype: this.skype,
                    phone: this.telObj.view_phone,
                    messengers: this.telObj.checkbox_messenger,
                }

                let image = {
                    name:this.image_name,
                    file:this.load_avatar
                }
                obj.image = this.load_avatar !== null ? JSON.stringify(image) : this.load_avatar

                return obj
            },
            setValuePosition(value){
                $('#position_list').removeClass('show')
                this.position = value
            },
            fillDataPhone(value){
                if(value === ''){
                    return false
                }
                if(value.indexOf('+') === -1 || value.indexOf('(') === -1 || value.indexOf(')') === -1){
                    return true
                }
                // 1
                let arr_phone = value.split('+').pop().split('(');
                this.telObj.code_country = arr_phone[0];
                $('#code_country').val(this.telObj.code_country)
                // 2
                arr_phone = arr_phone[1].split(')')
                this.telObj.operator_code = arr_phone[0];
                $('#operator_code').val(this.telObj.operator_code)
                // 3
                this.telObj.phone_number = arr_phone[1];
                $('#phone_number').val(this.telObj.phone_number)

                this.telObj.bool_target_input = true
            },
            returnFile(file){
                this.load_avatar = file.canvas
                this.image_name = file.name
            },
            errorFormat(name) {
                this.message('File ' + name + ' unacceptable. allowed (.jpg, .jpeg, .png)', 'error', 5000, false, true);
            },
        },
        computed: {
            // в случае редактирования company
            setValuesFields(){
                if(this.contact == null){
                    return false
                }

                this.contact_id = this.contact.id
                this.name = this.contact.name
                this.surname = this.contact.surname
                this.position = this.contact.position !== null ? this.contact.position.title : ''
                this.email = this.contact.email !== null ? this.contact.email : ''
                this.skype = this.contact.skype
                // телефон
                this.telObj.view_phone = this.contact.phone !== null ? this.contact.phone : ''
                this.fillDataPhone(this.telObj.view_phone)
                // месенджеры
                let input = '';
                this.telObj.checkbox_messenger = this.contact.messengers !== null ? this.contact.messengers : []
                for(let i=0; i<this.telObj.checkbox_messenger.length; i++) {
                    input = document.querySelector('#checkbox-messenger_'+this.telObj.checkbox_messenger[i]);
                    input.checked = true;
                }
                // avatar
                this.update_avatar_url = this.contact.avatar === null ? this.contact.default_avatar_url : this.contact.avatar.url
            },
        },
        props: [
            'lang',
            'contact',
            'settings',
        ],
        mounted() {
            // инициализация всплывающих подсказок
            $('[data-toggle="tooltip"]').tooltip();
            this.$nextTick( () => {
                this.setValuesFields
            })
        },
        validations: {
            name: {
                required,
            },
            surname: {
                required,
            },
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .form-group {
        padding: 5px 10px 15px;
        background: #ededed;
        position: relative;
        .invalid-feedback {
            margin-bottom: -13px;
            padding: 3px 0px 1px 0px;
        }
    }
    .telephone{
        .box-left-right{
            display: flex;
            .left-phone{
                width: 50%;
                .box-input-tel{
                    display: flex;
                    align-items: flex-end;

                    .minus-tel{
                        line-height: 38px;
                    }
                    .code_country,
                    .operator_code{
                        margin: 0 10px;
                    }
                    .phone_number{
                        margin-left: 10px;
                    }
                    .box-prefix-tel{
                        #code_country,
                        #phone_number,
                        #operator_code{
                            width: 140px;
                        }
                    }
                }
            }
            .right-phone{
                width: 50%;
            }
        }

        .invalid-feedback {
            display: block;
        }
        .view-phone{
            border-bottom: 1px dashed #444;
            width: 160px;
            margin-bottom: 10px;
        }
    }
    .target-label {
        color: #035ba4;
        font-weight: 500 !important;
        cursor: pointer;
    }
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
    .desc-helper-italic,
    h1{
        padding-left: 4px;
    }

</style>





























