<template>
    <div>
        <client-only>
			<offline-alert/>
		</client-only>

        <section class="section-sm">
            <div class="container">

                <div class="row">
                    <div class="col-lg-3">
                        <card class="shadow-sm bg-image p-lg-3" style="height: 100%;">
                            <div class="text-center">
                                <img :src="user.photo_url" :alt="user.name" class="rounded-circle img-fluid profile-photo">
                                <h5 class="mt-3">{{user.name}}</h5>
                            </div>
                            <hr>
                            <div>
                                <h6 class="text-uppercase small"><small>navigation</small></h6>
                                <ul class="list-unstyled mt-4">
                                    <li v-for="tab in tabs" :key="tab.id" class="mb-3">
                                        <router-link :to="{ name: tab.route }" class="text-muted" style="font-size: 15px !important;">
                                            <fa :icon="tab.icon" fixed-width class=" mr-2" />
                                            {{tab.name}}
                                        </router-link>
                                    </li>
                                </ul>
                            </div>
                        </card>
                    </div>

                    <div class="col-lg-9">
                         <!-- // Course Lists -->
                        <div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card widget-inline shadow-sm">
                                        <div class="card-body p-0">
                                            <div class="row no-gutters">
                                                <div class="col card-lift--hover">
                                                    <router-link :to="{ name: 'instructor.courses.active'}" class="text-secondary">
                                                        <div class="card shadow-none m-0">
                                                            <div class="card-body text-center">
                                                                <fa icon="link" class="text-muted" style="font-size: 24px;" />
                                                                <h3 class="mt-3"><span>{{activeCourses}}</span></h3>
                                                                <p class="text-muted font-15 mb-0">Active courses</p>
                                                            </div>
                                                        </div>
                                                    </router-link>
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
                        <transition name="fade" mode="out-in">
						    <router-view />
						</transition>
                    </div>

                </div>

            </div>
        </section>
    </div>
</template>

<script>
    import axios from 'axios'
    import { mapGetters } from 'vuex'
    export default {
        layout: 'instructor',

        middleware: 'auth',

        head() {
            return { title: 'Instructor Panel' }
        },

        computed: {
            ...mapGetters({
                user: 'auth/user'
            }),
            tabs() {
                return [
                    {
                        icon: 'archive',
                        name: 'Courses',
                        route: 'instructor.courses'
                    },
                    {
                        icon: 'wallet',
                        name: 'Instructor Revenue'
                    },
                    {
                        icon: 'cogs',
                        name: 'Settings'
                    }
                ]
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
                console.log(e)
            }
        }
    }
</script>

<style lang="scss" scoped>
    .profile-photo {
        height: 80px;
        width: 80px;
    }

    a:hover {
        color: #172B4D !important;
    }
</style>
