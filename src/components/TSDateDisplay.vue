<template>
  <time v-bind:datetime="date" class="post-list__meta--date date">
    {{ date_FR }}
  </time>
</template>
<script>
export default {
  name: 'TSDateDisplay',
  props: ['timestamp'],
  methods: {
    format_date_FR(ts) {
      const milliseconds = ts * 1000
      const dateObject = new Date(milliseconds)

      const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
      }

      return dateObject.toLocaleDateString('fr-FR', options)
    },
    format_date(ts) {
      const milliseconds = ts * 1000
      const dateObject = new Date(milliseconds)

      return dateObject.toLocaleDateString()
    },
  },
  data() {
    return {
      date_FR: this.format_date_FR(this.timestamp),
      date: this.format_date(this.timestamp),
    }
  },
}
</script>
