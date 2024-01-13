import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/Login.vue'
import Register from '../views/Register.vue'
import StudentProfile from '../views/StudentProfile.vue'
import EditProfile from '../views/EditProfile.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'dashboard',
      component: () => import('../views/Dashboard.vue')
    },
    {
      path: '/login',
      name: 'Login',
      component: LoginView
    },
    {
      path: '/register',
      name: 'Register',
      component: Register
    },
    {
      path: '/student-profile',
      name: 'StudentProfile',
      component: StudentProfile
    },
    {
      path: '/edit-profile/:id',
      name: 'EditProfile',
      component: EditProfile
    }
  ]
})

router.beforeEach((to, from) => {
  let userInfo = localStorage.getItem('userInfo');
  if (!userInfo && to.name !== 'Login' && to.name !== 'Register') {
    return { name: 'Login' }
  }
})

export default router
