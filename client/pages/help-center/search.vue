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
                                <li class="breadcrumb-item active text-white" aria-current="page">Searched for - '{{searchQuery}}'</li>
                            </ol>
                        </nav>
                        <div class="mt-5">
                            <h1 class="text-white">Searched for - '{{searchQuery}}' </h1>
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
                                <div class="ml-2" v-if="searchResults.length != 0">
                                    <div v-for="(group) in groups" :key="group.id">
                                        <div v-for="item in group" :key="item.id">
                                            <div class="article">
                                                <h5>{{item.searchable.title}}</h5>
                                                <h6 class="text-muted mt-2"><small><fa icon="clock" /> {{ item.searchable.created_at | moment('MMMM D, YYYY') }}</small></h6>
                                                <h6 class="mt-4 mb-5">
                                                    {{item.searchable.excerpt}}
                                                </h6>
                                                <h6>
                                                    <router-link :to="{ name: 'help-center.post', params: { categorySlug: item.searchable.category_id, postSlug: item.searchable.slug } }" class="btn btn-outline-default text-capitalize btn-sm">
                                                        Read More
                                                    </router-link>
                                                </h6>
                                                <hr style="margin-left: -15px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-else class="row justify-content-center align-items-center">
                                    <div class="col-lg-6">
                                        <div class="text-center">
                                            <svg width="100" height="100"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <image xlink:href="https://res.cloudinary.com/dl9phqhv0/image/upload/c_scale,h_100/v1574303740/Logos/search_fi9mlk.svg" width="100" height="100"/>
                                            </svg>
                                            <h4 class="mt-3">No Results found for "{{searchQuery}}"</h4>
                                        </div>
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

        scrollToTop: false,
        
        head() {
            return { title: 'Searched for' + this.searchQuery }
        },

        data: () => ({
            search: '',
            isLoading: false
        }),

        watchQuery: ['q'],

        async asyncData({query, error}) {
            try {
                let { data } = await axios.get('/help-center/search?q=' + query.q)
                return {
                    categories: data.categories,
                    searchResults: data.searchResults,
                    searchQuery: query.q
                }
            } catch (e) {
                error({ statusCode: 500, message: 'Something went wrong!' })
            }
        },

        methods: {
            submit() {
                this.$router.push('/help-center/search?q=' + this.search)
            }
        },

        computed:{
            groups() {
                return groupBy(this.searchResults, 'groupName')
            }
        }

    }

    function groupBy(array, key){
        const result = {}
        array.forEach(item => {
            if (!result[item[key]]){
                result[item[key]] = []
            }
            result[item[key]].push(item)
        })
        return result
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
</style>