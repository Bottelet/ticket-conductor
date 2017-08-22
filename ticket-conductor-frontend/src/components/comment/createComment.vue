<template>
  <v-flex xs12>
    <v-card light>
    <v-text-field
    name="comment"
    label="Comment"
    textarea
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
import auth from '../../auth/index.js'

export default {
  data () {
    return {
      comment: null,
    }
  },
  methods: {
    newComment() {
      var comment = this.comment
      self = this;
      axios.post(config.api_url + '/ticket/' + this.$route.params.id + '/create-comment',
      {
        text: comment,
      },
      {
        headers: auth.getAuthHeader()
      })
      .then(function (response) {
        self.comment = null
        //TODO: Do not call parents other child component function like this
        self.$parent.$children[2].getComments() //A vuejs 1 (I think)hack to call the getConsumer method, on parent component to instantly refresh the information
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
