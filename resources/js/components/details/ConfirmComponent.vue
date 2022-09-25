<template>
    <div class="confirm">

        <div class="modal fade" id="modal-confirm"  tabindex="-1" role="dialog"
             aria-labelledby="authModalTitle" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            {{title}}
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            {{text}}
                        </p>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-block btn-outline-danger" data-dismiss="modal">
                            {{trans('pages.offer','cancel')}}
                        </button>

                        <button @click="confirmAlert()"
                            type="button" class="btn btn-block btn-primary">
                            {{trans('pages.offer','confirm')}}
                        </button>

                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

    import translation from "../../mixins/translation";

    export default{
        mixins: [
            translation,
        ],
        data() {
            return {
                title: "Подтвердить",
                text: "",
            }
        },
        methods : {
            openModal(data) {
                this.text = data.text
                this.title = data.title !== null ? data.title : this.title

                $('#modal-confirm').modal('toggle')
            },
            confirmAlert(){
                $('#modal-confirm').modal('hide')
                this.$emit('confirm', true)
            }
        },
        props: [
            'lang',
        ],
        mounted() {
            this.title = this.trans('pages.offer','confirm')
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .modal-header{
        padding: 5px 15px;
        .close{
            padding: 20px;
        }
    }
    .modal-body{
        text-align: center;
        padding: 1rem!important;
    }
    .modal-footer{
        border: none;
        display: flex;
        justify-content: center !important;
        padding-bottom: 20px;
        button{
            width: auto;
            margin: 0 !important;
        }
        button:nth-child(1){
            margin-right: 15px !important;
        }
    }


</style>
