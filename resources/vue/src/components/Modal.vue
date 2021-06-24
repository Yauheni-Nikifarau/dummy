<template>
    <div class="modal fade show d-block">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><slot name="title"></slot></h5>
                    <button @click.prevent="closeModal"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body p-3">
                    <slot name="body"></slot>
                </div>

                <div class="modal-footer">
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    setup (props, {emit}) {
        const closeModal = () => {
            emit('closeModal');
        }
        return {
            closeModal
        }
    },
    name: "modal",
};
</script>

<style scoped></style>
