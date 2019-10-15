<template>
    <div>
        <navigation></navigation>
        <nuxt/>
    </div>
</template>

<script>
    import Navigation from '@/layouts/partials/Navigation';
    export default {
    	components: {
    		Navigation
		}
	}
</script>
