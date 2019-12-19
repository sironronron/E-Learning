<template>
    <transition name="fade" mode="out-in">
        <div class="modal-mask">
            <div class="modal with-transitions fade show" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add new section</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="$emit('close')">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="addSection" @keydown="form.onKeydown($event)">
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
            async addSection() {
                try {
                    const { data } = await this.form.post(`/instructor/courses/section/add_section/${this.course_id}`)
                    .then((res) => {
                        this.$swal({
                            type: 'toast',
                            timer: 5000,
                            position: 'bottom-end',
                            showConfirmButton: false,
                            type: success,
                            text: res.data.message
                        })
                        this.$emit('close', false)
                    })
                } catch (e) {
                    return
                }
            }
        }

    }
</script>

<style>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }
</style>