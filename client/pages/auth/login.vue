<template>
	<div>
		<div class="jumbotron py-5 bg-default rounded-0">
			<div class="container-lg">
				<h6 class="text-muted"><router-link :to="{ name: 'welcome' }" class="text-muted">Home</router-link> / Login</h6>
				<h3 class="text-white mb-0">Login Existing Account</h3>
			</div>
		</div>
		<!-- // Login Form -->
		<section class="section-sm">
			<div class="container">
				<div class="row justify-content-center">
				<div class="col-lg-7">
					<card class="p-3 shadow rounded border">
					<div class="text-center">
						<h2 class="">Login Form</h2>
						<h6>Provide your login credentials</h6>
					</div>
					<hr>
					<div class="row justify-content-center">
						<div class="col-lg-8">
							<form @submit.prevent="login" @keydown="form.onKeydown($event)">

								<!-- //email  -->
								<div class="form-group mb-4">
									<label for="name" class="col-form-label">Email</label>
									<div>
										<input type="text" name="email" v-model="form.email" :class="{ 'is-invalid' : form.errors.has('email') }" class="form-control" placeholder="Email Address">
										<has-error :form="form" field="email"></has-error>
									</div>
								</div>

								<!-- //email  -->
								<div class="form-group mb-4">
									<label for="Password" class="col-form-label">Password</label>
									<div>
										<input type="password" name="password" v-model="form.password" :class="{ 'is-invalid' : form.errors.has('password') }" class="form-control" placeholder="Password">
										<has-error :form="form" field="password"></has-error>
									</div>
								</div>

								<div class="form-group row">
									<div class="col-lg-6">
										<checkbox v-model="remember" name="remember">
										{{ $t('remember_me') }}
										</checkbox>
									</div>
									<div class="col-lg-6">
										<h6 class="float-right">
										<router-link :to="{ name: 'password.request' }" class="ml-auto my-auto text-default">
											{{ $t('forgot_password') }}
										</router-link>
										</h6>
									</div>
								</div>
								
								<div class="text-center">
									<v-button :loading="form.busy" class="btn-block">
										{{ $t('login') }}
									</v-button>
								</div>

								<div class="text-center mt-4">
									<h6>Login With</h6>
									<div class="row mt-4">
										<div class="col-lg">
											<login-with-facebook class="btn-block"></login-with-facebook>
										</div>
										<div class="col-lg">
											<login-with-google class="btn-block"></login-with-google>
										</div>
									</div>
								</div>

							</form>


							<h6 class="text-center mt-5">
								Don't have an account? <router-link :to="{ name: 'register' }">Register</router-link>
							</h6>

							</div>
						</div>
					</card>
				</div>
			</div>
		</div>
		</section>
	</div>
</template>

<script>
	import Form from 'vform'

	export default {

		middleware: 'guest',

		head () {
			return { title: this.$t('login') }
		},

		data: () => ({
			form: new Form({
			email: '',
			password: ''
			}),
			remember: false
		}),

		methods: {
			async login () {

			let data

			// Submit the form.
			try {
				const response = await this.form.post('/login')
				data = response.data
			} catch (e) {
				return
			}

			// Save the token.
			this.$store.dispatch('auth/saveToken', {
				token: data.token,
				remember: this.remember
			})

			// Fetch the user.
			await this.$store.dispatch('auth/fetchUser')

			// Redirect home.
			this.$router.push({ name: 'home' })
			}
		}
	}
</script>

<style>

</style>