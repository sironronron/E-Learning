<template>
    <div>
        <div>
            <navbar />
        </div>

        <div>
            <nuxt/>
        </div>

        <!-- // Footer -->
        <div>
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