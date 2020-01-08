<template>
	<div>
		<!-- // Main Register -->
		<section class="section">
			<div class="container">

				<div class="row justify-content-center">
					<div class="col-lg-7">

						<form @submit.prevent="save" @keydown="form.onKeydown($event)">

							<!-- // Ready Button -->
							<template v-if="step == 1">
								<div class="text-center">
									<h2>Are you ready?</h2>
									<h6>Just click the button below to continue if you are ready!</h6>
									<button class="btn btn-danger btn-lg w-50 mt-3 mb-5" @click.prevent="next()">Continue</button>
								</div>
							</template>

							<!-- // Teaching Skill -->
							<template v-if="step == 2">
								<h2>Share your knowledge!</h2>
								<h6 class="mt-4">BrainSparks courses are video-based experiences that give students the chance to learn actionable skills. Whether you have experience teaching, or it’s your first time, we’ll help you package your knowledge into an online course that improves student lives.</h6>

								<hr class="full-width-hr my-4">

								<div class="row justify-content-center">
									<div class="col-lg-6">

										<div class="form-group border p-3 rounded" v-for="(item, key) in teachingSkills" :key="key">
											<div class="custom-control custom-radio">
												<input :id="key + 1" type="radio" class="custom-control-input" v-model="form.teaching_skills" :value="item.value"> 
												<label :for="key + 1" class="custom-control-label">
													{{item.name}}
												</label>
											</div>
										</div>

										<div v-if="form.teaching_skills === 'OTHER'" class="form-group">
											<label for="please-define" class="col-form-label"><b>Please Define</b></label>
											<input type="text" name="teaching_skill_other" v-model="form.teaching_skill_other" :class="{ 'is-invalid' : form.errors.has('teaching_skill_other') }" class="form-control rounded">
											<has-error :form="form" field="teaching_skill_other"></has-error>
										</div>

									</div>
								</div>

								<!-- // Prev and Next Button -->
								<div class="row justify-content-center mt-5">
									<div class="col-lg-2">
										<button v-if="form.teaching_skills === ''" disabled class="btn btn-sm btn-default" @click.prevent="next()">
											<fa icon="arrow-right" fixed-width /> Next
										</button>
										<button v-if="form.teaching_skills != ''" class="btn btn-sm btn-default" @click.prevent="next()">
											<fa icon="arrow-right" fixed-width /> Next
										</button>
									</div>
								</div>
								
							</template>

							<template v-if="step == 3">
								<h2>Create a course</h2>
								<h6 class="mt-4">Over the years we’ve helped thousands of instructors learn how to record at home. No matter your experience level, you can become a video pro too. We’ll equip you with the latest resources, tips, and support to help you succeed.</h6>

								<hr class="full-width-hr my-4">

								<div class="row justify-content-center">
									<div class="col-lg-6">
										
										<div class="form-group border p-3 rounded" v-for="(item, key) in videoSkills" :key="key">
											<div class="custom-control custom-radio">
												<input :id="key + 1" type="radio" class="custom-control-input" v-model="form.video_skills" :value="item.value"> 
												<label :for="key + 1" class="custom-control-label">
													{{item.name}}
												</label>
											</div>
										</div>

									</div>
								</div>


								<!-- // Prev and Next Button -->
								<div class="row justify-content-center mt-5">
									<div class="col-lg-2">
										<!-- // Previous button -->
										<button class="btn btn-sm btn-default" @click.prevent="prev()">
											<fa icon="arrow-left" fixed-width /> Previous
										</button>
									</div>
									<div class="col-lg-2">
										<!-- // Next Button -->
										<button v-if="form.video_skills === ''" disabled class="btn btn-sm btn-default" @click.prevent="next()">
											<fa icon="arrow-right" fixed-width /> Next
										</button>
										<button v-if="form.video_skills != ''" class="btn btn-sm btn-default" @click.prevent="next()">
											<fa icon="arrow-right" fixed-width /> Next
										</button>
									</div>
								</div>
							
							</template>

							<template v-if="step == 4">
								<h2>Expand your reach!</h2>
								<h6 class="mt-4">Once you publish your course, you can grow your student audience and make an impact with the support of Brainspark's marketplace promotions and also through your own marketing efforts. Together, we’ll help the right students discover your course.</h6>

								<hr class="full-width-hr my-4">

								<div class="row justify-content-center">
									<div class="col-lg-6">

										<div class="form-group border p-3 rounded" v-for="(item, key) in audienceNumber" :key="key">
											<div class="custom-control custom-radio">
												<input :id="key + 1" type="radio" class="custom-control-input" v-model="form.audience_number" :value="item.value"> 
												<label :for="key + 1" class="custom-control-label">
													{{item.name}}
												</label>
											</div>
										</div>

									</div>
								</div>

							</template>

							<div class="row justify-content-center mt-4" v-if="step == 4">
								<div class="col-lg-2">
									<!-- // Previous button -->
									<button class="btn btn-sm btn-default" @click.prevent="prev()">
										<fa icon="arrow-left" fixed-width /> Previous
									</button>
								</div>
								<div class="col-lg-2">
									<v-button v-if="form.audience_number === ''" disabled :loading="form.busy" class="btn-sm">
										<fa icon="check" fixed-width /> 
										Register
									</v-button>
									<v-button v-if="form.audience_number != ''" :loading="form.busy" class="btn-sm">
										<fa icon="check" fixed-width /> 
										Register
									</v-button>
								</div>
							</div>

						</form>

					</div>
				</div>

			</div>
		</section>


	</div>
