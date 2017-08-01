<!-- I dont know if i have done this "flash-message" corretly, but it works with vuex, by calling commit(setFlashmessage)
And set a value of show to true and than in dashboard i implement this component and if show is true, it will than show the flash message
and after 5 sec it will than set flashMessage to be false, and nothing wil show Prob a hack, but no idea how to do it better atm-->
<template>
	<v-card class="grey lighten-4">
		<v-snackbar
		top
		right
		multi-line
		vertical
		:class="type.type"
		v-model="snackbar"
		>
		{{ flashMessage.text }}
		<v-btn flat class="black--text" @click.native="snackbar = false">Close</v-btn>
	</v-snackbar>
</v-card>
</template>

<script>

	export default {
		data () {
			return {
				snackbar: true,
				y: 'top',
				x: null,
				mode: '',
				type: { type: this.$store.getters.getFlashMessage.type}
			}
		},
		methods : {
			//Hack to delay the fade out for the snackbar, and than set flashmessage to false so it does not keep showing
			delay() {
				var myTimerPromise = new Promise((resolve, reject) => {
					setTimeout(() => {
			            // callback function for timer, gets called after the time-delay
			            this.snackbar = false
			            resolve();
			            
			        }, 4000);  
					setTimeout(() => {

						this.$store.commit('setFlashMessage', false)
					}, 5000);  

				});
			}
		},
		computed: {
			flashMessage () {
				return this.$store.getters.getFlashMessage
			}

		},
		mounted() {
			this.delay()
		}
	}
</script>

<style>
	
</style>