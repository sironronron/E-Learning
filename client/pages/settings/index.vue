<template>
	<div>
		<section class="section-profile-cover section-shaped my-0">
			<div class="shape shape-style-1 shape-primary shape-skew alpha-4">
			</div>
		</section>
		<section class="section section-skew">
			<div class="container">
				<div class="card card-profile mt--500 shadow rounded"><!----><!---->
					<div class="p-5">
						<div class="row">
							<div class="col-lg-2 border-right">
								<h5><b>Account Settings</b></h5>
								<ul class="list-unstyled mt-3">
									<li class="mt-2" v-for="tab in tabs" :key="tab.id">
										<router-link :to="{ name: tab.route }" class="text-dark">{{tab.name}}</router-link>
									</li>
								</ul>
							</div>
							<div class="col-lg-9 ml-lg-4">
								<transition name="fade" mode="out-in">
									<router-view />
								</transition>
							</div>
						</div>
					</div>
				</div>
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
						name: this.$t('account'),
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
	.settings-card .card-body {
		padding: 0;
	}
	.mt--500 {
		margin-top: -500px !important;
	}
</style>
