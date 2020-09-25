<template>
	<div>
    <p v-if="! loaded">
      loading
    </p>
		<div class="civilization-list" v-else-if="civilizations.length">
			<civilization-card
				v-for="civ in civilizations"
				:key="civ.id"
				:initialCivilization="civ"
				@remove="removeCivilization"
			/>
		</div>
		<p v-else>
      No civilizations loaded
		</p>
	</div>
</template>

<script>
import axios from "axios";
import CivilizationCard from "./CivilizationCard.vue";

let nextCivId = 1

export default {
  components: {
    CivilizationCard
  },
  data() {
    return {
      civilizations: [ ],
      loaded: false
    }
  },
  beforeMount() {
    this.load();
  },
  methods: {
    removeCivilization(idToRemove) {
      axios.delete(`/api/civilizations/${idToRemove}`).then((res) => {
        console.log(`DELETE response: ${res.status}`);
        this.load();
      }, (err) => {
        console.log(`DELETE error: ${err}`);
      });
    },

    load() {
      console.log("loading list");
      axios.get("/api/civilizations").then((res) => {
        this.civilizations = res.data.data; // why am i returning data.data?
        console.log(this.civilizations);
        this.$emit("log", `loaded ${this.civilizations && this.civilizations.length} civilizations`);
        this.loaded = true;
      }, (err) => {
        console.log(`error loading list: ${err}`);
      });
    }
  }
}
</script>

<style lang="scss">
@import '../../sass/_variables.scss';
</style>
