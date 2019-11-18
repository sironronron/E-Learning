<template>
	<div>
		<!-- jumbotron -->
		<div class="jumbotron bg-image mb-0 rounded-0">
			<section class="section">
				<div class="container-lg">
					<!-- // Slogan -->
					<div class="row row-grid align-items-end">
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

		<!-- section -->
		<section class="section-sm">
			<div class="container">
				<h4>Featured Courses</h4>
			</div>
		</section>
	</div>
</template>

<script>
	export default {
		middleware: 'auth',

		head() {
			return { title: 'Welcome to E-Learning' }
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