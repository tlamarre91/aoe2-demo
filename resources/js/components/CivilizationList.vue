<template>
	<div>
    <button @click="reinitializeDb">
      reinitialize database from source
    </button>
		<input-text 
			v-model="newCivText"
			placeholder="New civilization"
			@keydown.enter="addCivilization"
		/>
    <p v-if="! loaded">
      loading
    </p>
		<ul v-else-if="civilizations.length">
			<civilization-card
				v-for="civ in civilizations"
				:key="civ.id"
				:initialCivilization="civ"
				@remove="removeCivilization"
			/>
		</ul>
		<p v-else>
      No civilizations loaded
		</p>
	</div>
</template>

<script>
import axios from "axios";
import InputText from './InputText.vue'
import CivilizationCard from "./CivilizationCard.vue";

let nextCivId = 1

export default {
  components: {
    InputText, CivilizationCard
  },
  data() {
    return {
      newCivText: '',
      civilizations: [ ],
      loaded: false
    }
  },
  beforeMount() {
    this.load();
  },
  methods: {
    addCivilization() {
      const trimmedText = this.newCivText.trim()
      if (trimmedText) {
        //this.civilizations.push({
        //  id: nextCivId++,
        //  name: trimmedText
        //})
        //this.newCivText = ''
        axios.post('/api/civilizations', {
          name: trimmedText
        }).then((res) => {
          console.log(`POST response: ${res.status}`);
          this.load();
        }, (err) => {
          console.log(`POST error: ${err}`);
        });
      }
    },

    removeCivilization(idToRemove) {
      //this.civilizations = this.civilizations.filter(civ => {
      //  return civ.id !== idToRemove
      //})
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
        this.loaded = true;
      }, (err) => {
        console.log(`error loading list: ${err}`);
      });
    },

    reinitializeDb() {
      axios.post("/api/civilizations/initialize").then((res) => {
        const json = res.data;
        console.log(json);
        this.load();
      }, (err) => {
        console.log(`error reinitializing DB: ${err}`);
      });
    }
  }
}
</script>
