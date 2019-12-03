<template>
    <div>
        <client-only>
			<offline-alert/>
		</client-only>
        <!-- // jumbotron -->
        <div class="jumbotron mb-0 bg-gradient-default">
            <section class="section-sm">
                <div class="container">
                    <div class="row">
                        <!-- Course Overview -->
                        <div class="col-lg-8 h-100">
                            <div style="height: 220px;">
                                <h1 class="text-white font-weight-500">{{course.title}}</h1>
                                <h4 class="text-white font-weight-300 mt-2">{{course.excerpt}}</h4>
                                <div class="rating-row">
                                    <span class="course-badge best-seller mr-2">{{course.level}}</span>
                                    <fa icon="star" fixed-width style="color: #f4c150" />
                                    <fa icon="star" fixed-width style="color: #f4c150" />
                                    <fa icon="star" fixed-width style="color: #f4c150" />
                                    <fa icon="star" fixed-width style="color: #f4c150" />
                                    <fa icon="star" fixed-width style="color: whitesmoke" />
                                    <small>
                                        <span class="d-inline-block average-rating text-white mr-2">4</span><span class="text-white mr-2">(2 Ratings)</span>
                                        <span class="enrolled-num text-white">
                                            3 Students enrolled
                                        </span>
                                    </small>
                                </div>
                                <div class="created-row mt-2">
                                    <small>
                                        <span class="created-by text-white">
                                            Created by
                                            <router-link :to="{ name: 'course.instructor.show', params: { username: course.user.username } }">
                                                {{course.user.name}}
                                            </router-link>
                                        </span>
                                        <span class="last-updated-date text-white ml-2">Last updated {{course.updated_at | moment(' L')}}</span>
                                        <span class="comment text-white"><fa icon="comment" class="mr-1 ml-2" />English</span>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- // Main Course -->
        <section class="section-sm">
            <div class="container">
                <div class="row">
                    <!-- // More Course Information -->
                    <div class="col-lg-8">  

                        <!-- // What Will I learn? -->
                        <div class="border rounded bg-secondary p-3">
                            <h4>What will I learn?</h4>
                            <ul class="list-unstyled p-0 m-0 mt-4 align-items justify-content flex-wrap what-you-get-box">
                                <li v-for="outcome in course.outcomes" :key="outcome.id" class="small mb-3">
                                    <div class="row">
                                        <div class="col-lg-auto">
                                            <fa icon="check-circle" class="text-success" />
                                        </div>
                                        <div class="col-lg-11">
                                            {{outcome.description}}
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- // Course Description -->
                        <div class="mt-4">
                            <h4>Description</h4>
                            <div v-html="course.description" class="mt-4">
                                {{course.description}}
                            </div>
                            <h5 class="mt-5"><b>Who this course is for?</b></h5>
                            <ul>
                                <li v-for="who in course.whos" :key="who.id">
                                    {{who.description}}
                                </li>
                            </ul>
                        </div>

                        <!-- // Featured Review -->
                        <!-- <div class="border rounded bg-secondary p-3 mt-4">
                            <h4>Featured Review</h4>

                        </div> -->


                    </div>
                    <!-- // Card Course Video Overview -->
                    <div class="col-lg-4">
                        <div class="card shadow-sm mt---1">
                            <div class="card-body p-0">
                                <div class="preview-video-box">
                                    <a href="#" data-toggle="modal" data-target="#videoModal">
                                        <vue-plyr>
                                            <video :poster="course.image">
                                            </video>
                                        </vue-plyr>
                                    </a>
                                </div>
                                <div class="p-4">
                                    <div class="pricing">
                                        <h2 class="font-weight-500">
                                            <client-only>
                                                ₱{{course.price | numeral('₱0,0.00')}}
                                            </client-only>
                                        </h2>
                                    </div>
                                    <div class="mt-4">
                                        <button class="btn btn-danger btn-lg text-capitalize btn-block">
                                            Buy Now
                                        </button>
                                        <button class="btn btn-outline-neutral btn-lg text-capitalize btn-block text-dark border">
                                            Add to cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- // What Will I learn? -->
                        <div class="border rounded bg-secondary p-3 mt-4 sticky-top" style="top: 5rem">
                            <h4>Requirements</h4>
                            <ul class="list-unstyled p-0 m-0 mt-4 align-items justify-content flex-wrap what-you-get-box">
                                <li v-for="requirement in course.requirements" :key="requirement.id" class="small mb-3">
                                    <div class="row">
                                        <div class="col-lg-auto">
                                            <fa icon="check-circle" class="text-muted" />
                                        </div>
                                        <div class="col-lg-11">
                                            {{requirement.description}}
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- // Might Like Courses -->
        <section class="section-sm bg-secondary">
            <div class="container">

                <might-likes></might-likes>

            </div>
        </section>

        <!-- // Modal Dialog -->
        <div class="modal fade bg-dark" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{course.title}} Overview</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <vue-plyr>
                            <div class="plyr__video-embed">
                                <iframe
                                    :src="course.course_overview_url" allowfullscreen allowtransparency>
                                </iframe>
                            </div>
                        </vue-plyr>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import axios from 'axios'
    import MightLikes from '../../components/global/MightLike'

    export default {
        
        components: {
            MightLikes
        },
    
        layout: 'default',

        head() {
            return { title: this.course.title }
        },

        data: () => ({
            isModalVisible: false
        }),      

        async asyncData({ params, error }) {
            try {
                let { data } = await axios.get(`/course/${params.slug}`)
                return {
                    course: data.course
                }
            } catch (e) {
                error({ statusCode: 500, message: 'Something went wrong!' })
            }
        },

        methods: {
            showModal() {
                this.isModalVisible = true
            },
            closeModal() {
                this.isModalVisible = false
            }
        }
    }

</script>

<style scoped>
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
    .course-header-wrap > div > span {
        margin-right: 12px;
        margin-bottom: 7px;
        font-size: 15px;
    }
    .course-sidebar {
        background-color: #fff;
        box-shadow: 0 0 1px 1px rgba(20,23,28,.1), 0 3px 1px 0 rgba(20,23,28,.1);
        border-radius: 4px;
        color: #505763;
        padding: 3px;
        position: relative;
        margin-top: -250px;
        z-index: 10;
    }
    .what-you-get-box ul li:before {
        font-family: Font Awesome\ 5 Free;
        font-weight: 900;
        -moz-osx-font-smoothing: grayscale;
        -webkit-font-smoothing: antialiased;
        display: inline-block;
        font-style: normal;
        font-variant: normal;
        text-rendering: auto;
        line-height: 1;
        content: "\f00c";
        color: #a1a7b3;
        font-size: 14px;
        position: absolute;
        left: 0;
        top: 4px;
    }
    .what-you-get-box ul {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
    }
    .mt---1 {
        margin-top: -87%;
    }
</style>