<template>
	<div id="app">
		<h2>AoE2 Civilization Editor</h2>
    <div class="input-container">
      <input-text 
        v-model="newCivText"
        placeholder="Add new civilization"
        @keydown.enter="addCivilization"
        @submit="addCivilization"
      />
    </div>
    <log-display ref="log" :max-entries="5" />
    <div class="buttons-container">
      <a tabindex="0" href="#" class="normal-button" @click="refresh">
        refresh
      </a>
      <a tabindex="0" href="#" class="urgent-button" @click="reinitializeDb">
        populate defaults
      </a>
      <a tabindex="0" href="#" class="urgent-button" @click="dropAll">
        delete all
      </a>
    </div>
		<civilization-list ref="list"/>
	</div>
</template>

<script>
import CivilizationList from "./CivilizationList.vue";
import InputText from "./InputText.vue"
import LogDisplay from "./LogDisplay.vue";

export default {
	components: {
		CivilizationList,
    InputText,
    LogDisplay
	},

  data() {
    return {
      newCivText: '',
    }
  },

  mounted() {
    this.$root.$on("log", (entry) => {
      this.$refs.log.pushEntry(entry);
    });
  },

  methods: {
    addCivilization() {
      const trimmedText = this.newCivText.trim()
      if (trimmedText) {
        const url = "/api/civilizations";
        axios.post(url, {
          name: trimmedText
        }).then((res) => {
          this.newCivText = "";
          const status = res.status == 200 ? "OK": res.status;
          const msg = `POST ${url} response: ${status}`;
          console.log(msg);
          this.$root.$emit("log", msg);
          this.$refs.list.load();
        }, (err) => {
          console.log(`POST ${url} error: ${err}`);
        });
      }
    },

    reinitializeDb() {
      const msg = "requesting database reinitialization";
      console.log(msg);
      this.$root.$emit("log", msg);
      const url = "/api/civilizations/initialize";
      axios.post(url).then((res) => {
        const status = res.status == 200 ? "OK": res.status;
        const msg = `POST ${url} response: ${status}`;
        console.log(msg);
        this.$root.$emit("log", msg);

        const json = res.data;
        console.log(json);
        this.$refs.list.load();
      }, (err) => {
        const msg = `POST ${url} error: ${err}`;
        console.log(msg);
        this.$root.$emit("log", msg);
      });
    },

    dropAll() {
      const url = "/api/civilizations/destroy-all";
      axios.delete(url).then((res) => {
        const status = res.status == 200 ? "OK": res.status;
        const msg = `DELETE ${url} response: ${status}`;
        console.log(msg);
        this.$root.$emit("log", msg);
        this.$refs.list.load();
      }, (err) => {
        console.log(`DELETE ${url} error: ${err}`);
      });
    },

    refresh() {
      this.$root.$emit("log", "refreshing civilization list");
      this.$refs.list.load();
    }
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
	color: $green;
}

.input-container {
  height: 3rem;
}

.buttons-container {
  margin: 0;
  display: flex;
  justify-content: space-evenly;
}

.normal-button {
  color: $white;
  background-color: $green;
  font-size: 1rem;
  font-weight: bold;
  text-decoration: none;
  padding: 0.3em 0.5em;
}

.normal-button:hover {
  background-color: #555;
}

.normal-button:focus {
  background-color: #555;
}

.urgent-button {
  color: $white;
  background-color: $urgent;
  font-size: 1rem;
  font-weight: bold;
  text-decoration: none;
  padding: 0.3em 0.5em;
}

.urgent-button:hover {
  background-color: #555;
}

.urgent-button:focus {
  background-color: #555;
}
</style>
