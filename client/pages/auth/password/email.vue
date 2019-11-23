<template>
	<div>
		<section class="section">
			<div class="container">

				<div class="row justify-content-center">
					<div class="col-lg-4">

						<h6><b>Request Reset Password Email</b></h6>
						<hr class="full-width-hr mb-4 mt-4">

						<form @submit.prevent="send" @keydown="form.onKeydown($event)">

							<div class="form-group">
								<input type="email" name="email" v-model="form.email" :class="{ 'is-invalid' : form.errors.has('email') }" class="form-control rounded" placeholder="Email Address">
								<has-error :form="form" field="email"></has-error>
							</div>

							<!-- <client-only>
								<vue-recaptcha sitekey="6LdL2MMUAAAAAGiVxrd_nF34cUozqfQ3TSs1QedU" :loadRecaptchaScript="true"></vue-recaptcha>
							</client-only> -->

							<v-button :loading="form.busy" class="btn-block btn-lg mt-2">
								{{$t('send_password_reset_link')}}
							</v-button>

							<h6 class="mt-3">If you're still having problem, please contact us by clicking <a href="#">here</a>.</h6>

						</form>

					</div>
				</div>

			</div>
		</section>
	</div>
</template>

<script>
	import Form from 'vform'
	import VueRecaptcha from 'vue-recaptcha'

	export default {

		components: {
			VueRecaptcha
		},

		middleware: 'guest',

		head () {
			return { title: this.$t('reset_password') }
		},

		data: () => ({
			status: '',
			form: new Form({
				email: ''
			})
		}),

		methods: {
			async send () {
				try {
					const { data } = await this.form.post('/password/email')
					this.status = data.status
					this.form.reset()
					this.$swal({
						toast: true,
						position: 'bottom-end',
						type: 'success',
						text: 'Password reset link is sent to your email',
						showConfirmButton: false,
						timer: 5000
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