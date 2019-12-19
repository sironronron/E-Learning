<template>
    <div>
        <h4 class="mb-4">Courses that you might like!</h4>
        <div class="py-4 border-top border-bottom">
            <div v-if="isLoading">
                <section class="section">
                    <div class="container text-center">
                        <img src="https://res.cloudinary.com/dl9phqhv0/image/upload/v1574394025/Loader/ajax-loader_sln1xw.gif" alt="">
                    </div>
                </section>
            </div>
            <div v-else class="row with-transitions">
				<div class="col-lg-3 col-sm-6 item-col-lg-3 " v-for="course in mightLikes" :key="course.id">
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
</template>

<script>
    import axios from 'axios'

    export default {

        data: () => ({
            mightLikes: [],
            isLoading: false
        }),

        created() {
            this.getMightLikeCourses()
        },

        methods: {
            getMightLikeCourses() {
                this.isLoading = true
                axios.get(`/course/${this.$route.params.slug}`)
                .then((res) => {
                    this.isLoading = false
                    this.mightLikes = res.data.mightLikes
                })
                .catch((err) => {
                    this.isLoading = false
                    this.$swal({
                        toast: true,
                        position: 'bottom-end',
                        timer: 5000,
                        showConfirmationButton: false,
                        type: 'warning',
                        text: 'Something went wrong!'
                    })
                })
            }
        }

    }
    
</script>

<style scoped>
    .rating {
		margin-top: 7px;
		font-size: 11px;
	}
</style>