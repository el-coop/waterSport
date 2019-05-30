<template>
	<div class="card mr-half">
		<header class="card-header">
			<p class="card-header-title" v-text="'Personal details'">
			</p>
		</header>
		<div class="card-content">
			<slot/>
		</div>
	</div>
</template>

<script>
	export default {
		name: "PersonalDetails"
	}
</script>
