<template>
	<div>
		<section class="section">
			<div class="container">

				<div class="row justify-content-center">
					<div class="col-lg-4">

						<h6><b>Change Password. Secure your Account</b></h6>
						<hr class="full-width-hr mb-4 mt-4">

						<form @submit.prevent="reset" @keydown="form.onKeydown($event)">

							<div class="form-group mb-3">
								<input type="email" name="email" v-model="form.email" :class="{ 'is-invalid' : form.errors.has('email') }" class="form-control rounded" placeholder="Email Address" disabled>
								<has-error :form="form" field="email"></has-error>
							</div>

							<div class="form-group mb-3">
								<client-only>
									<password-strength class="m-b-0"
										v-model="form.password" 
										:strength-meter-only="false"
										:toggle="true"
										name="password"
									/>
								</client-only>
								<has-error :form="form" field="password"></has-error>
							</div>

							<div class="form-group mb-3">
								<input type="password" name="password_confimration" v-model="form.password_confirmation" :class="{ 'is-invalid' : form.errors.has('password_confirmation') }" class="form-control rounded" placeholder="Password Confirmation">
								<has-error :form="form" field="password_confirmation"></has-error>
							</div>
								
							<div class="text-center">
								<v-button :loading="form.busy" class="btn-block btn-lg">
									{{ $t('reset_password') }}
								</v-button>
							</div>

						</form>

						<h6 class="text-center mt-3">
							Don't have an account? <router-link :to="{ name: 'register' }">Register</router-link>
						</h6>

						<hr class="full-width-hr my-3">

						<h6 class="mt-4">If you're still having problem, please contact us by clicking <a href="#">here</a>.</h6>

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

		middleware: 'guest',

		components: {
			PasswordStrength
		},

		head () {
			return { title: this.$t('reset_password') }
		},

		data: () => ({
			status: '',
			form: new Form({
				token: '',
				email: '',
				password: '',
				password_confirmation: ''
			}),
			warns: '',
			suggs: ''
		}),

		created () {
			this.form.email = this.$route.query.email
			this.form.token = this.$route.params.token
		},

		methods: {
			async reset () {
				try {
					const { data } = await this.form.post('/password/reset')
					this.status = data.status
					this.form.reset()
					this.$swal({
						toast: true,
						position: 'bottom-end',
						type: 'success',
						text: this.status,
						showConfirmButton: false,
						timer: 5000
					})
					.then((res) => {
						this.$route.push('/login')
					})
				} catch (e) {
					return
				}
			},
			showFeedback ({suggestions, warning}) {
				this.suggs = suggestions
				this.warns = warning
			},
		}
	}
</script>
