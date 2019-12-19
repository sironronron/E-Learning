<template>
    <transition name="fade" mode="out-in">
        <div class="modal-mask focused">
            <div class="modal with-transitions fade show" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add new lesson</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="$emit('close')"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form @submit.prevent="addSectionLesson" @keydown="form.onKeydown($event)">

                            <div class="modal-body">

                                <!-- // Lesson Title -->
                                <div class="form-group">
                                    <label for="title" class="col-form-label">Title</label>
                                    <input type="text" name="title" v-model="form.title" :class="{ 'is-invalid' : form.errors.has('title') }" class="form-control rounded">
                                    <has-error :form="form" field="title"></has-error> 
                                </div>

                                <!-- // Section  -->
                                <div class="form-group">
                                    <label for="course_section_id" class="col-form-label">Section</label>
                                    <select name="course_section_id" id="course_section_id" v-model="form.course_section_id" :class="{ 'is-invalid' : form.errors.has('course_section_id') }" class="custom-select rounded">
                                        <option value="" selected>Select Section</option>
                                        <option :value="section.id" v-for="(section, index) in sections" :key="section.id" >
                                            {{section.title}}
                                        </option>
                                    </select>
                                    <has-error :form="form" field="course_section_id" />
                                </div>

                                <!-- // Lesson Type -->
                                <div class="form-group">
                                    <label for="lesson_type" class="col-form-label">Lesson Type</label>
                                    <select name="lesson_type" id="lesson_type" v-model="form.lesson_type" :class="{ 'is-invalid' : form.errors.has('lesson_type') }" class="custom-select rounded">
                                        <option value="">Select Lesson Type</option>
                                        <option :value="type.value" v-for="type in lessonTypes" :key="type.id">
                                            {{type.name}}
                                        </option>
                                    </select>
                                </div>

                                <template v-if="form.lesson_type === 'VIDEO'">
                                    <!-- // Lesson Provider -->
                                    <div class="form-group">
                                        <label for="lesson_provider" class="col-form-label">Lesson Provider</label>
                                        <input type="text" name="lesson_provider" :class="{ 'is-invalid' : form.errors.has('lesson_provider') }" v-model="form.lesson_provider" class="form-control rounded">
                                        <has-error :form="form" field="lesson_provider"></has-error>
                                    </div>

                                    <!-- // Video URL -->
                                    <div class="form-group">
                                        <label for="video_url" class="col-form-l">Video URL</label>
                                        <input type="text" name="video_url" v-model="form.video_url" :class="{ 'is-invalid' : form.errors.has('video_url') }" class="form-control">
                                        <has-error :form="form" field="video_url"></has-error>
                                    </div>

                                    <!-- // Video Duration  -->
                                    <div class="form-group">
                                        <label for="duration" class="col-form-label">Duration</label>
                                        <input type="text" name="duration" v-model="form.duration" :class="{ 'is-invalid' : form.errors.has('duration') }" class="form-control">
                                        <has-error :form="form" field="duration"></has-error>
                                    </div>
                                </template>



                            </div>

                            <div class="modal-footer">
                                <v-button :loading="form.button" class="btn-primary rounded btn-sm">Add Lesson</v-button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    import axios from 'axios'
    import Form from 'vform'

    export default {
        props: ['course_id'],

        data: () => ({
            form: new Form({
                'course_section_id': '',
                'lesson_image': '',
                'title': '',
                'lesson_type': '',
                'lesson_provider': '',
                'video_url': '',
                'duration': '',
                'lesson_attachment': '',
                'summary': ''
            }),
            sections: [],
            isLoading: false
        }),

        created() {
            this.getSections()
        },

        computed: {
            lessonTypes() {
                return [
                    {
                        value: 'VIDEO',
                        name: 'Video URL'
                    },
                    {
                        value: 'TFILE',
                        name: 'Text File'
                    },
                    {
                        value: 'PDF',
                        name: 'PDF File'
                    },
                    {
                        value: 'DF',
                        name: 'Document File'
                    },
                    {
                        value: 'IFILE',
                        name: 'Image File'
                    }
                ]
            }  
        },

        methods: {

            getSections() {
                this.isLoading = true
                axios.get(`/instructor/courses/section/add_lesson/get/${this.course_id}`)
                .then((res) => {
                    this.isLoading = false
                    this.sections = res.data.sections
                })
            },

            async addSectionLesson() {
                try {
                    const { data } = await this.form.post(`/instructor/courses/section/add_lesson/post`)
                    .then((res) => {
                        this.$swal({
                            type: 'toast',
                            timer: 5000,
                            position: 'bottom-end',
                            showConfirmButton: false,
                            type: success,
                            text: res.data.message
                        })
                    })
                } catch(e) {
                    return
                }
            }
        }
    }
</script>