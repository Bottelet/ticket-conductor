<template>
	<v-layout row justify-center>
		<v-dialog v-model="dialog" width="1650px">
			<v-btn slot="activator"  fab dark small class="cyan" left  v-if="showButton">
				<v-icon dark>edit</v-icon>
			</v-btn>
			<v-card>
				<v-card-title>
					<span class="headline">Edit consumer</span>
				</v-card-title>
				<v-card-text>
					<v-layout row wrap>
						<v-flex xs6 >
							<v-text-field name="first_name" v-model="firstName" value="consumerChild.first_name" label="First name" prepend-icon="portrait" ></v-text-field>
						</v-flex>
						<v-flex xs6>
							<v-text-field name="last_name" label="Last name"  v-model="lastName"></v-text-field>
						</v-flex>
						<v-flex xs7>
							<v-text-field name="address" label="Address" prepend-icon="map" v-model="address"></v-text-field>
						</v-flex>
						<v-flex xs3>
							<v-text-field name="city" label="City" prepend-icon="location_city" v-model="city"></v-text-field>
						</v-flex>
						<v-flex xs2>
							<v-text-field name="zipcode" label="Zipcode" prepend-icon="place" v-model="zipcode"></v-text-field>
						</v-flex>
						<v-flex xs7>
							<v-text-field name="email" label="E-mail" prepend-icon="mail" v-model="email" required></v-text-field>
						</v-flex>
						<v-flex xs5>
							<v-text-field name="phone" label="Phone" prepend-icon="phone" v-model="phone"></v-text-field>
						</v-flex>
					</v-layout>
				</v-card-text>
				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn class="blue--text darken-1" flat @click.native="dialog = false">Close</v-btn>
					<v-btn class="blue--text darken-1" flat @click.native="dialog = false" v-on:click="updateConsumer">Save</v-btn>
				</v-card-actions>
			</v-card>
		</v-dialog>
	</v-layout>
</template>

<script>
	import axios from 'axios'
	import config from '../../../config/config.js'
	import auth from '../../auth/index.js'

	export default {
		props: {
			showButton: {
				type: Boolean,
				default: true
			}
		},
		data () {
			return {
				dialog: false,
				consumer: {},
				firstName: null,
				lastName: null,
				address: null,
				city: null,
				zipcode: null,
				email: null,
				phone: null
			}
		},
		methods: {
			updateConsumer() {
				var self = this
				axios.patch(config.api_url + '/consumer/'  + this.$route.params.id + '/update' , 
				{
					first_name: self.firstName,
					last_name: self.lastName,
					address: self.address,
					city: self.city,
					zipcode: self.zipcode,
					phone: self.phone,
					email: self.email
				},
				{
					headers: auth.getAuthHeader()
				})
				.then(function (response) {
					//TODO: Just find a better way...
					self.$parent.$parent.getConsumer() //A vuejs 1 (I think)hack to call the getConsumer method, on parent component to instantly refresh the information
					self.$store.commit('setFlashMessage', {
						text: "Consumer was updated",
						type: "success",
						show: "true"
					})
				})
				.catch(function (error) {

				});
			},
			getConsumer() {
				var self = this
				axios.get(config.api_url + '/consumer/' + this.$route.params.id, {
					headers: auth.getAuthHeader()
				})
				.then(function (response) {
					self.firstName = response.data.first_name
					self.lastName = response.data.last_name
					self.address = response.data.address
					self.city = response.data.city
					self.zipcode = response.data.zipcode
					self.email = response.data.email
					self.phone = response.data.phone
				})
				.catch(function (error) {

				});
			}
		},
		mounted: function() {
			//TODO: Had to make the GET api call to get the data for a consumer again, as i could not pass it with a prop for some reason gotta fix it.
			this.getConsumer()
		}
	}
</script>

<style>
	
</style>