<template>
<div class="container  mt-3 position-absolute top-50 start-50 translate-middle">
    <form @submit.prevent="handleSubmit">
        <div class="row box">
            <div class="col-sm-12 mb-4">
                <h2 class="text-center text-info">{{ title }}</h2>
            </div>
            <div class="col-sm-6 form-group">
                <label for="fname">First Name</label>
                <input type="text" class="form-control" name="fname" v-model.trim="form.fname" id="fname" placeholder="Enter your first name." required>
            </div>
            <div class="col-sm-6 form-group">
                <label for="lname">Last name</label>
                <input type="text" class="form-control" name="lname" v-model.trim="form.lname" id="lname" placeholder="Enter your last name." required>
            </div>
            <div class="col-sm-6 form-group">
                <label for="father_name">Father Name</label>
                <input type="text" class="form-control" name="father_name" v-model.trim="form.father_name" id="father_name" placeholder="Enter your father name." required>
            </div>
            <div class="col-sm-6 form-group">
                <label for="mother_name">Mother name</label>
                <input type="text" class="form-control" name="mother_name" v-model.trim="form.mother_name" id="mother_name" placeholder="Enter your mother name." required>
            </div>
            <div class="col-sm-6 form-group">
                <label for="Date">Date Of Birth</label>
                <input type="Date" name="dob" v-model="form.dob" class="form-control" id="Date" placeholder="" required>
            </div>
            <div class="col-sm-6 form-group align-bottom">
                <div class="pb-1">Gender</div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" v-model="form.gender" id="male" value="male">
                    <label class="form-check-label" for="male">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" v-model="form.gender" id="female" value="female">
                    <label class="form-check-label" for="female">Female</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" v-model="form.gender" id="other" value="other">
                    <label class="form-check-label" for="other">Other</label>
                </div>
            </div>
            <div class="col-sm-3 form-group">
                <label for="reading_class">Class</label>
                <select name="reading_class" v-model="form.reading_class" id="reading_class" class="form-control" required>
                    <option value="">--select--</option>
                    <option value="one">Class One</option>
                    <option value="two">Class Two</option>
                    <option value="three">Class Three</option>
                    <option value="four">Class Four</option>
                    <option value="five">Class Five</option>
                    <option value="six">Class Six</option>
                    <option value="seven">Class Seven</option>
                    <option value="eight">Class Eight</option>
                    <option value="Nine">Class Nine</option>
                    <option value="Ten">Class Ten</option>
                </select>
            </div>
            <div class="col-sm-3 form-group">
                <label for="group">Group (Optional)</label>
                <select name="group" v-model="form.group" id="group" class="form-control">
                    <option value="">--select--</option>
                    <option value="science">Science</option>
                    <option value="commerce">Commerce</option>
                    <option value="arts">Arts</option>
                    <!-- <option v-for="option in options" :value="option.value">
                        {{ option.text }}
                    </option> -->
                </select>
            </div>
            <div class="col-sm-3 form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" @blur="validateEmail" v-model.trim="form.email" id="email" placeholder="Enter your email." required>
            </div>
            <div class="col-sm-3 form-group">
                <label for="tel">Phone</label>
                <input type="tel" name="phone" v-model.trim="form.phone" class="form-control" id="tel" placeholder="Enter Your Contact Number." required>
            </div>
            <div class="col-sm-6 form-group">
                <label for="address">Address</label>
                <textarea name="address" v-model.trim="form.address" class="form-control" id="address" cols="30" rows="2" placeholder="Locality/House/Street no." required></textarea>
            </div>
            <div class="col-sm-6 form-group">
                <label for="photo">Student's Photo</label>
                <input type="file" name="photo" @change="uploadFile" ref="file" id="photo" class="form-control" :required="!update">
            </div>
            <div class="col-sm-6 form-group" v-if="!update">
                <label for="password">Password</label>
                <input type="password" name="password" @blur="validatePass" v-model="form.password" class="form-control" id="password" placeholder="Enter your password." required>
            </div>
            <div class="col-sm-6 form-group" v-if="!update">
                <label for="c_password">Confirm Password</label>
                <input type="password" name="c_password" @blur="confirmPass" v-model="form.c_password" class="form-control" id="c_password" placeholder="Re-enter your password." required>
            </div>
            <div class="col-sm-6">
                <div class="form-check my-2" v-if="!update">
                    <input class="form-check-input" type="checkbox" name="confirmation" v-model="form.confirmation" value="true" id="confirmation" required>
                    <label class="form-check-label" for="confirmation">
                        &nbsp;I declare all information are correct and accept all terms, conditions.
                    </label>
                </div>
            </div>
            <div class="col-sm-6 alert alert-danger" role="alert" v-if="error !== null">
                {{ error }}
            </div>
            <div class="col-sm-12 form-group mb-0">
                <button class="btn btn-primary float-end" type="submit">Submit</button>
            </div>
        </div>
    </form>
