import { Model, createServer } from 'miragejs'
import me from './api/mock/me.json'
import fetch from './api/mock/fetch.json'
import posts from './api/mock/posts.json'

export function makeServer({ environment = 'development' } = {}) {
  let server = createServer({
    environment,

    models: {
      todo: Model,
    },

    seeds(server) {
      server.create('todo', { content: 'Learn Mirage JS' })
      server.create('todo', { content: 'Integrate With Vue.js' })
    },

    routes() {
      this.namespace = 'api'

      this.get('/todos', (schema) => {
        return schema.todos.all()
      })

      this.get('/me', () => {
        return me
      })
      this.get('/posts', () => {
        return posts
      })
      this.get('/fetch', () => {
        return fetch
      })
    },
  })

  return server
}
