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

        <section class="section-sm">
            <div class="container">

                <div class="row">
                    <!-- // Sidebar -->
                    <div class="col-12 col-xl-2">
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
                    <!-- // Main Content -->
                    <div class="col-12 col-xl-10">
                        <card class="p-3 main-content border h-100 h-100vh">
                            <h4 class="font-weight-300">{{category.name}} - General</h4>
                            <template v-if="posts.length != 0">
                                <div>
                                    <ul class="list-unstyled mt-3">
                                        <li v-for="(item, key) in posts" :key="key">
                                            <router-link :to="{ name: 'help-center.student.category.post', params: { categorySlug: category.id, postSlug: item.slug } }" class="btn btn-link p-0 font-weight-400 text-capitalize">{{item.title}}</router-link>
                                        </li>
                                    </ul>
                                </div>
                            </template>
                            <template v-else>
                                <div>
                                    <p class="mt-3">There's no articles.</p>
                                </div>
                            </template>
                        </card>
                    </div>

                </div>

            </div>
        </section>

    </div>
</template>

<script>
    import axios from 'axios'

    export default {

        head() {
            return { title: `${this.category.name}` }
        },

        data: () => ({
            search: ''
        }),

        methods: {
            submit() {
                this.$router.push('/help-center/student/search?q=' + this.search)
            }
        },

        async asyncData({params}) {
            try {
                let { data } = await axios.get(`/help-center/category/${params.slug}`)
                return {
                    categories: data.categories,
                    category: data.category,
                    posts: data.posts
                }
            } catch (e) {
                return 
            }
        },
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
    .breadcrumb-item + .breadcrumb-item::before {
        color: #ffffff;
    }
    .main-content {
        margin-top: -33px;
        margin-bottom: -33px; 
        height: 100%;
    }
</style>