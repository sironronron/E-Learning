<template>
  <div>
	  	<client-only>
			<offline-alert/>
		</client-only>
		<!-- jumbotron -->
		<div class="jumbotron bg-image mb-0 rounded-0">
			<section class="section-sm">
				<div class="container">
					<!-- // Slogan -->
					<div class="row row-grid align-items-center">
						<div class="col-lg-6">
							<h1 class="display-2 text-white">
								Learn on your schedule
							</h1>
							<p class="lead text-white">
								Study any topic, anytime. Explore thousands of courses for the lowest price ever!
							</p>
							<div class="form-group mt-4">
								<form class="my-auto">
									<div class="input-group input-group-alternative">
										<input aria-describedby="addon-right addon-left" type="text" name="search" placeholder="Search for courses" class="form-inline form-control form-control-lg rounded-left search-welcome">
										<div class="input-group-prepend">
											<span class="input-group-text btn btn-lg btn-default rounded-right p-lg-3">
												<fa icon="search" fixed-width />
											</span>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<!-- // -->
		<!-- // Contents -->
		<div class="jumbotron p-0 mb-0 rounded-0">
			<section class="home-fact-area bg-gradient-danger">
				<div class="container container-facts">
					<div class="row justify-content-center">
						<div class="col-md-4 d-flex">
							<div class="home-fact-box mr-md-auto ml-auto mr-auto">
								<fa icon="bullseye" class="float-left mt-3" />
								<div class="text-box">
									<h4 class="text-white font-weight-600 mb-0">{{courses.length}} Online courses</h4>
									<p class="mb-0">Explore a variety of fresh topics</p>
								</div>
							</div>
						</div>

						<div class="col-md-4 d-flex">
							<div class="home-fact-box mr-md-auto ml-auto mr-auto">
								<fa icon="check" class="float-left mt-3" />
								<div class="text-box">
									<h4 class="text-white font-weight-600 mb-0">Expert instruction</h4>
									<p class="mb-0">Find the right course for you</p>
								</div>
							</div>
						</div>

						<div class="col-md-4 d-flex">
							<div class="home-fact-box mr-md-auto ml-auto mr-auto">
								<fa icon="clock" class="float-left mt-3" />
								<div class="text-box">
									<h4 class="text-white font-weight-600 mb-0">Lifetime access</h4>
									<p class="mb-0">Learn on your schedule</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<!-- // Courses -->
		<div class="section-sm">
			<div class="container">
				<h4>Top Courses</h4>
				<div class="mt-4">
					<div class="row">
						<div class="col-lg-3 col-sm-6 item-col-lg-3 mb-4" v-for="course in courses" :key="course.id">
							<router-link :to="{ name: 'course.show', params: { slug: course.slug } }">
								<div class="card shadow-sm shadow--hover card-lift--hover rounded">
									<img :src="course.image" class="card-img-top border-bottom" alt="">
									<div class="card-body py-3">
										<div class="grid-course-name">
											<h6 class="text-capitalize">
												<strong>{{course.title}}</strong>
											</h6>
										</div>
										<p class="mt-1 mb-1 small text-muted">{{course.user.name}}</p>
										<div class="rating">
											<fa icon="star" fixed-width style="color: #f4c150" />
											<fa icon="star" fixed-width style="color: #f4c150" />
											<fa icon="star" fixed-width style="color: #f4c150" />
											<fa icon="star" fixed-width style="color: #f4c150" />
											<fa icon="star" fixed-width style="color: #f4c150" />
										</div>
										<div class="price float-right">
											<h6 class="mt-3" v-if="course.has_discount == 1">
												<small class="text-muted"><strike>₱{{course.price}}</strike> </small>&nbsp; <b>₱{{course.discount | numeral('0,0.00')}}</b> 
											</h6>
											<h6 class="mt-3" v-else>
												<client-only>
													<b>₱{{course.price | numeral('0,0.00')}}</b>
												</client-only>
											</h6>
										</div>
									</div>
								</div>
							</router-link>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import { mapGetters } from 'vuex'
	import axios from 'axios'

	export default {
		layout: 'default',

		head () {
			return { title: this.$t('home') }
		},

		async asyncData({ error }) {
			try {
				let { data } = await axios.get('/welcome')
				return {
					courses: data.courses
				}
			} catch (e) {
				error({ statusCode: 500, message: 'Something went wrong!' })
			} 
		},

		data: () => ({
			title: process.env.appName
		}),

		computed: mapGetters({
			authenticated: 'auth/check'
		})
	}
</script>

<style scoped>
	.container-facts {
		max-width: 93% !important;
	}
	.bg-image {
		background-image: url('https://res.cloudinary.com/dl9phqhv0/image/upload/b_rgb:000000,c_scale,h_500,o_62/v1573179687/HQ%20Images/alexis-brown-omeaHbEFlN4-unsplash_m9sxu6.jpg'); 
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		background-attachment: fixed;
		background-position: center;
		background-repeat: no-repeat;
		background-size: cover;
	}
	.search-welcome {
	font-size: 20px !important;
	}
	.rating {
		margin-top: 7px;
		font-size: 11px;
	}
	.home-fact-area {
		color: #fff;
		padding: 15px 0;
	}
	.home-fact-box .text-box {
		padding: 10px 0 10px 63px;
	}
	.home-fact-box svg {
		font-size: 47px;
		margin-top: 8px;
	}
</style>
