<template>
  <div id="login" v-if="authenticate() === false">
    <login></login>
  </div>

  <div id="dashboard" v-else-if="authenticate() === true">
    <dashboard ></dashboard>
  </div>
</template>

<script>
  import Dashboard from './components/dashboard.vue'
  import Login from './components/login.vue'
  import auth from './auth/index.js'
  import axios from 'axios'
  import config from '../config/config.js'


  export default {
    data () {
      return {
        drawer: true,
        items: [
        { title: 'Signup', icon: 'dashboard', link: '/foo' },
        { title: 'Login', icon: 'question_answer', link: '/bar' },
        { title: 'Profile', icon: 'question_answer', link: '/user/profile' }
        ],
        mini: true,
        right: null,
      }
    },
    components: {
      'dashboard': Dashboard,
      'login': Login
    },
    methods: {
      authenticate() {
        return auth.user.authenticated
      },
      getProfile() {
        var self = this;
        axios.post(config.api_url + '/user/profile', 
          {},
          {
            headers: auth.getAuthHeader()
          }
          )
        .then(function (response) {
         self.$store.commit('setUser', response.data)
       })
        .catch(function (error) {

        });
      }
    },
    mounted: function (){
      if (this.authenticate() === true) {
        this.getProfile()
      }
    },
  }
</script>

<style>

</style>