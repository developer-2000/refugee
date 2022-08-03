<template>
    <ul class="pagination">
        <li class="page-item"
            v-if="pagination.current_page > 1"
        >
            <a class="page-link" href="javascript:void(0)" aria-label="Previous"
               @click.prevent="changePage(pagination.current_page - 1)"
            >
                <span aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M213.9 388 92.23 252l121.6-136a23.88 23.88 0 0 0 6.125-16c0-6.594-2.687-13.16-7.1-17.88-10.755-8.84-25.955-8-34.755 1.87L42.14 235.1a23.916 23.916 0 0 0 0 32l135.1 152c8.812 9.875 23.1 10.72 33.87 1.875C221.9 413.1 222.7 397.8 213.9 388zm20.2-152.9a23.916 23.916 0 0 0 0 32l135.1 152c8.812 9.875 23.1 10.72 33.87 1.875 9.906-8.813 10.72-24.03 1.875-33.88L284.2 252l121.6-136a23.88 23.88 0 0 0 6.125-16c0-6.594-2.687-13.16-7.1-17.88-9.874-8.844-25.06-8-33.87 1.875L234.1 235.1z"/></svg>
                </span>
            </a>
        </li>

        <li class="page-item"
            v-for="(page, key) in pagesNumber" :key="key"
            :class="{'active': page == pagination.current_page}">
            <a class="page-link" href="javascript:void(0)"
               @click.prevent="changePage(page)">
                {{ page }}
            </a>
        </li>

        <li class="page-item"
            v-if="pagination.current_page < pagination.last_page"
        >
            <a class="page-link" href="javascript:void(0)" aria-label="Next"
               @click.prevent="changePage(pagination.current_page + 1)"
            >
                <span aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M238.1 115.1 359.8 252 238.2 388a23.88 23.88 0 0 0-6.125 16c0 6.594 2.687 13.16 7.1 17.88 9.874 8.844 25.06 8 33.87-1.875l135.1-152a23.916 23.916 0 0 0 0-32l-135.1-152c-8.812-9.875-23.1-10.72-33.87-1.875-9.075 8.8-9.875 24.07-1.075 32.97zM217.9 268a23.916 23.916 0 0 0 0-32L81.88 83.99c-8.81-9.87-24-10.71-33.88-1.87-9.9 8.81-10.71 24.08-1.87 32.98L167.8 252 46.2 388a23.88 23.88 0 0 0-6.125 16c0 6.594 2.687 13.16 7.1 17.88 9.874 8.844 25.06 8 33.87-1.875L217.9 268z"/></svg>
                </span>
            </a>
        </li>
    </ul>
</template>

<script>
    export default{
        props: {
            pagination: {
                type: Object,
                required: true
            },
            offset: {
                type: Number,
                default: 1
            }
        },
        computed: {
            pagesNumber() {
                if (!this.pagination.to) {
                    return [];
                }
                let from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                let to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                let pagesArray = [];
                for (let page = from; page <= to; page++) {
                    pagesArray.push(page);
                }
                return pagesArray;
            }
        },
        methods : {
            changePage(page) {
                this.pagination.current_page = page;
                this.$emit('paginate', {
                    page: page
                })
            }
        }
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .pagination{
        justify-content: center;
        margin: 23px 0 0;
        svg{
            width: 14px;
            path{
                fill:#3490dc;
            }
        }
    }

</style>
