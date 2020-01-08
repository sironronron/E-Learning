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
								<form class="my-auto d-inline w-25" @submit.prevent="submit">
									<div class="input-group input-group-alternative">
										<input aria-describedby="addon-right addon-left" type="text" v-model="search" name="search" placeholder="Search for solutions" class="form-inline form-control">
										<div class="input-group-prepend">
											<span class="input-group-text rounded-right">
												<fa icon="search" fixed-width class="text-danger" />
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

        <section class="section-sm">
            <div class="container">

                <div class="row justify-content-center">
                    <div class="col-lg-7">

                        <h4 class="font-weight-400">BrainSparks Customer Service</h4>
                        <h6>Have a question/problem? Please write here, and we will reply back soonest.</h6>
						<hr class="full-width-hr mb-4 mt-4">

                        <form @submit.prevent="sendInquiry" @keydown="form.onKeydown($event)">

                            <div>

                                <!-- // Role -->
                                <div class="form-group">
                                    <label for="role" class="col-form-label">Are you a student or instuctor? <span class="text-danger">*</span></label>
                                    <select name="role" id="role" v-model="form.role" :class="{ 'is-invalid' : form.errors.has('role') }" class="custom-select rounded">
                                        <option value="">Select Role</option>'
                                        <option v-for="(item, key) in roles" :key="key" :value="item.value">
                                            {{item.name}}
                                        </option>
                                    </select>
                                    <has-error :form="form" field="role"></has-error>
                                </div>

                                <!-- // Inquiry -->
                                <div class="form-group">
                                    <label for="subject" class="col-form-label">What is your inquiry about? <span class="text-danger">*</span></label>
                                    <!-- // -->
                                    <input v-if="form.role == ''" type="text" name="subject" v-model="form.subject" :class="{ 'is-invalid' : form.errors.has('subject') }" disabled class="form-control rounded">
                                    <!-- // -->
                                    <input v-else type="text" name="subject" v-model="form.subject" :class="{ 'is-invalid' : form.errors.has('subject') }" class="form-control rounded">
                                    <has-error :form="form" field="subject"></has-error>
                                </div>

                                <!-- // Email Address -->
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">Name <span class="text-danger">*</span></label>
                                            <!-- // -->
                                            <input v-if="form.subject == ''" type="text" name="name" v-model="form.name" disabled class="form-control rounded">
                                            <!-- // -->
                                            <input v-else type="text" name="name" v-model="form.name" :class="{ 'is-invalid' : form.errors.has('name') }" class="form-control rounded">
                                            <has-error :form="form" field="name" /> 
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="email" class="col-form-label">Email Address <span class="text-danger">*</span></label>
                                            <!-- // -->
                                            <input v-if="form.subject == ''" type="email" name="email" v-model="form.email" disabled class="form-control rounded">
                                            <!-- // -->
                                            <input v-else type="email" name="email" v-model="form.email" :class="{ 'is-invalid' : form.errors.has('email') }" class="form-control rounded">
                                            <has-error :form="form" field="email"></has-error>
                                        </div>
                                    </div>
                                </div>

                                <!-- // Body -->
                                <div class="form-group">
                                    <label for="description" class="col-form-label">Description <span class="text-danger">*</span></label>
                                    <!-- // -->
                                    <textarea v-if="form.subject == ''" disabled name="body" id="body" cols="30" rows="5" v-model="form.body" class="form-control rounded"></textarea>
                                    <!-- // -->
                                    <textarea v-else name="body" id="body" cols="30" rows="5" v-model="form.body" :class="{ 'is-invalid' : form.errors.has('body') }" class="form-control rounded"></textarea>
                                    
                                    <has-error :form="form" field="body"></has-error>
                                </div>

                                <checkbox v-model="form.agreed_terms" name="agreed_terms">
									I agree to the terms of BrainSparks Privacy Policy.
                                    BrainSparks will only use my information to process current and future transactions in accordance with the Data Privacy Act of 2012.
								</checkbox>

                                <button v-if="form.body == '' || form.agreed_terms === false" class="btn btn-danger rounded mt-4 text-capitalize" disabled>
                                    Submit Inquiry
                                </button>

                                <v-button v-else :loading="form.busy" type="danger" class="text-capitalize rounded mt-4">
                                    Submit Inquiry
                                </v-button>

                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </section>

    </div>
</template>

<script>
    import axios from 'axios'
    import Form from 'vform'

    export default {

        scrollToTop: false,

        head() {
            return { title: 'Contact Us' }
        },

        data: () => ({
            search: '',
            form: new Form({
                name: '',
                role: '',
                subject: '',
                email: '',
                body: '',
                agreed_terms: false
            })
        }),

        computed: {
            roles() {
                return [
                    {
                        value: 'STUDENT',
                        name: 'Student'
                    },
                    {
                        value: 'INSTRUCTOR',
                        name: 'Instructor'
                    }
                ]
            }
        },

        methods: {
            async sendInquiry() {
                try {
                    let { data } = await this.form.post('/help-center/customer_inquiry')
                    this.$swal({
                        type: 'success',
                        text: data.message
                    })
                    this.$router.push({ name: 'help-center.student' })
                } catch (e) {
                    return
                }
            },
            
            submit() {
                this.$router.push('/help-center/student/search?q=' + this.search)
            }
        }

    }
</script>