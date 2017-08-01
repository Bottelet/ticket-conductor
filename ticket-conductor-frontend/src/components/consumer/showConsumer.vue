<template>
	<v-layout row wrap>
		<v-flex xs12>
			<header-card :consumer="consumer"></header-card>
		</v-flex>
		<v-spacer></v-spacer>
		<v-flex xs12>
			<h6>Consumer tickets</h6>
			<v-text-field
			append-icon="search"
			label="Search"
			single-line
			hide-details
			v-model="search"
			></v-text-field>
		</v-card-title>
		<v-data-table
		v-bind:headers="headers"
		v-bind:items="tickets"
		v-bind:search="search"
		>
		<template slot="items" scope="props">
			<td class="text-xs-left">
				<router-link :to="{ name: 'showTicket', params: { id: props.item.id }}">
					<v-chip small v-if="props.item.status == 'Open'" class="green white--text">
						O
					</v-chip>
					<v-chip small v-else-if="props.item.status == 'Pending'" class="orange white--text">
						P
					</v-chip>
					<v-chip small v-else-if="props.item.status == 'New'" class="indigo white--text">
						N
					</v-chip>
					<v-chip small v-else-if="props.item.status == 'Solved'" class="red white--text">
						S
					</v-chip>
					{{ props.item.title }}
				</router-link>
			</td>
			<td class="text-xs-left">{{ props.item.type }}</td>
			<td class="text-xs-left">{{ props.item.status }}</td>
			<td class="text-xs-left">{{ props.item.priority }}</td>
			<td class="text-xs-left">{{ props.item.created_at | formatDate }}</td>
		</template>
		<template slot="pageText" scope="{ pageStart, pageStop }">
			From {{ pageStart }} to {{ pageStop }}
		</template>
	</v-data-table>
</v-flex>
</v-layout>
</template>

<script>
	import axios from 'axios'
	import moment from 'moment'
	import config from '../../../config/config.js'
	import auth from '../../auth/index.js'
	import snackbar from '../layout/misc/snackbar.vue'
	import headerCard from './headerCard.vue'

	export default {
		data () {
			return {
				search: '',
				pagination: {},
				headers: [
				{
					text: 'Title',
					align: 'left',
					sortable: false,
					value: 'title'
				},
				{ 
					text: 'Type',
					value: 'type',
					align: 'left'
				},
				{ 
					text: 'Status', 
					value: 'status',
					align: 'left'
				},
				{ 
					text: 'Priority',
					value: 'priority',
					align: 'left' 
				},
				{ 
					text: 'Created at',
					value: 'created_at',
					align: 'left' 
				},
				],
				tickets: [],
				consumer: {},
			}
		},
		methods: {
			getConsumerTickets() {
				var self = this
				axios.get(config.api_url + '/user/' + this.$route.params.id  + '/tickets', {
					headers: auth.getAuthHeader()
				})
				.then(function (response) {
					self.tickets = response.data
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
					self.consumer = response.data
				})
				.catch(function (error) {

				});
			}

		},
		mounted: function () {
			this.getConsumerTickets()
			this.getConsumer()
		},
		components: {
			'flash-message': snackbar,
			'header-card': headerCard
		},
		filters: {
			formatDate: function(date) {
				return moment(date).fromNow()
			}
		}
	}
</script>
<style>
	
</style>