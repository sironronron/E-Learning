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
					<div class="row row-grid align-items-end">
						<div class="col-lg-6">
							<h1 class="display-3 text-white">
								Unlock Opportunity
							</h1>
							<h6 class="lead text-white mb-0">
								Study any topic, anytime. Explore thousands of courses for the lowest price ever!
							</h6>
						</div>
					</div>
				</div>
			</section>
		</div>

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
											<template v-if="course.free_course != 1">
												<h6 class="mt-3" v-if="course.has_discount == 1"><small class="text-muted"><strike>₱{{course.price}}</strike> </small>&nbsp; <b>₱{{course.discount}}</b> </h6>
												<h6 class="mt-3" v-else>
													<client-only>
														₱<b>{{course.price | numeral('0,0')}}</b>
													</client-only>
												</h6>
											</template>
											<template v-else>													
												<h6 class="mt-3">Free Course</h6>
											</template>
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
	import axios from 'axios'

	export default {
		middleware: 'auth',

		head() {
			return { title: 'Welcome to E-Learning' }
		},

		async asyncData({ error }) {
			try {
				let { data } = await axios.get('/welcome')
				return {
					courses: data.courses
				}
			} catch (e) {
				error({ statusCode: 500, message: 'Something went wrong' })
			}
		}
	}
</script>

<style scoped>
	.bg-image {
		background-image: url('https://res.cloudinary.com/dl9phqhv0/image/upload/v1578039329/HQ%20Images/eb91edb8-3561-4cf3-843a-a56790395ab1_itmr9l.jpg'); 
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		background-repeat: no-repeat;
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