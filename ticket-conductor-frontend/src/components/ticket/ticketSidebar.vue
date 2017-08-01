<template>
	<v-card class="grey lighten-4 elevation-0">
		<v-card-text>
			<v-container fluid>
				<v-layout row wrap>
					<v-select
					label="Collaborators"
					v-bind:items="people"
					v-model="selected_users"
					item-text="name"
					item-value="id"
					multiple
					chips
					max-height="auto"
					autocomplete
					>
					<template slot="item" scope="data">
						<v-list-tile-content>
							<v-list-tile-title v-html="data.item.name"></v-list-tile-title>
							<v-list-tile-sub-title v-html="data.item.group"></v-list-tile-sub-title>
						</v-list-tile-content>
					</template>
				</v-select>
			</v-layout>
			<v-btn success dark v-on:click="postCollaborators">Update Collaborators</v-btn>

			<v-layout row wrap>
				<v-flex xs4 >
					<v-select
					v-bind:items="status"
					v-model="elStatus"
					label="Status"
					single-line
					bottom
					hint="Status"
					persistent-hint
					item-text="status"
					item-value="status"
					></v-select>
				</v-flex>
				<v-flex xs4 >
					<v-select
					v-bind:items="types"
					v-model="elType"
					label="Type"
					single-line
					bottom
					hint="Type"
					persistent-hint
					item-text="type"
					item-value="type"
					></v-select>
				</v-flex>
				<v-flex xs4 >
					<v-select
					v-bind:items="priorities"
					v-model="elPriority"
					label="Priority"
					single-line
					bottom
					hint="Priority"
					persistent-hint
					item-text="priority"
					item-value="priority"
					></v-select>
				</v-flex>
			</v-layout>
		</v-container>
	</v-card-text>
</v-card>
</template>

<script>
	import axios from 'axios'
	import config from '../../../config/config.js'
	import auth from '../../auth/index.js'

	export default {
		props: ['ticket'],
		data () {
			return {
				selected_users: [],
				people: [],
				status: [
				{ status: 'New' },
				{ status: 'Open' },
				{ status: 'Pending' },
				{ status: 'Solved' }
				],
				types: [
				{ type: 'Question' },
				{ type: 'Incident' },
				{ type: 'Problem' },
				{ type: 'Task' }
				],
				priorities: [
				{ priority: 'Low' },
				{ priority: 'Normal' },
				{ priority: 'High' },
				{ priority: 'Urgent' }
				],
				elStatus: {status: this.ticket.status},
				elType: {type: this.ticket.type},
				elPriority: {priority: this.ticket.priority},
			}
		},
		methods: {
			getGruopsWithUsers() {
				var self = this
				axios.get(config.api_url + '/group/users', {
					headers: auth.getAuthHeader()
				})
				.then(function (response) {
					self.people = response.data
				})
				.catch(function (error) {

				});
			},
			getCollaborators(){
				var self = this
				axios.get(config.api_url + '/ticket/' + this.$route.params.id + '/collaborators', {
					headers: auth.getAuthHeader()
				})
				.then(function (response) {
					self.selected_users = response.data
				})
				.catch(function (error) {

				});
			},
			postCollaborators() {
				var selected_users = this.selected_users
				self = this
				axios.patch(config.api_url + '/ticket/' + this.$route.params.id + '/update', 
				{
					collaborators: selected_users
				},
				{
					headers: auth.getAuthHeader()
				})
				.then(function (response) {
					self.$store.commit('setFlashMessage', {
						text: "Collaborators was updated",
						type: "success",
						show: "true"
					})
				})
				.catch(function (error) {
				});
			},
			updateAttributes(data) {
				self = this
				axios.patch(config.api_url + '/ticket/' + this.$route.params.id + '/update', 
					data 
				,
				{
					headers: auth.getAuthHeader()
				})
				.then(function (response) {
					self.$store.commit('setFlashMessage', {
						text: "Attribute was updated",
						type: "success",
						show: "true"
					})
				})
				.catch(function (error) {
				});
			}
		},
		watch: {
			//TODO: watch is fired on first change when select the same value in the frontend, find some work around
			elPriority: function (new_priority, old_priority) {
				this.updateAttributes({priority: new_priority})
			},
			elStatus: function (new_status, old_status) {
				this.updateAttributes({status: new_status})
			},
			elType: function (new_type, old_type) {
				this.updateAttributes({type: new_type})
			}
		},
		mounted: function () {
			this.getGruopsWithUsers()
			this.getCollaborators()
		}
	}
</script>

<style>
	
</style>