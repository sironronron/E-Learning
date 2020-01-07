<template>
    <div class="modal-mask">
        <div class="modal with-transitions fade show" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    
                    <!-- // Modal Header -->
                    <div class="modal-header">
                        <slot name="header" />
                    </div>

                    <!-- // Modal Data Content -->
                    <form @submit.prevent="form_action" >
                        <slot name="form" />
                    </form>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Modal',

        props: {
            form_action: { type: Function, default: null },
            form_event: { default: null }
        }
    }
</script>

<style>

</style>