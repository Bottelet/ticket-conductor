<template>
	<v-card>
		<v-card-title>
			Groups <new-group-modal></new-group-modal>
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
		v-bind:items="groups"
		v-bind:search="search"
		>
		<template slot="items" scope="props">
			<td class="text-xs-left">
				{{ props.item.name}}
			</td>
			
			<td class="text-xs-left" v-if="props.item.description != null">{{ props.item.description}}</td>
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
	import createGroupModal from './createGroupModal.vue'

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
					text: 'Description', 
					value: 'description',
					align: 'left'
				},
				],
				groups: []
			}
		},
		methods: {
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
		components: {
			'new-group-modal': createGroupModal
		},
		mounted: function () {
			this.getGroups()
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