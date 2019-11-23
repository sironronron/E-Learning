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
