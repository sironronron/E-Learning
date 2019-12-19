<template>
    <div class="row justify-content-center">
        <div class="col-lg-4">

            <div>
                <template v-if="!editEmail">
                    <div class="form-group">
                        <label for="email" class="col-form-label">Email: </label>
                        <input type="email" class="form-control rounded" disabled v-model="form.email">
                        <a href="#" @click="btnEdit" class="small"><fa :icon="['far', 'edit']" /> Edit</a>
                    </div>
                </template>

                <template v-else>
                    <div class="">
                        <form @submit.prevent="update" @keydown="form.onKeydown($event)">

                            <div class="form-group">
                                <label for="email" class="col-form-label">Email: </label>
                                <input type="email" class="form-control rounded" name="email" :class="{ 'is-invalid' : form.errors.has('email') }" v-model="form.email">
                                <has-error :form="form" field="email"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="current_password" class="col-form-label">Current Password: </label>
                                <input type="password" name="current_password" class="form-control rounded" :class="{ 'is-invalid' : form.errors.has('current_password') }" v-model="form.current_password" placeholder="Current Password">
                                <has-error :form="form" field="current_password"></has-error>
                            </div>
                            <a href="#" @click="btnCancel" class="small">Cancel</a>
                            <v-button :loading="form.busy" class="btn-sm float-right">
                                Submit
                            </v-button>
                        </form>
                    </div>
                </template>
            </div>

        </div>
    </div>
</template>

<script>
    import Form from 'vform'
    import { mapGetters } from 'vuex'

    export default {

        head() {
            return { title: 'Account Settings' }
        },

        data: () => ({
            form: new Form({
                email: '',
                current_password: ''
            }),
            editEmail: false
        }),

        computed: mapGetters({
            user: 'auth/user'
        }),

        created() {
            this.form.keys().forEach((key) => {
                this.form[key] = this.user[key]
            })
        },

        methods: {
            async update() {
                try {
                    const { data } = await this.form.patch('/instructor/settings/email')
                    this.$store.dispatch('auth/updateUser', { user: data })
                    this.$swal({
                        toast: true,
                        position: 'bottom-end',
                        timer: 5000,
                        showConfirmButton: false,
                        type: 'success',
                        text: this.$t('info_updated')
                    })
                } catch (e) {
                    return
                }
            },

            btnEdit() {
                this.editEmail = true
            },

            btnCancel() {
                this.editEmail = false
            }
        }

    }
</script>

<style>

</style>