</div>
</template>

<script>
import axios from 'axios'
export default {
    name: 'RegisterForm',
    data() {
        return {
            form: {
                fname: "",
                lname: "",
                father_name: "",
                mother_name: "",
                dob: "",
                gender: "",
                reading_class: "",
                group: "",
                email: "",
                phone: "",
                address: "",
                password: "",
                c_password: "",
                confirmation: "",
                edit_id: "",
            },
            photo: "",
            error: null,
            userInfo: null,
            question: this.update
        }
    },
    props: {
        title: String,
        id: Number,
        update: Boolean
    },
    methods: {
        validateEmail() {
            let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            if (emailPattern.test(this.form.email)) {
                this.error = null;
            } else {
                this.error = 'Please enter a valid email address!';
            }
        },
        validatePass() {
            if (this.form.password.length >= 4) {
                this.error = null;
            } else {
                this.error = 'Please enter 4 length password!';
            }
        },
        confirmPass() {
            if (this.form.password == this.form.c_password) {
                this.error = null;
            } else {
                this.error = 'Password not match!';
            }
        },
        uploadFile() {
            this.photo = this.$refs.file.files[0];
        },
        handleSubmit(e) {
            e.preventDefault();
            if (this.error == null) {
                const formData = new FormData();
                for (const key in this.form) {
                    formData.append(key, this.form[key]);
                }
                formData.append('photo', this.photo);
                if (this.update === true && this.form.email != '') {
                    // Update request using axios with set headers
                    var headers = {
                        'Content-Type': 'multipart/form-data',
                        'Authorization': 'Bearer ' + this.userInfo.token,
                    };
                    axios.post(this.apiUrl + 'update-profile', formData, {
                            headers
                        })
                        .then((response) => {
                            if (response.data.success) {
                                Swal.fire({
                                    title: "Success!",
                                    text: response.data.message,
                                    type: "success",
                                    showConfirmButton: true,
                                    allowEscapeKey: false,
                                    allowOutsideClick: false,
                                    timer: 5000,
                                });
                                this.$router.push({
                                    name: 'StudentProfile'
                                });
                            } else {
                                this.error = response.data.message;
                            }
                        })
                        .catch(function (error) {
                            console.error(error);
                        });
                } else {
                    if (this.form.password.length >= 4 && this.form.email != '') {
                        // POST request using axios with set headers
                        var headers = {
                            'Content-Type': 'multipart/form-data'
                        };
                        axios.post(this.apiUrl + 'register', formData, {
                                headers
                            })
                            .then((response) => {
                                if (response.data.success) {
                                    localStorage.setItem('userInfo', JSON.stringify(response.data.data));
                                    Swal.fire({
                                        title: "Success!",
                                        text: response.data.message,
                                        type: "success",
                                        showConfirmButton: true,
                                        allowEscapeKey: false,
                                        allowOutsideClick: false,
                                        timer: 5000,
                                    });
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
            }
        },
        fetchData() {
            axios.get(this.apiUrl + 'student-info?id=' + this.userInfo.id, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + this.userInfo.token
                    }
                })
                .then(response => {
                    if (response.status == 200) {
                        let $result = response.data.data;
                        this.form.edit_id = $result.id;
                        this.form.fname = $result.fname;
                        this.form.lname = $result.lname;
                        this.form.father_name = $result.father_name;
                        this.form.mother_name = $result.mother_name;
                        this.form.dob = $result.dob;
                        this.form.gender = $result.gender;
                        this.form.reading_class = $result.reading_class;
                        this.form.group = $result.group;
                        this.form.email = $result.email;
                        this.form.phone = $result.phone;
                        this.form.address = $result.address;
                    }
                })
                .catch(error => {
                    console.error(error)
                });
        }
    },
    async mounted() {
        if (this.update === true) {
            let userInfo = localStorage.getItem('userInfo');
            this.userInfo = JSON.parse(userInfo);
            if (this.userInfo != null) {
                this.fetchData();
            }
        }
    }
}
</script>

<style scoped>
.box {
    box-shadow: 0px 0px 5px 1px #999;
    padding: 1.5rem !important;
    background: #e9ecef;
}
</style>
