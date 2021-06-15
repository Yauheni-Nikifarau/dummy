<template>
    <modal>
        <div class="form-floating">
            <input type="text" name="name" class="form-control" id="floatingInput1">
            <label for="floatingInput1">Name</label>
        </div>
        <div class="form-floating mt-3 mb-3">
            <input type="text" name="surname" class="form-control" id="floatingInput2">
            <label for="floatingInput2">Surname</label>
        </div>
        <div class="form-floating">
            <input type="email" name="email" class="form-control" id="floatingInput3">
            <label for="floatingInput3">Email</label>
        </div>
        <div class="form-floating mt-3 mb-3">
            <input type="password" name="password" class="form-control" id="floatingInput4">
            <label for="floatingInput4">Password</label>
        </div>
        <div class="form-floating">
            <input type="date" name="birth" class="form-control" id="floatingInput5">
            <label for="floatingInput5">Birth date</label>
        </div>
    </modal>

    <shadow></shadow>
</template>

<script>
import Shadow from "../common/Shadow";
import Modal from "./Modal";

export default {
    name: "register-modal",
    components: {
        Shadow,
        Modal
    }
}
</script>

<style scoped>

</style>
