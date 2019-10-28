import Vue from 'vue'
import Router from 'vue-router'
import { interopDefault } from './utils'
import scrollBehavior from './router.scrollBehavior.js'

const _7c514734 = () => interopDefault(import('../pages/cart/index.vue' /* webpackChunkName: "pages/cart/index" */))
const _23372e28 = () => interopDefault(import('../pages/auth/signin.vue' /* webpackChunkName: "pages/auth/signin" */))
const _70a58728 = () => interopDefault(import('../pages/categories/_slug.vue' /* webpackChunkName: "pages/categories/_slug" */))
const _295a5aa0 = () => interopDefault(import('../pages/products/_slug.vue' /* webpackChunkName: "pages/products/_slug" */))
const _02a8445e = () => interopDefault(import('../pages/index.vue' /* webpackChunkName: "pages/index" */))

Vue.use(Router)

export const routerOptions = {
  mode: 'history',
  base: decodeURI('/'),
  linkActiveClass: 'nuxt-link-active',
  linkExactActiveClass: 'nuxt-link-exact-active',
  scrollBehavior,

  routes: [{
      path: "/cart",
      component: _7c514734,
      name: "cart"
    }, {
      path: "/auth/signin",
      component: _23372e28,
      name: "auth-signin"
    }, {
      path: "/categories/:slug?",
      component: _70a58728,
      name: "categories-slug"
    }, {
      path: "/products/:slug?",
      component: _295a5aa0,
      name: "products-slug"
    }, {
      path: "/",
      component: _02a8445e,
      name: "index"
    }],

  fallback: false
}

export function createRouter() {
  return new Router(routerOptions)
}
