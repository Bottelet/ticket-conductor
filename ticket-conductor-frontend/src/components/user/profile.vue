<template>
	<v-layout row wrap>
		<v-flex md6>
			<header-card :user="user"></header-card>
		</v-flex>
		<v-flex md8>
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
	import headerCard from './headerCard.vue'
	import snackbar from '../layout/misc/snackbar.vue'

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
				user: {},
			}
		},
		methods: {
			getUsersTicket() {
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
			getUser() {
				var self = this
				axios.get(config.api_url + '/user/' + this.$route.params.id  + '/profile', {
					headers: auth.getAuthHeader()
				})
				.then(function (response) {
					self.user = response.data
				})
				.catch(function (error) {

				});
			}

		},
		mounted: function () {
			this.getUsersTicket()
			this.getUser()
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