<template>
    <div>
        <client-only>
			<offline-alert/>
		</client-only>
        <!-- Add New Course -->
        <h2 class="mb-0 m-t-8 font-weight-400"><img src="https://res.cloudinary.com/dl9phqhv0/image/upload/c_scale,h_60/v1576222206/Logos/online-learning_osijg7.svg" style="width: 60px; height: 60px;" alt=""> &nbsp; Courses</h2>

        <!-- // Table of Courses -->
        <div class="mt-4">
            <div class="row">
                <div class="col-lg-12 h-100">

                    <div class="row">
                        <div class="col-lg-4">
                            <form class="my-auto">
                                <div class="input-group input-group-alternative">
                                    <input aria-describedby="addon-right addon-left" type="text" name="search" placeholder="Search for courses" class="form-inline form-control rounded-left search-welcome">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text btn btn-default rounded-right p-lg-3">
                                            <fa icon="search" fixed-width />
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-2">
                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Filter
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <router-link :to="{ name: 'instructor.courses.create' }" class="btn btn-outline-default rounded float-right">
                                <fa icon="plus" fixed-width />
                                Add New Course
                            </router-link>
                        </div>
                    </div>

                    <card class="shadow-sm mt-3">
                        <h4 class="mb-3 header-title"><b>Course list</b></h4>

                        <div v-if="isLoading">
                            <section class="section">
                                <div class="container text-center">
                                    <img src="https://res.cloudinary.com/dl9phqhv0/image/upload/v1574394025/Loader/ajax-loader_sln1xw.gif" alt="">
                                </div>
                            </section>
                        </div>

                        <div v-else>
                            <div v-if="courses == 0">
                                <section class="section">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-12">
                                            <div class="text-center">
                                                <img style="opacity: 1;" width="100" src="http://demo.academy-lms.com/default/assets/backend/images/file-search.svg"><br>
                                                No data found
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>

                            <div v-else>
                                <!-- // Entries and Search -->

                                <table class="table table-striped dt-responsive nowrap dataTable no-footer dtr-inline collapsed" width="100%" data-page-length="25" role="grid" aria-describedby="course-datatable-server-side_info" style="width: 100%;">
                                    <thead>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 353.6px;" aria-label="Title">Title</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 66.6px;" aria-label="Category">Category</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 133.6px;" aria-label="Lesson and section">Lesson and section</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 115.6px;" aria-label="Enrolled student">Enrolled student</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 46.6px;" aria-label="Status">Status</th>
                                    </thead>
                                    <tbody>
                                        <tr role="row" class="odd" v-for="course in allCourses.data" :key="course.id">
                                            <td>
                                                <router-link :to="{ name: 'instructor.courses.edit', params: { slug: course.slug } }">
                                                    {{course.title}}
                                                </router-link>
                                                <br>
                                                <small class="text-muted">
                                                    <span style="font-size: 11px;">Instructor: &nbsp; <b>{{course.user.name}}</b></span>
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge badge-dark" style="font-size: 9px;">{{course.category.name}}</span>
                                            </td>
                                            <td style="font-size: 13px;">
                                                <small class="text-muted"><b>Total section</b>: 3</small><br>
                                                <small class="text-muted"><b>Total lesson</b>: 7</small><br>
                                            </td>
                                            <td style="font-size: 12px;">
                                                <small class="text-muted"><b>Total enrolment</b>: 0</small>
                                            </td>
                                            <td style="font-size: 12px;">
                                                <span class="badge badge-success" v-if="course.status === 'PUBLISHED'">{{course.status}}</span>
                                                <span class="badge badge-warning" v-if="course.status === 'PENDING'">{{course.status}}</span>
                                                <span class="badge badge-default" v-if="course.status === 'DRAFT'">{{course.status}}</span>
                                            </td>
                                            <td style="display: none;">
                                                <span class="badge badge-dark-lighten">$1800</span>
                                            </td>
                                            <td style="display: none;">
                                                <div class="dropright dropright">
                                                    <button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="mdi mdi-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="http://demo.academy-lms.com/default/home/course/how-to-shoot-b-roll-footage-with-peter-mckinnon/26" target="_blank">View course on frontend</a></li>
                                                        <li><a class="dropdown-item" href="http://demo.academy-lms.com/default/user/course_form/course_edit/26">Edit this course</a></li>
                                                        <li><a class="dropdown-item" href="http://demo.academy-lms.com/default/user/course_form/course_edit/26">Section and lesson</a></li>
                                                        <li><a class="dropdown-item" href="javascript::" onclick="confirm_modal('http://demo.academy-lms.com/default/user/course_actions/draft/26')">Mark as drafted</a></li>
                                                        <li><a class="dropdown-item" href="javascript::" onclick="confirm_modal('http://demo.academy-lms.com/default/user/course_actions/delete/26')">Delete</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <pagination :data="allCourses" @pagination-change-page="getCourses"></pagination>
                            </div>
                        </div>
                    </card>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import axios from 'axios'
    import Pagination from 'laravel-vue-pagination'

    export default {

        components: {
            Pagination
        },
        
        middleware: 'auth',

        scrollToTop: true,
        
        head() {
            return { title: 'My Courses' }
        },

        data: () => ({
            allCourses: [],
            courses: '',
            isLoading: false,
            activeCourses: '',
            pendingCourses: '',
            draftCourses: '',
            freeCourses: '',
            paidCourses: '0'
        }),

        created() {
            this.getCourses()
        },

        methods: {
            getCourses(page = 1) {
                axios.get('/instructor/courses?page=' + page)
                .then((res) => {
                    this.allCourses = res.data.allCourses
                    this.courses = res.data.courses
                    this.activeCourses =  res.data.activeCourses
                    this.pendingCourses =  res.data.pendingCourses
                    this.draftCourses =  res.data.draftCourses
                    this.freeCourses =  res.data.freeCourses
                    this.paidCourses =  res.data.paidCourses
                })
                .catch((err) => {
                    console.log(err)
                })
            }
        },

    }

</script>

<style scoped>
    .card .header-title {
        margin-bottom: .5accrem;
        text-transform: uppercase;
        letter-spacing: .02em;
        font-size: .875rem;
        margin-top: 0;
    }
</style>