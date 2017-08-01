<template>
	<v-layout row justify-center>
		<v-dialog v-model="dialog" width="1650px">
			<v-btn icon slot="activator" class="ml-3 teal text--lighten-2 icon-background" v-if="showButton">
				<v-icon dark medium>add</v-icon>
			</v-btn>
			<v-card>
				<v-card-title>
					<span class="headline">Create a new ticket</span>
				</v-card-title>
				<v-card-text>
					<v-layout row wrap>
						<v-flex xs12>
							<v-text-field name="title" label="Title" v-model="elTitle" required></v-text-field>
						</v-flex>
						<v-flex xs12>
							<v-text-field
							name="description"
							label="Description"
							multi-line
							v-model="elDescription"
							></v-text-field>
						</v-flex>
						<v-flex xs4 >
							<v-select
							v-bind:items="status"
							v-model="elStatus"
							label="Status"
							name="status"
							single-line
							bottom
							></v-select>
						</v-flex>
						<v-flex xs4 >
							<v-select
							v-bind:items="types"
							v-model="elType"
							label="Type"
							name="type"
							single-line
							bottom
							></v-select>
						</v-flex>
						<v-flex xs4 >
							<v-select
							v-bind:items="priorities"
							v-model="elPriority"
							label="Priority"
							name="priority"
							single-line
							bottom
							></v-select>
						</v-flex>
						<v-flex xs12>
							<v-text-field name="consumer" label="Consumer email" v-model="elConsumer" persistent-hint hint="If no consumer is found, a new one is created" required></v-text-field>
						</v-flex>
					</v-layout>
				</v-card-text>
				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn class="blue--text darken-1" flat @click.native="dialog = false">Close</v-btn>
					<v-btn class="blue--text darken-1" flat @click.native="dialog = false" v-on:click="newTicket">Save</v-btn>
				</v-card-actions>
			</v-card>
		</v-dialog>
	</v-layout>
</template>

<script>
	import axios from 'axios'
	import ticket from './ticket.vue'
	import config from '../../../config/config.js'
	import auth from '../../auth/index.js'

	export default {
		data () {
			return {
				dialog: false,
				elStatus: null,
				elType: null,
				elPriority: null,
				elTitle: null,
				elDescription: null,
				elConsumer: null,
				status: [
				{ text: 'New' },
				{ text: 'Open' },
				{ text: 'Pending' },
				{ text: 'Solved' }
				],
				types: [
				{ text: 'Question' },
				{ text: 'Incident' },
				{ text: 'Problem' },
				{ text: 'Task' }
				],
				priorities: [
				{ text: 'Low' },
				{ text: 'Normal' },
				{ text: 'High' },
				{ text: 'Urgent' }
				],
				consumers: []
			}
		},
		props: {
			showButton: {
				type: Boolean,
				default: true
			}
		},
		methods: {
			newTicket() {
				var self = this
				var title = this.elTitle
				var description = this.elDescription
				var status = this.elStatus.text
				var type = this.elType.text
				var priority = this.elPriority.text
				var consumer = this.elConsumer
				axios.post(config.api_url + '/ticket/create', 
				{
					title: title,
					description: description,
					status: status,
					type: type,
					priority: priority,
					consumer: consumer

				},
				{
					headers: auth.getAuthHeader()
				})
				.then(function (response) {
					self.elTitle = null
					self.elDescription = null
					self.elType= null					
					self.elPriority = null
					self.elStatus = null
					self.$parent.getTickets() //A vuejs 1 (I think)hack to call the getTicket method, on parent component to instantly refresh the table
					self.$store.commit('setFlashMessage', {
						text: "Ticket was created",
						type: "success",
						show: "true"
					})
				})
				.catch(function (error) {

				});
			},
			getConsumerEmails() {
				var self = this
				axios.get(config.api_url + '/consumer-mails', {
					headers: auth.getAuthHeader()
				})
				.then(function (response) {
					self.consumers = response.data
				})
				.catch(function (error) {

				});
			}
		},
		mounted: function() {
			this.getConsumerEmails()
		}
	}
</script>

<style>
	
</style>