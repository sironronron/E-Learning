import Vue from 'vue'
import { library, config } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import {
  faUser, faLock, faSignOutAlt, faCog, faTh, faDesktop, faUserSecret, faCube, faMagic, faMale, faPencilAlt, faSearch, faCartPlus, faBars, faBullseye, faCheck, faClock, faEnvelope, faKey, faStar, faBell, faCheckCircle, faClipboardList, faClipboardCheck, faPiggyBank, faQuestionCircle
} from '@fortawesome/free-solid-svg-icons'

import {
  faGithub, faCss3Alt, faGooglePlusSquare, faFacebookSquare, faGoogle, faFacebookMessenger, faInstagram, faPinterest, faTwitterSquare
} from '@fortawesome/free-brands-svg-icons'

config.autoAddCss = false

library.add(
  faUser, faLock, faSignOutAlt, faCog, faGithub, faTh, faDesktop, faCss3Alt, faUserSecret, faCube, faMagic, faMale,
  faPencilAlt, faSearch, faCartPlus, faBars, faBullseye, faCheck, faClock, faEnvelope, faKey, faUser, faGooglePlusSquare,
  faFacebookSquare, faGoogle, faStar, faBell, faCheckCircle, faFacebookMessenger, faClipboardCheck, faClipboardList,
  faClock, faPiggyBank, faInstagram, faPinterest, faTwitterSquare, faQuestionCircle
)

Vue.component('fa', FontAwesomeIcon)
