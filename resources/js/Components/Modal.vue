<template>
    <div
        v-if="isOpen"
        class="modal fade show"
        id="modal-default"
        style="display: block;"
        aria-modal="true"
        role="dialog"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header btn btn-primary">
                    <h4 class="modal-title">
                        Are you sure?
                    </h4>
                    <button
                        @click="closeModal"
                        aria-label="Close"
                        class="close"
                        data-dismiss="modal"
                        type="button"
                    >
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        The data will be deleted permanently.
                    </p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button
                        @click="closeModal"
                        class="btn btn-default"
                        data-dismiss="modal"
                        type="button"
                    >
                      Close
                    </button>
                    <button
                        @click="deleteData"
                        class="btn btn-danger"
                    >
                       Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        closeModal () {
            this.$emit('toggleModal')
        },

        deleteData () {
            this.$emit('deleteData')
        }
    },

    props: {
        isOpen: Boolean
    }
}
</script>
