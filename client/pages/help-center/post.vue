<template>
    <div>
        <!-- // Search and Breadcrumbs  -->
        <div class="jumbotron pt-4 pb-4 mb-0 bg-gradient-danger border-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent small p-0">
                                <li class="breadcrumb-item" aria-current="page">
                                    <router-link :to="{ name: 'help-center.student' }" class="text-white">Home</router-link>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">
                                    <router-link :to="{ name: 'help-center.student.category', params: { slug: category.slug } }" class="text-white">{{category.name}} - General</router-link>
                                </li>
                                <li class="breadcrumb-item active text-white" aria-current="page">{{post.title}}</li>
                            </ol>
                        </nav>
                        <div class="mt-5">
                            <h1 class="text-white font-weight-300">{{post.title}}</h1>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="align-content-lg-end">
                            <!-- // Search Form  -->
                            <form class="my-auto d-inline w-25" @submit.prevent="submit">
								<div class="input-group input-group-alternative">
									<input aria-describedby="addon-right addon-left" v-model="search" type="text" name="search" placeholder="Search for solutions" class="form-inline form-control">
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
        </div>

        <div class="row">
            <div class="col-12 col-xl-8">
                <div class="bg-white px-5 py-4 border-right h-100 h-100vh">
                    <div class="container custom-container">
                        <span v-html="post.body">{{post.body}}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-2">
                <div class="bg-transparent pt-4">
                    <div class="container">
                        <router-link :to="{ name: 'help-center.contact' }" class="btn btn-danger btn-block text-capitalize rounded">Contact Us</router-link>
                        <div class="mt-4">
                            <h6><b>Related Articles</b></h6>
                            <ul class="list-unstyled mt-3">
                                <li v-for="(item, index) in related" :key="index">
                                    <router-link :to="{ name: 'help-center.student.category.post', params: { categorySlug: item.category_id, postSlug: item.slug } }" class="btn btn-link text-capitalize p-0 font-weight-400">
                                        {{item.title}}
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-4">
                            <h6><b>Student Topics</b></h6>
                            <ul class="list-unstyled mt-3">
                                <li v-for="(category, key) in categories" :key="key">
                                    <router-link :to="{ name: 'help-center.student.category', params: { slug: category.slug } }" class="btn btn-link text-capitalize p-0 font-weight-500">
                                        {{category.name}}
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>


<script>
    import axios from 'axios'

    export default {

        scrollToTop: true,

        head() {
            return { title: `${this.post.title}` }
        },

        data: () => ({
            search: ''
        }),

        methods: {
            submit() {
                this.$router.push('/help-center/student/search?q=' + this.search)
            }
        },

        async asyncData({ params, error }) {
            try {
                let { data } = await axios.get(`/help-center/category/post/${params.categorySlug}/${params.postSlug}`)
                return {
                    category: data.category,
                    post: data.post,
                    categories: data.categories,
                    related: data.related
                }
            } catch (e) {
                error({ statusCode: 500, message: 'Oopsss... Something went wrong!'})
            }
        }

    }

</script>

<style scoped>
    @media (min-width: 1200px) { 
		.container {
			max-width: 1024px !important;
        }
        .container-lg {
            max-width: 100% !important;
        }
        .custom-container {
            padding-left: 8rem !important;
        }
    }
    .router-link-active {
        font-weight: 700;
    }
    .breadcrumb-item + .breadcrumb-item::before {
        color: #ffffff;
    }
    
</style>
