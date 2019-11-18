<template>
    <div class="layout">
        <div>
            <navbar />
        </div>

        <!-- Flash Notification -->
        <div class="flash" v-if="flash.success">
            <div class="toast toast--green">
                <div class="uk-child-width-expand@s" uk-grid>
                    <div class="uk-width-expand">
                        <div class="toast__content">
                            <p class="toast__message">{{ flash.success }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flash" v-if="flash.error">
            <div class="toast toast--red">
                <div class="uk-child-width-expand@s" uk-grid>
                    <div class="uk-width-expand">
                        <div class="toast__content">
                            <p class="toast__message">{{ flash.error }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- End Flash Notification -->

        <div>
            <nuxt />
        </div>

        <div>
			<footer class="bg-white shadow" style="border-bottom: solid 5px #bc4e9c">
				<section class="section-sm">
					<div class="container">
						<div class="row">
							<div class="col-lg-6">
								<img src="https://res.cloudinary.com/dl9phqhv0/image/upload/c_scale,w_150/v1573175311/Logos/logo-dark_uaqwbf.png" alt="E-Learning" class="img-fluid" />
							</div>
							<div class="col-lg-6">
								<ul class="nav justify-content-md-end footer-menu">
									<li class="nav-item">
										<a class="nav-link" href="http://demo.academy-lms.com/default/home/about_us">About</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="http://demo.academy-lms.com/default/home/privacy_policy">Privacy policy</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="http://demo.academy-lms.com/default/home/terms_and_condition">Terms &amp; condition</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="http://demo.academy-lms.com/default/home/login">
										Help Center
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</section>
			</footer>
		</div>

  </div>
</template>

<script>
    import Navbar from '~/components/HelpNavbar'
    import Flash from '../helpers/flash'

    export default {
        components: {
            Navbar, Flash
        },

        data: () => ({
            flash: Flash.state
        })
    }
</script>

<style scoped>
    @media (min-width: 1200px) { 
            .container {
                max-width: 100% !important;
            }
        }
    .footer-menu .nav-link {
        padding: 6px 0;
        font-size: 13px;
    }
    .footer-menu .nav-item:not(:last-child) {
        margin-right: 20px;
    }
    .toast__svg{
        fill:#fff;
    }

    .toast {
        text-align:left;
        padding: 21px 0;
        background-color:#fff;
        border-radius:4px;
        max-width: 500px;
        top: 0px;
        box-shadow: 1px 7px 14px -5px rgba(0,0,0,0.2);
    }

    .toast--green .toast__icon{
        background-color:#2BDE3F;
    }

    .toast--green:before{
        background-color:#2BDE3F;
    }

    .toast--red:before{
        background-color: #ee395b;
    }

    .toast:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        border-top-left-radius:4px;
        border-bottom-left-radius: 4px;
    }

    .toast__icon{
        position:absolute;
        top:50%;
        left:22px;
        transform:translateY(-50%);
        width:14px;
        height:14px;
        padding: 7px;
        border-radius:50%;
        display:inline-block;
    }

    .toast__type {
        color: #3e3e3e;
        font-weight: 700;
        margin-top: 0;
        margin-bottom: 8px;
    }

    .toast__message {
        font-size: 14px;
        margin-top: 0;
        margin-bottom: 0;
        color: #878787;
    }

    .toast__content{
        padding-left:60px;
        padding-right:60px;
    }

    .toast__close {
        position: absolute;
        right: 22px;
        top: 50%;
        width: 14px;
        cursor:pointer;
        height: 14px;
        fill:#878787;
        transform: translateY(-50%);
    }

    .icon__check {
        background-color: #2BDE3F;
        border-radius: 50%;
    }

</style>