<template>
	<div>
		<div class="jumbotron bg-gradient-default mb-0 rounded-0 pb-0 pt-lg-5">
			<section>
				<div class="container">
					<div>
						<h2 class="text-white">Account Settings</h2>
						<ul class="list-unstyled pt-3">
							<li class="d-inline-block mr-4" v-for="tab in tabs" :key="tab.id">
								<router-link :to="{ name: tab.route }" class="page-header text-white">
									{{tab.name}}
								</router-link>
							</li>
						</ul>
					</div>
				</div>
			</section>
		</div>

		<!-- // Main Component -->
		<section class="section-sm">
			<div class="container">
				<transition name="fade" mode="out-in">
					<router-view></router-view>
				</transition>
			</div>
		</section>

	</div>
</template>

<script>
	import { mapGetters } from 'vuex'

	export default {

		middleware: 'auth',

		computed: {
			...mapGetters({
				user: 'auth/user'
			}),
			tabs () {
				return [
					{
						icon: 'user',
						name: 'Edit Profile',
						route: 'settings.account'
					},
					{
						icon: 'lock',
						name: this.$t('password'),
						route: 'settings.password'
					},
					{
						name: 'Avatar',
						route: 'settings.avatar'
					}
				]
			}
		}
	}
</script>

<style scoped>
	.jumbotron {
		padding-top: 2rem;
		padding-left: 2rem;
		padding-right: 2rem;
	}

	.page-header {
		padding: 0 0 5px;
		border-bottom: 6px solid hsla(0, 0%, 100%, 0);
		color: #fff;
		display: block;
	}

	.router-link-active {
		border-bottom: 5px solid red;
		cursor: text;
	}

	.page-header:hover {
		color: white;
		border-bottom: 5px solid red;
	}
</style>