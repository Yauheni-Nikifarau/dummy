<template>
    <div class="col">
        <div class="card shadow-sm">
            <div class="card-body">
                <img
                    :src="apiRootForImages + hotel.image"
                    alt="hotel"
                    style="width: 100%; height: 200px; object-fit: cover"
                />
                <p class="linkprimary text-decoration-none fw-bolder fs-3">
                    {{ hotel.name }}
                </p>
                <div class="d-flex justify-content-between align-items-center">
                    <router-link
                        class="btn btn-outline-success"
                        :to="'/hotels/' + hotel.name.replace(/ /g, '_') + '_' + hotel.id"
                        >More
                    </router-link>
                    <router-link
                        class="btn btn-outline-success"
                        :to="'/trips?hotel=' + hotel.name.replace(/ /g, '_')"
                        >Trips
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  setup () {
    return {
      apiRootForImages: process.env.VUE_APP_API_ROOT_PATH + "/storage/"
    }
  },
    name: "hotel-card-item",
    props: ["hotel"],
};
</script>

<style scoped></style>
