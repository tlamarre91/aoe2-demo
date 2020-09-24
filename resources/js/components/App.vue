<template>
	<div id="app">
		<h2>AoE2 Civilization Editor</h2>
		<CivilizationList/>
	</div>
</template>

<script>
import CivilizationList from "./CivilizationList.vue";

export default {
	components: {
		CivilizationList
	}
}
</script>

<style lang="scss">
@import '../../sass/_variables.scss';

*, *::before, *::after {
	box-sizing: border-box;
}

#app {
	max-width: 800px;
	margin: 0 auto;
	line-height: 1.4;
	font-family: 'Nunito', sans-serif;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
}

h2 {
	text-align: center;
	color: $blue;
}
</style>
