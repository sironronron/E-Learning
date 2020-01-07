<template>
    <transition name="fade" mode="out-in">
        <modal :form_action="addSection" @keydown="form.onKeydown($event)">
            <template slot="header">
                <h5 class="modal-title">Add new section</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="$emit('close')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </template>
            <template slot="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title" class="col-form-label">Title</label>
                        <input type="text" name="title" :class="{ 'is-invalid' : form.errors.has('title') }" v-model="form.title" class="form-control rounded">
                        <h6 class="text-muted"><small>Provide a Section Name</small></h6>
                        <has-error :form="form" field="title" />
                    </div>
                </div>
                <div class="modal-footer">
                    <v-button :loading="form.busy" class="btn btn-primary rounded btn-sm">Save changes</v-button>
                </div>
            </template>
        </modal>
    </transition>
</template>

<script>
    import Form from 'vform'

    export default {

        props: ['course_id'],

        data: () => ({
            form: new Form({
                title: ''
            }),
        }),

        methods: {
            async addSection(event) {
                try {
                    const { data } = await this.form.post(`/instructor/courses/section/add_section/${this.course_id}`)
                    this.$swal({
                        type: 'success',
                        text: data.message
                    })
                    var sectionData = {
                        id: data.id,
                        title: data.title,
                        slug: data.slug
                    }
                    this.$emit('close')
                    this.$emit('clicked', sectionData)
                } catch (e) {
                    return
                }
            }
        }

    }
</script>