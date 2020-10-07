<template>
  <div>
    <h2 class="post-list__post-title post-title">
      <a v-bind:href="post.link" v-bind:title="post.title">
        {{ post.title }}
      </a>
    </h2>
    <p class="excerpt">
      {{ post.description }}
      ... <a v-bind:href="post.link">[lire]</a>
    </p>
    <div class="post-list__meta">
      <TSDateDisplay v-bind:timestamp="post.timestamp" />
      &#8226;
      <span class="post-meta__tags">
        via blog
      </span>
    </div>
    <hr class="post-list__divider" />
  </div>
</template>
<script>
import TSDateDisplay from './TSDateDisplay'

export default {
  name: 'PostBlogDisplay',
  components: { TSDateDisplay },
  props: ['post'],
}
</script>
