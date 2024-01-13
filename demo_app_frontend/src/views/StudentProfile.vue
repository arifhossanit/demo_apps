<template>
<div class="row">
    <Headers />
    <!-- <Sidebar /> -->

    <div class="col-md-9 p-4 m-auto">
        <div class="padding">
            <div class="row container d-flex justify-content-center">
                <div class="col-xl-6 col-md-12">
                    <div class="card">
                        <div class="row">
                            <div class="col-sm-4 bg-c-lite-green user-profile">
                                <div class="text-center text-white">
                                    <div class="mt-5">
                                        <img :src="baseUrl+'storage/'+results.photo" class="img-radius" alt="User-Profile-Image">
                                    </div>
                                    <h6>Name: {{ results.name }}</h6>
                                    <p>ID: {{ results.id }}</p>
                                    
                                    <RouterLink :to="`/edit-profile/${results.id}`" class="nav-link d-inline-block"><i class="fa-solid fa-pen-to-square me-3" title="Edit Profile"></i></RouterLink>
                                    <i class="fa-solid fa-trash-can" title="Delete Profile" @click="deleteProfile(results.id)"></i>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="card-block">
                                    <h6 class="heading">Personal Information</h6>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p class="label">Father Name</p>
                                            <h6 class="text-muted">{{ results.father_name }}</h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="label">Mother Name</p>
                                            <h6 class="text-muted">{{ results.mother_name }}</h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="label">Date of Birth</p>
                                            <h6 class="text-muted">{{ results.dob }}</h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="label">Gender</p>
                                            <h6 class="text-muted">{{ results.gender }}</h6>
                                        </div>
                                    </div>
                                    <h6 class="heading">Contact Info</h6>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p class="label">Email</p>
                                            <h6 class="text-muted">{{ results.email }}</h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="label">Phone</p>
                                            <h6 class="text-muted">{{ results.phone }}</h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="label">Address</p>
                                            <h6 class="text-muted">{{ results.address }}</h6>
                                        </div>
                                    </div>
                                    <h6 class="heading">Other Info</h6>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p class="label">Class</p>
                                            <h6 class="text-muted">{{ results.reading_class }}</h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="label">Group</p>
                                            <h6 class="text-muted">{{ results.group }}</h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="label">Profile Create</p>
                                            <h6 class="text-muted">{{ results.created_at.split('T')[0] }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import axios from 'axios';
import Headers from '../components/includes/Headers.vue';
// import Sidebar from '../components/includes/Sidebar.vue';
export default {
    name: "StudentProfile",
    components: {
        Headers,
        // Sidebar
    },
    data() {
        return {
            results: null,
            userInfo: null,
        }
    },
    methods: {
        async deleteProfile(id) {
            if (confirm('Are you sure you want to delete this item?')) {
                try {
                    const response = await axios.delete(this.apiUrl + 'delete-profile?id=' + id, {
                        headers: {
                            'Authorization': 'Bearer ' + this.userInfo.token,
                            'Content-Type': 'application/json'
                        }
                    })
                    if (response.data.success) {
                        localStorage.removeItem('userInfo');
                        Swal.fire({
                            title: "Success!",
                            text: response.data.message,
                            type: "success",
                            showConfirmButton: true,
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 5000,
                        });
                        this.$router.push('/login');
                    }
                } catch (error) {
                    console.error(error)
                }
            }
        }
    },
    async beforeMount() {
        let userInfo = localStorage.getItem('userInfo');
        this.userInfo = JSON.parse(userInfo);
        try {
            const response = await axios.get(this.apiUrl + 'student-info?id=' + this.userInfo.id, {
                headers: {
                    'Authorization': 'Bearer ' + this.userInfo.token,
                    'Content-Type': 'application/json'
                }
            })
            // this.results = JSON.parse(response.data);
            if (response.data.success) {
                this.results = response.data.data;
            }
        } catch (error) {
            console.error(error)
        }
    },
    // beforeRouteEnter(to, from, next) {
    //     if (!window.Laravel.isLoggedin) {
    //         window.location.href = "/";
    //     }
    //     next();
    // }
}
</script>

<style scoped>
.card {
    border-radius: 5px;
    -webkit-box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
    box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
    border: none;
}

.bg-c-lite-green {
    background: -webkit-gradient(linear, left top, right top, from(#f29263), to(#ee5a6f));
    background: linear-gradient(to right, #ee5a6f, #f29263);
}

.user-profile {
    padding: 20px 0;
}

.card-block {
    padding: 1.25rem;
}

.img-radius {
    border-radius: 5px;
    width: 100px;
}

.heading {
    font-weight: 600;
    border-bottom: 1px solid #e0e0e0;
    margin-top: 15px;
    margin-bottom: 10px;
}
.fa-solid{
    cursor: pointer;
}
</style>
