<template>
    <Headers />
    <RegisterForm title="Profile Edit" :update="true" :id="editId"/>
</template>

<script>
import { useRoute } from 'vue-router';
import RegisterForm from '../components/RegisterForm.vue';
import Headers from '../components/includes/Headers.vue';
export default {
    name : 'EditProfile',
    data() {
        return {
            editId: null,
        }
    },
    components:{
        Headers,
        RegisterForm
    },
    mounted() {
        const route=useRoute();
        let id = route.params.id;
        this.editId = parseInt(id);
    }
}
</script>

