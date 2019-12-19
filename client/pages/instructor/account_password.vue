<template>
	<div class="row justify-content-center">
		<div class="col-lg-4">
			<div>
				<form @submit.prevent="update" @keydown="form.onKeydown($event)">

					<div class="form-group">
						<label for="curretn_password" class="col-form-label">Current Password: </label>
						<input type="text" name="current_password" v-model="form.current_password" :class="{ 'is-invalid' : form.errors.has('current_password') }" class="form-control rounded" placeholder="Current Password">
						<has-error :form="form" field="current_password" />
					</div>

					<!-- Password -->
					<div class="form-group">
						<label class="col-form-label">{{ $t('new_password') }}:</label>
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

					<!-- Password Confirmation -->
					<div class="form-group">
						<label class="col-form-label">{{ $t('confirm_password') }}</label>
						<div>
							<input v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" type="password" name="password_confirmation" class="form-control">
							<has-error :form="form" field="password_confirmation" />
						</div>
					</div>

					<div class="form-group">
						<div>
							<v-button :loading="form.busy" class="btn-sm float-right">
								Update Password
							</v-button>
						</div>
					</div>

				</form>
			</div>
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

		head () {
			return { title: this.$t('settings') }
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
			async update () {
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
			showFeedback ({suggestions, warning}) {
				this.suggs = suggestions
				this.warns = warning
			},
		}
	}
</script>


<style scoped>
	.Password {
		max-width: 466px !important;
	}
</style>
