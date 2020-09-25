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
      const url = `/api/civilizations/${idToRemove}`;
      axios.delete(url).then((res) => {
        const status = res.status == 200 ? "OK": res.status;
        const msg = `DELETE ${url} response: ${status}`;
        console.log(msg);
        this.$root.$emit("log", msg);
        this.load();
      }, (err) => {
        const msg = `DELETE error: ${err}`;
        console.log(msg);
        this.$root.$emit("log", msg);
      });
    },

    load() {
      console.log("loading list");
      const url = "/api/civilizations";
      axios.get(url).then((res) => {
        this.civilizations = res.data.data; // why am i returning data.data?
        const msg =  `GET ${url} loaded ${this.civilizations ? this.civilizations.length : 0} civilizations`;
        console.log(msg);
        this.$root.$emit("log", msg);
        console.log(this.civilizations);
        this.loaded = true;
      }, (err) => {
        const msg = `GET ${url} error: ${err}`;
        console.log(msg);
        this.$root.$emit("log", msg);
      });
    }
  }
}
</script>

<style lang="scss">
@import '../../sass/_variables.scss';
</style>
