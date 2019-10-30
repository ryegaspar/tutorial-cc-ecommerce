<template>
    <div class="section">
        <div class="container is-fluid">
            <div class="columns is-centered">
                <div class="column is-three-quarters">
                    <h1 class="title is-4">Your cart</h1>

                    <article class="message" v-if="products.length">
                        <cart-overview></cart-overview>
                    </article>

                    <nuxt-link
                        :to="{ name: 'checkout'}"
                        v-if="!empty"
                        class="button is-fullwidth is-info is-medium"
                    >
                        Checkout
                    </nuxt-link>
                    <p v-else>Your cart is empty</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
	import CartOverview from '@/components/cart/CartOverview';
	import {mapGetters} from 'vuex';

	export default {

		components: {
			CartOverview
		},

		computed: {
			...mapGetters({
				empty: 'cart/empty',
				products: 'cart/products',
				changed: 'cart/changed'
			})
		}

	}
</script>
