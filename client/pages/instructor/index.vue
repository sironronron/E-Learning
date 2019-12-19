<template>
    <div>
        <client-only>
			<offline-alert/>
		</client-only>

        <section class="section-sm">
            <div class="container">

                <transition name="fade" mode="out-in">
				    <router-view />
				</transition>

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
        },
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
    .router-link-active {
        font-weight: bold;
    }
</style>
