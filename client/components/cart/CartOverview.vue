<template>
    <table class="table is-hoverable is-fullwidth">
        <tbody>
        <cart-overview-product v-for="product in products"
                               :key="product.id"
                               :product="product"
        >
        </cart-overview-product>
        </tbody>
    </table>
</template>

<script>
    import { mapGetters } from 'vuex';
    import CartOverviewProduct from '@/components/cart/CartOverviewProduct'

    export default {
    	computed: {
    		...mapGetters({
                products: 'cart/products'
            })
        },

        components: {
    		CartOverviewProduct
        }
    }
</script>
