<template>
    <main class="p-5">
        <img :src="order.image" alt="hotel" />
        <h2>Order #{{ order.id }}</h2>
        <p>Price: {{ order.price }}$</p>
        <p v-if="order.paid">You already have paid this order</p>
        <p v-else>
            You have not paid this trip and reservation expires at
            {{ order.reservation_expires }}
        </p>
        <p>
            If you have any problem, or questions,
            <router-link :to="'/account/conversations/' + order.id" class="btn btn-success">contact us</router-link>
        </p>
        <p>
            Download report:
            <button class="btn btn-success" @click="pdfReport">PDF</button>
            <button class="btn btn-success" @click="docxReport">DOC</button>
        </p>

        <p>
            Send report via mail:
            <button class="btn btn-success" @click="pdfMail">PDF</button>
            <button class="btn btn-success" @click="docxMail">DOC</button>
        </p>

        <div class="alert alert-success mt-3" v-if="mailSent">
            Check Your Email Box!
        </div>
        <div class="alert alert-danger mt-3" v-if="mailError">
            Sorry, but something went wrong.
        </div>
    </main>
</template>

<script>
import {reactive, ref} from "vue";
import { useRoute } from "vue-router";

export default {
    setup() {
        const route = useRoute();
        const authHeader = localStorage.getItem("authHeader");
        const orderId = route.params.id;
        const mailSent = ref(false);
        const mailError = ref(false);
        const order = reactive({
            id: "",
            price: 0,
            paid: false,
            reservation_expires: 0,
            image: "",
        });
        const getOrderInfo = async () => {
            const ordersUrl =
                process.env.VUE_APP_API_ROOT_PATH + "/api/orders/" + orderId;
            const response = await fetch(ordersUrl, {
                headers: {
                    Authorization: authHeader,
                },
            });
            const json = await response.json();
            const data = json.data;
            order.id = data.id;
            order.price = data.price;
            order.paid = data.paid;
            order.reservation_expires = data.reservation_expires;
            order.image =
                process.env.VUE_APP_API_ROOT_PATH + "/storage/" + data.image;
        };
        const report = async (extension, mail = false) => {
            extension =
                extension == "pdf" || extension == "docx" ? extension : "docx";
            const reportUrl =
                process.env.VUE_APP_API_ROOT_PATH +
                "/api/orders/" +
                orderId +
                "/report?extension=" +
                extension +
                "&send_via_email=" +
                mail;
            const response = await fetch(reportUrl, {
                headers: {
                    Authorization: authHeader,
                },
            });
            if (response.status == 500) {
                mailError.value = true;
                mailSent.value = false;
            }
            const data = await response.json();
            if (mail) {
                if (data.success) {
                    mailError.value = false;
                    mailSent.value = true;
                }
            } else {
                const path =
                    process.env.VUE_APP_API_ROOT_PATH + "/storage/" + data.data;
                let a = document.createElement("a");
                a.href = path;
                a.target = "_blanc";
                document.body.append(a);
                a.click();
                a.remove();
            }
        };
        const pdfReport = () => {
            report("pdf");
        };
        const docxReport = () => {
            report("docx");
        };
        const pdfMail = () => {
            report("pdf", true);
        };
        const docxMail = () => {
            report("docx", true);
        };
        getOrderInfo();
        return {
            pdfMail,
            docxMail,
            pdfReport,
            docxReport,
            order,
            mailSent,
            mailError
        };
    },
    name: "order-page",
};
</script>

<style scoped>
.btn {
    margin: 0 10px;
}
</style>
