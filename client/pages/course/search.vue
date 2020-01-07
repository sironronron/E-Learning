<template>
    <div>

        <!-- // Filters -->
        <div class="jumbotron bg-secondary mb-0 rounded p-4">
            <div class="container">
                <div class="p-2">
                    <h5>{{searchResults.length}} results for <strong>{{searchQuery}}</strong></h5>
                    <div class="mt-3">
                        <div class="row">
                            <!-- // Star and Duration Filter  -->
                            <div class="col-lg-6">
                                <div class="d-flex justify-content-start">
                                    <div class="dropdown">
                                        <button class="btn btn-neutral dropdown-toggle text-capitalize text-dark font-weight-400" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-top: 2px solid #f4c150;">
                                            Ratings
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-left dropdown-menu-ratings">
                                            
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-neutral dropdown-toggle text-capitalize text-dark font-weight-400" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-top: 2px solid #cc87b4;">
                                            Duration
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-left dropdown-menu-ratings">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- // Advance Filters -->
                            <div class="col-lg-6">
                                <div class="d-flex justify-content-end">
                                    <div class="dropdown">
                                        <button class="btn btn-neutral dropdown-toggle text-capitalize text-dark font-weight-400" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            All Filters
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-ratings">
                                            
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-neutral dropdown-toggle text-capitalize text-dark font-weight-400" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Sort
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-ratings">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <section class="section-sm">
            <div class="container">
                
                <div class="row">
                    <div class="col-lg-9">
                        <!-- <h5>Explore <b class="text-default">Web Development</b></h5> -->
                        <!-- <h5 class="mb-0">{{searchResults.length}} results for <b>{{searchQuery}}</b></h5> -->
                        <hr class="mb-0 mt-0">
                        <div v-if="searchResults.length != 0">
                            <!-- // Main Search  -->
                            <div v-for="(group) in groups" :key="group.id">
                                <div v-for="(item, key) in group.slice(0, 6)" :key="key">
                                    <div v-if="item.type === 'courses'" class="search_body pt-2 pb-5 pl-2 pr-3 border-bottom">
                                        <router-link :to="{ name: 'course.show', params: { slug: item.searchable.slug } }">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <img :src="item.searchable.image" class="search_image img-fluid" alt="">
                                                </div>
                                                <div class="col-lg-7">
                                                    <h5 class="mb-0 font-weight-600">{{item.title}}</h5>
                                                    <div class="rating-row">
                                                        <span class="course-badge best-seller mr-2">{{item.searchable.level}}</span>
                                                        <small>
                                                            <span class="d-inline-block average-rating text-dark mr-2"></span>
                                                            <span class="text-dark mr-2"></span>
                                                            <span class="enrolled-num">
                                                            </span>
                                                        </small>
                                                    </div>
                                                    <h6 class="text-muted mt-1"><small>{{item.searchable.excerpt}}</small></h6>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="float-right">
                                                        <div v-if="item.searchable.has_discount == 0">
                                                            <h5 class="font-weight-bold text-right">₱{{item.searchable.price | numeral('0,0.00')}}</h5>
                                                        </div>
                                                        <div v-if="item.searchable.has_discount == 1">
                                                            <h5 class="font-weight-bold text-right">₱{{item.searchable.discount | numeral('0,0.00')}}</h5>
                                                            <h6 class="text-muted float-right"><strike>₱{{item.searchable.price | numeral('0,0.00')}}</strike></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </router-link>
                                    </div>
                                </div>
                            </div>

                            <!-- // For beginners -->
                            <div class="mt-5">
                                <h4>Courses for Beginners</h4>
                                <client-only>
                                    <carousel :paginationEnabled="false" :perPage="4" :loop="false">
                                        <slide v-for="(course, key) in forBeginners" :key="key" style="margin-right: 10px;" class="py-3">
                                            <router-link :to="{ name: 'course.show', params: { slug: course.slug } }">
                                                <div class="card border shadow-sm shadow--hover rounded">
                                                    <img :src="course.image" class="card-img-top border-bottom" alt="">
                                                    <div class="card-body py-3">
                                                        <div class="grid-course-name">
                                                            <h6 class="text-capitalize">
                                                                <strong>{{course.title}}</strong>
                                                            </h6>
                                                        </div>
                                                        <p class="mt-1 mb-1 small text-muted">{{course.user.name}}</p>
                                                        <div class="rating">
                                                            <fa icon="star" fixed-width style="color: #f4c150" />
                                                            <fa icon="star" fixed-width style="color: #f4c150" />
                                                            <fa icon="star" fixed-width style="color: #f4c150" />
                                                            <fa icon="star" fixed-width style="color: #f4c150" />
                                                            <fa icon="star" fixed-width style="color: #f4c150" />
                                                        </div>
                                                        <div class="price float-right">
                                                            <template v-if="course.free_course != 1">
                                                                <h6 class="mt-3" v-if="course.has_discount == 1"><small class="text-muted"><strike>₱{{course.price}}</strike> </small>&nbsp; <b>₱{{course.discount}}</b> </h6>
                                                                <h6 class="mt-3" v-else>
                                                                    <client-only>
                                                                        ₱<b>{{course.price | numeral('0,0')}}</b>
                                                                    </client-only>
                                                                </h6>
                                                            </template>
                                                            <template v-else>													
                                                                <h6 class="mt-3">Free Course</h6>
                                                            </template>
                                                        </div>
                                                    </div>
                                                </div>
                                            </router-link>
                                        </slide>
                                    </carousel>
                                </client-only>
                            </div>

                            <!-- // Continuation -->
                            <div class="mt-5" v-for="(group) in groups" :key="group.id">
                                <div v-for="(item, key) in group" :key="key">
                                    <div v-if="item.type === 'courses'" class="search_body pt-2 pb-5 pl-2 pr-3 border-bottom">
                                        <router-link :to="{ name: 'course.show', params: { slug: item.searchable.slug } }">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <img :src="item.searchable.image" class="search_image img-fluid" alt="">
                                                </div>
                                                <div class="col-lg-7">
                                                    <h5 class="mb-0 font-weight-600">{{item.title}}</h5>
                                                    <div class="rating-row">
                                                        <span class="course-badge best-seller mr-2">{{item.searchable.level}}</span>
                                                        <small>
                                                            <span class="d-inline-block average-rating text-dark mr-2"></span>
                                                            <span class="text-dark mr-2"></span>
                                                            <span class="enrolled-num">
                                                            </span>
                                                        </small>
                                                    </div>
                                                    <h6 class="text-muted mt-1"><small>{{item.searchable.excerpt}}</small></h6>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="float-right">
                                                        <div v-if="item.searchable.has_discount == 0">
                                                            <h5 class="font-weight-bold text-right">₱{{item.searchable.price | numeral('0,0.00')}}</h5>
                                                        </div>
                                                        <div v-if="item.searchable.has_discount == 1">
                                                            <h5 class="font-weight-bold text-right">₱{{item.searchable.discount | numeral('0,0.00')}}</h5>
                                                            <h6 class="text-muted float-right"><strike>₱{{item.searchable.price | numeral('0,0.00')}}</strike></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </router-link>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div v-else class="mt-5">
                            <h3>Sorry, we couldn't find any results for "{{searchQuery}}"</h3>
                            <h5 class="mt-4">Try adjusting your search. Here are some ideas:</h5>
                            <ul class="mt-3 pl-3">
                                <li>Make sure all words are spelled correctly.</li>
                                <li>Try different search terms.</li>
                                <li>Try more general search terms.</li>
                            </ul>
                        </div>
                        
                    </div>
                    <div class="col-lg-3">
                        <!-- // Money Back Guarantee -->
                        <div class="pt-4 pb-2 px-4 border rounded">
                            <h6><b><fa icon="calendar-alt" class="text-info" /> &nbsp; Not Sure?</b></h6>
                            <p>Every course comes with a 30-day money-back-guarantee</p>
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

        head() {
            return { title: `Searched for "${this.searchQuery}"`}
        },

        watchQuery: ['q'],

        async asyncData({query, error}) {
            try {
                let { data } = await axios.get('/search_query?q=' + query.q)
                return {
                    searchResults: data.searchResults,
                    searchQuery: query.q,
                    forBeginners: data.forBeginners
                }
            } catch (e) {
                error({ statusCode: 500, message: 'Something went wrong!' })
            }
        },

        computed: {
            groups() {
                return groupBy(this.searchResults, 'groupName')
            }
        }

    }

    function groupBy(array, key) {
        const result = {}
        array.forEach(item => {
            if (!result[item[key]]) {
                result[item[key]] = []
            }
            result[item[key]].push(item)
        })
        return result
    }

