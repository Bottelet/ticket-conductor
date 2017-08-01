// src/auth/index.js

import router from '../router/index.js'
import axios from 'axios';
import config from '../../config/config.js'

export default {

  // User object will let us check authentication status
  user: {
    authenticated: false
  },

  // Send a request to the login URL and save the returned JWT
  login(context, creds, redirect) {
    var self = this;
    axios.post(config.app_url + '/oauth/token/', {
      username: creds.email,
      password: creds.password,
      client_id: config.client_id,
      client_secret: config.client_secret,
      grant_type: "password",
      scope: "*"
    },
    {
      headers: {
        'Access-Control-Allow-Origin': 'http:127.0.0.1:9090'
      }
    })
    .then(function (response) {
      localStorage.setItem('token', response.data.access_token)
      self.user.authenticated = true

      if(redirect) {
        router.push(redirect)        
      }

      location.reload();
    })
    .catch(function (error) {

    });
  },
  // To log out, we just need to remove the token
  logout(redirect) {
    localStorage.removeItem('token')
    this.user.authenticated = false

    if(redirect) {
      router.push(redirect)        
    }
    location.reload();
  },

  checkAuth() {
    var jwt = localStorage.getItem('token')
    if(jwt) {
      this.user.authenticated = true
    }
    else {
      this.user.authenticated = false      
    }
  },

  // The object to be passed as a header for authenticated requests
  getAuthHeader() {
    return {
      'Authorization': 'Bearer ' + localStorage.getItem('token')
    }
  }
} 