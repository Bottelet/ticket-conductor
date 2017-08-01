<template>
	<v-layout row justify-center>
		<v-dialog v-model="dialog" width="1650px">
			<v-btn icon slot="activator" class="ml-3 teal text--lighten-2 icon-background" v-if="showButton">
				<v-icon dark medium>add</v-icon>
			</v-btn>
			<v-card>
				<v-card-title>
					<span class="headline">Create a new user</span>
				</v-card-title>
				<v-card-text>
					<v-layout row wrap>
						<v-flex xs6 >
							<v-text-field name="first_name" v-model="firstName" value="consumerChild.first_name" label="First name" prepend-icon="portrait" required ></v-text-field>
						</v-flex>
						<v-flex xs6>
							<v-text-field name="last_name" label="Last name"  v-model="lastName" required></v-text-field>
						</v-flex>
						<v-flex xs7>
							<v-text-field name="email" label="E-mail" prepend-icon="mail" v-model="email" :rules="[rules.email]" required></v-text-field>
						</v-flex>
						<v-flex xs5>
							<v-text-field name="phone" label="Phone" prepend-icon="phone" v-model="phone"></v-text-field>
						</v-flex>
						<v-flex xs6>
							<v-text-field type="password" name="password" label="Password" prepend-icon="lock" v-model="password" required></v-text-field>
						</v-flex>
						<v-flex xs6>
							<v-text-field type="password" name="confirmPassowrd" label="Confirm password" v-model="confirmPassowrd" required></v-text-field>
						</v-flex>
						<v-flex xs12 >
							<v-select
							prepend-icon="supervisor_account"
							v-bind:items="groups"
							v-model="groupId"
							label="Groups"
							name="group_id"
							item-text="name"
							item-value="id"
							single-line
							bottom
							required
							></v-select>
						</v-flex>
					</v-layout>
				</v-card-text>
				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn class="blue--text darken-1" flat @click.native="dialog = false">Close</v-btn>
					<v-btn class="blue--text darken-1" flat v-on:click="newUser">Save</v-btn>
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
		data () {
			return {
				dialog: false,
				firstName: null,
				lastName: null,
				email: null,
				phone: null,
				password: null,
				confirmPassowrd:null,
				groupId: null,
				groups: [],
				rules: {
					required: (value) => !!value || 'Required.',
					email: (value) => {
						const pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
						return pattern.test(value) || 'Invalid e-mail.'
					}
				}
			}
		},
		props: {
			showButton: {
				type: Boolean,
				default: true
			}
		},
		methods: {
			newUser() {
				var self = this
				if (!this.firstName) {
					self.$store.commit('setFlashMessage', {
						text: "First name is required",
						type: "error",
						show: "true"
					})
					return;
				}
				if (!this.groupId) {
					self.$store.commit('setFlashMessage', {
						text: "Last name is required",
						type: "error",
						show: "true"
					})
					return;
				}
				if (!this.email) {
					self.$store.commit('setFlashMessage', {
						text: "Email is required",
						type: "error",
						show: "true"
					})
					return;
				}
				if (!this.password) {
					self.$store.commit('setFlashMessage', {
						text: "Password is required",
						type: "error",
						show: "true"
					})
					return;
				}
				if (this.confirmPassowrd != this.password) {
					self.$store.commit('setFlashMessage', {
						text: "Password does not match",
						type: "error",
						show: "true"
					})
					return;
				}
				if (!this.groupId) {
					self.$store.commit('setFlashMessage', {
						text: "Group is required",
						type: "error",
						show: "true"
					})
					return;
				}

				axios.post(config.api_url + '/user/create', 
				{
					first_name: self.firstName,
					last_name: self.lastName,
					phone: self.phone,
					email: self.email,
					password: self.password,
					confirmPassowrd: self.confirmPassowrd,
					group_id: self.groupId

				},
				{
					headers: auth.getAuthHeader()
				})
				.then(function (response) {
					self.firstName = null
					self.lastName = null
					self.phone= null					
					self.email = null
					self.password = null
					self.confirmPassowrd = null
					self.$parent.getUsers() //A vuejs 1 (I think)hack to call the getUsers method, on parent component to instantly refresh the table
					self.$store.commit('setFlashMessage', {
						text: "User was created",
						type: "success",
						show: "true"
					})
				})
				.catch(function (error) {

				});
			},
			getGroups() {
				var self = this
				axios.get(config.api_url + '/group', {
					headers: auth.getAuthHeader()
				})
				.then(function (response) {
					self.groups = response.data
				})
				.catch(function (error) {

				});
			}
		},
		mounted: function() {
			this.getGroups()
		}
	}
</script>

<style>
	
</style>