<template>
	<v-container fluid>
		<v-layout row>
			<v-flex sm2>
				<ul>
					<li class="headline text-sm-left">{{consumer.email}} </li>
					<li class="caption text-sm-left">{{ consumer.first_name}} {{consumer.last_name}}</li>
					<li class="caption text-sm-left">{{consumer.phone}}</li>
				</ul>
			</v-flex>
			<v-flex sm2>
				<ul>
					<li class="caption text-sm-left">{{ consumer.address}}</li>
					<li class="caption text-sm-left">{{consumer.zipcode}} {{consumer.city}}</li>
					<li class="caption text-sm-left">{{consumer.country}}</li>
				</ul>
			</v-flex>
			<v-flex sm2>
				<ul>
					<li class="caption text-sm-left">{{ consumer.company_name}}</li>
					<li class="caption text-sm-left">{{consumer.vat}}</li>
					<li><edit-consumer-modal :consumer="consumer"></edit-consumer-modal></li>
				</ul>
			</v-flex>
		</v-layout>
	</v-container>
</template>
<script>
import EditConsumerModal from './editConsumerModal.vue'

	export default {
		props: ['consumer'],
		data () {
			return {

			}
		},
		components: {
			'edit-consumer-modal': EditConsumerModal
		},
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