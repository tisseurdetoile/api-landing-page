<template>
  <div id="app">
    <span class="mobile btn-mobile-menu">
      <i class="icon icon-list btn-mobile-menu__icon"></i>
      <i class="icon icon-x-circle btn-mobile-close__icon hidden"></i>
    </span>
    <HeaderDisplay v-bind:info="meInfo" />
    <div class="content-wrapper">
      <PostsDisplay />
      <FooterDisplay />
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import PostsDisplay from './components/PostsDisplay.vue'
import HeaderDisplay from './components/HeaderDisplay.vue'
import FooterDisplay from './components/FooterDisplay.vue'

export default {
  name: 'App',
  components: {
    PostsDisplay,
    HeaderDisplay,
    FooterDisplay,
  },
  data() {
    return {
      meInfo: null,
    }
  },
  mounted() {
    axios.get('api/me').then((response) => (this.meInfo = response.data))
  },
}
</script>
