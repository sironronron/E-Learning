<template>
    <div>
        <template v-if="!isLoading">
            <div v-if="courses.length != 0">
                <div v-for="(item, key) in courses.data" :key="key">
                    <div class="search_body pt-2 pb-5 pl-2 pr-3 border-bottom">
                        <router-link :to="{ name: 'course.show', params: { slug: item.slug } }">
                            <div class="row">
                                <div class="col-lg-3">
                                    <img :src="item.image" class="search_image img-fluid" alt="">
                                </div>
                                <div class="col-lg-7">
                                    <h5 class="mb-0 font-weight-600">{{item.title}}</h5>
                                    <div class="rating-row">
                                        <span class="course-badge best-seller mr-2">{{item.level}}</span>
                                        <small>
                                            <span class="d-inline-block average-rating text-dark mr-2"></span>
                                            <span class="text-dark mr-2"></span>
                                            <span class="enrolled-num">
                                            </span>
                                        </small>
                                    </div>
                                    <h6 class="text-muted mt-1"><small>{{item.excerpt}}</small></h6>
                                </div>
                                <div class="col-lg-2">
                                    <div class="float-right">
                                        <div v-if="item.has_discount == 0">
                                            <h5 class="font-weight-bold text-right">₱{{item.price | numeral('0,0.00')}}</h5>
                                        </div>
                                        <div v-if="item.has_discount == 1">
                                            <h5 class="font-weight-bold text-right">₱{{item.discount | numeral('0,0.00')}}</h5>
                                            <h6 class="text-muted float-right"><strike>₱{{item.price | numeral('0,0.00')}}</strike></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </router-link>
                    </div>
                </div>
                <div class="d-block">
                    <div>
                        <pagination class="justify-content-center mt-4" :data="courses" @pagination-change-page="getAllCourses" :showDisabled="true" :limit="10" align="center"></pagination>
                    </div>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="py-5 text-center">
				<img src="https://res.cloudinary.com/dl9phqhv0/image/upload/v1574394025/Loader/ajax-loader_sln1xw.gif" alt="">
			</div>
        </template>
    </div>
</template>

<script>
    import axios from 'axios'
    import Pagination from 'laravel-vue-pagination'

    export default {

        components: {
            Pagination
        },

        data: () => ({
            courses: [],
            isLoading: false
        }),

        created() {
            this.getAllCourses()
        },

        methods: {
            getAllCourses(page = 1) {
                this.isLoading = true
                axios.get(`/course/category/${this.$route.params.slug}?page=` + page)
                .then((res) => {
                    this.isLoading = false
                    this.courses = res.data.courses
                }).catch((err) => {
                    console.log(err)
                })
            }
        }

    }

</script>

<style lang="scss" scoped>
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