<template>
    <div>
        <section class="section-sm">
            <div class="container">
                <!-- // Alert -->
                <div class="alert alert-success">
                    <h6 class="mb-0 text-white">
                        <fa icon="check-circle" fixed-width /> You've successfully logged out of E-Learning. Come back soon!
                    </h6>     
                </div>

                <div class="jumbotron bg-image mb-0 rounded">
                    <section class="section-sm">
                        <div class="container">
                            <!-- // Slogan -->
                            <div class="row row-grid">
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
                                                <h6 class="mt-3" v-if="course.has_discount == 1"><small class="text-muted"><strike>₱{{course.price}}</strike> </small>&nbsp; <b>₱{{course.discount}}</b> </h6>
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
        </section>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        layout: 'default',

        middleware: 'guest',

        head() {
            return { title: "You've successfully logged out" }
        },

        async asyncData() {
            try {
                let { data } = await axios.get('/welcome')
                return {
                    courses: data.courses
                }
            } catch (e) {
                return
            }
        }
    }
</script>

<style scoped>
    .bg-image {
		background-image: url('https://i.udemycdn.com/notices/featured_banner/image/0d4f1c65-363c-4c91-af1a-b8b10c8cb3ff.jpg'); 
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		background-repeat: no-repeat;
	}
</style>