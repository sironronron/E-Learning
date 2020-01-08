<template>
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div>
                <form @submit.prevent="update" @keydown="form.onKeydown($event)">
                    <alert-success :form="form" :message="$t('info_updated')"></alert-success>

                    <div class="form-group">
                        <label for="name" class="col-form-label">Name: </label>
                        <input type="text" name="name" v-model="form.name" :class="{ 'is-invalid' : form.errors.has('name') }" class="form-control rounded" placeholder="Name">
                    </div>

                    <div class="form-group">
                        <label for="birthday" class="col-form-label">Birthday: </label>
                        <div>
                            <flat-pickr v-model="form.birthday"
                                :class="{ 'is-invalid has-danger': form.errors.has('birthday') }"
                                class="form-control rounded input-group-alternative"
                                placeholder="Birthday"
                            ></flat-pickr>
                          <has-error :form="form" field="birthday" class="text-capitalize"></has-error>
                        </div>
                        </div>

                    <div class="form-group">
                        <label for="phone" class="col-form-label">Phone: </label>
                        <input type="text" name="phone" v-model="form.phone" :class="{ 'is-invalid' : form.errors.has('phone') }" class="form-control rounded" placeholder="Phone">
                    </div>

                    <div class="form-group">
                        <label for="introduction" class="col-form-label">Introduction: </label>
                        <input type="text" name="introduction" v-model="form.introduction" :class="{ 'is-invalid' : form.errors.has('introduction') }" class="form-control rounded" placeholder="Introduction">
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-form-label">Biography: </label>
                        <div>
                            <client-only>
                                <froala id="edit" name="biography" :tag="'textarea'" :class="{ 'is-invalid' : form.errors.has('biography') }" v-model="form.biography"></froala>
                                <has-error :form="form" field="biography"></has-error>
                            </client-only>
                          <h6 class="text-muted"><small>
                            Your instructor biography should emphasize your experience and expertise. It should have at least 50 characters and may not contain links or coupon codes.
                          </small></h6>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="facebook_link" class="col-form-label">Facebook Link: </label>
                        <input type="text" class="form-control rounded" name="facebook_link" v-model="form.facebook_link" :class="{ 'is-invalid' : form.errors.has('facebook_link') }" placeholder="Facebook Link">
                    </div>

                    <div class="form-group">
                        <label for="twitter_link" class="col-form-label">Twitter Link: </label>
                        <input type="text" class="form-control rounded" name="twitter_link" v-model="form.twitter_link" :class="{ 'is-invalid' : form.errors.has('twitter_link') }" placeholder="Twitter Link">
                    </div>

                    <div class="form-group">
                        <label for="youtube_link" class="col-form-label">Youtube Link: </label>
                        <input type="text" class="form-control rounded" name="youtube_link" v-model="form.youtube_link" :class="{ 'is-invalid' : form.errors.has('youtube_link') }" placeholder="Youtube Link">
                    </div>

                    <div class="form-group text-center">
                        <v-button :loading="form.busy" class="btn-lg btn-block" >Update Profile</v-button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Form from 'vform'
    import { mapGetters } from 'vuex'

    export default {
        scrollToTop: false,

        head() {
            return { title: 'Edit Profile Information' }
        },

        data: () => ({
            form: new Form({
                name: '',
                phone: '',
                birthday: '',
                biography: '',
                introduction: '',
                facebook_link: '',
                twitter_link: '',
                youtube_link: '',
                introduction: ''
            })
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
                    const { data } = await this.form.patch('/settings/profile')
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
            }
        }
    }
</script>

<style>

</style>
