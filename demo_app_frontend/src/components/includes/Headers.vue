<template>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top with-shadow px-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <RouterLink to="/" class="nav-link">Dashboard</RouterLink>
                </li>
                <li class="nav-item">
                    <RouterLink to="/student-profile" class="nav-link">Profile</RouterLink>
                </li>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
                <button class="btn btn-outline-danger ms-4" title="Logout" @click="logout"><i class="fa-solid fa-power-off"></i></button>
            </form>
        </div>
    </div>
</nav>
</template>

<script>
export default {
    name: "Headers",
    data() {
        return {
            name: null,
        }
    },
    methods: {
        logout() {
            localStorage.removeItem('userInfo');
            Swal.fire({
                title: "Success!",
                text: "Successfully Logout",
                type: "success",
                showConfirmButton: true,
                allowEscapeKey: false,
                allowOutsideClick: false,
                timer: 5000,
            });
            this.$router.push('/login');
        }
    },
}
</script>
