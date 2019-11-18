<template>
    <div>
        <!-- // Jumbotron -->
        <div class="jumbotron bg-image mb-0 rounded-0">
            <section class="section">
                <div class="container">
                    <!-- // Slogan -->
                    <div class="row row-grid">
                        <div class="col-lg-5">
                            <h1 class="display-2 text-white font-weight-300">
                                Make a global impact
                            </h1>
                            <p class="lead text-white">
                                Create an online video course and earn money by teaching people around the world.
                            </p>
                            <div class="mt-5 col-lg-6">
                                <router-link :to="{ name: 'register.instructor' }" class="btn btn-danger btn-lg btn-block text-capitalize">
                                    Become an Instructor
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- //  -->
        <section class="section bg-white">
            <div class="container text-center">
                <div>
                    <h2 class="font-weight-300">Discover Your Potential</h2>
                </div>
                <div class="row m-t-80">
                    <div class="col-lg-4">
                        <svg width="63" height="63"
							xmlns="http://www.w3.org/2000/svg">
							<image xlink:href="https://res.cloudinary.com/dl9phqhv0/image/upload/c_scale,h_63/v1573808517/Logos/piggybank_hmdceo.svg" height="63" width="63"/>
						</svg>
                        <div class="mt-4">
                            <h4>Earn Money</h4>
                            <p>Earn money every time a student purchases your course. Get paid monthly through PayPal or Payoneer, it’s your choice.</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <svg width="63" height="63"
							xmlns="http://www.w3.org/2000/svg">
							<image xlink:href="https://res.cloudinary.com/dl9phqhv0/image/upload/c_scale,h_63/v1573808618/Logos/play-button_eq409x.svg" height="63" width="63"/>
						</svg>
                        <div class="mt-4">
                            <h4>Inspire Students</h4>
                            <p>Help people learn new skills, advance their careers, and explore their hobbies by sharing your knowledge.</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <svg width="63" height="63"
							xmlns="http://www.w3.org/2000/svg">
							<image xlink:href="https://res.cloudinary.com/dl9phqhv0/image/upload/c_scale,h_63/v1573808751/Logos/like-thumb-up-outlined-symbol_y9wspz.svg" height="63" width="63"/>
						</svg>
                        <div class="mt-4">
                            <h4>Join Our Community</h4>
                            <p>Take advantage of our active community of instructors to help you through your course creation process.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- // Customer Service -->
        <div class="jumbotron bg-image-2 mb-0 rounded-0">
            <section class="section">
                <div class="container text-center">
                    <div class="row justify-content-center">
                        <div class="col-lg-9">
                            <card class="p-lg-4 rounded shadow-lg card-lift--hover">
                                <div>
                                    <h2 class="font-weight-300">We're Here to Help</h2>
                                </div>
                                <p class="mt-5">Our Instructor Support Team is here for you 24/7 to help you through your course creation needs. Use our Teaching Center, a resource center to help you through the process. Join Studio U and get peer-to-peer support from our engaged instructor community. This community group is always on, always there, and always helpful.</p>
                            </card>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- //  -->
        <section class="section-lg bg-secondary">
            <div class="container text-center">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <h1 class="font-weight-300">Become an instructor today</h1>
                        <h5 class="mt-2 mb-3">Join the world's largest online learning marketplace.</h5>
                        <router-link :to="{ name: 'register.instructor' }" class="btn btn-danger text-capitalize btn-lg w-25 mt-4">
                            Get Started
                        </router-link>
                    </div>
                </div>
            </div>
        </section>

    </div>
</template>

<script>
    export default {
        layout: 'default',

        head() {
            return { title: 'Teach in E-Learning' }
        }
    }
</script>

<style scoped>
    .bg-image {
        background: #505763 url(https://udemy-images.udemy.com/teaching/header-image.jpg) right top no-repeat;
        background-size: cover;
    }

    .bg-image-2 {
        background: #505763 url(https://res.cloudinary.com/dl9phqhv0/image/upload/c_mfit,e_opacity_threshold:60,h_500,w_1350/v1573809159/HQ%20Images/marvin-meyer-SYTO3xs06fU-unsplash_1_rfxy1k.jpg) right top no-repeat;
        background-size: cover;
    }
</style>