import Vue from 'vue'
import Profile from '../components/user/profile.vue'
import Statistics from '../components/layout/statistics.vue'
import Tickets from '../components/ticket/ticket.vue'
import ShowTicket from '../components/ticket/showTicket.vue'
import ShowConsumer from '../components/consumer/showConsumer.vue'
import Consumers from '../components/consumer/consumer.vue'
import Users from '../components/user/user.vue'
import Groups from '../components/group/group.vue'

export default [
{ 
	path: '/dashboard',
	component: Statistics, 
	name: 'dashboard'
},
{ 
	path: '/profile/:id',
	component: Profile,
	name: 'profile' 
},
{ 
	path: '/tickets',
	component: Tickets,
	name: 'tickets'
},
{
	path: '/ticket/:id',
	component: ShowTicket,
	name: 'showTicket'
},
{
	path: '/consumer/:id',
	component: ShowConsumer,
	name: 'showConsumer'
},
{
	path: '/consumers',
	component: Consumers,
	name: 'consumers'
},
{
	path: '/users',
	component: Users,
	name: 'users'
},
{
	path: '/groups',
	component: Groups,
	name: 'groups'
}
];