<template>
    <RegisterForm title="Student Registration" :update="false" />
</template>

<script>
import RegisterForm from '../components/RegisterForm.vue';
export default {
    name : 'Register',
    components:{
        RegisterForm,
        Headers
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

