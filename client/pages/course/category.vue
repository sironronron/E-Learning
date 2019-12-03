<template>
    <div>
        {{category}}
    </div>
</template>

<script>
    import axios from 'axios'

    export default {

        head() {
            return { title: 'Category ' }
        },

        async asyncData({params, error}) {
            try {
                let { data } = await axios.get(`/category/${params.slug}`)
                return {
                    category: data.category
                }
            } catch (e) {
                return
            }
        },      
    }
</script>

<style scoped>
    
</style>