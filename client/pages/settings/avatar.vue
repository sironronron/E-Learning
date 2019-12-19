<template>
    <div class="row justify-content-center">
        <div class="col-lg-5">

            <h2>Avatar</h2>
            <h6>Change your profile photo.</h6>

            <hr class="full-width-hr mb-4 mt-4">

            <form @submit.prevent="save" @keydown="form.onKeydown($event)">

                <alert-success :form="form" message="Avatar is successfully changed."></alert-success>

                <alert-error :form="form" message="Failed to upload Avatar."></alert-error>

                <div class="form-group">
                    <label for="avatar" class="col-form-label">Avatar</label>
                    <input type="file" name="avatar" @change="selectFile" class="form-control">
                </div>

                <v-button :loading="form.busy" class="btn-block btn-lg">
                    Upload Photo
                </v-button>

            </form>

        </div>
    </div>
</template>

<script>
    import Form from 'vform'
    import { mapGetters } from 'vuex'

    if (process.client) {
        let objectToFormData = document.createElement('script')
        objectToFormData.setAttribute('src', "https://cdn.rawgit.com/cretueusebiu/412715093d6e8980e7b176e9de663d97/raw/aea128d8d15d5f9f2d87892fb7d18b5f6953e952/objectToFormData.js")
        document.head.appendChild(objectToFormData)    
    }

    export default {
        
        scrollToTop: false,

        head() {
            return { title: 'Change Avatar' }
        },

        data: () => ({
            form: new Form({
                avatar: ''
            }),
            message: ''
        }),

        computed: mapGetters({
            user: 'auth/user'
        }),

        methods: {
            selectFile(e) {
                const file = e.target.files[0]
                this.form.avatar = file
            },

            async save() {
                try {
                    const { data } = await this.form.submit('post', '/instructor/settings/avatar', {
                        transformRequest: [function (data, headers) {
                            return objectToFormData(data)
                        }]
                    })

                    this.$store.dispatch('auth/updateUser', { user: data })

                    .then((res) => {
                        this.$swal(({
                            toast: true,
                            position: 'bottom-end',
                            timer: 5000,
                            showConfirmButton: false,
                            type: 'success',
                            text: res.data.message
                        }))
                    })
                } catch (e) {
                    return
                    this.message(e.error.data.message)
                }
            }
        }

    }
</script>

<style>

</style>