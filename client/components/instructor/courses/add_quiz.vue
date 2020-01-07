<template>
    <transition name="fade" mode="out-in">
        <modal :form_action="addQuiz" @keydown="form.onKeydown($event)">

            <template slot="header">
                <h5 class="modal-title">
                    Add New Quiz
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="$emit('close')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </template>

            <template slot="form">
                <div class="modal-body">
                    <!-- // Quiz Title -->
                    <div class="form-group">
                        <label for="quiz_title" class="col-form-label">Quiz Title</label>
                        <input type="text" name="title" :class="{ 'is-invalid' : form.errors.has('title') }" v-model="form.title" class="form-control rounded">
                        <has-error :form="form" field="title"></has-error>
                    </div>

                    <!-- // Section Id -->
                    <div class="form-group">
                        <label for="course_curriculum_section_id" class="col-form-label">Section</label>
                        <select name="course_curriculum_section_id" :class="{ 'is-invalid' : form.errors.has('course_curriculum_section_id') }" v-model="form.course_curriculum_section_id" class="custom-select rounded">
                            <option value="">Select Section</option>
                            <option v-for="(item, index) in sections" :key="index" :value="item.id">{{item.title}}</option>
                        </select>
                        <has-error :form="form" field="course_curriculum_section_id"></has-error>
                    </div>

                    <!-- // Instruction -->
                    <div class="form-group">
                        <label for="instruction" class="col-form-label">Instruction</label>
                        <input type="text" name="instruction" :class="{ 'is-invalid' : form.errors.has('instruction') }" v-model="form.instruction" class="form-control rounded">
                        <has-error :form="form" field="instruction"></has-error>
                    </div>

                </div>

                <div class="modal-footer">
                    <v-button :loading="form.button" class="btn-primary rounded btn-sm">Add Quiz</v-button>
                </div>
            </template>
        
        </modal>
    </transition>
</template>

<script>
    import axios from 'axios'
    import Form from 'vform'

    export default {
        props: ['course_id'],

        data: () => ({
            form: new Form({
                title: '',
                course_curriculum_section_id: '',
                instruction: ''
            }),
            sections: [],
            isLoading: false
        }),

        created() {
            this.getSections()
        },

        methods: {
            getSections() {
                this.isLoading = true
                axios.get(`/instructor/courses/section/add_quiz/get/${this.course_id}`)
                .then((res) => {
                    this.isLoading = false
                    this.sections = res.data.sections
                })
            },
            
            async addQuiz() {
                try {
                    const { data } = await this.form.post('/instructor/courses/section/add_quiz/post')
                    this.$swal({
                        type: 'success',
                        text: 'Quiz has been saved'
                    })
                    this.$emit('close')
                } catch (e) {
                    return
                } 
            }
        }
    }
</script>

<style>

</style>