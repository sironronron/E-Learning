<template>
    <div>
        <!-- // jumbotron -->
        <div class="jumbotron mb-0 bg-gradient-default">
            <div class="container">
                <div class="row">
                    <!-- Course Overview -->
                    <div class="col-lg-auto">
                        <img :src="`http://127.0.0.1:8001/storage/${instructor.avatar}`" class="rounded-circle" width="130" height="130" alt="">
                    </div>
                    <div class="col-lg-10">
                        <div class="ml-5 mt-3">
                            <h3 class="text-white font-weight-500">{{instructor.name}}</h3>
                            <h5 class="text-muted font-weight-300 mt-2">@{{instructor.username}}</h5>
                            <p class="mt-3 text-white" v-html="instructor.biography">
                                {{instructor.biography}}
                            </p>
                            <div class="social-media">
                                <div class="inline">
                                    <h3 class="text-white">
                                        <a v-if="instructor.facebook_link" href="#" class="mr-2" title="Facebook Link">
                                            <fa :icon="['fab', 'facebook-square' ]" />
                                        </a>
                                        <a v-if="instructor.twitter_link" href="#" class="mr-2" title="Twitter Link">
                                            <fa :icon="['fab', 'twitter-square' ]" />
                                        </a>
                                        <a v-if="instructor.youtube_link" href="#" class="mr-2" title="Youtube Link">
                                            <fa :icon="['fab', 'youtube-square' ]" />
                                        </a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="section-sm">
            <div class="container">

                <div class="row">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-10">
                        <h4>Courses taught by {{instructor.name}}</h4>
                        <hr class="full-width-hr mt-3 mb-3">
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 item-col-lg-3 mb-4" v-for="course in courses" :key="course.id">
                                <router-link :to="{ name: 'course.show', params: { slug: course.slug } }">
                                    <div class="card shadow-sm shadow--hover card-lift--hover rounded">
                                        <img :src="course.image" class="card-img-top" alt="">
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
                                                <h6 class="mt-3" v-if="course.has_discount == 1"><small class="text-muted"><strike>${{course.price}}</strike> </small>&nbsp; <b>${{course.discount}}</b> </h6>
                                                <h6 class="mt-3" v-else>
                                                    <client-only>
                                                        ₱{{course.price | numeral('0,0.00')}}
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
        </section>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {

        head() {
            return { title: this.instructor.name}
        },

        async asyncData({params}) {
            try {
                let { data } = await axios.get('/course/instructor/' + params.username)
                return {
                    instructor: data.instructor,
                    courses: data.courses
                }
            } catch (e) {
                return
            }
        }   

    }
</script>

<style scoped>
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