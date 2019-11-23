<template>
	<div>
		<section class="section">
			<div class="container">

				<div class="row justify-content-center">
					<div class="col-lg-4">

						<h6><b>Resend Email Verification</b></h6>
						<hr class="full-width-hr mb-4 mt-4">

						<form @submit.prevent="send" @keydown="form.onKeydown($event)">

							<div class="form-group">
								<div>
									<input type="email" name="email" v-model="form.email" :class="{ 'is-invalid' : form.errors.has('email') }" class="form-control" placeholder="Email Address">
									<has-error :form="form" field="email"></has-error>
								</div>
							</div>

							<v-button :loading="form.busy" class="btn-block btn-lg">
								{{$t('send_verification_link')}}
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