<template>
    <div>
        <!-- Breadcrumbs stroke -->
        <div v-if="back_url !== undefined && back_url[0][0].name !== null"
             class="top-panel bread-top"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="m166.5 424.5-143.1-152a23.94 23.94 0 0 1-6.562-16.5 23.94 23.94 0 0 1 6.562-16.5l143.1-152c9.125-9.625 24.31-10.03 33.93-.938 9.688 9.126 10.03 24.38.938 33.94l-128.4 135.5 128.4 135.5c9.094 9.562 8.75 24.75-.938 33.94-9.53 9.058-24.73 8.658-33.93-.942z"/></svg>
            <template v-for="(obj, key) in back_url[0]">
                <a :href="`/${obj.url}`">{{trans('menu.menu',obj.name)}}</a>
                <span class="bread-slash"> | </span>
            </template>
        </div>

        <!-- buttons -->
        <div class="top-panel">
            <button class="btn btn-block btn-outline-primary" type="button">
                Откликнуться
            </button>
            <button class="btn btn-block btn-outline-primary" type="button"
                    @click="findSimilarVacancy()"
            >
                {{trans('vacancies','find_similar_jobs')}}
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
    import translation from "../../mixins/translation";

    export default {
        components: {
            'bookmark_buttons': bookmark_buttons,
            'vacancy_template': vacancy_template,
        },
        mixins: [
            translation,
        ],
        data() {
            return { }
        },
        methods: {
            makeBackUrl(){
                let url = '&#060; '
                if(this.back_url !== undefined && this.back_url[0][0].name !== null){
                    this.back_url[0].forEach(function(item, i, arr) {
                        console.log( i + ": " + item.name );
                        url += '&nbsp; <a href="/'+item.url+'">'+item.name+'</a>&nbsp; |'
                    });
                }
                return url
            },
            findSimilarVacancy(){
                let params = new URLSearchParams(window.location.search)
                params.delete('categories')
                params.delete('position')
                params.set('categories',this.vacancy.categories.toString())
                params.set('position',this.vacancy.position.title)
                params.sort()

                location.href = this.lang.prefix_lang+'vacancy?'+params.toString()
            }
        },
        props: [
            'lang',   // масив названий и url языка
            'vacancy',
            'settings',
            'user',
            'back_url',
        ],
        mounted() {
            console.log(this.vacancy)
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .box-page {
        padding: 25px;
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





























