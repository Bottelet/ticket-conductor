<template>
	<v-layout row wrap>
		<v-container fluid>
			<v-flex xs12 md6 offset-md3>
				<v-card>
					<v-toolbar class="indigo" dark>
						<v-toolbar-title>Login</v-toolbar-title>
					</v-toolbar>
					<v-card-text>
						<v-text-field
						label="Email"
						name="email"
						class="mt-5"
						v-model="credentials.email"
						></v-text-field>
						<p class="red--text caption">{{ errors.email }}</p>
						<v-text-field
						name="password"
						label="Enter your password"
						hint="At least 6 characters"
						min="6"
						type="password"
						v-model="credentials.password"
						></v-text-field>
						<p class="red--text caption">{{ errors.password }}</p>
						<div>
							<v-btn success dark v-on:click="postLogin">Login</v-btn>
						</div>
					</v-card-text>
				</v-card>
			</v-flex>
		</v-container>
	</v-layout>
</template>

<script>
	import axios from 'axios';
	import auth from '../auth/index.js'

	export default {
		data () {
			return {
				errors: {
					email: '',
					password: '',
				},
				credentials: {
					email: '',
					password: '',
				}
			}
		},
		methods: {
			postLogin : function() {
				if (this.credentials.email == "") {
					this.errors.email = "Email is required"
				} else  {
					this.errors.email = ""
				}
				if (this.credentials.password == "") {
					this.errors.password = "Password is required"
				} else  {
					this.errors.password = ""
				}
				if (this.credentials.email == "" || this.credentials.password == "") {
					return false
				}
				var credentials = {
					email: this.credentials.email,
					password: this.credentials.password,
				}
				auth.login(this, credentials, '/foo')
			}
		}
	}
</script>

<style>
	.message {
		color: blue;
	}
	.input-group__details:before {
		background-color: rgba(0,0,0,.12);
	}
</style>