<template>
	<v-layout row justify-center>
		<v-dialog v-model="dialog" width="1650px">
			<v-btn icon slot="activator" class="ml-3 teal text--lighten-2 icon-background" v-if="showButton">
				<v-icon dark medium>add</v-icon>
			</v-btn>
			<v-card>
				<v-card-title>
					<span class="headline">Create a new group</span>
				</v-card-title>
				<v-card-text>
					<v-layout row wrap>
						<v-flex xs12>
							<v-text-field name="name" v-model="name" label="Name" prepend-icon="translate" required ></v-text-field>
						</v-flex>
						<v-flex xs12>
							<v-text-field name="description" label="Description" prepend-icon="speaker_notes" multi-line v-model="description"></v-text-field>
						</v-flex>
					</v-layout>
				</v-card-text>
				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn class="blue--text darken-1" flat @click.native="dialog = false">Close</v-btn>
					<v-btn class="blue--text darken-1" flat v-on:click="newGroup">Save</v-btn>
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
				name: null,
				description: null,
				groups: [],
			}
		},
		props: {
			showButton: {
				type: Boolean,
				default: true
			}
		},
		methods: {
			newGroup() {
				var self = this
				if (!this.name) {
					self.$store.commit('setFlashMessage', {
						text: "Group name is required",
						type: "error",
						show: "true"
					})
					return;
				}

				axios.post(config.api_url + '/group/create', 
				{
					name: self.name,
					description: self.description,
				},
				{
					headers: auth.getAuthHeader()
				})
				.then(function (response) {
					self.name = null
					self.description = null

					self.$parent.getGroups() //A vuejs 1 (I think)hack to call the getUsers method, on parent component to instantly refresh the table
					self.$store.commit('setFlashMessage', {
						text: "Group was created",
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