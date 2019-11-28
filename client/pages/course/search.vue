<template>
    <div>
        
        <section class="section-sm">
            <div class="container">
                
                <div class="row">
                    <div class="col-lg-9">
                        <!-- <h5>Explore <b class="text-default">Web Development</b></h5> -->
                        <h5 class="mb-0">{{searchResults.length}} results for <b>{{searchQuery}}</b></h5>
                        <hr class="mb-0">
                        <div v-if="searchResults.length != 0">
                            <div v-for="(group) in groups" :key="group.id">
                                <div v-for="item in group" :key="item.id">
                                    <div v-if="item.type === 'courses'" class="search_body pt-2 pb-5 pl-2 pr-3 border-bottom">
                                        <router-link :to="{ name: 'course.show', params: { slug: item.searchable.slug } }">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <img :src="item.searchable.image" class="search_image" alt="">
                                                </div>
                                                <div class="col-lg-6">
                                                    <h5 class="mb-0">{{item.title}}</h5>
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
                                                <div class="col-lg-3">
                                                    <div class="float-right">
                                                        <div v-if="item.searchable.has_discount == 0">
                                                            <h5>₱{{item.searchable.price | numeral('0,0.00')}}</h5>
                                                        </div>
                                                        <div v-if="item.searchable.has_discount == 1">
                                                            <h5>₱{{item.searchable.discount | numeral('0,0.00')}}</h5>
                                                            <h6 class="text-muted float-right"><strike>₱{{item.searchable.count | numeral('0,0.00')}}</strike></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">

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
                    searchQuery: query.q
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
</style>