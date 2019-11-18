<template>
    <div>
        <!-- jumbotron -->
		<div class="jumbotron bg-gradient-danger mb-0 rounded-0">
			<section class="section-sm">
				<div class="container">
					<!-- // Slogan -->
					<div class="row justify-content-center">
                        <div class="col-lg-7 text-center">
                            <h1 class="display-3 text-white">How can we help?</h1>
                            <div class="form-group mt-4">
								<form class="my-auto">
									<div class="input-group input-group-alternative">
										<input aria-describedby="addon-right addon-left" type="text" name="search" placeholder="Search for solutions" class="form-inline form-control form-control-lg rounded-left search-welcome">
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
		<!-- // FQA -->
		<section class="section">
			<div class="container">
				<h3>Frequently Asked Questions</h3>
				<div class="row mt-4">
					<div class="col-lg-9">
						<div class="row">
							<div class="col-lg-4 mb-3">
								<card class="p-1 pb-4 shadow-sm shadow--hover">
									<h5>Lifetime Access</h5>
								</card>
							</div>
							<div class="col-lg-4">
								<card class="p-1 pb-4 shadow-sm shadow--hover">
									<h5>Lifetime Access</h5>
								</card>
							</div>
							<div class="col-lg-4">
								<card class="p-1 pb-4 shadow-sm shadow--hover">
									<h5>Lifetime Access</h5>
								</card>
							</div>
							<div class="col-lg-4">
								<card class="p-1 pb-4 shadow-sm shadow--hover">
									<h5>Lifetime Access</h5>
								</card>
							</div>
							<div class="col-lg-4">
								<card class="p-1 pb-4 shadow-sm shadow--hover">
									<h5>Lifetime Access</h5>
								</card>
							</div>
							<div class="col-lg-4">
								<card class="p-1 pb-4 shadow-sm shadow--hover">
									<h5>Lifetime Access</h5>
								</card>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<card class="p-1 bg-gradient-danger h-100 shadow-sm shadow--hover card-lift--hover rounded" style="height: 100%; cursor: pointer;">
							<div class="text-center align-items-center mt-4">
								<h1 class="display-1 text-white"><fa :icon="['fab', 'facebook-messenger']"  /></h1>
								<h4 class="text-white mt-2">Contact Us</h4>
							</div>
						</card>
					</div>
				</div>
			</div>
		</section>

		<!-- // SELECT TOPIC -->
		<section class="section-sm">
			<div class="container">
				<h3>Select topic to search for help</h3>
				<div class="row mt-4">
					<div class="col-lg-4 mb-3" v-for="category in categories" :key="category.id">
						<div class="wrap">
							<router-link :to="{ name: 'help-center.category', params: { slug: category.slug } }">
								<card class="shadow-sm shadow--hover wrap align-items-center">
									<div class="mt-3">
										<svg width="63" height="63"
											xmlns="http://www.w3.org/2000/svg">
											<image :xlink:href="category.icon" height="63" width="63"/>
										</svg>
										<h5 class="mt-3">{{category.name}}</h5>
										<h6 class="mb-0 text-muted">{{category.description}}</h6>
									</div>
								</card>
							</router-link>
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
		
		layout: 'help-center',

		head() {
			return { title: 'Help Center' }
		},

		async asyncData() {
			try {
				let { data } = await axios.get('/help-center')
				return {
					categories: data.categories
				}
			} catch (e) {
				console.log(e)
			}
		},

	}
</script>

<style scoped>
	@media (min-width: 1200px) { 
		.container {
			max-width: 1024px !important;
		}
	}
	.wrap {
		border-radius: 2px;
		text-align: center;
		min-height: 205px;
		cursor: pointer;
		-webkit-transition: all 0.25s ease;
		-moz-transition: all 0.25s ease;
		-o-transition: all 0.25s ease;
		transition: all 0.25s ease;
	}
	.icon-2 {
		height: 4rem;
		width: 4em;
	}
</style>