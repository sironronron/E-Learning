<template>
    <div class="row justify-content-center">
        <div class="col-lg-4">

            <div class="text-center">
                <img v-if="user.avatar == 'users/default.png'" :src="user.photo_url" class="rounded-circle img-fluid profile-photo" alt="">
                <img v-if="user.avatar != 'users/default.png'" :src="user.avatar" class="rounded-circle img-fluid profile-photo" alt="">
            </div>

            <hr>
            
            <form @submit.prevent="save" @keydown="form.onKeydown($event)">
                <alert-error :form="form" message="There were some problems with your input."></alert-error>
                <div class="form-group">
                    <label for="avatar" class="col-form-label">Avatar</label>
                    <input type="file" name="avatar" @change="selectFile" class="form-control">
                    <has-error :form="form" field="avatar"></has-error>
                </div>
                <v-button :loading="form.busy" class="btn-sm float-right">
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
        
        middleware: 'auth',

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
                        this.$router.push({ name: 'instructor.settings.avatar' })
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

<style scoped>
    .profile-photo {
        width: 220px !important;
        height: 220px !important;
    }
</style>