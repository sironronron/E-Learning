<template>
	<div>
		<!-- // Jumbotron What Category You Are In -->
		<div class="jumbotron bg-gradient-danger mb-0 rounded-0 p-0">
			<section class="py-4">
				<div class="container">
					<h2 class="text-white font-weight-300 mb-0 py-2">
						{{ category.name }} Courses
					</h2>
				</div>
			</section>
		</div>

		<!-- // Main Content -->
		<section class="section-sm">
			<div class="container">
				
				<!-- // Carousels -->
				<div>
					<h3 class="font-weight-600">Courses to get you started!</h3>
		
					<ul class="nav mt-4">
						<li class="nav-item">
							<h5>
								<a @click="showMostPopular" type="button" href="#most-popular" :class="{ 'router-link-active' : isMostPopular == true }" class="nav-link" aria-label="trending">
									Most Popular
								</a>
							</h5>
						</li>
						<li class="nav-item">
							<h5>
								<a @click="showTrending" type="button" href="#trending" :class="{ 'router-link-active' : isTrending == true }" class="nav-link" aria-label="trending">
									Trending
								</a>
							</h5>
						</li>
					</ul>
			
					<template v-if="isMostPopular == true">
						<most-popular></most-popular>
					</template>

					<template v-else-if="isTrending == true">
						<trending></trending>
					</template>
				</div>
			</div>
		</section>

		<div class="jumbotron bg-image mb-0 rounded-0 p-4">
			<div class="container">
				<div class="row justify-content-between">
					<div class="col-lg-4" v-for="(item, key) in promotions" :key="key">
						<div class="card border h-100">
							<!---->
							<div class="card-body">
								<div class="d-flex px-3 pt-3">
									<div>
										<div class="icon icon-shape bg-gradient-default shadow rounded-circle text-white">
											<fa :icon="item.icon" fixed-width />
										</div>
									</div>
									<div class="pl-4 pr-2">
										<h5 class="title font-weight-600">{{item.title}}</h5>
										<p>{{item.text}}</p>
									</div>
								</div>
							</div>
							<!---->
							<!---->
						</div>
					</div>
				</div>
			</div>
		</div>

		<section class="section-sm">
			<div class="container">
				<!-- // Featured Courses -->
				<div class="mt-3">
					<h5 class="font-weight-300">
						Featured Course
					</h5>
					<div class="slider">
						<div class="py-3">
							<card class="rounded shadow--hover border">
								<!-- // Rows -->
								<div class="row">
									<div class="col-lg-5">
										<client-only>
											<cld-image :publicId="`${featuredCourse.image_public_id}.png`" responsive="width" alt="">
												<cld-transformation height="236" width="420" crop="fill" />
												<cld-transformation border="1px_solid_rgb:00390b" />
											</cld-image>
										</client-only>
									</div>
									<div class="col-lg-7 pl-3">
										<!-- // Content -->
										<h5 class="font-weight-600 mb-0">{{featuredCourse.title}}</h5>
										<p class="text-other">Last Updated {{featuredCourse.updated_at | moment('dddd, MMMM Do YYYY')}}</p>

										<div class="rating-row">
											<span class="course-badge best-seller mr-2">{{featuredCourse.level}}</span>
											<small class="mr-4">
												<span class="d-inline-block average-rating mr-2 text-other">1 Hour</span> &middot;
												<span class="mr-2 text-other"> &nbsp; {{featuredCourse.lessons.length}} Lectures</span>
												<span class="enrolled-num text-other"> &middot;
													&nbsp; 3 Students enrolled
												</span>
											</small>
											<fa icon="star" fixed-width style="color: #f4c150" />
											<fa icon="star" fixed-width style="color: #f4c150" />
											<fa icon="star" fixed-width style="color: #f4c150" />
											<fa icon="star" fixed-width style="color: #f4c150" />
											<fa icon="star" fixed-width style="color: whitesmoke" />
											<small>
												<span class="d-inline-block average-rating text-other mr-2">4</span><span class="text-other mr-2">(2 Ratings)</span>
											</small>
										</div>

										<p class="mt-3" style="font-size: 15px !important;">
											{{featuredCourse.excerpt}} | By {{featuredCourse.user.name}}
										</p>

										<router-link :to="{ name: 'course.show', params: { slug: featuredCourse.slug } }" class="btn btn-default rounded text-capitalize">
											Explore Course
										</router-link>

										<div class="d-block">
											<div class="float-right">
												<template v-if="featuredCourse.free_course != 1">
													<div class="mt-3" v-if="featuredCourse.has_discount == 1">
														<h4 class=" d-inline-block"><small class="text-muted"></small>&nbsp; <b>₱{{featuredCourse.discount}}</b> </h4>
														<strike class="text-other">₱{{featuredCourse.price}}</strike>  
													</div>
													<h6 class="mt-3" v-else>
														<client-only>
															₱<b>{{featuredCourse.price | numeral('0,0')}}</b>
														</client-only>
													</h6>
												</template>
												<template v-else>													
													<h4 class="mt-3">Free Course</h4>
												</template>
											</div>
										</div>
										
									</div>
								</div>
							</card>
						</div>
					</div>
				</div>

				<!-- // Popular Topics -->
				<div class="mt-3">
					<h5 class="font-weight-300 mb-4">
						Popular Topics
					</h5>
					<div class="row">
						<div class="col-lg-3 mb-3">
							<card class="p-1 shadow-sm shadow--hover">
								<h6 class="mb-0">Lifetime Access</h6>
							</card>
						</div>
						<div class="col-lg-3">
							<card class="p-1 shadow-sm shadow--hover">
								<h6 class="mb-0">Lifetime Access</h6>
							</card>
						</div>
						<div class="col-lg-3">
							<card class="p-1 shadow-sm shadow--hover">
								<h6 class="mb-0">Lifetime Access</h6>
							</card>
						</div>
						<div class="col-lg-3">
							<card class="p-1 shadow-sm shadow--hover">
								<h6 class="mb-0">Lifetime Access</h6>
							</card>
						</div>
						<div class="col-lg-3">
							<card class="p-1 shadow-sm shadow--hover">
								<h6 class="mb-0">Lifetime Access</h6>
								</card>
						</div>
						<div class="col-lg-3">
							<card class="p-1 shadow-sm shadow--hover">
								<h6 class="mb-0">Lifetime Access</h6>
							</card>
						</div>
						<div class="col-lg-3">
							<card class="p-1 shadow-sm shadow--hover">
								<h6 class="mb-0">Lifetime Access</h6>
							</card>
						</div>
						<div class="col-lg-3">
							<card class="p-1 shadow-sm shadow--hover">
								<h6 class="mb-0">Lifetime Access</h6>
							</card>
						</div>
					</div>
				</div>

				<!-- // All Category Courses -->
				<div class="mt-5">
					<h3 class="font-weight-600 mb-3">All {{category.name}} Courses</h3>
						<!-- // Filters -->
					<div>
						<div class="jumbotron bg-secondary mb-0 rounded p-2">
							<div class="container">
								<div class="p-2">
									<div>
										<div class="row">
											<!-- // Star and Duration Filter  -->
											<div class="col-lg-6">
												<div class="d-flex justify-content-start">
													<div class="dropdown">
														<button class="btn btn-neutral dropdown-toggle text-capitalize text-dark font-weight-400" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-top: 2px solid #f4c150;">
															Ratings
														</button>
														<div class="dropdown-menu dropdown-menu-left dropdown-menu-ratings">
															
														</div>
													</div>
													<div class="dropdown">
														<button class="btn btn-neutral dropdown-toggle text-capitalize text-dark font-weight-400" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-top: 2px solid #cc87b4;">
															Duration
														</button>
														<div class="dropdown-menu dropdown-menu-left dropdown-menu-ratings">
															
														</div>
													</div>
												</div>
											</div>
											<!-- // Advance Filters -->
											<div class="col-lg-6">
												<div class="d-flex justify-content-end">
													<div class="dropdown">
														<button class="btn btn-neutral dropdown-toggle text-capitalize text-dark font-weight-400" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															All Filters
														</button>
														<div class="dropdown-menu dropdown-menu-ratings">
															
														</div>
													</div>
													<div class="dropdown">
														<button class="btn btn-neutral dropdown-toggle text-capitalize text-dark font-weight-400" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Sort
														</button>
														<div class="dropdown-menu dropdown-menu-ratings">
															
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="d-block py-3">
							<p class="float-right">{{countCourses}} courses</p>
						</div>

						<!-- // Course Lists -->
						<hr class="mb-0 mt-4">

						<div class="row">
							<!-- // Main Category Courses -->
							<div class="col-lg-9">
								<category-courses></category-courses>
							</div>

							<div class="col-lg-3">
								<!-- // Money Back Guarantee -->
								<div class="mt-2 pt-4 pb-2 px-4 border rounded">
									<h6><b><fa icon="calendar-alt" class="text-info" /> &nbsp; Not Sure?</b></h6>
									<p>Every course comes with a 30-day money-back-guarantee</p>
								</div>
							</div>

						</div>

					</div>
				</div>
			</div>
		</section>

	</div>
