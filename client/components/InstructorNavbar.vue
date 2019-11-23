<template>
	<nav class="navbar navbar-expand-lg navbar-light bg-gradient-default shadow-sm" style="height: 80px;">
		<div class="container">
			<router-link :to="{ name: 'instructor.courses' }" class="navbar-brand">
				<img src="https://res.cloudinary.com/dl9phqhv0/image/upload/c_scale,w_172/v1574062722/Logos/logo-light_gwp73l.png" alt="E-Learning" class="m-t-5 img-fluid" />
			</router-link>

			<button :aria-label="$t('toggle_navigation')" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false">
				<fa icon="bars" fixed-width />
			</button>

			<div id="navbarToggler" class="collapse navbar-collapse">
				<ul class="navbar-nav navbar-nav-hover">
					<li class="nav-item">
						<span class="text-white">Instructor Panel</span>
					</li>
				</ul>

				<ul class="navbar-nav ml-auto navbar-nav-hover">
					<template v-if="user">
						<li class="nav-item dropdown">
							<a href="#" class="nav-link" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<fa :icon="['far', 'envelope']" class="h5 mb-0 text-white" fixed-width />
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<div class="p-3 text-center">
									<h6 class="mb-0">You don't have any new messages.</h6>
								</div>
							</div>
						</li>
						<li class="nav-item dropdown">
							<a href="#" class="nav-link" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<fa icon="bell" class="h5 mb-0 text-white" fixed-width />
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<div class="p-3 text-center">
									<h6 class="mb-0">You don't have any new notifications.</h6>
								</div>
							</div>
						</li>
						<li class="nav-item dropdown border-right">
							<a class="nav-link"
							href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
							>
								<img :src="user.photo_url" class="rounded-circle profile-photo mr-1">
								<span class="text-white">{{user.name}}</span>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<div>
									<a href="#" class="dropdown-item mb-2 dropdown-item-2">
										<div class="row">
											<div class="col-lg-2">
												<img :src="user.photo_url" class="profile-photo-2 rounded-circle" :alt="user.name">
											</div>
											<div class="col-lg-10">
												<div class="ml-2 mt-1">
													<h6 class="font-weight-600 mb-0">{{user.name}}</h6>
													<h6 class="text-muted">{{user.email}}</h6>
												</div>
											</div>
										</div>
									</a>
									<router-link :to="{ name: 'home' }" class="dropdown-item dropdown-item-2">
										Go to home
									</router-link>
									<router-link :to="{ name: 'settings.account' }" class="dropdown-item dropdown-item-2">
										Account
									</router-link>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item pl-3 dropdown-item-2" href="#" @click.prevent="logout">
										{{ $t('logout') }}
									</a>
								</div>
							</div>
						</li>
						<li class="nav-item">
							<span class="nav-link text-white">
								Follow Us
								<a href="#" class="text-white" target="_blank"><fa :icon="['fab', 'facebook-square']" fixed-width /></a>
								<a href="#" class="text-white" target="_blank"><fa :icon="['fab', 'instagram']" fixed-width /></a>
								<a href="#" class="text-white" target="_blank"><fa :icon="['fab', 'twitter-square']" fixed-width /></a>
							</span>
						</li>
					</template>
				</ul>
			</div>
		</div>
	</nav>
</template>

<script>
	import { mapGetters } from 'vuex'
	import LocaleDropdown from './LocaleDropdown'

	export default {
		components: {
			LocaleDropdown
		},

		data: () => ({
			appName: process.env.appName
		}),
		
		computed: {
			...mapGetters({
				user: 'auth/user'
			}),
			tabs () {
				return [
					{
						icon: 'desktop',
						name: 'Web Design'
					},
					{
						icon: 'pencil-alt',
						name: 'Graphic Design'
					},
					{
						icon: 'male',
						name: 'User Experience'
					},
					{
						icon: 'magic',
						name: 'Interior Design'
					},
					{
						icon: 'cube',
						name: '3D and Animation'
					},
					{
						icon: 'user-secret',
						name: 'Fashion'
					},
					{
						icon: ['fab', 'css3-alt'],
						name: 'Front-end Development'
					},
				]
			}
		},

		methods: {
			async logout () {
				// Log out the user.
				await this.$store.dispatch('auth/logout')
				// Redirect to login.
				this.$router.push({ name: 'logout' })
			}
		}
	}
</script>

<style scoped>
	@media(min-width: 1200px) {
		.container {
			max-width: 100% !important;
		}
	}
	.profile-photo {
		width: 2rem;
		height: 2rem;
		margin: -.375rem 0;
	}
	.profile-photo-2 {
		width: 46px;
		height: 46px;
	}
	.container {
		width: 100% !important;
	}
	.navbar-brand img {
		height: 35px;
	}
	.form-group {
		margin-bottom: 0.5rem !important;
	}
	.form-control {
		transition: ease-in;
		background: whitesmoke;
	}
	.form-control:active {
		background: #fff;
	}
	.form-control:focus {
		border: solid 1px;
		background: #fff;
	}
	.navbar-collapse.collapsing, .navbar-collapse.show {
		margin-top: 70px;
	}
	.nav-link {
		font-size: small;
		padding: 12px 15px;
		font-weight: 400;
	}
	.nav-link:hover {
		background: gray;
	}
	.w-47 {
		width: 45% !important;
	}
	.dropdown-menu {
		width: 330px !important;
	}
	.dropdown-item-2 {
		font-size: 0.888rem !important;
	}
</style>
