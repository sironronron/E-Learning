<template>
    <div>
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
                            <div class="border rounded bg-secondary p-3">
                                <h4>What will I learn?</h4>
                                <ul class="list-unstyled p-0 m-0 mt-4 align-items justify-content flex-wrap what-you-get-box">
                                    <template v-if="!isExpandedOutcome">                                        
                                        <li v-for="(outcome, index) in course.outcomes.slice(0, 5)" :key="outcome.id" class="mb-1">
                                            <div class="d-flex">
                                                <div>
                                                    <fa icon="check" class="text-success mr-2" />
                                                </div>
                                                <div>
                                                    {{outcome.description}}
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mt-2" v-if="course.outcomes.length > 5">
                                            <a href="#" @click.prevent="showOutcome"> <fa icon="plus" fixed-width /> &nbsp; Show More </a>
                                        </li>
                                    </template>
                                    <template v-else>
                                        <li v-for="outcome in course.outcomes" :key="outcome.id" class="mb-1">
                                            <div class="d-flex">
                                                <div>
                                                    <fa icon="check" class="text-success mr-2" />
                                                </div>
                                                <div>
                                                    {{outcome.description}}
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mt-2">
                                            <a href="#" @click.prevent="lessOutcome"><fa icon="minus" fixed-width /> &nbsp; Show Less</a>
                                        </li>                    
                                    </template>
                                </ul>
                            </div>

                            <!-- // Course Description -->
                            <div class="mt-5">
                                <h4>Description</h4>
                                <div class="mt-4">
                                    <read-more more-str="read more" less-str="read less" :max-chars="1000" :text="course.description"></read-more>
                                </div>
                                <h5 class="mt-5"><b>Who this course is for?</b></h5>
                                <ul>
                                    <li v-for="who in course.whos" :key="who.id">
                                        {{who.description}}
                                    </li>
                                </ul>
                            </div>

                            <div class="mt-5">
                                <h4>Course Content <span class="float-right text-muted"><small>220 Lectures</small></span></h4>
                                <!-- // Course Sections  -->
                                <div class="accordion mt-3" id="accordionExample">
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link text-muted text-capitalize" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    <fa icon="plus" fixed-width class="mr-2" />Collapsible Group Item #1
                                                </button>
                                            </h2>
                                        </div>

                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                            <div class="card-body">
                                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingTwo">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link collapsed text-muted text-capitalize" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    <fa icon="plus" fixed-width class="mr-2" />Collapsible Group Item #2
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                            <div class="card-body">
                                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingThree">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link collapsed text-muted text-capitalize" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                    <fa icon="plus" fixed-width class="mr-2" />Collapsible Group Item #3
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                            <div class="card-body">
                                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- // Course Tutor  -->

                            <div class="mt-5" id="course-instructor">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <cld-image v-if="course.user.photo_url != 'users/default.png'" :publicId="`${course.user.avatar_public_id}.png`">
                                            <cld-transformation height="130" width="130" crop="fill" radius="100" />
                                        </cld-image>
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
                                            <read-more more-str="read more" less-str="read less" :max-chars="500" :text="course.user.biography"></read-more>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <!-- // Card Course Video Overview -->
                        <div class="col-lg-4 hidden-xs-down">
                            <div class="sticky-top">
                                <div class="card shadow-sm mt---1">
                                    <div class="card-body p-0">
                                        <div class="preview-video-box">
                                            <vue-plyr>
                                                <div class="plyr__video-embed">
                                                    <!-- youtube div element -->
                                                    <client-only>
                                                        <vue-plyr v-if="course.course_overview_provider == 'Youtube'">
                                                            <div data-plyr-provider="youtube" autopause="true" :data-plyr-embed-id="course.course_overview_url"></div>
                                                        </vue-plyr>
                                                        <vue-plyr v-if="course.course_overview_provider == 'Vimeo'">
                                                            <div data-plyr-provider="vimeo" :data-plyr-embed-id="course.course_overview_url"></div>
                                                        </vue-plyr>
                                                        
                                                    </client-only>
                                                </div>
                                            </vue-plyr>
                                        </div>
                                        <div class="p-4">
                                            <div class="pricing">
                                                <h2 class="font-weight-500">
                                                    <client-only>
                                                        <div class="d-flex">
                                                            <div>
                                                                <span v-if="!course.has_discount">₱{{course.price | numeral('₱0,0.00')}}</span>
                                                                <span v-else>₱{{course.discount | numeral('₱0,0.00')}}</span>
                                                            </div>
                                                            <div v-if="course.has_discount" class="ml-2">
                                                                <strike class="text-muted small"><small>₱{{course.price | numeral('₱0,0.00')}}</small></strike>
                                                                <span class="text-danger small"><small>{{percentage}}% off</small></span>
                                                            </div>
                                                        </div>
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
                                <div class="border rounded bg-secondary p-3 mt-4">
                                    <h4>Requirements</h4>
                                    <ul class="list-unstyled p-0 m-0 mt-4 align-items justify-content flex-wrap what-you-get-box">
                                        <li v-for="requirement in course.requirements" :key="requirement.id" class="">
                                            <div class="d-flex">
                                                <div>
                                                    <fa icon="check-circle" class="text-muted mr-2" />
                                                </div>
                                                <div>
                                                    {{requirement.description}}
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
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
            isModalVisible: false,
            isExpandedOutcome: false
        }),      

        async asyncData({ params, error }) {
            try {
                let { data } = await axios.get(`/course/${params.slug}`)
                return {
                    course: data.course,
                    percentage: ((1 - (data.course.discount / data.course.price)) * 100).toFixed(0)
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
            },
            showOutcome() {
                this.isExpandedOutcome = true
            },
            lessOutcome() {
                this.isExpandedOutcome = false
            },
        },

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
        margin-top: -95%;
    }
    .sticky-top {
        z-index: 0 !important;
    }
</style>