</template>

<script>
	import axios from 'axios'
	import MostPopular from '../../../components/courses/category/popular.vue'
	import Trending from '../../../components/courses/category/trending.vue'
	import CategoryCourses from '../../../components/courses/category/all_courses.vue'

	export default {

		components: {
			MostPopular, Trending, CategoryCourses
		},

		head() {
			return { title: this.category.name }
		},

		data: () => ({
			isMostPopular: true,
			isTrending: false,
		}),

		async asyncData({ params, error }) {
			try {
				let { data } = await axios.get(`/course/category/${params.slug}`)
				return {
					category: data.category,
					featuredCourse: data.featuredCourse,
					countCourses: data.countCourses
				}
			} catch (e) {
				return
			}
		},

		methods: {
			showMostPopular() {
				this.isMostPopular = true
				this.isTrending = false
			},

			showTrending() {
				this.isTrending = true
				this.isMostPopular = false
			},
		},

		computed: {
			promotions() {
				return [
					{
						icon: 'history',
						title: 'Go at your own pace',
						text: "Enjoy lifetime access to courses on Academy's website"
					},
					{
						icon: 'check',
						title: 'Learn from industry experts',
						text: 'Select from top instructors around the world'
					},
					{
						icon: 'play',
						title: 'Find video courses on almost any topic',
						text: 'Build your library for your career and personal growth'
					}
				]
			}
		}

	}

