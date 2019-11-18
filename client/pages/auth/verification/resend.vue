<template>
	<div>
		<div class="jumbotron py-5 bg-default rounded-0">
			<div class="container-lg">
				<h6 class="text-muted"><router-link :to="{ name: 'welcome' }" class="text-muted">Home</router-link> / Resend Email Verification</h6></h6>
				<h3 class="text-white mb-0">Email Verification</h3>
			</div>
		</div>


		<section class="section-sm">
			<div class="container">

				<div class="row justify-content-center">
					<div class="col-lg-7">

						<card class="p-3 shadow rounded">

							<div class="text-center">
								<h2 class="">Resend Email Verification Form</h2>
								<h6>Resend your e-mail verification link if you didn't receive one.</h6>
							</div>
							<hr>

							<div class="row justify-content-center">
								<div class="col-lg-8">

									<form @submit.prevent="send" @keydown="form.onKeydown($event)">

										<div class="form-group">
											<label for="email" class="col-form-label"><fa icon="envelope" fixed-width class="mr-2" />Email</label>
											<div>
												<input type="email" name="email" v-model="form.email" :class="{ 'is-invalid' : form.errors.has('email') }" class="form-control" placeholder="Email Address">
												<has-error :form="form" field="email"></has-error>
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

	export default {
		middleware: 'guest',

		head () {
			return { title: this.$t('verify_email') }
		},

		data: () => ({
			status: '',
			form: new Form({
				email: ''
			})
		}),

		created () {
			if (this.$route.query.email) {
				this.form.email = this.$route.query.email
			}
		},

		methods: {
			async send () {
				try {
					const { data } = await this.form.post('/email/resend')
					this.status = data.status
					this.form.reset()
					this.$swal({
						type: 'success',
						text: `${this.status}`
					})
				} catch (e) {
					return
				}
			}
		}
	}
</script>

<style>

</style>