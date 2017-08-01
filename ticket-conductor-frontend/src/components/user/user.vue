<template>
	<v-card>
		<v-card-title>
			Users <new-user-modal></new-user-modal>
			<v-spacer></v-spacer>
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
		v-bind:items="users"
		v-bind:search="search"
		>
		<template slot="items" scope="props">
			<td class="text-xs-left" v-if="props.item.first_name != null">
				<router-link :to="{ name: 'profile', params: { id: props.item.id }}">
					{{ props.item.first_name}} {{ props.item.last_name}}
				</router-link>
			</td>
			<td class="text-xs-left unavailable-link" v-else>
				<router-link :to="{ name: 'profile', params: { id: props.item.id }}">
					undefined
				</router-link>
			</td>
			
			<td class="text-xs-left" v-if="props.item.email != null">{{ props.item.email}}</td>

			<td class="text-xs-left" v-if="props.item.phone != null">{{ props.item.phone}}</td>
			<td class="text-xs-left grey--text" v-else>undefined</td>
		</template>
		<template slot="pageText" scope="{ pageStart, pageStop }">
			From {{ pageStart }} to {{ pageStop }}
		</template>
	</v-data-table>
</v-card>

</template>

<script>
	import axios from 'axios'
	import config from '../../../config/config.js'
	import auth from '../../auth/index.js'
	import createUserModal from './createUserModal.vue'

	export default {
		data () {
			return {
				search: '',
				pagination: {},
				headers: [
				{
					text: 'Name',
					align: 'left',
					value: 'first_name'
				},

				{ 
					text: 'Email', 
					value: 'email',
					align: 'left'
				},
				{ 
					text: 'Phone',
					value: 'phone',
					align: 'left' 
				},
				],
				users: []
			}
		},
		methods: {
			getUsers() {
				var self = this
				axios.get(config.api_url + '/user', {
					headers: auth.getAuthHeader()
				})
				.then(function (response) {
					self.users = response.data
				})
				.catch(function (error) {

				});
			}
		},
		components: {
			'new-user-modal': createUserModal
		},
		mounted: function () {
			this.getUsers()
		}
	}
</script>

<style>
	.icon-background {
		padding: 2px;
		border-radius: 30px;
	}

	a {
		color: #575756;
		text-decoration: none;
	}

	a:active, a:hover {
		outline-width: 0;
		color: #383838;
	}	
	.unavailable-link a {
		color: #9e9e9e;
	}
	.unavailable-link a:active, a:hover {
		outline-width: 0;
		color: #383838;
	}

</style>