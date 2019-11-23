<template>
    <div></div>
</template>

<script>
    import axios from 'axios'

    export default {
        layout: 'default',

        scrollToTop: false,

        head() {
            return { title: 'Results for ' + this.searchQuery}
        },

        watchQuery: ['q'],

        async asyncData({query, error}) {
            try {
                let { data } = await axios.get('/course/search_query?q=' + query.q)
                return {
                    searchResults: data.searchResults,
                    searchQuery: data.searchQuery
                }
            } catch (e) {
                error({ statusCode: 500, message: 'Something went wrong' })
            }
        },

        computed: {
            groups() {
                return groupBy(this.searchResults, 'groupName')
            }
        }
    }

    function groupBy(array, key){
        const result = {}
        array.forEach(item => {
            if (!result[item[key]]){
                result[item[key]] = []
            }
            result[item[key]].push(item)
        })
        return result
    }
</script>

<style>

</style>