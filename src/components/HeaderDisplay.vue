<template>
  <!-- on ajoute la class panel-cover--collapsed pour avoir les liens -->
  <header
    v-bind:class="{ 'panel-cover--collapsed': displayNews }"
    class="panel-cover"
    v-bind:style="[cssBackGround]"
  >
    <div class="panel-main">
      <div class="panel-main__inner panel-inverted">
        <div v-if="info" class="panel-main__content">
          <a v-bind:href="info.url" title="link to home of Jekyll-Uno">
            <img
              v-bind:src="'./' + info.icon"
              class="user-image"
              alt="My Profile Photo"
            />
            <h1 class="panel-cover__title panel-title">
              {{ info.title }}
            </h1>
          </a>
          <hr class="panel-cover__divider" />
          <p class="panel-cover__description">
            {{ info.subtitle }}
          </p>
          <hr class="panel-cover__divider panel-cover__divider--secondary" />
          <div class="navigation-wrapper">
            <nav class="cover-navigation cover-navigation--primary">
              <ul class="navigation">
                <li class="navigation__item">
                  <a v-on:click="toggleNews" title="News" class="blog-button">
                    News
                  </a>
                </li>
              </ul>
            </nav>
            <NavigationIcon v-if="info" :iconData="info" />
          </div>
        </div>
      </div>
      <div class="panel-cover--overlay"></div>
    </div>
  </header>
</template>
<script>
import NavigationIcon from './NavigationIcon.vue'
export default {
  name: 'HeaderDisplay',
  data() {
    return {
      displayNews: this.isLandingOnNews(),
      publicPath: process.env.BASE_URL,
      count: 0,
    }
  },
  components: { NavigationIcon },
  props: { info: Object },
  computed: {
    cssBackGround() {
      var img_src = 'url(' + this.publicPath + this.imageSrc + ')'
      return {
        'background-image': img_src,
        'background-size': 'cover',
      }
    },
    imageSrc() {
      if (this.info !== null) {
        return this.info.background
      } else {
        return 'cover.jpg'
      }
    },
  },
  methods: {
    isLandingOnNews() {
      return window.location.pathname === '/news'
    },
    toggleNews() {
      this.displayNews = !this.displayNews
    },
    increment() {
      this.count++
    },
  },
}
</script>
