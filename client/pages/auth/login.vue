<template>
	<div>
		<section class="section">
			<div class="container">

				<div class="row justify-content-center">
					<div class="col-lg-4">

						<h6><b>Sign In and Start Learning!</b></h6>
						<hr class="full-width-hr mb-4 mt-4">

						<form @submit.prevent="login" @keydown="form.onKeydown($event)">

							<div class="form-group mb-3">
								<input type="email" name="email" v-model="form.email" :class="{ 'is-invalid' : form.errors.has('email') }" class="form-control rounded" placeholder="Email Address">
								<has-error :form="form" field="email"></has-error>
							</div>

							<div class="form-group mb-3">
								<input type="password" name="password" v-model="form.password" :class="{ 'is-invalid' : form.errors.has('password') }" class="form-control" placeholder="Password">
								<has-error :form="form" field="password"></has-error>
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
								<v-button :loading="form.busy" class="btn-block btn-lg">
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

						<h6 class="text-center mt-3">
							Don't have an account? <router-link :to="{ name: 'register' }">Register</router-link>
						</h6>

					</div>
				</div>

			</div>
		</section>
	</div>
</template>

<script>
	import Form from 'vform'
	import PasswordStrength from 'vue-password-strength-meter'

	export default {

		components: {
			PasswordStrength	
		},

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
				this.$swal({
					toast: true,
					position: 'bottom-end',
					timer: 5000,
					showConfirmButton: false,
					type: 'success',
					text: "Welcome to E-Learning!"
				})
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