</script>

<style lang="scss" scoped>

	.search {
        &_image {
            width: 210px;
            height: 118px;
            object-fit: cover;
        }
        &_body {
            cursor: pointer;
        }
        &_body:hover {
            background: whitesmoke;
        }
    }

	.nav-link {
		font-size: 14px !important;
		padding: 0.70rem 10px !important;
		margin-right: 2rem;
		color: #000;
	}
	
	.router-link-active {
		border-bottom: 5px solid red;
		cursor: text;
	}

	.nav-link:hover {
		color: red;
		border-bottom: 5px solid red;
	}
	 .course-header-wrap .course-badge {
        font-size: 9px !important;
    }
    .course-badge.best-seller {
        background: #f4c150;
    }
    .course-header-wrap > div > span {
        margin-right: 12px;
        margin-bottom: 7px;
        font-size: 15px;
    }
    .course-badge {
        color: #29303b;
        box-shadow: 0 0 1px 1px rgba(20,23,28,.1), 0 3px 1px 0 rgba(20,23,28,.1);
        pointer-events: none;
        border-radius: 3px;
        font-size: 9px;
        padding: 1px 8px;
        font-weight: 700;
        position: relative;
        line-height: 1.5;
        text-align: center;
        text-transform: uppercase;
        display: inline-block;
    }
    .course-badge:after {
        border-radius: 3px;
        right: -4px;
        background: inherit;
        content: "";
        height: 11px;
        position: absolute;
        top: 2px;
        transform: rotate(45deg);
        width: 11px;
        z-index: 0;
        display: block;
    }
    .course-header-wrap > div > span {
        margin-right: 12px;
        margin-bottom: 7px;
        font-size: 15px;
    }
    .course-sidebar {
        background-color: #fff;
        box-shadow: 0 0 1px 1px rgba(20,23,28,.1), 0 3px 1px 0 rgba(20,23,28,.1);
        border-radius: 4px;
        color: #505763;
        padding: 3px;
        position: relative;
        margin-top: -250px;
        z-index: 10;
	}
	hr {
        border-top: 0.25rem solid rgba(0, 0, 0, 0.1);
	}
</style>