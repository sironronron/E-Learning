<template>
	<div>
		<div >
			<h4>My Profile</h4>
			<p class="text-muted text-small">Add information about yourself to share on your profile.</p>
		</div>

		<hr style="border-top: 2px solid rgba(0, 0, 0, 0.1)">

		<form @submit.prevent="update" @keydown="form.onKeydown($event)">

			<alert-success :form="form" :message="$t('info_updated')" />

			<div v-if="user.role_id == 3" class="alert alert-danger">
				<h6 class="mb-0 text-white">Please complete your profile information, it will be displayed on your instructor page.</h6>
			</div>


			<h5 class="mb-4"><b>Basic Information</b></h5>

			<div class="row justify-content-center">
				<div class="col-lg-7">

					<div class="form-group mb-3">
						<label for="name" class="col-form-label">Name</label>
						<div>
							<input type="text" name="name" v-model="form.name" :class="{ 'is-invalid' : form.errors.has('name') }" class="form-control">
							<has-error :form="form" field="name"></has-error>
						</div>
					</div>

					<div class="form-group mb-3">
						<label for="name" class="col-form-label">Email</label>
						<div>
							<input type="email" name="email" v-model="form.email" :class="{ 'is-invalid' : form.errors.has('email') }" class="form-control" disabled>
							<has-error :form="form" field="email"></has-error>
						</div>
					</div>

					<div class="form-group mb-5">
						<label for="name" class="col-form-label">Biography</label>
						<div>
							<textarea name="biography" id="" cols="30" rows="5" v-model="form.biography" :class="{ 'is-invalid' : form.errors.has('biography') }" class="form-control"></textarea>
							<has-error :form="form" field="biography"></has-error>
						</div>
					</div>

				</div>
			</div>

			<h5 class="mb-4"><b>Social Media Links</b></h5>

			<div class="row justify-content-center">
				<div class="col-lg-7">
					<div class="form-group mb-3">
						<label for="facebook" class="col-form-label">Facebook Link</label>
						<div>
							<input type="text" v-model="form.facebook_link" :class="{ 'is-invalid' : form.errors.has('facebook_link') }" class="form-control">
							<has-error :form="form" field="facebook_link"></has-error>
						</div>
					</div>

					<div class="form-group mb-3">
						<label for="facebook" class="col-form-label">Twitter Link</label>
						<div>
							<input type="text" v-model="form.twitter_link" :class="{ 'is-invalid' : form.errors.has('twitter_link') }" class="form-control">
							<has-error :form="form" field="twitter_link"></has-error>
						</div>
					</div>

					<div class="form-group mb-3">
						<label for="facebook" class="col-form-label">Youtube Link</label>
						<div>
							<input type="text" v-model="form.youtube_link" :class="{ 'is-invalid' : form.errors.has('youtube_link') }" class="form-control">
							<has-error :form="form" field="youtube_link"></has-error>
						</div>
					</div>
				</div>
			</div>

			<hr style="border-top: 2px solid rgba(0, 0, 0, 0.1)">

			<div class="form-group row justify-content-center">
				<div class="col-lg-7">
					<v-button :loading="form.busy" class="btn-block">
						Update Profile
					</v-button>
				</div>
			</div>

		</form>
	</div>
</template>

<script>
	import Form from 'vform'
	import { mapGetters } from 'vuex'

	export default {
		scrollToTop: false,

		head () {
			return { title: this.$t('settings') }
		},

		data: () => ({
			form: new Form({
				name: '',
				email: '',
				biography: '',
				facebook_link: '',
				twitter_link: '',
				youtube_link: ''
			})
		}),

		computed: mapGetters({
			user: 'auth/user'
		}),

		created () {
			// Fill the form with user data.
			this.form.keys().forEach((key) => {
				this.form[key] = this.user[key]
			})
		},

		methods: {
			async update () {
				try {
					const { data } = await this.form.patch('/settings/profile')
					this.$store.dispatch('auth/updateUser', { user: data })
					this.$swal({
						toast: true,
						position: 'bottom-end',
						timer: 5000,
						showConfirmButton: false,
						type: 'success',
						text: this.$t('info_updated')
					})
				} catch (e) {
					return
				}
			}
		}
	}
</script>
