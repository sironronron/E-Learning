import Vue from 'vue'
import CloudinaryVue from 'cloudinary-vue'
import { CldContext, CldImage, CldVideo, CldTransformation } from 'cloudinary-vue'

Vue.component(CldContext)
Vue.component(CldImage)
Vue.component(CldVideo)
Vue.component(CldTransformation)

Vue.use(CloudinaryVue, {
  configuration: {
    cloudName: 'dl9phqhv0'
  }
})
