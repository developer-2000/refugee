<template>
    <div class="box-page">
        <!-- обратная ссылка -->
        <div class="top-panel bread-top-cabinet">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="m166.5 424.5-143.1-152a23.94 23.94 0 0 1-6.562-16.5 23.94 23.94 0 0 1 6.562-16.5l143.1-152c9.125-9.625 24.31-10.03 33.93-.938 9.688 9.126 10.03 24.38.938 33.94l-128.4 135.5 128.4 135.5c9.094 9.562 8.75 24.75-.938 33.94-9.53 9.058-24.73 8.658-33.93-.942z"/></svg>
                <a :href="`${lang.prefix_lang}private-office`">
                    {{trans('menu.menu','cabinet')}}
                </a>
                <span class="bread-slash"> | </span>
            </div>

            <a class="btn btn-block btn-primary" id="create-vacancy" :href="`${lang.prefix_lang}private-office/vacancy/create`">Добавить вакансию</a>
        </div>

        <h1 class="title_page card-body">
            <u>{{trans('vacancies','my')}}</u>
            {{trans('vacancies','vacancies')}}
        </h1>


    </div>
</template>

<script>
    import translation from '../../mixins/translation'
    import response_methods_mixin from "../../mixins/response_methods_mixin";
    import bookmark_vacancies_mixin from "../../mixins/bookmark_vacancies_mixin";


    export default {
        components: {

        },
        mixins: [
            translation,
            response_methods_mixin,
            bookmark_vacancies_mixin
        ],
        data() {
            return {
            }
        },
        methods: {

            initialData(){
                // зарплата
                $('.box-salary').css('margin-top','0')
                // h2 заголовок в моих вакансиях
                $('.title-vacancy').removeClass("col-sm-9").css('margin','0px 0 10px')
                // click menu vacancy
                $(document).on('click.bs.dropdown', '.dropdown-toggle', (e) => {
                    e.stopPropagation();
                });
                // click vacancy
                document.querySelectorAll('.box-vacancy').forEach( (el) => {
                    el.addEventListener('click', (e) => {
                        // клик по родителю
                        if ( $(e.target).hasClass("dropdown-toggle") ) {
                            return false
                        }
                        // переход по url
                        let target = e.target;
                        // с дочернего на .box-vacancy
                        let parent = target.closest('.box-vacancy');
                        if (!parent) return;

                        let alias = $(parent).attr('data-alias')
                        this.transitionToVacancy(alias)
                    })
                } );
            }
        },
        props: [
            'lang',   // масив названий и url языка
            'resumes',
        ],
        mounted() {
            this.initialData()
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .top-panel{
        display: flex;
        justify-content: space-between;
        &>div{
            display: flex;
            align-items: center;
        }
    }
    .box-vacancy {
        display: flex;
        justify-content: space-between;
        .salary-vacancy {
            display: flex;
            .salary {
                color: $black;
                margin-right: 4px;
                white-space: nowrap;

                svg {
                    width: 12px;
                    margin-bottom: 2px;

                    path {
                        fill: $euro-color-blue;
                    }
                }
            }
        }
        .left-site{
            width: 100%;
        }
        .right-site {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-self: stretch;
            align-items: flex-end;

            .response-vacancy {
                text-align: center;
                font-weight: 600;
                line-height: 22px;
                margin-right: 5px;
            }

            .button-vacancy {
                display: flex;

                & > button {
                    margin-right: 10px;
                }
            }
        }
    }
    #create-vacancy{
        width: 175px;
    }

</style>





























