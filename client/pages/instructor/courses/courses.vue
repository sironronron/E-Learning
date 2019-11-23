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
        <!-- // Course Lists -->
        <div class="mt-4">
           <div class="row">
                <div class="col-12">
                    <div class="card widget-inline shadow-sm">
                        <div class="card-body p-0">
                            <div class="row no-gutters">
                                <div class="col card-lift--hover">
                                    <a href="http://demo.academy-lms.com/default/user/courses" class="text-secondary">
                                        <div class="card shadow-none m-0">
                                            <div class="card-body text-center">
                                                <fa icon="link" class="text-muted" style="font-size: 24px;" />
                                                <h3 class="mt-3"><span>{{activeCourses}}</span></h3>
                                                <p class="text-muted font-15 mb-0">Active courses</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col card-lift--hover">
                                    <a href="http://demo.academy-lms.com/default/user/courses" class="text-secondary">
                                        <div class="card shadow-none m-0 border-left">
                                            <div class="card-body text-center">
                                                <fa icon="unlink" class="text-muted" style="font-size: 24px;" />
                                                <h3 class="mt-3"><span>{{pendingCourses}}</span></h3>
                                                <p class="text-muted font-15 mb-0">Pending courses</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col card-lift--hover">
                                    <a href="http://demo.academy-lms.com/default/user/courses" class="text-secondary">
                                        <div class="card shadow-none m-0 border-left">
                                            <div class="card-body text-center">
                                                <fa icon="bookmark" class="text-muted" style="font-size: 24px;"/>
                                                <h3 class="mt-3"><span>{{draftCourses}}</span></h3>
                                                <p class="text-muted font-15 mb-0">Draft courses</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col card-lift--hover">
                                    <a href="http://demo.academy-lms.com/default/user/courses" class="text-secondary">
                                        <div class="card shadow-none m-0 border-left">
                                            <div class="card-body text-center">
                                                <fa :icon="['fas', 'star']" class="text-muted" style="font-size: 24px;"/>
                                                <h3 class="mt-3"><span>{{freeCourses}}</span></h3>
                                                <p class="text-muted font-15 mb-0">Free courses</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col card-lift--hover">
                                    <a href="http://demo.academy-lms.com/default/user/courses" class="text-secondary">
                                        <div class="card shadow-none m-0 border-left">
                                            <div class="card-body text-center">
                                                <fa icon="tags" class="text-muted" style="font-size: 24px;"/>
                                                <h3 class="mt-3"><span>{{paidCourses}}</span></h3>
                                                <p class="text-muted font-15 mb-0">Paid courses</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div> <!-- end row -->
                        </div>
                    </div> <!-- end card-box-->
                </div> <!-- end col-->
            </div>
        </div>
        <!-- // List of Courses -->
        
        <!-- // Table of Courses -->
        <div class="mt-4">
            <div class="row">
                <div class="col-lg-12 h-100">
                    <card class="shadow-sm" style="height: 777px;">
                        <h4 class="mb-3 header-title">Course list</h4>

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
                            <div v-if="allCourses.length == 0">
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
                                        <th class="sorting_asc" rowspan="1" colspan="1" style="width: 11.8px;" aria-label="#">

                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 353.6px;" aria-label="Title">Title</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 66.6px;" aria-label="Category">Category</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 133.6px;" aria-label="Lesson and section">Lesson and section</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 115.6px;" aria-label="Enrolled student">Enrolled student</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 46.6px;" aria-label="Status">Status</th>
                                    </thead>
                                    <tbody>
                                        <tr role="row" class="odd" v-for="course in allCourses.data" :key="course.id">
                                            <td class="sorting_1" tabindex="0" style="font-size: 12px;">
                                                
                                            </td>
                                            <td>
                                                <strong>
                                                    <a href="http://demo.academy-lms.com/default/user/course_form/course_edit/26" class="small">
                                                        {{course.title}}
                                                    </a>
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
            isLoading: false
        }),

        created() {
            this.getCourses()
        },

        methods: {
            getCourses(page = 1) {
                axios.get('/instructor/courses?page=' + page)
                .then((res) => {
                    this.allCourses = res.data.allCourses
                })
                .catch((err) => {
                    console.log(err)
                })
            }
        },

        async asyncData({ error }) {
            try {
                let { data } = await axios.get('/instructor/courses')
                return {
                    activeCourses: data.activeCourses,
                    pendingCourses: data.pendingCourses,
                    draftCourses: data.draftCourses,
                    freeCourses: data.freeCourses,
                    paidCourses: data.paidCourses,
                }
            } catch (e) {
                error({ statusCode: 500, message: 'Something went wrong!' })
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
    table.dataTable.dtr-inline.collapsed>tbody>tr[role=row]>td:first-child:before, table.dataTable.dtr-inline.collapsed>tbody>tr[role=row]>th:first-child:before {
        -webkit-box-shadow: 0 0 45px 0 rgba(0,0,0,.12);
        box-shadow: 0 0 45px 0 rgba(0,0,0,.12);
        background-color: #0acf97;
        top: auto;
        bottom: auto;
    }
    table.dataTable.dtr-inline.collapsed > tbody > tr[role="row"] > td:first-child:before, table.dataTable.dtr-inline.collapsed > tbody > tr[role="row"] > th:first-child:before {
        margin-top: 5px;
        height: 14px;
        width: 14px;
        display: block;
        position: absolute;
        color: white;
        border: 2px solid white;
        border-radius: 14px;
        box-shadow: 0 0 3px #444;
        box-sizing: content-box;
        text-align: center;
        text-indent: 0 !important;
        font-family: 'Courier New', Courier, monospace;
        line-height: 14px;
        content: '+';
        background-color: #0275d8;
    }
</style>