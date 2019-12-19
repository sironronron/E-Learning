<template>
	<div class="row justify-content-center">
		<div class="col-lg-5">

			<h2>Password</h2>
			<h6>Secure your account, change password every month!</h6>

			<hr class="full-width-hr mb-4 mt-4">

			<form @submit.prevent="update" @keydown="form.onKeydown($event)">

				<alert-success :form="form" :message="$t('password_updated')"></alert-success>

				<!-- // Current Password -->
				<div class="form-group">
					<label for="current_password" class="col-form-label">Current Password</label>
					<input type="password" name="current_password" v-model="form.current_password" :class="{ 'is-invalid' : form.errors.has('current_password') }" class="form-control rounded">
					<has-error :form="form" field="current_password"></has-error>
				</div>

				<!-- // Password -->
				<div class="form-group">
					<label for="password" class="col-form-label">Password</label>
					<div>
						<!-- <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" type="password" name="password" class="form-control"> -->
						<has-error :form="form" field="password" />
						<client-only>
							<password-strength class="m-b-0"
								v-model="form.password"
								:strength-meter-only="false"
								:toggle="true"
								@feedback="showFeedback"
							/>
						</client-only>
						<p class="text-muted mb-0 suggestions-warns">
							<small>{{ suggs[0] }} {{ warns }}</small>
						</p>
					</div>
				</div>

				<!-- // Password Confirmation -->
				<div class="form-group">
					<label for="password_confirmation" class="col-form-label">Password Confirmation</label> 
					<input type="password" name="password_confirmation" v-model="form.password_confirmation" :class="{ 'is-invalid' : form.errors.has('password_confirmation') }" class="form-control rounded">
					<has-error :form="form" field="password_confirmation"></has-error>
				</div>

				<v-button :loading="form.busy" class="btn-lg btn-block mt-3">
					Update Password
				</v-button>

			</form>

		</div>
	</div>
</template>

<script>
	import Form from 'vform'
	import PasswordStrength from 'vue-password-strength-meter'

	export default {

		components: {
			PasswordStrength
		},

		scrollToTop: false,

		head() {
			return { title: 'Change Password' }
		},

		data: () => ({
			form: new Form({
				current_password: '',
				password: '',
				password_confirmation: ''
			}),
			warns: '',
			suggs: ''
		}),

		methods: {
			async update() {
				try {
					await this.form.patch('/settings/password')
					this.form.reset()
					this.$swal({
						type: 'success',
						text: this.$t('password_updated')
					})
				} catch (e) {
					return
				}
			},
			showFeedback({suggestions, warning}) {
				this.suggs = suggestions,
				this.warns = warning
			}
		}

	}
</script>

<style scoped>
	.Password {
		max-width: 490px !important;
	}
</style>