</template>

<script>
	import Form from 'vform'

	export default {

		layout: 'instructor-register',
		
		middleware: ['auth', 'is-instructor'],

		head() {
			return { title: 'Become an Instructor!' }
		},

		data: () => ({
			form: new Form({
				'teaching_skills': '',
				'teaching_skill_other': '',
				'video_skills': '',
				'audience_number': ''
			}),
			step: 1
		}),

		methods: {

			async save() {

				let data

				try {
					const response = await this.form.post('/instructor/instructor-registration/v2')
					data = response.data
					this.$swal({
						type: 'success',
						text: data.message
					})
				} catch (e) {
					return
				}

				this.$router.push({ name: 'instructor.courses' })
			},

			next: function() {
				this.step++
			},

			prev: function() {
				this.step--
			}

		},


		computed: {

			teachingSkills() {
				return [
					{
						value: 'PERSON_INFORMAL',
						name: 'In person, informally'
					},
					{
						value: 'PERSON_PROFESSIONAL',
						name: 'In person, professionally'
					},
					{
						value: 'ONLINE',
						name: 'Online'
					},
					{
						value: 'OTHER',
						name: 'Other'
					}
				]
			},

			videoSkills() {
				return [
					{
						value: 'BEGINNER',
						name: "I'm a beginner"
					},
					{
						value: 'SOME_KNOWLEDGE',
						name: "I have some knowledge"
					},
					{
						value: 'EXPERIENCED',
						name: "I'm experienced"
					},
					{
						value: 'READY_UPLOAD',
						name: 'I have videos ready to upload'
					}
				]
			},

			audienceNumber() {
				return [
					{
						value: 'NAM',
						name: 'Not at the moment'
					},
					{
						value: 'SMF',
						name: "I have a small following"
					},
					{
						value: 'SZF',
						name: 'I have a sizeable following'
					}
				]
			}

		},

	}
</script>

<style scoped>
	.bg-image {
		background-image: url('https://res.cloudinary.com/dl9phqhv0/image/upload/c_fill,h_329,w_1185/v1576806174/HQ%20Images/neonbrand-zFSo6bnZJTw-unsplash_cmeqgg.jpg');
		-webkit-background-size: auto;
		-moz-background-size: auto;
		-o-background-size: auto;
		background-size: auto;
		background-repeat: no-repeat;
	}
	.custom-radio .custom-control-label::before {
		top: -1px !important;
		border-radius: 50%;
	}
	.custom-control-label::after {
		top: -1px !important;
	}
</style>