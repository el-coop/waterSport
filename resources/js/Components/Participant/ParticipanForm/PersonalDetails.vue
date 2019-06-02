<template>
	<div>
		<h4 class="title is-4" v-text="'Personal details'">
		</h4>
		<slot/>
	</div>
</template>

<script>
	export default {
		name: "PersonalDetails"
	}
</script>
