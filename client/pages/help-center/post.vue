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

        <section class="section-sm">
            <div class="container">

                <div class="row">
                    <div class="col-lg-9">
                        <!-- // Post -->
                        <span v-html="post.body">{{post.body}}</span>
                        <div class="mt-5">
                            <h6 class="text-muted">Updated {{post.updated_at | moment('from')}}</h6>
                            <hr class="my-3">
                            <h5>Was this article helpful?</h5>
                            <div class="d-flex">
                                <div>
                                    <template>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <fa :icon="['far', 'thumbs-up']" fixed-width />
                                        </button>
                                    </template>
                                </div>
                                <div class="ml-2">
                                    <button class="btn btn-sm btn-outline-danger">
                                        <fa :icon="['far', 'thumbs-down']" fixed-width />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <!-- // Categories -->
                        <h6><b>Student Topics</b></h6>
                        <div class="pt-3">
                            <ul class="list-unstyled small">
                                <li class="mb-3" v-for="cat in categories" :key="cat.id">
                                    <router-link :to="{ name: 'help-center.student.category', params: { slug: cat.slug } }" class="text-dark">
                                        <svg width="15" height="15"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <image :xlink:href="cat.icon" height="15" width="15"/>
                                        </svg>
                                        <span class="ml-2">{{cat.name}}</span>
                                    </router-link>
                                </li>
                            </ul>
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
        scrollToTop: false,

        head() {
            return { title: this.post.title }
        },

        data: () => ({
            search: '',
            category: [],
            categories: [],
            related: []
        }),

        async asyncData({ params }) {
            try {
                let { data } = await axios.get(`/help-center/category/post/${params.categorySlug}/${params.postSlug}`)
                return {
                    post: data.post
                }
            } catch (e) {
                return
            }
        },

        created() {
            this.getCategories()
        },

        methods: {
            getCategories: function() {
                axios.get(`/help-center/category/post/${this.$route.params.categorySlug}/${this.$route.params.postSlug}`)
                .then((res) => {
                    this.category = res.data.category
                    this.categories = res.data.categories
                    this.related = res.data.related 
                }).catch((err) => {
                    console.log(err)
                })
            },

            submit: function() {
                this.$router.push('/help-center/student/search?q=' + this.search)
            }
        }
    }
</script>

<style>

</style>