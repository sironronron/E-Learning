<template>
    <div>
        <client-only>
			<offline-alert/>
		</client-only>
        <!-- Add New Course -->
        <card class="shadow-sm p-3">
            <h4 class="mb-0 float-left m-t-8 font-weight-400"><fa icon="book-open" fixed-width /> Courses</h4>
            <router-link :to="{ name: 'instructor.courses.create' }" class="btn btn-outline-default rounded float-right">
                <fa icon="plus" fixed-width />
                Add New Course
            </router-link>
        </card>
        
        <!-- // Table of Courses -->
        <div class="mt-4">
            <div class="row">
                <div class="col-lg-12 h-100">
                    <card class="shadow-sm" style="height: 777px;">
                        <h4 class="mb-3 header-title">Active Course Lists</h4>

                        <!-- // Filter -->
                        <form class="row justify-content-center" method="get">
                            <!-- Course Filter -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="Category" class="col-form-label text-muted"><small>Category</small></label>
                                    <div>
                                        <select name="category" id="category" class="custom-select custom-select-sm rounded">
                                            <option value="">Select Category</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="Category" class="col-form-label text-muted"><small>Status</small></label>
                                    <div>
                                        <select name="category" id="category" class="custom-select custom-select-sm rounded">
                                            <option value="">Select Category</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="Category" class="col-form-label text-muted"><small>Price</small></label>
                                    <div>
                                        <select name="category" id="category" class="custom-select custom-select-sm rounded">
                                            <option value="">Select Category</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <button class="btn btn-default btn-sm btn-block m-t-46"><fa icon="filter" fixed-width class="mr-2" /> Filter</button>
                            </div>
                        </form>

                        <div v-if="isLoading">
                            <section class="section">
                                <div class="container text-center">
                                    <img src="https://res.cloudinary.com/dl9phqhv0/image/upload/v1574394025/Loader/ajax-loader_sln1xw.gif" alt="">
                                </div>
                            </section>
                        </div>

                        <div v-else>
                            <div v-if="countCourses == 0">
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
                                <div class="row">
                                    <div class="col-lg-2">
                                        <!-- // Course Table -->
                                        <div class="form-group">
                                            <label for="Category" class="col-form-label text-muted"><small>Show Entries</small></label>
                                            <div>
                                                <select name="category" id="category" class="custom-select custom-select-sm rounded">
                                                    <option value="">10</option>
                                                    <option value="">25</option>
                                                    <option value="">50</option>
                                                    <option value="">100</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-10">
                                        <div class="form-group float-right">
                                            <label for="search" class="col-form-label text-muted"><small class="">Search</small></label>
                                            <div>
                                                <input type="text" class="form-control form-control-sm rounded" >
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <table class="table table-striped dt-responsive nowrap dataTable no-footer dtr-inline collapsed" width="100%" data-page-length="25" role="grid" aria-describedby="course-datatable-server-side_info" style="width: 100%;">
                                    <thead>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 353.6px;" aria-label="Title">Title</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 66.6px;" aria-label="Category">Category</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 133.6px;" aria-label="Lesson and section">Lesson and section</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 115.6px;" aria-label="Enrolled student">Enrolled student</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 46.6px;" aria-label="Status">Status</th>
                                    </thead>
                                    <tbody>
                                        <tr role="row" class="odd" v-for="course in activeCourses.data" :key="course.id">
                                            <td>
                                                <strong>
                                                    <router-link :to="{ name: 'instructor.courses.edit', params: { slug: course.slug } }" class="small">
                                                        {{course.title}}
                                                    </router-link>
                                                </strong>
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
                                <pagination :data="activeCourses" @pagination-change-page="getActiveCourses"></pagination>
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
            return { title: 'All Active Course' }
        },

        data: () => ({
            activeCourses: [],
            countCourses: '',
            isLoading: false
        }),

        created() {
            this.getActiveCourses()
        },

        methods: {
            getActiveCourses() {
                axios.get('/instructor/courses/active-courses')
                .then((res) => {
                    this.activeCourses = res.data.activeCourses
                    this.countCourses = res.data.countCourses
                })
                .catch((err) => {
                    console.log(err)
                })
            }
        }

    }
</script>

<style scoped>
    .card .header-title {
        margin-bottom: .5rem;
        text-transform: uppercase;
        letter-spacing: .02em;
        font-size: .875rem;
        margin-top: 0;
    }
    div.dataTables_wrapper div.dataTables_length label {
        font-weight: normal;
        text-align: left;
        white-space: nowrap;
    }
    table thead th {
        font-size: .680rem !important;
        font-weight: bold;
    }
</style>