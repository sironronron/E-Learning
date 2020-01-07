<template>
    <div>
        <div>
            <client-only>
                <offline-alert/>
            </client-only>

            <!-- // jumbotron -->
            <div class="jumbotron mb-0 bg-dark">
                <section class="">
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
                                                <a href="#course-instructor" :to="{ name: 'course.instructor.show', params: { username: course.user.username } }">
                                                    {{course.user.name}}
                                                </a>
                                            </span>
                                            <span class="last-updated-date text-white ml-2">Last updated {{course.updated_at | moment(' L')}}</span>
                                            <span class="comment text-white"><fa icon="language" class="mr-1 ml-2" />English</span>
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
                            <div class="course__outcome">
                                <div class="course__outcome--title">
                                    What will I learn?
                                </div>
                                <template v-if="!isExpandedOutcome">
                                    <ul class="course__outcome--items mt-4">
                                        <li v-for="(item, key) in course.outcomes.slice(0, 6)" :key="key">
                                            {{item.description}}
                                        </li>
                                    </ul>
                                    <div class="mt-2" v-if="course.outcomes.length > 6">
                                        <a href="#" @click.prevent="showOutcome"> <fa icon="plus" fixed-width /> &nbsp; Show More </a>
                                    </div>
                                </template>

                                <template v-else>
                                    <ul class="course__outcome--items mt-4">
                                        <li v-for="(outcome, key) in course.outcomes" :key="key">
                                            {{outcome.description}}
                                        </li>
                                    </ul>
                                    <div class="mt-2">
                                        <a href="#" @click.prevent="lessOutcome"><fa icon="minus" fixed-width /> &nbsp; Show Less</a>
                                    </div>                    
                                </template>
                            </div>

                            <!-- // Course Requirements and For who -->
                            <div class="mt-5">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h4>Who this course is for?</h4>
                                        <div class="mt-4">
                                            <ul class="pl-3 text-justify">
                                                <li v-for="who in course.whos" :key="who.id">
                                                    {{who.description}}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <h4>Requirements</h4>
                                        <div class="mt-4">
                                            <ul class="pl-3 text-justify">
                                                <li v-for="(item, key) in course.requirements" :key="key">
                                                    {{item.description}}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>             
                            </div>

                            <!-- // Course Description -->
                            <div class="mt-5">
                                <h4>Description</h4>
                                <div class="mt-4">
                                    <client-only>
                                        <read-more more-str="read more" less-str="read less" :max-chars="1000" :text="course.description"></read-more>
                                    </client-only>
                                </div>
                            </div>

                            <!-- // Might Like Courses -->
                            <div class="mt-5" v-if="mightLikes.length != 0">
                                <h4>You might like</h4>
                                <hr class="mb-0 mt-3" style="border-top: 0.25rem solid rgba(0, 0, 0, 0.1);">
                                <div v-for="(item, key) in mightLikes" :key="key" class="search_body py-2 pl-2 pr-3 border-bottom">
                                    <router-link :to="{ name: 'course.show', params: { slug: item.slug } }">
                                        <div class="row">
                                            <div class="col-lg-auto">
                                                <client-only>
                                                    <cld-image :publicId="`${item.image_public_id}.png`" alt="" >
                                                        <cld-transformation height="70" width="125" crop="fill" />
                                                    </cld-image>
                                                </client-only>
                                            </div>
                                            <div class="col-lg-5">
                                                <h6 class="mb-0 font-weight-600">{{item.title}}</h6>
                                                <h6 class="text-muted mt-1"><small>Updated {{item.updated_at | moment(' L')}}</small></h6>
                                            </div>
                                            <div class="col-lg-1">
                                                <h6 class="mb-0"><fa icon="star" fixed-width style="color: #f4c150" /> 4.4</h6>
                                            </div>
                                            <div class="col-lg-1">
                                                <h6 class="mb-0"><fa icon="user" fixed-width class="text-muted" /> 350</h6>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="float-right">
                                                    <div v-if="item.has_discount == 0">
                                                        <h6 class="font-weight-bold text-right">₱{{item.price | numeral('0,0.00')}}</h6>
                                                    </div>
                                                    <div v-if="item.has_discount == 1">
                                                        <h6 class="font-weight-bold text-right">₱{{item.discount | numeral('0,0.00')}}</h6>
                                                        <h6 class="text-muted float-right"><strike>₱{{item.price | numeral('0,0.00')}}</strike></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </router-link>
                                </div>
                            </div>

                            <!-- // Course content -->
                            <div class="mt-5 course-curriculum-box">
                                <div class="course-curriculum-title clearfix">
                                    <div class="title float-left">Curriculum for this course</div>
                                    <div class="float-right m-t-5">
                                        <span @click="toggle" class="collapse-all" style="cursor: pointer;" v-if="!show">
                                            Expand All
                                        </span>
                                        <span @click="toggle" class="collapse-all" style="cursor: pointer;" v-else>
                                            Collapse All
                                        </span>
                                        <span class="total-lectures">
                                            {{countLessons}} Lessons              
                                        </span>
                                        <span class="total-time">
                                            {{duration}} Hours              
                                        </span>
                                    </div>
                                </div>
                                <!-- // Course Curriculum Accordion -->
                                <div class="course__curriculum-accordion">
                                    <div class="lecture__group-wrapper">
                                        <div v-for="(item, index) in sections" :key="`${index}-section`" >
                                            <!-- // Lecture -->
                                            <div class="lecture__group-title clearfix" :aria-expanded="show ? 'true' : 'false'">
                                                <!-- // Lesson Title -->
                                                <div class="title float-left">
                                                    <!-- <fa icon="plus" fixed-width class="text-primary font-weight-300" /> -->
                                                    {{ item.title }}
                                                </div>
                                                <!-- // Lesson Data -->
                                                <div class="float-right">
                                                    <span class="total-lectures">
                                                        {{ item.lessons.length }} Lessons
                                                    </span>
                                                    <span class="total-time">
                                                        00:15:00 Hours
                                                    </span>
                                                </div>
                                            </div>
                                            <!-- // Lectures -->
                                            <div class="lecture-list">
                                                <ul class="list-unstyled mb-0">
                                                    <li v-for="(lesson, index) in item.lessons" :key="`${index}-lesson`" class="lecture has-preview" v-show="show">
                                                        <span class="lecture-title">{{ lesson.title }}</span>
                                                        <span class="lecture-time float-right">{{ lesson.duration }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- // Course Tutor  -->
                            <div class="mt-5" id="course-instructor">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <template v-if="course.user.photo_url != 'users/default.png'" >
                                            <client-only>
                                                <cld-image :publicId="`${course.user.avatar_public_id}.png`" alt="" >
                                                    <cld-transformation height="130" width="130" crop="fill" radius="100" />
                                                </cld-image>
                                            </client-only>
                                        </template>
                                        
                                        <img v-if="course.user.photo_url == 'users/default.png'" :src="course.user.photo_url" class="rounded-circle img-fluid course__user-img" alt="">

                                        <ul class="list-unstyled mt-3">
                                            <li class=" mb-1"><fa icon="star" fixed-width /> <b>4.5</b> Instructor rating</li>
                                            <li class=" mb-1"><fa icon="comment" fixed-width /> <b>160,475</b> Reviews</li>
                                            <li class=" mb-1"><fa icon="user" fixed-width /> <b>644,590</b> Students</li>
                                            <li class=""><fa icon="play-circle" fixed-width /> <b>51</b> Courses</li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-8">
                                        <h5 class="mt-2 mb-1"><b>{{course.user.name}}</b></h5>
                                        <h6 class="text-dark">{{course.user.introduction}}</h6>
                                        <div class="mt-3">
                                            <client-only>
                                                <read-more v-if="course.user.biography" more-str="read more" less-str="read less" :max-chars="500" :text="course.user.biography"></read-more>
                                            </client-only>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <!-- // Card Course Video Overview -->
                        <div class="col-lg-4 hidden-xs-down">
                            <div class="sticky-top">
                                <div class="card shadow-sm" style="margin-top: -335px;">
                                    <div class="card-body p-0">
                                        <div class="preview-video-box">
                                            <a href="#" @click="openPlayerModal">
                                                <img :src="course.image" class="img-fluid" style="width: 100%; height: 215px;" alt="">
                                            </a>
                                        </div>
                                        <div class="p-4">
                                            <div class="pricing">
                                                <h2 class="font-weight-500">
                                                <div class="d-flex">
                                                    <div>
                                                        <client-only>
                                                            <span v-if="!course.has_discount">₱{{course.price | numeral}}</span>
                                                            <span v-else>₱{{course.discount | numeral}}</span>
                                                        </client-only>
                                                    </div>
                                                    <div v-if="course.has_discount" class="ml-2">
                                                        <client-only>
                                                            <strike class="text-muted small"><small>₱{{course.price | separator }}</small></strike>
                                                            <span class="text-danger small"><small>{{percentage}}% off</small></span>
                                                        </client-only>
                                                    </div>
                                                </div>
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
                            </div>
                           
                        </div>
                    </div>
                </div>
            </section>

            <transition name="fade" mode="out-in">
                <video-plyr v-if="isModalVisible" @close="closePlayerModal"></video-plyr>
            </transition>

        </div>

    </div>
</template>

<script>
    let myBody = null

    import axios from 'axios'
    import MightLikes from '../../components/global/MightLike'
    import VideoPlyr from '../../components/courses/show/video-plyr'

    if (process.client) {
        let Youtube = document.createElement('script')
        Youtube.setAttribute('src', "https://www.youtube.com/iframe_api")
    }

    export default {
        
        components: {
            MightLikes, VideoPlyr
        },
    
        layout: 'default',

        head() {
            return { title: this.course.title }
        },

        data: () => ({
            isModalVisible: false,
            isExpandedOutcome: false,
            MightLikes: [],
            show: false
        }),      

        async asyncData({ params, error }) {
            try {
                let { data } = await axios.get(`/course/${params.slug}`)
                return {
                    course: data.course,
                    percentage: ((1 - (data.course.discount / data.course.price)) * 100).toFixed(0),
                    mightLikes: data.mightLikes,
                    sections: data.sections,
                    countLessons: data.countLessons,
                    duration: data.totalDuration
                }
            } catch (e) {
                error({ statusCode: 500, message: 'Something went wrong!' })
            }
        },

        methods: {
            showOutcome() {
                this.isExpandedOutcome = true
            },
            lessOutcome() {
                this.isExpandedOutcome = false
            },

            // Open Video Player Modal
            openPlayerModal() {
                this.isModalVisible = true

                // Add class to body
                myBody.classList.toggle('modal-open')
            },
            closePlayerModal() {
                this.isModalVisible = false
                myBody.classList.remove('modal-open')
            },

            toggle() {
                this.show = !this.show
            }
        },

        mounted () {
            myBody = document.getElementsByTagName('body')[0]
        }

    }

</script>

<style lang="scss" scoped>
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
    .mt---1 {
        margin-top: -95%;
    }
    .sticky-top {
        z-index: 0 !important;
    }
    .search {
        &_image {
            width: 125px;
            height: 70px;
            object-fit: cover;
        }
        &_body {
            cursor: pointer;
        }
        &_body:hover {
            background: whitesmoke;
        }
    }
</style>