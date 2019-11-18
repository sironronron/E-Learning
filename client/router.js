import Vue from 'vue'
import Router from 'vue-router'
import { scrollBehavior } from '~/utils'

Vue.use(Router)

const page = path => () => import(`~/pages/${path}`).then(m => m.default || m)

const routes = [
  { path: '/', name: 'welcome', component: page('welcome.vue') },

  { path: '/login', name: 'login', component: page('auth/login.vue') },
  { path: '/register', name: 'register', component: page('auth/register.vue') },
  { path: '/logout', name: 'logout', component: page('auth/logout.vue') },
  { path: '/password/reset', name: 'password.request', component: page('auth/password/email.vue') },
  { path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue') },
  { path: '/email/verify/:id', name: 'verification.verify', component: page('auth/verification/verify.vue') },
  { path: '/email/resend', name: 'verification.resend', component: page('auth/verification/resend.vue') },

  { path: '/home', name: 'home', component: page('home.vue') },
  { path: '/settings',
    component: page('settings/index.vue'),
    children: [
      { path: '', redirect: { name: 'settings.account' } },
      { path: 'account', name: 'settings.account', component: page('settings/account.vue') },
      { path: 'password', name: 'settings.password', component: page('settings/password.vue') },
      { path: 'change-avatar', name: 'settings.avatar', component: page('settings/avatar.vue') }
    ] 
  },

  // Help Center
  { path: '/help-center', name: 'help-center.index', component: page('help-center/index.vue') },
  { path: '/help-center/category/:slug', name: 'help-center.category', component: page('help-center/category.vue') },
  { path: '/help-center/category/:categorySlug/:postSlug', name: 'help-center.post', component: page('help-center/post.vue') },

  // Teach in E-Learning
  { path: '/teach-with-us', name: 'teach', component: page('teach.vue') },

  { path: '/register/instructor', name: 'register.instructor', component: page('auth/instructor-register.vue') }

]

export function createRouter () {
  return new Router({
    routes,
    scrollBehavior,
    mode: 'history'
  })
}
