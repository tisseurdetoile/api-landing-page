<template>
  <nav class="cover-navigation navigation--social">
    <ul class="navigation">
      <!-- Twitter -->
      <li v-if="iconData.social.twitter" class="navigation__item">
        <a
          v-bind:href="'http://twitter.com/' + iconData.social.twitter"
          v-bind:title="'@' + iconData.social.twitter"
          target="_blank"
        >
          <i class="icon icon-social-twitter"></i>
          <span class="label">Twitter</span>
        </a>
      </li>

      <!-- Facebook -->
      <li v-if="iconData.social.facebook" class="navigation__item">
        <a
          v-bind:href="'http://fb.me/' + iconData.social.facebook"
          v-bind:title="iconData.social.facebook + 'on Facebook'"
          target="_blank"
        >
          <i class="icon icon-social-facebook"></i>
          <span class="label">Facebook</span>
        </a>
      </li>

      <!-- LinkedIn -->
      <li v-if="iconData.social.linkedin" class="navigation__item">
        <a
          v-bind:href="
            'https://www.linkedin.com/in/' + iconData.social.linkedin
          "
          v-bind:title="iconData.social.facebook + 'on LinkedIn'"
          target="_blank"
        >
          <i class="icon icon-social-linkedin"></i>
          <span class="label">LinkedIn</span>
        </a>
      </li>

      <!-- GitHub -->
      <li v-if="iconData.social.github" class="navigation__item">
        <a
          v-bind:href="'https://www.github.com/' + iconData.social.github"
          v-bind:title="iconData.social.github + 'on GitHub'"
          target="_blank"
        >
          <i class="icon icon-social-github"></i>
          <span class="label">GitHub</span>
        </a>
      </li>

      <!-- Email -->
      <li v-if="iconData.social.mail" class="navigation__item">
        <a
          v-bind:href="'mailto:' + iconData.social.mail"
          v-bind:title="'Email ' + iconData.social.mail"
          target="_blank"
        >
          <i class="icon icon-mail"></i>
          <span class="label">Email</span>
        </a>
      </li>

      <!-- RSS -->
      <li v-if="iconData.social.rss" class="navigation__item">
        <a v-bind:href="iconData.social.rss" title="Subscribe" target="_blank">
          <i class="icon icon-rss"></i>
          <span class="label">RSS</span>
        </a>
      </li>

      <!-- Website -->
      <li v-if="iconData.url" class="navigation__item">
        <a v-bind:href="iconData.url" title="Subscribe" target="_blank">
          <i class="icon icon-paw"></i>
          <span class="label">Website</span>
        </a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  name: 'NavigationIcon',
  props: {
    iconData: Object,
  },
}
</script>
