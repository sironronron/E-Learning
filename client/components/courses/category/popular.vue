<template>
	<div>
		<template v-if="!isLoading">
			<client-only>
				<carousel :perPage="5" :loop="true" :paginationEnabled="false" >
					<slide v-for="(course, key) in mostPopular" :key="key" style="margin-right: 10px;" class="py-4">
						<router-link :to="{ name: 'course.show', params: { slug: course.slug } }">
							<div class="card border shadow-sm shadow--hover rounded">
								<img :src="course.image" class="card-img-top border-bottom" alt="">
								<div class="card-body py-3">
									<div class="grid-course-name">
										<h6 class="text-capitalize">
											<strong>{{course.title}}</strong>
										</h6>
									</div>
									<p class="mt-1 mb-1 small text-muted">{{course.user}}</p>
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
					</slide>
				</carousel>
			</client-only>
		</template>
		<template v-else>
			<div class="py-5 text-center">
				<img src="https://res.cloudinary.com/dl9phqhv0/image/upload/v1574394025/Loader/ajax-loader_sln1xw.gif" alt="">
			</div>
		</template>
	</div>
</template>

<script>
	import axios from 'axios'

	export default {

		name: 'MostPopular',

		data: () => ({
			mostPopular: {
				user: []
			},
			isLoading: false
		}),

		created() {
			this.getMostPopularCourses()
		},

		methods: {
			getMostPopularCourses() {
				this.isLoading = true
				axios.get(`/course/category/${this.$route.params.slug}`)
				.then((res) => {
					this.isLoading = false
					this.mostPopular = res.data.mostPopular
				}).catch((err) => {
					console.log(err)
				})
			}
		}
		
	}

</script>

<style>

</style>