<template>
    <div class="row">
        <Headers />
        <!-- <Sidebar /> -->

        <h2 class="col-2 m-auto mt-5 text-center">
            Dashboard
            <br>
            <div style="font-size: 10px;">(Click profile for profile view)</div>
        </h2>
    </div>
</template>

<script>
import Headers from '../components/includes/Headers.vue';
// import Sidebar from '../components/includes/Sidebar.vue';
export default {
    name: "Dashboard",
    components: {
        Headers,
        // Sidebar
    },
    data() {
        return {
            name: null,
        }
    }
    // beforeRouteEnter(to, from, next) {
    //     if (!window.Laravel.isLoggedin) {
    //         window.location.href = "/";
    //     }
    //     next();
    // }
}
</script>

<style scoped>

</style>