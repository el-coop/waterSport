<template>
	<div>
		<h4 class="title is-4" v-text="$translations.personalDetails">
		</h4>
		<slot/>
	</div>
</template>

<script>
	export default {
		name: "PersonalDetails"
	}
</script>
