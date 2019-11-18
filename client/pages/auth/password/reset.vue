<template>
	<div>
		<div class="jumbotron py-5 bg-default rounded-0">
			<div class="container-lg">
				<h6 class="text-muted"><router-link :to="{ name: 'welcome' }" class="text-muted">Home</router-link> / Reset Password</h6></h6>
				<h3 class="text-white mb-0">Change Account Password</h3>
			</div>
		</div>
		
		<section class="section-sm">
			<div class="container">

				<div class="row justify-content-center">
					<div class="col-lg-7">

						<card class="p-3 shadow rounded">
							<div class="text-center">
								<h2 class="">Change Password Form</h2>
								<h6>Secure your account, please don't use a basic password.</h6>
							</div>
							<hr>

							<div class="row justify-content-center">
								<div class="col-lg-8">
									<form @submit.prevent="reset" @keydown="form.onKeydown($event)">

										<div class="form-group">
											<label for="email" class="col-form-label">Email</label>
											<div>
												<input type="email" name="email" v-model="form.email" :class="{ 'is-invalid' : form.errors.has('email') }" class="form-control" placeholder="Email Address" disabled>
												<has-error :form="form" field="email"></has-error>
											</div>
										</div>

										<div class="form-group">
											<label for="password" class="col-form-label">Password</label>
											<div>
												<input type="password" name="password" v-model="form.password" :class="{ 'is-invalid' : form.errors.has('password') }" class="form-control" placeholder="New Password">
												<has-error :form="form" field="password"></has-error>
												<client-only>
													<password-strength class="m-b-0"
														v-model="form.password" 
														:strength-meter-only="true"
														:toggle="true"
														@feedback="showFeedback"
													/>
												</client-only>
												<p class="text-muted mb-0 suggestions-warns">
													<small>{{ suggs[0] }} {{ warns }}</small>
												</p>
											</div>
										</div>

										<div class="form-group">
											<label for="password" class="col-form-label">Confirm Password</label>
											<div>
												<input type="password" name="password_confirmation" v-model="form.password_confirmation" :class="{ 'is-invalid' : form.errors.has('password_confirmation') }" class="form-control" placeholder="Confirm Password">
												<has-error :form="form" field="password_confirmation"></has-error>
											</div>
										</div>

										<v-button :loading="form.busy" class="btn-block">
											{{$t('send_password_reset_link')}}
										</v-button>

									</form>

									<h6 class="mt-4">If you're still having problem, please contact us by clicking <a href="#">here</a>.</h6>

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
