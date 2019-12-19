<template>
    <div>
		<client-only>
			<offline-alert/>
		</client-only>

		<h2 class="mb-0 m-t-8 font-weight-400"><img src="https://res.cloudinary.com/dl9phqhv0/image/upload/c_scale,h_60/v1576466807/Online%20Learning%20Icon%20Pack/036-setting_quvvlb.svg" style="width: 60px; height: 60px;" alt=""> &nbsp; Account settings</h2>

       	<ul class="nav mt-4">
			<li class="nav-item" v-for="tab in tabs" :key="tab.id">
				<h5><router-link :to="{name: tab.route}" class="nav-link" href="#">{{tab.name}}</router-link></h5>
			</li>
		</ul>

		<div class="mt-4">
			<transition name="fade" mode="out-in">
			    <router-view />
			</transition>
		</div>

    </div>
</template>

<script>
    import Form from 'vform'
    import { mapGetters } from 'vuex'

    export default {
        scrollToTop: true,

        head() {
            return { title: this.$t('settings') }
        },

        data: () => ({
			form: new Form({
				name: '',
				email: '',
				biography: '',
				facebook_link: '',
				twitter_link: '',
				youtube_link: '',
				introduction: ''
			})
		}),

		computed: {
			...mapGetters({
				user: 'auth/user'
			}),
			tabs () {
				return [
					{
						icon: 'user',
						name: 'Account Security',
						route: 'instructor.settings.account'
					},
					{
						icon: 'lock',
						name: this.$t('password'),
						route: 'instructor.settings.password'
					},
					{
						name: 'Profile Information',
						route: 'instructor.settings.profile'
					},
					{
						name: 'Avatar',
						route: 'instructor.settings.avatar'
					}
				]
			}
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

<style style="scss" scoped>
	.nav-link {
		padding: 0.25rem 0 !important;
		margin-right: 2rem;
	}
	
	.router-link-active {
		border-bottom: 5px solid red;
		cursor: text;
	}

	.nav-link:hover {
		color: red;
		border-bottom: 5px solid red;
	}
</style>