<template>
    <div>
        <!-- // jumbotron -->
        <div class="jumbotron pt-4 pb-4 mb-0 bg-gradient-danger border-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent small p-0">
                                <li class="breadcrumb-item" aria-current="page">
                                    <router-link :to="{ name: 'help-center.index' }" class="text-white">Home</router-link>
                                </li>
                                <li class="breadcrumb-item active text-white" aria-current="page">{{category.name}}</li>
                            </ol>
                        </nav>
                        <div class="mt-5">
                            <h1 class="text-white">{{category.name}}</h1>
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

        <div class="container">
            <div class="row">
                <div class="col-lg-2 mt-4">
                    <div class="">
                        <h6><b>Student Topics</b></h6>
                        <div class="pt-3">
                            <ul class="list-unstyled small">
                                <li class="mb-3" v-for="cat in categories" :key="cat.id">
                                    <router-link :to="{ name: 'help-center.category', params: { slug: cat.slug } }" class="text-dark">
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
                <div class="col-lg-10 h-100">
                    <div class="border-left border-right border-bottom bg-white h-100">
                        <section class="section-sm" style="min-height: 400px;">
                            <div class="container">
                                <div class="ml-2">
                                    <div class="article">
                                        <h3 class="mb-0">{{post.title}}</h3>
                                        <h6 class="text-muted mt-2"><small><fa icon="clock" /> {{ post.created_at | moment('MMMM D, YYYY') }} &middot; <router-link :to="{ name: 'help-center.category', params: { slug: category.slug } }">{{category.name}}</router-link> </small></h6>
                                        <hr>
                                        <span v-html="post.body">{{post.body}}</span>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {

        layout: 'help-center',

        head() {
            return { title: `${this.post.title}` }
        },

        data: () => ({
            search: ''
        }),

        methods: {
            submit() {
                this.$router.push('/help-center/search?q=' + this.search)
            }
        },

        async asyncData({ params, error }) {
            try {
                let { data } = await axios.get(`/help-center/category/post/${params.categorySlug}/${params.postSlug}`)
                return {
                    category: data.category,
                    post: data.post,
                    categories: data.categories
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
    }
    .router-link-active {
        font-weight: 700;
    }
</style>