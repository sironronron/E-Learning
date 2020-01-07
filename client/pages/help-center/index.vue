<template>
    <div>
        
        <transition name="fade" mode="out-in">
            <router-view />
        </transition>

    </div>
</template>

<script>
    import axios from 'axios'
    
    export default {

        layout: 'help-center',

        head() {
            return { title: 'Help Center' }
        },

    }
</script>

<style>

</style>