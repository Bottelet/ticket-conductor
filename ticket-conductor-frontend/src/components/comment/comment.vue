<template>
  <v-flex xs12>
    <v-card light v-for="comment in comments" :key="comment.id" class="comment mb-3">
      <p>{{comment.text}}</p>
      <p class="caption footer-text">Created: {{comment.created_at | formatDate}}</p>
    </v-card>
  </v-flex>
</template>

<script>
import axios from 'axios'
import config from '../../../config/config.js'
import auth from '../../auth/index.js'
import moment from 'moment'

export default {
  props: ['ticketId'],
  data () {
    return {
      comments: [],
    }
  },
  methods: {
    getComments() {
      var self = this
      axios.get(config.api_url + '/ticket/' + self.ticketId + '/comments', {
        headers: auth.getAuthHeader()
      })
      .then(function (response) {
        self.comments = response.data
      })
      .catch(function (error) {

      });
    }
  },
  mounted: function() {
    this.getComments()
  },
  filters: {
    formatDate: function(date) {
      return moment(date).fromNow()
    }
  }
}
</script>

<style>
.comment {
    min-height: 130px;
    padding-left: 20px;
    padding-top: 20px;
    padding-bottom: 15px;
}
.footer-text {
    margin-top: 4%;
}
</style>
