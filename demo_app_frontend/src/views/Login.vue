<template>
    <!-- Login Form -->
    <div class="container">
        <div class="row w-75 justify-content-center position-absolute top-50 start-50 translate-middle">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card shadow">
                    <div class="card-title text-center border-bottom">
                        <h2 class="p-3">Login</h2>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger" role="alert" v-if="error !== null">
                            {{ error }}
                        </div>
                        <form>
                            <div class="mb-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" v-model="email" @blur="validateEmail" required autofocus />
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" v-model="password" @blur="validatePass" required/>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary" v-on:click="handleSubmit">Login</button>
                            </div>
                            <div id="emailHelp" class="form-text text-center mb-5 text-dark">Not Registered? 
                                <RouterLink to="/register" class="text-dark fw-bold">Create an Account</RouterLink>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    name : 'Login',
    data() {
        return {
            email: "",
            password: "",
            error: null
        }
    },
    methods: {
        validateEmail() {
            let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            if (emailPattern.test(this.email)) {
                this.error = null;
            } else {
                this.error = 'Please enter a valid email address!';
            }
        },
        validatePass(){
            if (this.password.length >= 4) {
                this.error = null;
            } else {
                this.error = 'Please enter 4 length password!';
            }
        },
        handleSubmit(e) {
            e.preventDefault();
            if (this.error==null && this.password.trim() != '' && this.email.trim() != '') {
                // POST request using axios with set headers
                let body = { email: this.email,password: this.password };
                const headers= { 'Content-Type': 'multipart/form-data' } ;
                axios.post(this.apiUrl+'login', body, { headers })
                .then(response => {
                    console.log(response.data)
                    if (response.data.success) {
                        localStorage.setItem('userInfo', JSON.stringify(response.data.data));
                        this.$router.push('/');
                    } else {
                        this.error = response.data.message;
                    }
                })
                .catch(function (error) {
                    console.error(error);
                });
            }
        }
    },
    beforeRouteEnter(to, from, next) {
        let userInfo = localStorage.getItem('userInfo');
        if (!!userInfo) {
            return next('/');
        }
        next();
    }
}
</script>