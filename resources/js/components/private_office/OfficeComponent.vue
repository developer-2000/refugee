<template>
    <div class="forms office">
        <h1 class="title_page card-body">Личный кабинет</h1>

        <div class="box-settings">
            <div class="container-fluid">
                <ul class="inline-ul">
                    <li>
                        <a :href="`${lang.prefix_lang}private-office/vacancy/bookmark-vacancies`">
                            <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                <path d="m462.3 62.71c-54.5-46.5-136.1-38.99-186.6 13.27l-19.69 20.61-19.71-20.61c-40.7-42.13-123-67.27-186.54-13.27-62.87 53.49-66.07 149.79-9.95 207.79l193.2 199.7c6.29 6.5 14.79 9.8 22.89 9.8 8.25 0 16.33-3.25 22.58-9.751l193.6-199.8c56.42-57.949 53.02-154.25-9.78-207.74zm-13 185.49-192.9 199.9-193.64-199.9c-38.37-39.5-46.37-115 7.75-161.11 54.79-46.88 119.29-12.87 142.79 11.5l42.75 44.13 42.75-44.13c23.13-24 88.13-58 142.8-11.5 53.9 46.01 46 121.51 7.7 161.11z"/>
                            </svg>
                            <span>
                                Закладки вакансий
                            </span>
                        </a>
                    </li>
                    <li>
                        <a :href="`${lang.prefix_lang}private-office/vacancy/my-vacancies`">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M448 96h-64V48c0-26.47-21.5-48-48-48H176c-26.5 0-48 21.53-48 48v48H64c-35.35 0-64 28.7-64 64v256c0 35.35 28.65 64 64 64h384c35.35 0 64-28.65 64-64V160c0-35.3-28.7-64-64-64zM160 48c0-8.83 7.2-16 16-16h160c8.8 0 16 7.17 16 16v48H160V48zm320 368c0 17.64-14.36 32-32 32H64c-17.64 0-32-14.36-32-32V288h144v64c0 8.844 7.156 16 16 16h128c8.844 0 16-7.156 16-16v-64h144v128zm-272-80v-48h96v48h-96zm272-80H32v-96c0-17.64 14.36-32 32-32h384c17.64 0 32 14.36 32 32v96z"/></svg>
                            <span>
                                Мои вакансии
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>



    </div>
</template>

<script>

    export default {
        mixins: [
        ],
        data() {
            return {
            }
        },
        methods: {
        },
        props: [
            'lang',   // масив названий и url языка
        ],
        mounted() {
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    h1{
        padding-left: 15px;
    }
    .box-settings{
        li {
            display: block;
            float: left;
            background-color: #fff;
            outline: 1px solid #e9ebed;
            margin: 0 0 -1px -1px;
            max-width: 33.33333333%;
            padding: 0;
            width: 100%;
            &:hover{
                outline: 1px solid #c0ddfb;
                position: relative;
                z-index: 9;
            }
            a {
                display: flex;
                align-items: center;
                padding: 15px;
                font-size: 18px;
                svg{
                    width: 35px;
                    margin-right: 15px;
                    path{
                        fill:#3490dc;
                    }
                }
                &:hover{
                    svg{
                        path{
                            fill:#1d68a7;
                        }
                    }
                }
            }
        }
    }


    @media (max-width: 767px) {
        .box-settings li {
            border-left: none;
            border-right: none;
            max-width: 100%;
            width: 100%;
        }
    }

</style>





























