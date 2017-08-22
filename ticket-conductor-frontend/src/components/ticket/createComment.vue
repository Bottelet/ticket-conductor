<template>
  <v-flex xs12>
    <v-card light>
    <v-text-field
    name="comment"
    label="Comment"
    textarea
    counter
    textarea
    v-model="comment"
    ></v-text-field>
    <v-btn light class="white--text" primary v-on:click="newComment">Add comment</v-btn>
  </v-card>
  </v-flex>
</template>
<script>
import axios from 'axios'
import config from '../../../config/config.js'

export default {
  data () {
    return {
      comment: null,
    }
  },
  methods: {
    newComment() {
      var comment = this.elConsumer
      axios.post(config.api_url + '/ticket/' + this.$route.params.id + 'create-comment',
      {
        title: comment,
      },
      {
        headers: auth.getAuthHeader()
      })
      .then(function (response) {
        self.comment = null
        self.$parent.getTickets() //A vuejs 1 (I think)hack to call the getTicket method, on parent component to instantly refresh the table
        self.$store.commit('setFlashMessage', {
          text: "Comment was added",
          type: "success",
          show: "true"
        })
      })
      .catch(function (error) {

      });
    }
  }
}
</script>
<style>
.application--light .input-group.input-group--textarea:not(.input-group--full-width) textarea {
  border:none;
}
</style>
