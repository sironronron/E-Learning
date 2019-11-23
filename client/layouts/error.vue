<template>
    <section class="section-lg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div v-if="error.statusCode === 404" class="text-center">
                        <svg width="150" height="150"
                            xmlns="http://www.w3.org/2000/svg">
                            <image xlink:href="https://res.cloudinary.com/dl9phqhv0/image/upload/c_scale,h_150/v1574303107/Logos/error-404_1_dys5jz.svg" width="150" height="150"/>
                        </svg>
                    </div>
                    <div v-else class="text-center">
                        <svg width="150" height="150"
                            xmlns="http://www.w3.org/2000/svg">
                            <image xlink:href="https://res.cloudinary.com/dl9phqhv0/image/upload/c_scale,h_150/v1574303459/Logos/server_x142l1.svg" width="150" height="150"/>
                        </svg>
                    </div>
                    <div v-if="error.statusCode === 404" class="m-t-10 title">
                        <h2>Page not Found</h2>
                        <p class="description">
                            We can't find the page you're looking for. Try searching our course catalog, or browse our top topics.
                            <br><br>
                            Visit our support page for any questions. ({{error.statusCode}})
                        </p>
                    </div>
                    <div v-else class="title">
                        <h2>An error occured</h2>
                        <p class="description">
                            Our smart monkeys is doing their best to resolve this issue. Please <a href="#" class="text-priamry">contact us</a> for more info.
                            <br><br>
                            Visit our support page for any questions. ({{error.statusCode}})
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        props: ['error'],
        
        head () {
            return { title: 'Error' }
        }
    }
</script>