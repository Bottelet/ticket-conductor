<template>
	<div id="example-3">
		<v-container fluid>
			<v-layout row>
				<v-flex xs2 class="profile-image">
					<img :src="user.image_path" />
				</v-flex>
				<v-flex xs10>
					<ul>
						<li class="headline">{{ user.first_name}} {{user.last_name}}</li>
						<li class="caption">{{user.email}}</li>
						<li class="caption">{{user.phone}}</li>
					</ul>
				</v-flex>
			</v-layout>
		</v-container>
	</div>
</template>
<script>
	export default {
		props: ['user'],
		data () {
			return {

			}
		}
	}
</script>

<style>
	li {
		list-style: none;
	}
	.profile-image img {
		height: 95%;
		width: 100%;
		border-radius: 50%;
	}
</style>