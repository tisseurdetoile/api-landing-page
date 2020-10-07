<template>
  <div class="content-wrapper__inner">
    <div class="main-post-list">
      <ol v-if="posts" class="post-list">
        <li v-for="item in posts.posts" :key="item.hash">
          <PostBlogDisplay v-if="item.type == 'rss'" v-bind:post="item" />
          <PostTwitterDisplay
            v-if="item.type == 'twitter'"
            v-bind:post="item"
          />
        </li>
      </ol>
      <hr class="post-list__divider " />
    </div>
  </div>
</template>
<script>
import axios from 'axios'
import PostBlogDisplay from './PostBlogDisplay'
import PostTwitterDisplay from './PostTwitterDisplay'
export default {
  name: 'PostDisplay',
  components: { PostBlogDisplay, PostTwitterDisplay },
  data() {
    return {
      posts: null,
    }
  },
  mounted() {
    axios.get('api/posts').then((response) => (this.posts = response.data))
  },
}
</script>
