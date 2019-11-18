<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm" style="border-top: solid 5px #bc4e9c">
		<div class="container">
			<router-link :to="{ name: 'help-center.index' }" class="navbar-brand">
				<img src="https://res.cloudinary.com/dl9phqhv0/image/upload/c_scale,w_150/v1573175311/Logos/logo-dark_uaqwbf.png" alt="E-Learning" class="m-t-5 img-fluid" />
			</router-link>

			<button :aria-label="$t('toggle_navigation')" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false">
				<fa icon="bars" fixed-width />
			</button>

			<div id="navbarToggler" class="collapse navbar-collapse">

				<ul class="navbar-nav ml-auto navbar-nav-hover">
					<li class="nav-item border-right">
						<router-link :to="{ name: 'welcome' }" class="nav-link">
							Go Home
						</router-link>
					</li>
					<template v-if="user">
						<!-- Authenticated -->
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle"
							href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
							>
								<img :src="user.photo_url" class="rounded-circle profile-photo mr-1">
								{{user.name}}
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<router-link :to="{ name: 'settings.account' }" class="dropdown-item dropdown-item-2">
									Account
								</router-link>
								<a class="dropdown-item pl-3 dropdown-item-2" href="#" @click.prevent="logout">
									{{ $t('logout') }}
								</a>
							</div>
						</li>
					</template>
					<!-- Guest -->
					<template v-else>
						<li class="nav-item">
							<router-link :to="{ name: 'login' }" class="nav-link" active-class="active">
								{{ $t('login') }}
							</router-link>
						</li>
						<li class="nav-item">
							<router-link :to="{ name: 'register' }" class="btn btn-default text-capitalize text-white" active-class="active">
								{{ $t('register') }}
							</router-link>
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
        component: {
            LocaleDropdown
        },

        data: () => ({
			appName: process.env.appName
        }),
        
        computed: mapGetters({
            user: 'auth/user'
        }),

        methods: {
            async logout() {
                // logout user
                await this.$store.dispatch('auth/logout')
                // Redirect
                this.$router.push({ name: 'welcome' })
            }
        }

    }
</script>

<style scoped>
	@media (min-width: 1200px) { 
		.container {
			max-width: 1024px !important;
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
	.navbar-brand img {
		height: 40px;
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
		background: whitesmoke;
	}
</style>