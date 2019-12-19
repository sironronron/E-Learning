<template>
	<div>
		<div class="row justify-content-center">
			<div class="col-lg-5">

				<h2>Profile</h2>
				<h6>Add Information about yourself to share on your profile.</h6>

				<hr class="full-width-hr mb-4 mt-4">

				<form @submit.prevent="update" @keydown="form.onKeydown($event)">

					<alert-success :form="form" message="Your Profile Information is Changed"></alert-success>

					<!-- // Name  -->
					<div class="form-group">
						<label for="name" class="col-form-label">Name</label>
						<input type="text" name="name" v-model="form.name" :class="{ 'is-invalid' : form.errors.has('name') }" class="form-control rounded">
						<has-error :form="form" field="name"></has-error>
					</div>

					<!-- // Email -->
					<template v-if="!editEmail">
						<div class="form-group">
							<label for="email" class="col-form-label">Email</label>
							<input type="email" name="email" v-model="form.email" disabled class="form-control rounded">
							<a href="#" @click.prevent="editEmail = true" class="small"><fa :icon="['far', 'edit']" fixed-width /> Edit</a>
						</div>
					</template>

					<template v-else>
						
						<div class="p-lg-3 border">
							
							<form @submit.prevent="updateEmai" @keydown="form.onKeydown($event)">
								<!-- // Change Email -->
								<div class="form-group">
									<label for="email" class="col-form-label">Email</label>
									<input type="email" name="email" v-model="form.email" :class="{ 'is-invalid' : form.errors.has('email') }" class="form-control rounded">
									<has-error :form="form" field="email"></has-error>
								</div>

								<!-- // Confirm Password -->
								<div class="form-group">
									<label for="current_password" class="col-form-label">Current Password</label>
									<input type="password" name="current_password" v-model="form.current_password" :class="{ 'is-invalid' : form.errors.has('current_password') }" class="form-control rounded">
									<has-error :form="form" field="current_password"></has-error>
								</div>

								<a href="#" @click.prevent="editEmail = false" class="small"><fa :icon="['far', 'edit']" fixed-width /> Cancel</a>
								
								<v-button :loading="form.busy" class="btn-sm float-right">
									Submit
								</v-button>

							</form>
							
						</div>

					</template>


					<!-- // Biography -->
					<div class="form-group">
						<label for="biography" class="col-form-label">Biography</label>
						<div>
                            <client-only>
                                <froala id="edit" name="biography" :tag="'textarea'" :class="{ 'is-invalid' : form.errors.has('biography') }" v-model="form.biography"></froala>
                                <has-error :form="form" field="biography"></has-error>
                            </client-only>
                        </div>
					</div>

					<!-- // Social Media Links -->
					<div class="form-group">
						<label for="facebook_link" class="col-form-label">Facebook Link</label>
						<input type="text" name="facebook_link" v-model="form.facebook_link" :class="{ 'is-invalid' : form.errors.has('facebook_link') }" class="form-control rounded">
						<has-error :form="form" field="facebook_link"></has-error>
					</div>

					<div class="form-group">
						<label for="twitter_link" class="col-form-label">Twitter Link</label>
						<input type="text" name="twitter_link" v-model="form.twitter_link" :class="{ 'is-invalid' : form.errors.has('twitter_link') }" class="form-control rounded">
						<has-error :form="form" field="twitter_link"></has-error>
					</div>

					<div class="form-group">
						<label for="youtube_link" class="col-form-label">Youtube Link</label>
						<input type="text" name="youtube_link" v-model="form.youtube_link" :class="{ 'is-invalid' : form.errors.has('youtube_link') }" class="form-control rounded">
						<has-error :form="form" field="youtube_link"></has-error>
					</div>

					<v-button :loading="form.busy" class="btn-lg btn-block">
						Update Profile Info
					</v-button>
	
				</form>

			</div>
		</div>
	</div>
</template>

<script>
	import Form from 'vform'
	import { mapGetters } from 'vuex'

	export default {

		middleware: 'auth',

		scrollToTop: false,

		head() {
			return { title: this.$t('settings') }
		},

		data: () => ({
			form: new Form({
				name: '',
				email: '',
				current_password: '',
				biography: '',
				phone: '',
				birthday: '',
				facebook_link: '',
				twitter_link: '',
				youtube_link: '',
				introduction: ''
			}),
			editEmail: false
		}),

		computed: mapGetters({
			user: 'auth/user'
		}),

		created() {
			this.form.keys().forEach((key) => {
				this.form[key] = this.user[key]
			})
		},

		methods: {
			async update() {
				try { 
					const { data } = await this.form.patch('/settings/profile')
					this.$store.dispatch('auth/updateUser', {
						user: data
					})

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
			},

			async updateEmai() {
				try {
					const { data } = await this.form.patch('/instructor/settings/email')
					this.$store.dispatch('auth/updateUser', {
						user: data
					})
					this.editEmail = false
					this.$swal({
						toast: true,
						position: 'bottom-end',
						timer: 5000,
						showConfirmButton: false,
						type: 'success',
						text: 'Email Updated'
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