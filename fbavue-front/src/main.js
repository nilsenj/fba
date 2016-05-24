import Vue from 'vue'
import Index from './Index.vue'
import VueRouter from 'vue-router'
import VueResource from 'vue-resource'
import Item from './components/Item.vue'
import Basket from './components/Basket.vue'
import Contact from './components/Contact.vue'

Vue.use(VueRouter)
Vue.use(VueResource)

Vue.filter('currencyDisplay', {
  // model -> view
  // formats the value when updating the input element.
  read: function (val) {
    return '$' + val.toFixed(2)
  },
  // view -> model
  // formats the value when writing to the data.
  write: function (val, oldVal) {
    var number = +val.replace(/[^\d.]/g, '')
    return isNaN(number) ? 0 : parseFloat(number.toFixed(2))
  }
})

Vue.filter('isDecimal', {
  // model -> view
  // formats the value when updating the input element.
  read: function (val) {
    if (val) {
      return parseFloat(val).toFixed(3)
    }
  },
  // view -> model
  // formats the value when writing to the data.
  write: function (val, oldVal) {
    var number = +val.replace(/[^\d.]/g, '')
    return isNaN(number) ? 0 : parseFloat(number.toFixed(3))
  }
})

Vue.config.debug = true
Vue.config.devtools = true
Vue.config.silent = false

// For 404 page
var notFound = Vue.extend({
  // path : '/path/to/component.html'
  template: '<h1 class="text-center text-danger">Not Found</h1>'
})

// Our subroute content just for testing.
var subRouteContent = Vue.extend({
  template:
  '<h1>Navbar example</h1>' +
  '<p>This example is a quick exercise to illustrate how the default, static and fixed to top navbar work. It includes the responsive CSS and HTML, so it also adapts to your viewport and device.</p>' +
  '<p>To see the difference between static and fixed top navbars, just scroll.</p>'
})

// Router options
const router = new VueRouter({
  history: true,
  hashbang: false,
  saveScrollPosition: true,
  transitionOnLoad: true,
  root: '/'
})
// Router map for defining components
router.map({
  // For Not Found template
  '*': {
    component: notFound
  },
  '/': {
    component: Index,
    // Defining Subroutes
    subRoutes: {
      '/subroute': {
        component: subRouteContent
      }
    }
  },
  '/basket': {
    component: Basket,
    name: 'basket.index',
    router: router,
    // Defining Subroutes
    subRoutes: {
    }
  },
  '/item': {
    component: Item,
    // Defining Subroutes
    subRoutes: {
      '/subroute': {
        component: subRouteContent
      }
    }
  },
  '/me': {
    component: Contact
  }
})

var App = Vue.extend()

router.start(App, '#app')
