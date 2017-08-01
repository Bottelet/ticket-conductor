import Vue from 'vue/dist/vue'
import VueRouter from 'vue-router'
import Vuetify from 'vuetify'
import App from './app.vue'
import Router from './router/index.js'
import auth from './auth/index.js'
import Vuex from 'vuex'


//Check on every request if user is authenticated
auth.checkAuth()
Vue.use(Vuex)
Vue.use(VueRouter)
Vue.use(Vuetify)



const state = {
	user: {},
	flashMessage: {},
}

const getters = {
	getUser: state => {
		return state.user
	},
	getFlashMessage: state => {
		return state.flashMessage
	}
}

const mutations = {
	setUser(state, user) {
		state.user = user
	},
	setFlashMessage(state, flashMessage) {
		state.flashMessage = flashMessage
	}
}

const actions = {
	setUser(context, data) {
		context.commit('setUser', data)
	},
	setFlashMessage(context, data) {
		context.commit('setFlashMessage', data)
	}
}

const store = new Vuex.Store({
	state,
	getters,
	mutations,
	actions
})

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = new VueRouter({
  routes: Router // short for `routes: routes`
})

// 4. Create and mount the root instance.
// Make sure to inject the router with the router option to make the
// whole app router-aware.
const app = new Vue({
	router,
	el: '#wrapper',
	store: store,
	components: { App }
})

