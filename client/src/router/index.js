import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from '../pages/Home.vue'

import Auth from '../pages/Auth.vue'
import LoginLayout from '../layouts/auth/LoginLayout.vue'
import RegisterLayout from '../layouts/auth/RegisterLayout.vue'
import ForgotPasswordLayout from '../layouts/auth/ForgotPasswordLayout.vue'
import VerifyLayout from '../layouts/auth/VerifyLayout.vue'

import Search from '../pages/Search.vue'

import Course from '../pages/Course.vue'

import Lesson from '../pages/Lesson.vue'

import Profile from '../pages/Profile.vue'
import MyCoursesLayout from '../layouts/profile/MyCoursesLayout.vue'
import TeachersCenterLayout from '../layouts/profile/TeachersCenterLayout.vue'
import AccountSettingsLayout from '../layouts/profile/AccountSettingsLayout.vue'
import CustomerSupportLayout from '../layouts/profile/CustomerSupportLayout.vue'

import Form from '../pages/Form.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home,
    props: true,
    meta: {
      hideHeaderSearchBar: true,
      requiresAuth: false,
    },
  },
  {
    path: '/auth',
    component: Auth,
    props: true,
    meta: {
      requiresAuth: false,
      hideHeader: true,
    },
    children: [
      {
        path: '',
        redirect: 'login',
      },
      {
        path: 'login',
        name: 'login',
        component: LoginLayout,
      },
      {
        path: 'register',
        name: 'register',
        component: RegisterLayout,
      },
      {
        path: 'forgot-password',
        name: 'forgot-password',
        component: ForgotPasswordLayout,
      },
      {
        path: 'verify',
        name: 'verify',
        component: VerifyLayout,
      },
    ],
  },
  {
    path: '/search',
    name: 'search',
    component: Search,
    props: true,
    meta: {
      hideHeaderSearchBar: true,
      requiresAuth: false,
    },
  },
  {
    path: '/course/:courseId',
    name: 'course',
    component: Course,
    props: true,
    meta: {
      requiresAuth: false,
    },
  },
  {
    path: '/course/:courseId/section/:sectionId/lesson/:lessonId',
    name: 'lesson',
    component: Lesson,
    props: true,
    meta: {
      requiresAuth: false,
    },
  },
  {
    path: '/profile',
    component: Profile,
    props: true,
    meta: {
      requiresAuth: true,
    },
    children: [
      {
        path: '',
        redirect: 'my-courses',
      },
      {
        path: 'my-courses',
        name: 'my-courses',
        component: MyCoursesLayout,
      },
      {
        path: 'teachers-center',
        name: 'teachers-center',
        component: TeachersCenterLayout,
        props: true,
      },
      {
        path: 'account-settings',
        name: 'account-settings',
        component: AccountSettingsLayout,
        props: true,
      },
      {
        path: 'customer-support',
        name: 'customer-support',
        component: CustomerSupportLayout,
        props: true,
      },
    ],
  },
  {
    path: '/form/:formType',
    name: 'form',
    component: Form,
    props: true,
    meta: {
      requiresAuth: true,
    },
  },
  {
    // catch all route
    path: '*',
    redirect: { name: 'home' },
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
})

// Route guards to prevent unauthorized access to restricted routes
// router.beforeEach((to, _, next) => {
//   const requiresAuth = to.matched.some(record => record.meta.requiresAuth)
//   const user = window.localStorage.getItem(process.env.VUE_APP_USER_KEY)
//
//   // anonymous user trying to access app
//   if (requiresAuth && !user) next({ name: 'login' })
//   // prevent logged in user from getting to login and register pages again
//   else if (to.path.includes('auth') && user) next({ name: 'home' })
//   // logged in user navigating the app or anonymous user on public pages
//   else if (!requiresAuth || user) next()
// })

export default router
