require('dotenv').config()
const { join } = require('path')
const { copySync, removeSync } = require('fs-extra')

module.exports = {
  // mode: 'spa', // Comment this for SSR

  srcDir: __dirname,

  env: {
    apiUrl: process.env.API_URL || process.env.APP_URL + '/api',
    appName: process.env.APP_NAME || 'E-Learning',
    appLocale: process.env.APP_LOCALE || 'en',
    githubAuth: !!process.env.GITHUB_CLIENT_ID,
    facebookAuth: !!process.env.FACEBOOK_CLIENT_ID,
    googleAuth: !!process.env.GOOGLE_CLIENT_ID,
  },

  head: {
    title: process.env.APP_NAME,
    titleTemplate: '%s - ' + process.env.APP_NAME,
    meta: [
      { charset: 'utf-8' },
      // { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: 'Nuxt.js project' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      { rel: 'stylesheet', href: 'https://fonts.googleapis.com/css?family=Open+Sans&display=swap' }
    ]
  },

  loading: { color: '#007bff' },

  router: {
    middleware: ['locale', 'check-auth']
  },

  css: [
    { src: '~assets/sass/app.scss', lang: 'scss' },
    { src: 'plyr/dist/plyr.css' }
  ],

  plugins: [
    '~components/global',
    '~plugins/i18n',
    '~plugins/vform',
    '~plugins/axios',
    '~plugins/fontawesome',
    '~plugins/password-strength',
    '~plugins/flat-pickr',
    '~plugins/moment',
    '~plugins/pagination',
    '~plugins/vue-plyr',
    // '~plugins/nuxt-client-init', // Comment this for SSR
    '~plugins/cloudinary',
    { src: '~plugins/readmore', mode: 'client' },
    { src: '~plugins/offline-alert', mode: 'client' },
    { src: '~plugins/numerals', mode: 'client' },
    { src: '~plugins/recaptchaV3', mode: 'client' },
    { src: '~plugins/froala', mode: 'client' },
    { src: '~plugins/vue-sweetalert2', mode: 'client' },
    { src: '~plugins/bootstrap', mode: 'client' }
  ],

  modules: [
    '@nuxtjs/router'
  ],

  server: {
    port: 3000, // default: 3000
    host: '0.0.0.0' // default: localhost
  },

  build: {
    extractCSS: true
  },

  hooks: {
    build: {
      done (builder) {
        // Copy dist files to public/_nuxt
        if (builder.nuxt.options.dev === false && builder.nuxt.options.mode === 'spa') {
          const publicDir = join(builder.nuxt.options.rootDir, 'public', '_nuxt')
          removeSync(publicDir)
          copySync(join(builder.nuxt.options.generate.dir, '_nuxt'), publicDir)
          copySync(join(builder.nuxt.options.generate.dir, '200.html'), join(publicDir, 'index.html'))
        }
      }
    }
  }
}