</script>

<style lang="scss" scoped>
    hr {
        border-top: 0.25rem solid rgba(0, 0, 0, 0.1);
    }

    .search {
        &_image {
            width: 210px;
            height: 118px;
            object-fit: cover;
        }
        &_body {
            cursor: pointer;
        }
        &_body:hover {
            background: whitesmoke;
        }
    }
    .course-header-wrap .course-badge {
        font-size: 9px !important;
    }
    .course-badge.best-seller {
        background: #f4c150;
    }
    .course-header-wrap > div > span {
        margin-right: 12px;
        margin-bottom: 7px;
        font-size: 15px;
    }
    .course-badge {
        color: #29303b;
        box-shadow: 0 0 1px 1px rgba(20,23,28,.1), 0 3px 1px 0 rgba(20,23,28,.1);
        pointer-events: none;
        border-radius: 3px;
        font-size: 9px;
        padding: 1px 8px;
        font-weight: 700;
        position: relative;
        line-height: 1.5;
        text-align: center;
        text-transform: uppercase;
        display: inline-block;
    }
    .course-badge:after {
        border-radius: 3px;
        right: -4px;
        background: inherit;
        content: "";
        height: 11px;
        position: absolute;
        top: 2px;
        transform: rotate(45deg);
        width: 11px;
        z-index: 0;
        display: block;
    }
    .dropdown-menu-ratings {
        width: 253px;
    }
</style>