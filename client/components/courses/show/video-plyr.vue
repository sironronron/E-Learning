<template>
    <transition name="fade" mode="out-in">
        <div class="modal-mask focused">
            <div class="modal with-transitions fade show" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h5 class="modal-title text-white">Course Overview</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" @click="$emit('close')"><span aria-hidden="true" class="text-white">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <!-- // Youtube -->
                            <vue-plyr v-if="courseOverviewURL.course_overview_provider === 'Youtube'">
                                <div class="plyr__video-embed">
                                    <iframe
                                    :src="`https://www.youtube.com/embed/${courseOverviewURL.course_overview_url}?iv_load_policy=3&modestbranding=1&playsinline=1&showinfo=0&rel=0&enablejsapi=1`"
                                    allowfullscreen allowtransparency allow="autoplay">
                                    </iframe>
                                </div>
                            </vue-plyr>

                            <vue-plyr v-else-if="courseOverviewURL.course_overview_provider === 'Vimeo'">
                                <div class="plyr__video-embed">
                                    <iframe
                                        :src="`https://player.vimeo.com/video/${courseOverviewURL.course_overview_url}?loop=false&byline=false&portrait=false&title=false&speed=true&transparent=0&gesture=media`"
                                        allowfullscreen allowtransparency allow="autoplay">
                                    </iframe>
                                </div>
                            </vue-plyr>

                            <!-- https://www.w3schools.com/html/mov_bbb.mp4 -->
                            <!-- video element -->
                            <vue-plyr v-else-if="courseOverviewURL.course_overview_provider === 'HTML5'">
                                <video :poster="courseOverviewURL.image" src="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer.mp4">
                                    <source src="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-576p.mp4" type="video/mp4" size="576">
                                    <source src="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-720p.mp4" type="video/mp4" size="720">
                                    <source src="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-1080p.mp4" type="video/mp4" size="1080">
                                    <track kind="captions" label="English" srclang="en" src="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer.vtt" default>
                                </video>
                            </vue-plyr>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    import axios from 'axios'

    export default {
        data: () => ({
            courseOverviewURL: []
        }),

        created() {
            this.getCourseOverviewUrl()
        },

        methods: {
            getCourseOverviewUrl() {
                axios.get(`/course/getCourseOverviewURL/${this.$route.params.slug}`)
                .then((res) => {
                    this.courseOverviewURL = res.data.courseOverviewURL
                })
            }
        }
    }
</script>

<style>

</style>