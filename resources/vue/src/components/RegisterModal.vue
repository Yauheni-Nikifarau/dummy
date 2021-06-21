<template>
    <modal @closeModal="closeModal">
        <template v-slot:title>Registration</template>
        <template v-slot:body>
            <div class="form-floating">
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    id="floatingInput1"
                />
                <label for="floatingInput1">Name</label>
            </div>
            <div class="form-floating mt-3 mb-3">
                <input
                    type="text"
                    name="surname"
                    class="form-control"
                    id="floatingInput2"
                />
                <label for="floatingInput2">Surname</label>
            </div>
            <div class="form-floating">
                <input
                    type="email"
                    name="email"
                    class="form-control"
                    id="floatingInput3"
                />
                <label for="floatingInput3">Email</label>
            </div>
            <div class="form-floating mt-3 mb-3">
                <input
                    type="password"
                    name="password"
                    class="form-control"
                    id="floatingInput4"
                />
                <label for="floatingInput4">Password</label>
            </div>
            <div class="form-floating">
                <input
                    type="date"
                    name="birth"
                    class="form-control"
                    id="floatingInput5"
                />
                <label for="floatingInput5">Birth date</label>
            </div>
        </template>
        <template v-slot:footer>
            <button class="btn btn-primary">Register</button>
        </template>
    </modal>

    <bg-shadow></bg-shadow>
</template>

<script>
import Modal from "./Modal";
import BgShadow from "./BgShadow";

export default {
    setup (props, { emit }) {
        const closeModal = () => {
            emit("closeModal");
        };
        return {
            closeModal
        };
    },
    name: "register-modal",
    components: {
        BgShadow,
        Modal,
    },
};
</script>

<style scoped></style>
