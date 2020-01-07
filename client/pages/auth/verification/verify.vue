<template>
	<div>
		<div class="jumbotron py-5 bg-default rounded-0">
			<div class="container-lg">
				<h6 class="text-muted"><router-link :to="{ name: 'welcome' }" class="text-muted">Home</router-link> / Email Verification</h6></h6>
				<h3 class="text-white mb-0">{{status}}</h3>
			</div>
		</div>

		<section class="section-sm">
			<div class="container">
				<div class="row justify-content-center text-center">
					<div class="col-lg-8 mb-5 mb-lg-0">
						<template v-if="success">
							<h1 class="text-center">{{ status }}!</h1>
							<div class="text-center mt-5 mb-5">
								<svg width="120" height="120"
									xmlns="http://www.w3.org/2000/svg">
									<image xlink:href="https://res.cloudinary.com/http-book-keeping-com/image/upload/c_scale,h_120,q_40/v1572840179/Icon/email.svg" height="120" width="120"/>
								</svg>
							</div>
							<p class="lead mt-4">
								Welcome to E-Learning! To learn how to use our service please click <router-link :to="{ name: 'help-center.student.category', params: 'getting-started' }">here</router-link>.
								If you have any questions you can contact us or go to our <router-link :to="{ name:'help-center.students' }">Help Center</router-link>.
							</p>
							<router-link :to="{ name: 'login' }" class="btn btn-white mt-4">
								Go to Log in Page
							</router-link>
						</template>
						<template v-else>
							<h1 class="font-weight-light">
								{{ status || $t('failed_to_verify_email') }}
							</h1>
							<div class="text-center mt-5 mb-5">
								<svg width="120" height="120"
									xmlns="http://www.w3.org/2000/svg">
									<image xlink:href="https://res.cloudinary.com/http-book-keeping-com/image/upload/c_scale,h_120,q_20/v1572839996/Icon/mailfailed_qwqpzm.svg" height="120" width="120"/>
								</svg>
							</div>
							<p class="lead mt-4">
								<span v-if="status == 'The email is already verified.'">
									Your e-mail is already verified. Click <router-link :to="{ name: 'login' }">here</router-link> to go to the login page.
								</span>
								<span v-else>
									Woops! Something happened. Looks like we we're not able to verify your email. Please wait a minute and try again. Sorry for the inconvenience! :(
								</span>
							</p>
							<router-link v-if="status != 'The email is already verified.'" :to="{ name: 'verification.resend' }" class="btn btn-danger mt-4">
								{{ $t('resend_verification_link') }}
							</router-link>
						</template>
					</div>
				</div>
			</div>
		</section>

	</div>
</template>

<script>
	import axios from 'axios'

	const qs = params => Object.keys(params).map(key => `${key}=${params[key]}`).join('&')

	export default {

		middleware: 'guest',

		head () {
			return { title: this.status }
		},

		data: () => ({
			status: []
		}),

		async asyncData ({ params, query }) {
            try {
                const { data } = await axios.post(`/email/verify/${params.id}?${qs(query)}`)
                return { success: true, status: data.status }
                this.status = data.status
            } catch (e) {
                return { success: false, status: e.response.data.status }
                this.status = e.response.data.status
            }
        },
	}
</script>

<style>

</style>