<template>
    <transition name="layout" mode="out-in">
        <div>
            <div>
                <navbar />
            </div>

            <div v-if="user.role_id === 3">
                <nuxt/>
            </div>

            <!-- // If not instructor -->
            <div v-else class="section-lg">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                        <img src="https://res.cloudinary.com/dl9phqhv0/image/upload/c_scale,w_250/v1573175311/Logos/logo-dark_uaqwbf.png" alt="E-Learning" class="img-fluid" />
                            <h1 class="text-center mt-3">You'd have to be an Instructor to access this page!</h1>
                            <router-link :to="{ name: 'welcome' }" class="btn btn-white mt-5">
                                Go Back to Home Page
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- // Footer -->
            <div class="mt-5">
                <footer class="bg-secondary border-top">
                    <section class="section-sm">
                        <div class="container text-center">
                            <svg width="108" height="25"
                                xmlns="http://www.w3.org/2000/svg">
                                <image xlink:href="https://res.cloudinary.com/dl9phqhv0/image/upload/c_scale,h_25/v1573175311/Logos/logo-dark_uaqwbf.png" width="108" height="25"/>
                            </svg>
                            <h6 class="mt-1">E-Learning Instructor Page</h6>
                        </div>
                    </section>
                </footer>
            </div>
            
        </div>
    </transition>
</template>

<script>
    import Navbar from '~/components/InstructorNavbar'
    import { mapGetters } from 'vuex'

    export default {
        components: {
            Navbar
        },

        computed: mapGetters({
            user: 'auth/user'
        })
    }

</script>

<style>

</style>