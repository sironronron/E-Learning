<template>
    <div>
        <client-only>
			<offline-alert/>
		</client-only>
        <!-- Course Title -->
        <card class="shadow-sm p-3">
            <h5 class="mb-0 float-left m-t-10 font-weight-400"><fa icon="book-open" fixed-width /> &nbsp; {{course.title}}</h5>
            <router-link :to="{ name: 'instructor.courses.create' }" class="btn btn-outline-default rounded float-right">
                <fa icon="plus" fixed-width />
                Add New Course
            </router-link>
        </card>

    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        head() {
            return { title: this.course.title }
        },

        async asyncData({ params,error }) {
            try {
                let { data } = await axios.get(`/instructor/courses/show/${params.slug}`)
                return {
                    course: data.course
                }
            } catch (e) {
                error({ statusCode: 500, message: 'Something went wrong'})
            }
        }
    }
</script>