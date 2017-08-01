<template>
	<v-app id="example-2" standalone>
		<v-navigation-drawer permanent light :mini-variant.sync="mini" v-model="drawer" overflow>
			<v-toolbar flat class="transparent">
				<v-list class="pa-0">
					<v-list-tile avatar tag="div">
						<v-list-tile-avatar>
							<img :src="user.image_path" />
						</v-list-tile-avatar>
						<v-list-tile-content>
							<v-list-tile-title>{{ user.first_name }} {{ user.last_name }} </v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
				</v-list>
			</v-toolbar>
			<v-list class="pt-0" dense>
				<v-divider></v-divider>

				<v-list-tile v-for="item in items" :key="item.title" router :to="item.link">
					<v-list-tile-action>
						<v-icon >{{ item.icon }}</v-icon>
					</v-list-tile-action>
					<v-list-tile-content>
						<v-list-tile-title >{{ item.title }}</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-list-tile>
					<v-list-tile-action v-on:click="logout">
						<v-icon >exit_to_app</v-icon>
					</v-list-tile-action>
					<v-list-tile-content>
						<v-list-tile-title>Logout</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
			</v-list>
		</v-navigation-drawer>
		<v-toolbar fixed class="indigo darken-4" dark>
			<v-toolbar-side-icon @click.native.stop="mini = !mini"></v-toolbar-side-icon>
			<v-toolbar-title>Ticket-conductor</v-toolbar-title>
		</v-toolbar>
		<main>
			<v-container fluid>
				<router-view></router-view>
			</v-container>
			<flash-message v-if="flashMessage.show" ></flash-message>
		</main>
	</v-app>

</template>

<script>
	import auth from '../auth/index.js'
	import snackbar from './layout/misc/snackbar.vue'
	
	export default {
		data () {
			return {
				drawer: true,
				user_id: null,
				items: [
				{ title: 'Dashboard', icon: 'dashboard', link: '/dashboard' },
				//TODO: Make not static, somehow provide the id in the link with VueX getter (User)
				{ title: 'Profile', icon: 'face', link: '/profile/1'},
				{ title: 'Tickets', icon: 'loyalty', link: '/tickets' },
				{ title: 'Consumers', icon: 'accessibility', link: '/consumers' },
				{ title: 'Users', icon: 'tag_faces', link: '/users' },
				{ title: 'Groups', icon: 'supervisor_account', link: '/groups' },
				//Logout had to be done static
				],
				mini: true,
				right: null,
			}
		},
		methods: {
			logout() {
				auth.logout("/")
			}
		},
		computed: {
			user () {
				return this.$store.getters.getUser
			},
			flashMessage () {
				return this.$store.getters.getFlashMessage
			}

		},
		components: {
			'flash-message': snackbar
		},
		mounted () {
		}
	}
</script>

<style>
	
</style>