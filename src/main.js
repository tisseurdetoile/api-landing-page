import Vue from 'vue'
import App from './App.vue'
import './assets/style/uno.css'
import { makeServer } from './server'

Vue.config.productionTip = false

if (process.env.NODE_ENV === 'development') {
  makeServer()
}

new Vue({
  data() {
    return {
      landingOnNews: this.isLandingOnNews(),
      displayNews: false,
    }
  },
  render: (h) => h(App),
  methods: {
    isLandingOnNews() {
      return window.location.pathname === '/news'
    },
    toggleNews(event) {
      console.log('function oggleNews')
      console.log(event)
    },
  },
}).$mount('#app')
