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
                                    <router-link :to="{ name: 'help-center.student' }" class="text-white">Home</router-link>
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

        <section class="section-sm">
            <div class="container">

                <div class="row">
                    <div class="col-lg-9">
                        <!-- // Search Results -->
                        <h4 class="font-weight-300">You searched for - "{{searchQuery}}"</h4>
                        <template v-if="searchResults.length != 0">
                            <div v-for="(group) in groups" :key="group.id">
                                <ul class="list-unstyled mt-3">
                                    <li v-for="item in group" :key="item.id">
                                        <router-link :to="{ name: 'help-center.student.category.post', params: { categorySlug: item.searchable.category_id, postSlug: item.searchable.slug } }" class="btn btn-link p-0 font-weight-400 text-capitalize">{{item.title}}</router-link>
                                    </li>
                                </ul>
                            </div>
                        </template>
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
            return { title: `Searched for ${this.searchQuery}` }
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
                this.$router.push('/help-center/student/search?q=' + this.search)
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

<style>

</style>