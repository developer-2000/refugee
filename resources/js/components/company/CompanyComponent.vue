<template>
    <div class="box-page container">
        <!-- left -->
        <div class="left-site">
            <!-- company logo -->
            <div class="box-title">
                <h3 class="font-weight-bold">
                    {{company.title}}
                </h3>
                <img :src="`/${company.image.url}`"
                     :alt="company.image.title"
                >
            </div>
            <!-- свойства -->
            <div class="box-properties">
                <div class="line-property property-category">
                    <span class="box-svg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 168c-48.6 0-88 39.4-88 88s39.38 88 88 88 88-39.4 88-88-39.4-88-88-88zm0 128c-22.9 0-40-18-40-40 0-21.1 17.1-40 40-40 21.1 0 40 18 40 40s-18.9 40-40 40zm232-64h-41.63C435.5 145.2 366.8 76.5 280 65.62V23.1c0-13.25-10.75-24-23.1-24S232 10.75 232 23.1v42.52C145.2 76.5 76.5 145.2 65.62 232H23.1C10.75 232 0 242.7 0 255.1S10.75 280 23.1 280h41.63C76.5 366.8 145.2 435.5 232 446.4v41.63c0 13.25 10.75 23.1 23.1 23.1S280 501.3 280 488v-41.63C366.8 435.5 435.5 366.8 446.4 280H488c13.25 0 24-10.75 24-23.1S501.3 232 488 232zM256 400c-79.38 0-144-64.63-144-144s64.6-144 144-144 144 64.62 144 144-64.6 144-144 144z"/></svg>
                    </span>
                    <span>
                        <template v-for="(value, key) in company.categories">
                            {{trans('vacancies',settings.categories[value])}},
                        </template>
                    </span>
                </div>
                <div class="line-property property-location">
                    <span class="box-svg">
                        <svg viewBox="0 0 384 512" xmlns="http://www.w3.org/2000/svg"><path d="M168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2H168.3zM192 256C227.3 256 256 227.3 256 192C256 156.7 227.3 128 192 128C156.7 128 128 156.7 128 192C128 227.3 156.7 256 192 256z"/></svg>
                    </span>
                    <span>
                        {{addressView(company)}}
                    </span>
                </div>
                <!-- phone -->
                <div v-if="company.contact !== null" class="line-property property-mobile">
                    <span class="box-svg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M304 0H80C44.65 0 16 28.65 16 64v384c0 35.35 28.65 64 64 64h224c35.35 0 64-28.65 64-64V64c0-35.35-28.7-64-64-64zm16 448c0 8.822-7.178 16-16 16H80c-8.82 0-16-7.2-16-16v-80h256v80zm0-128H64V64c0-8.822 7.178-16 16-16h224c8.8 0 16 7.18 16 16v256zM160 432h64c8.836 0 16-7.164 16-16s-7.164-16-16-16h-64c-8.836 0-16 7.164-16 16s7.2 16 16 16z"/></svg>
                    </span>
                    <div class="target-label"
                         v-if="!bool_show_phone"
                         @click="bool_show_phone = true"
                    >
                        Показать номер
                    </div>
                    <a href="javascript:void(0)"
                         v-else
                         @click="copyPhone($event.target)"
                    >{{company.contact.phone.replaceAll(/[(-)]/ig, ' ')}}</a>
                    <template v-for="(value, key) in company.contact.messengers">
                        <div v-if="settings.contact_information[value] == 'Telegram'">
                            <svg class="svg-telegram" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248,8C111.033,8,0,119.033,0,256S111.033,504,248,504,496,392.967,496,256,384.967,8,248,8ZM362.952,176.66c-3.732,39.215-19.881,134.378-28.1,178.3-3.476,18.584-10.322,24.816-16.948,25.425-14.4,1.326-25.338-9.517-39.287-18.661-21.827-14.308-34.158-23.215-55.346-37.177-24.485-16.135-8.612-25,5.342-39.5,3.652-3.793,67.107-61.51,68.335-66.746.153-.655.3-3.1-1.154-4.384s-3.59-.849-5.135-.5q-3.283.746-104.608,69.142-14.845,10.194-26.894,9.934c-8.855-.191-25.888-5.006-38.551-9.123-15.531-5.048-27.875-7.717-26.8-16.291q.84-6.7,18.45-13.7,108.446-47.248,144.628-62.3c68.872-28.647,83.183-33.623,92.511-33.789,2.052-.034,6.639.474,9.61,2.885a10.452,10.452,0,0,1,3.53,6.716A43.765,43.765,0,0,1,362.952,176.66Z"/></svg>
                        </div>
                        <div v-if="settings.contact_information[value] == 'Viber'">
                            <svg class="svg-viber"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M444 49.9C431.3 38.2 379.9.9 265.3.4c0 0-135.1-8.1-200.9 52.3C27.8 89.3 14.9 143 13.5 209.5c-1.4 66.5-3.1 191.1 117 224.9h.1l-.1 51.6s-.8 20.9 13 25.1c16.6 5.2 26.4-10.7 42.3-27.8 8.7-9.4 20.7-23.2 29.8-33.7 82.2 6.9 145.3-8.9 152.5-11.2 16.6-5.4 110.5-17.4 125.7-142 15.8-128.6-7.6-209.8-49.8-246.5zM457.9 287c-12.9 104-89 110.6-103 115.1-6 1.9-61.5 15.7-131.2 11.2 0 0-52 62.7-68.2 79-5.3 5.3-11.1 4.8-11-5.7 0-6.9.4-85.7.4-85.7-.1 0-.1 0 0 0-101.8-28.2-95.8-134.3-94.7-189.8 1.1-55.5 11.6-101 42.6-131.6 55.7-50.5 170.4-43 170.4-43 96.9.4 143.3 29.6 154.1 39.4 35.7 30.6 53.9 103.8 40.6 211.1zm-139-80.8c.4 8.6-12.5 9.2-12.9.6-1.1-22-11.4-32.7-32.6-33.9-8.6-.5-7.8-13.4.7-12.9 27.9 1.5 43.4 17.5 44.8 46.2zm20.3 11.3c1-42.4-25.5-75.6-75.8-79.3-8.5-.6-7.6-13.5.9-12.9 58 4.2 88.9 44.1 87.8 92.5-.1 8.6-13.1 8.2-12.9-.3zm47 13.4c.1 8.6-12.9 8.7-12.9.1-.6-81.5-54.9-125.9-120.8-126.4-8.5-.1-8.5-12.9 0-12.9 73.7.5 133 51.4 133.7 139.2zM374.9 329v.2c-10.8 19-31 40-51.8 33.3l-.2-.3c-21.1-5.9-70.8-31.5-102.2-56.5-16.2-12.8-31-27.9-42.4-42.4-10.3-12.9-20.7-28.2-30.8-46.6-21.3-38.5-26-55.7-26-55.7-6.7-20.8 14.2-41 33.3-51.8h.2c9.2-4.8 18-3.2 23.9 3.9 0 0 12.4 14.8 17.7 22.1 5 6.8 11.7 17.7 15.2 23.8 6.1 10.9 2.3 22-3.7 26.6l-12 9.6c-6.1 4.9-5.3 14-5.3 14s17.8 67.3 84.3 84.3c0 0 9.1.8 14-5.3l9.6-12c4.6-6 15.7-9.8 26.6-3.7 14.7 8.3 33.4 21.2 45.8 32.9 7 5.7 8.6 14.4 3.8 23.6z"/></svg>
                        </div>
                        <div v-if="settings.contact_information[value] == 'WhatsApp'">
                            <svg class="svg-whatsapp"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>
                        </div>
                    </template>

                </div>
                <div class="line-property"
                     v-if="company.site_company"
                >
                    <span class="box-svg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 16C123.5 16 16 123.5 16 256s107.5 240 240 240 239.1-107.5 239.1-240S388.5 16 256 16zm166 144h-48.7c-6.391-27.41-15.39-52.18-26.48-73.1C378.2 103.8 404.2 129.2 422 160zm-86 96c0 16.98-1.295 32.82-3.176 48H179.2c-1.9-15.2-3.2-31.9-3.2-48s1.295-32.82 3.176-48h153.6C334.7 223.2 336 239 336 256zm-80 192c-21.79 0-50.87-36.42-67.28-96h134.6c-16.42 59.6-45.52 96-67.32 96zm-67.3-288c16.4-59.6 45.5-96 67.3-96s50.87 36.42 67.28 96H188.7zm-23.5-73.1c-11.1 20.9-20.1 45.7-26.5 73.1H89.98c17.82-30.8 43.82-56.2 75.22-73.1zM70.32 208h60.25c-1.67 15.5-2.57 31.6-2.57 48s.9 32.5 2.6 48H70.32C66.34 288.6 64 272.6 64 256s2.34-32.6 6.32-48zm19.66 144h48.72c6.391 27.41 15.39 52.18 26.48 73.1-31.38-16.9-57.38-42.3-75.2-73.1zm256.82 73.1c11.1-20.9 20.1-45.7 26.5-73.1h48.74c-17.84 30.8-43.84 56.2-75.24 73.1zM441.7 304h-60.25c1.68-15.51 2.57-31.56 2.57-48s-.89-32.49-2.57-48h60.25c4 15.4 6.3 31.4 6.3 48s-2.3 32.6-6.3 48z"/></svg>
                    </span>
                    <a :href="company.site_company" target="_blank" class="link-a">
                        {{trans('company','company_website')}}
                    </a>
                </div>
                <div class="line-property property-employees">
                    <span class="box-svg">
                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 203"><path d="M47.2 26.1c-13.1 6.5-13.1 25.4 0 31.8 5.7 2.7 10.3 2.7 15.8-.2 13.2-6.6 13.2-24.8 0-31.5-5.6-2.8-10.3-2.8-15.8-.1zM119.6 25.5C112.2 28.1 106 37 106 45c0 5.1 3.1 11.8 7 15.4 8.5 7.7 20.5 7.3 28.6-.8 8.5-8.4 8.5-20.8 0-29.2-6-6.1-13.8-7.8-22-4.9zM191.2 26.1c-13.1 6.5-13.1 25.4 0 31.8 5.7 2.7 10.3 2.7 15.8-.2 13.2-6.6 13.2-24.8 0-31.5-5.6-2.8-10.3-2.8-15.8-.1zM38 73.6c-15.3 4.1-27.2 17.1-30.1 32.9-3 16 3.4 31.7 16.7 41.4l6.4 4.6v8.6c0 10.5 1.2 14.2 5.5 16.9 2.9 1.8 4.9 2 18.4 2 22 0 24.1-1.6 24.1-18 0-8.9-.1-9.3-3-12.2-2.7-2.6-3.6-3-6.7-2.5-5.2.9-7.5 3.6-8.1 9.6l-.5 5.1H49V90h8.3c4.6.1 10 .7 12.2 1.6 3.9 1.4 4 1.4 6-1.3 1.1-1.5 3.7-4.6 5.7-6.8l3.7-4.2-3.8-2.1c-2-1.2-6.4-2.8-9.6-3.7-7.6-1.9-26-1.9-33.5.1zm-7 40.6v15.3l-2-2.5c-3.1-4-4.5-12.1-3.2-18 1-4.4 3.7-10 4.8-10 .2 0 .4 6.9.4 15.2zM182.1 73.6c-3 .8-7.1 2.4-9.2 3.6l-3.8 2.1 3.7 4.2c2 2.2 4.6 5.3 5.7 6.9l2 2.7 4.4-1.5c2.5-1 7.6-1.6 12.2-1.6h7.9v72h-12v-4.6c0-3.7-.5-5.1-3-7.6-2.7-2.6-3.6-3-6.7-2.5-6.2 1-7.7 3.5-8.2 12.9-.4 10.4.9 15 5.3 17.7 3 1.9 4.9 2.1 18.5 2.1 22.1 0 24.1-1.5 24.1-18.3v-9.5l4.8-3.1c6.1-3.9 9.2-7.2 13.5-14.3 13.8-23.1.6-54.5-25.8-61.3-7.6-1.9-26.1-1.9-33.4.1zm45.9 33.2c2 7.2.7 15.9-3 20.4-1.9 2.3-1.9 2.3-1.9-13.2s0-15.5 1.9-13.2c1.1 1.3 2.4 4 3 6z"/><path d="M110 79.6c-15.3 4.1-27.2 17.1-30.1 32.9-3 16 3.4 31.7 16.7 41.4l6.4 4.6v11.6c0 20.6 1.4 21.9 23.9 21.9 22.8 0 24.1-1.1 24.1-21.3v-12.5l4.8-3.1c6.1-3.9 9.2-7.2 13.5-14.3 13.8-23.1.6-54.5-25.8-61.3-7.6-1.9-26.1-1.9-33.5.1zm23 55.4v39h-12V96h12v39zm-30-14.8v15.3l-2-2.5c-3.1-4-4.5-12.1-3.2-18 1-4.4 3.7-10 4.8-10 .2 0 .4 6.9.4 15.2zm53-7.4c2 7.2.7 15.9-3 20.4-1.9 2.3-1.9 2.3-1.9-13.2s0-15.5 1.9-13.2c1.1 1.3 2.4 4 3 6z"/></svg>
                    </span>
                    {{UpperCaseFirstCharacter( trans('company',settings.count_working[company.count_working_company]) )}}
                </div>
                <div class="line-property">
                    <span class="box-svg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M232 120C232 106.7 242.7 96 256 96C269.3 96 280 106.7 280 120V243.2L365.3 300C376.3 307.4 379.3 322.3 371.1 333.3C364.6 344.3 349.7 347.3 338.7 339.1L242.7 275.1C236 271.5 232 264 232 255.1L232 120zM256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0zM48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48C141.1 48 48 141.1 48 256z"/></svg>
                    </span>
                    {{UpperCaseFirstCharacter( trans('company','on_site_from')+' '+getDate(company.created_at)+' '+trans('company','years') )}}
                </div>
            </div>
        </div>

        <!-- right -->
        <div class="right-site">
            <!-- top panel -->
            <div class="top-panel">
                <div class="box-soc-button">
                    <a v-if="company.facebook_social"
                       :href="company.facebook_social"
                       target="_blank"
                    >
                        <svg class="svg-facebook" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"/></svg>
                    </a>
                    <a v-if="company.instagram_social"
                       :href="company.instagram_social"
                       target="_blank"
                    >
                        <svg class="svg-instagram" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
                    </a>
                    <a v-if="company.telegram_social"
                       :href="company.telegram_social"
                       target="_blank"
                    >
                        <svg class="svg-telegram" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248,8C111.033,8,0,119.033,0,256S111.033,504,248,504,496,392.967,496,256,384.967,8,248,8ZM362.952,176.66c-3.732,39.215-19.881,134.378-28.1,178.3-3.476,18.584-10.322,24.816-16.948,25.425-14.4,1.326-25.338-9.517-39.287-18.661-21.827-14.308-34.158-23.215-55.346-37.177-24.485-16.135-8.612-25,5.342-39.5,3.652-3.793,67.107-61.51,68.335-66.746.153-.655.3-3.1-1.154-4.384s-3.59-.849-5.135-.5q-3.283.746-104.608,69.142-14.845,10.194-26.894,9.934c-8.855-.191-25.888-5.006-38.551-9.123-15.531-5.048-27.875-7.717-26.8-16.291q.84-6.7,18.45-13.7,108.446-47.248,144.628-62.3c68.872-28.647,83.183-33.623,92.511-33.789,2.052-.034,6.639.474,9.61,2.885a10.452,10.452,0,0,1,3.53,6.716A43.765,43.765,0,0,1,362.952,176.66Z"/></svg>
                    </a>
                    <a v-if="company.twitter_social"
                       :href="company.twitter_social"
                       target="_blank"
                    >
                        <svg class="svg-twitter" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"/></svg>
                    </a>
                </div>
                <div class="box-scroll-button">
                    <button class="btn btn-block btn-outline-primary" type="button"
                            @click="scrollToAbout()"
                    >
                        {{trans('company','company_information')}}
                    </button>
                    <button class="btn btn-block btn-outline-primary" type="button"
                            @click="scrollToVacancies()"
                    >
                        {{trans('company','jobs')}}
                    </button>
                </div>
            </div>
            <!-- О компании -->
            <div class="box-about-company" id="box-about-company">
                <h3 class="font-weight-bold">
                    {{trans('company','about_company_2')}}
                </h3>
                <div v-if="company.about_company" class="about-company"
                     v-html="company.about_company"
                >
                </div>
                <div v-else class="about-company">
                    <i>
                        {{trans('company','company_description_empty')}}
                    </i>
                </div>
            </div>
            <!-- youtube -->
            <div v-if="company.youtube_links" class="box-media-files">
                <h3 class="font-weight-bold">
                    {{trans('company','media_files')}}
                </h3>
                <div class="container-fluid block-media-files ">
                    <div class="row">
                        <template v-for="(url, key) in company.youtube_links">
                            <iframe
                                class='col-sm-4 iframe-youtube'
                                :src="`https://www.youtube.com/embed/${getIfFrame(url)}`"
                                :srcdoc="`<style>
                            *{padding:0;margin:0;overflow:hidden}
                            html,body{height:100%}
                            img,span{position:absolute;width:100%;top:0;bottom:0;margin:auto}
                            span{height:1.5em;text-align:center;font:48px/1.5 sans-serif;color:white;text-shadow:0 0 0.5em black;}
                            .img{width: 52px;left: calc((100% / 2) - 25px);}
                            </style>
                            <a href=https://www.youtube.com/embed/${getIfFrame(url)}?autoplay=1>
                            <img src=https://img.youtube.com/vi/${getIfFrame(url)}/hqdefault.jpg alt='Demo video'>
                            <span class='span'><img class='img' src=/img/custom/youtube_button.png alt='Demo video'></span>
                            </a>`"
                                frameborder="0"
                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                                title="Demo video">
                            </iframe>
                        </template>
                    </div>
                </div>
            </div>
            <!-- vacancies -->
            <div class="box-company-vacancies" id="box-company-vacancies">
                <h3 class="font-weight-bold">
                    {{trans('company','company_vacancies')}}
                </h3>
                <!-- vacancies yes -->
                <div class="block-company-vacancies" v-if="company.vacancies.length">
                    <!-- item -->
                    <div class="box-vacancy"
                         v-for="(vacancy, key) in company.vacancies" :key="key"
                         :id="`v${key}`"
                         @click.prevent="transitionToVacancy(vacancy.alias)"
                    >
                        <!-- лента -->
                        <div class="ribbon-wrapper">
                            <div class="ribbon euro-color">
                                <svg xmlns="http://www.w3.org/2000/svg" class="euro-star-icon" viewBox="0 0 576 512"><path d="m305.3 12.57 54.9 169.03h177.6c17.6 0 24.92 22.55 10.68 32.9L404.78 319l54.89 169.1c5.44 16.76-13.72 30.69-27.96 20.33L288 403.1 144.3 507.6c-14.24 10.36-33.4-3.577-27.96-20.33l54.89-169.1L27.53 214.5c-14.25-10.3-6.93-32.9 10.68-32.9h177.6L270.7 12.5c5.5-16.69 29.1-16.69 34.6.07z"/></svg>
                            </div>
                        </div>
                        <!-- vacancy -->
                        <vacancy_template
                            :vacancy="vacancy"
                            :settings="settings"
                            :lang="lang"
                            :page="'search'"
                        ></vacancy_template>

                        <div class="footer-vacancy">
                            <!-- отображение прошедшего времени -->
                            <div class="date-document">
                                {{getDateDocumentString(vacancy.updated_at)}} назад
                            </div>

                            <!-- кнопки закладок вакансий -->
                            <bookmark_buttons
                                :lang="lang"
                                :vacancy="vacancy"
                                :user="user"
                                :which_button_show="'search_vacancy'"
                            ></bookmark_buttons>
                        </div>

                    </div>
                </div>
                <div class="block-company-vacancies" v-else>
                    <i>{{trans('company','no_vacancies_created')}}</i>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import response_methods_mixin from "../../mixins/response_methods_mixin";
    import bookmark_buttons from "../vacancy/details/BookmarkButtonsVacancyComponent";
    import vacancy_template from "../vacancy/details/VacancyTemplateComponent";
    import translation from "../../mixins/translation";
    import general_functions_mixin from "../../mixins/general_functions_mixin";
    import date_mixin from "../../mixins/date_mixin";

    export default {
        mixins: [
            response_methods_mixin,
            translation,
            general_functions_mixin,
            date_mixin
        ],
        components: {
            'bookmark_buttons': bookmark_buttons,
            'vacancy_template': vacancy_template,
        },
        data() {
            return {
                bool_show_phone: false,
            }
        },
        methods: {
            addressView(companyObj){
                let address_string = ''

                if(companyObj.country !== null){
                    address_string += companyObj.country.name+'.'
                }
                if(companyObj.region !== null){
                    address_string += ' ' + companyObj.region.name+'.'
                }
                if(companyObj.city !== null){
                    address_string += ' ' + companyObj.city.name+'.'
                }

                address_string += ' ' + companyObj.rest_address+'.'

                return address_string
            },
            getDate(value){
                let string, date = new Date(value)
                string = date.toLocaleString('default', { month: 'long' })
                string = string.charAt(0).toUpperCase() + string.slice(1)
                string = string +' '+ date.getFullYear()

                return string
            },
            getIfFrame(url){
                let id = null
                var youtubeRegExp = /(?:[?&]vi?=|\/embed\/|\/\d\d?\/|\/vi?\/|https?:\/\/(?:www\.)?youtu\.be\/)([^&\n?#]+)/;
                var match = url.match( youtubeRegExp );

                if( match && match[ 1 ].length == 11 ) {
                    id = match[ 1 ];
                }
                else{
                    this.message('В ссылке id видео не корректно!', 'error', 10000, false);
                    return false
                }

                return id
            },
            transitionToVacancy(vacancy_alias){
                location.href = this.lang.prefix_lang+'vacancy/'+vacancy_alias
            },
            scrollToAbout(){
                const el = document.getElementById('box-about-company');
                $('html,body').animate({
                    scrollTop:$(el).offset().top+"px"
                }, 500, 'linear');
            },
            scrollToVacancies(){
                const el = document.getElementById('box-company-vacancies');
                $('html,body').animate({
                    scrollTop:$(el).offset().top+"px"
                }, 500, 'linear');
            },
            // скопировать в буфер
            copyPhone(el){
                this.copyToClipboard(el)
                this.message("Номер скопировать в буфер обмена", 'success', 5000, false);
            },
        },
        props: [
            'lang',
            'company',
            'settings',
            'user',
        ],
        mounted() {
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .iframe-youtube{
        min-height: 190px;
    }
    .font-weight-bold{
        margin-bottom: 20px;
    }
    .box-page{
        display: flex;
        padding: 0;

        .left-site {
            border-right: 1px solid #dee2e6;
            width: 400px;
            padding: 20px 15px;

            .box-title{
                text-align: center;
                margin-bottom: 15px;
                img{
                    width: 200px;
                    height: 100px;
                }
            }
            .box-properties {
                padding: 10px 0;
                .line-property{
                    display: flex;
                    align-items: center;
                    line-height: 18px;
                    margin-bottom: 5px;
                    .box-svg {
                        min-width: 30px;
                        display: block;
                        line-height: 16px;
                        margin-right: 5px;
                        text-align: center;
                        padding: 2px 0;
                    }
                }
                .property-category {
                    svg {
                        width: 22px;
                    }
                }
                .property-location {
                    svg {
                        width: 17px;
                    }
                }
                .property-mobile {
                    svg {
                        width: 18px;
                    }
                    &>div{
                        svg {
                            margin-left: 5px;
                        }
                    }
                }
                .property-employees {
                    svg {
                        width: 26px;
                    }
                }
            }
        }

        .right-site{
            width: 100%;
            padding: 0 15px;
            &>div{
                margin-bottom: 40px;
            }
            &>div:last-child{
                margin-bottom: 15px;
            }
            .top-panel {
                display: flex;
                justify-content: space-between;
                position: -webkit-sticky;
                position: sticky;
                top: 0;
                border-bottom: 1px solid #dee2e6;
                background-color: #fff;
                padding: 15px;
                margin: 0 -15px;
                z-index: 10;
                font-size: 17px;
                .box-soc-button{
                    display: flex;
                    align-items: center;
                    svg{
                        width: 30px;
                        margin-right: 10px;
                        cursor: pointer;
                        &:hover{
                            outline: 1px solid #acddfb;
                            border-radius: 7px;
                            padding: 1px;
                        }
                    }
                }
                .box-scroll-button{
                    display: flex;
                    button{
                        width: auto;
                        margin-left: 10px;
                    }
                }
                button {
                    margin-right: 5px !important;
                }
            }
            .box-about-company{
                padding: 20px 0 0;
            }
            .box-media-files{
                .block-media-files{
                    padding: 0;
                    margin: 0 -2px;
                    img{
                        width: 150px;
                    }
                }
            }
            .box-company-vacancies{
                .block-company-vacancies{
                    padding: 0;
                    img{
                        width: 150px;
                    }
                }
            }
        }
    }

    svg {
        fill: #1d68a7;
    }
    .svg-facebook{
        path{
            fill: #0268e2;
        }
    }
    .svg-instagram{
        path{
            fill: #b542e1;
        }
    }
    .svg-telegram{
        path{
            fill: #2197d0;
        }
    }
    .svg-twitter{
        path{
            fill: #1c99e6;
        }
    }
    .svg-viber{
        path{
            fill: #754d94;
        }
    }
    .svg-whatsapp{
        path{
            fill: #259a16;
        }
    }

</style>





























