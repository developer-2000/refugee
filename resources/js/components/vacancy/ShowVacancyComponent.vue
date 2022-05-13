<template>
    <div>
        <!-- Breadcrumbs stroke -->
        <div class="top-panel bread-top">
            <template v-for="(array, key) in back_url">
                <a :href="`/${array.url}`">{{array.name}}</a>
                <span class="bread-slash"> / </span>
            </template>

        </div>
        <!-- buttons -->
        <div class="top-panel">
            <button class="btn btn-block btn-outline-primary" type="button">
                Откликнуться
            </button>
            <button class="btn btn-block btn-outline-primary" type="button">
                Найти похожие вакансии
            </button>
            <!-- кнопки закладок вакансий -->
            <bookmark_buttons
                :lang="lang"
                :vacancy="vacancy"
                :user="user"
                :which_button_show="'show_vacancy'"
            ></bookmark_buttons>
        </div>

        <div class="box-page">
            <!-- vacancy -->
            <vacancy_template
                :vacancy="vacancy"
                :settings="settings"
                :lang="lang"
                :page="'show'"
            ></vacancy_template>
        </div>
    </div>
</template>

<script>
    import bookmark_buttons from "./details/BookmarkButtonsVacancyComponent";
    import vacancy_template from "./details/VacancyTemplateComponent";

    export default {
        components: {
            'bookmark_buttons': bookmark_buttons,
            'vacancy_template': vacancy_template,
        },
        data() {
            return { }
        },
        methods: { },
        props: [
            'lang',   // масив названий и url языка
            'vacancy',
            'settings',
            'user',
            'back_url',
        ],
        mounted() {
            // console.log(this.vacancy)
            console.log(this.back_url)
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .top-panel{
        display: flex;
        align-items: center;
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        border-bottom: 1px solid #dee2e6;
        background-color: #fff;
        padding: 15px 25px;
        z-index: 1;
        font-size: 17px;
        button{
            width: auto;
            margin-right: 15px;
        }
    }
    .bread-top{
        padding: 10px 25px;
    }
    .box-page {
        padding: 25px;
    }
    .bread-slash{
        height: 26px;
        margin: 0 5px;
        color: #a7a8a9;
        font-size: 19px;
    }
    a {
        display: block;
        position: relative;
        padding: 0;
        line-height: 16px;
    }
    a::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 0.1em;
        background-color: #3490dc;
        opacity: 0;
        transition: opacity 100ms, transform 100ms;
    }
    a:hover::after,
    a:focus::after {
        opacity: 1;
        transform: translate3d(0, 0.2em, 0);
    }

</style>





























