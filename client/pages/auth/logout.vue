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

                <div class="jumbotron bg-image mb-0 rounded-0">
                    <section class="section-sm">
                        <div class="container-lg">
                            <!-- // Slogan -->
                            <div class="row row-grid">
                                <div class="col-lg-5">
                                    <h1 class="display-3 text-white">
                                        Unlock Opportunity
                                    </h1>
                                    <p class="lead text-white">
                                        Study any topic, anytime. Explore thousands of courses for the lowest price ever!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

            </div>
        </section>
    </div>
</template>

<script>

    export default {
        layout: 'default',

        middleware: 'guest',

        head() {
            return { title: "You've successfully logged out" }
        }
    }
</script>

<style scoped>
    .bg-image {
		background-image: url('https://res.cloudinary.com/dl9phqhv0/image/upload/c_scale,h_500/v1573196577/HQ%20Images/ali-yahya-ytNFYf4d_30-unsplash_lrzlrw.jpg'); 
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		background-attachment: fixed;
		background-position: center;
		background-repeat: no-repeat;
		background-size: cover;
		}
</style>