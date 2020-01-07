import Vue from 'vue'
import Router from 'vue-router'
import { scrollBehavior } from '~/utils'

Vue.use(Router)

const page = path => () => import(`~/pages/${path}`).then(m => m.default || m)

const routes = [
  // Welcome Path
  { path: '/', name: 'welcome', component: page('welcome.vue') },

  // Course View
  { path: '/course/:slug', name: 'course.show', component: page('course/show.vue') },
  // Course Instructor
  { path: '/course/instructor/:username', name: 'course.instructor.show', component: page('course/instructor.vue') },
  { path: '/search_query', name: 'course.search', component: page('course/search.vue') },
  { path: '/course/category/:slug', name: 'course.category', component: page('course/category/index.vue') },
  // User Authentication
  { path: '/login', name: 'login', component: page('auth/login.vue') },
  { path: '/register', name: 'register', component: page('auth/register.vue') },
  { path: '/logout', name: 'logout', component: page('auth/logout.vue') },
  { path: '/password/reset', name: 'password.request', component: page('auth/password/email.vue') },
  { path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue') },
  { path: '/email/verify/:id', name: 'verification.verify', component: page('auth/verification/verify.vue') },
  { path: '/email/resend', name: 'verification.resend', component: page('auth/verification/resend.vue') },

  // User Settings
  { path: '/home', name: 'home', component: page('home.vue') },
  { path: '/student/account',
    component: page('settings/index.vue'),
    children: [
      { path: '', redirect: { name: 'settings.account' } },
      { path: 'edit-profile', name: 'settings.account', component: page('settings/account.vue') },
      { path: 'password', name: 'settings.password', component: page('settings/password.vue') },
      { path: 'change-avatar', name: 'settings.avatar', component: page('settings/avatar.vue') }
    ]
  },

  // Help Center
  {
    path: '/help-center',
    component: page('help-center/index.vue'),
    children: [
      { path: '', redirect: { name: 'help-center.student'} },
      { path: 'student', name: 'help-center.student', component: page('help-center/student.vue') },
      { path: 'student/category/:slug', name: 'help-center.student.category', component: page('help-center/category.vue') },
      { path: 'student/category/:categorySlug/:postSlug', name: 'help-center.student.category.post', component: page('help-center/post.vue') },
      { path: 'student/search', name: 'help-center.student.search', component: page('help-center/search.vue') },
      { path: 'contact-us', name: 'help-center.contact', component: page('help-center/contact-us.vue') }
    ]
  },

  // Teach in E-Learning
  { path: '/teach-with-us', name: 'teach', component: page('teach.vue') },
  // Register as Instructor
  { path: '/register/instructor', name: 'register.instructor', component: page('auth/instructor-register.vue') },
  // Register as an Instructor if Already Registered
  { path: '/register/instrutor/v2', name: 'register.instructor.v2', component: page('auth/instructor-register-v2.vue') },


  // Instructor Pages
  {
    path: '/instructor',
    component: page('instructor/index.vue'),
    children: [
      { path: '', redirect: { name: 'instructor.courses' } },
      { path: 'courses', name: 'instructor.courses', component: page('instructor/courses/courses.vue') },
      // Course Creation
      { path: 'courses/create', name: 'instructor.courses.create', component: page('instructor/courses/create.vue') },
      // Course Show
      { path: 'courses/show/:slug', name: 'instructor.courses.show', component: page('instructor/courses/show.vue') },
      // Course Edit
      { path: 'courses/:slug/edit', name: 'instructor.courses.edit', component: page('instructor/courses/edit.vue') },
      // Course Statuses

      // Instructor Settings
      { path: 'settings',
        component: page('instructor/settings.vue'),
        children: [
          { path: '', redirect: { name: 'instructor.settings.account' } },
          { path: 'account-settings', name: 'instructor.settings.account', component: page('instructor/account_settings.vue') },
          { path: 'account-password', name: 'instructor.settings.password', component: page('instructor/account_password.vue') },
          { path: 'account-profile', name: 'instructor.settings.profile', component: page('instructor/account_profile.vue') },
          { path: 'account-avatar', name: 'instructor.settings.avatar', component: page('instructor/account_avatar.vue') }
        ]
      }

    ]
  }

]

export function createRouter () {
  return new Router({
    routes,
    scrollBehavior,
    mode: 'history'
  })
}
