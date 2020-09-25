<template>
  <div class="civilization-card">
    <div class="row justify-content-center">
      <div class="card">
        <div class="card-header">
          <div class="civ-name">
            {{ civilization.name }}
          </div>
          <div class="remove-btn">
            <button @click="$emit('remove', civilization.id)">
              x
            </button>
          </div>
        </div>
        <div class="card-body">
          <editable-text-row 
             @edited="handleEditedText"
             :civilization-id="civilization.id"
             key-string="expansion"
             label="Expansion"
             :initial-value="civilization.expansion" />
          <editable-text-row 
             @edited="handleEditedText"
             :civilization-id="civilization.id"
             key-string="army_type"
             label="Army type"
             :initial-value="civilization.army_type" />
          <editable-text-row 
             @edited="handleEditedText"
             :civilization-id="civilization.id"
             key-string="team_bonus"
             label="Team bonus"
             :initial-value="civilization.team_bonus" />
          <div class="card-footer">
            <div class="created-at">
              created: {{ displayCreatedAt }}
            </div>
            <div class="updated-at">
              updated: {{ displayUpdatedAt }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import EditableTextRow from "./EditableTextRow.vue";

export default {
  components: {
    EditableTextRow
  },

  props: {
    initialCivilization: {
      type: Object,
      required: true
    }
  },

  data() {
    return {
      civilization: this.initialCivilization
    };
  },

  computed: {
    displayCreatedAt: function () {
      const options = {
        year: 'numeric', month: 'numeric', day: 'numeric',
        hour: 'numeric', minute: 'numeric', second: 'numeric',
      };
      const date = new Date(this.civilization.created_at);
      return new Intl.DateTimeFormat('en-US', options).format(date);
    },
    displayUpdatedAt: function () {
      const options = {
        year: 'numeric', month: 'numeric', day: 'numeric',
        hour: 'numeric', minute: 'numeric', second: 'numeric',
      };
      const date = new Date(this.civilization.updated_at);
      return new Intl.DateTimeFormat('en-US', options).format(date);
    }
  },

  mounted() {
    console.log('CivilizationCard mounted.')
  },

  methods: {
    //load() {
    //  axios.get(`/api/civilizations/${this.civilization.id}`).then((res) => {
    //    const msg = `GET ${this.civilization.id} result: ${res}`;
    //    this.$root.$emit("log", msg);
    //    console.log(msg);
    //  }, (err) => {
    //    console.log(`GET ${this.civilization.id} error: ${err}`);
    //  });
    //},

    handleEditedText(keyval) {
      const update = { };
      const key = keyval[0];
      const newValue = keyval[1];
      update[key] = newValue;
      console.log(update);
      axios.put(`/api/civilizations/${this.civilization.id}`, update).then((res) => {
        const status = res.status == 200 ? "OK" : res.status;
        const msg = `PUT civ ${this.civilization.id} response status: ${status}`;
        this.$root.$emit("log", msg);
        console.log(msg);
        console.log(res.data);
        this.civilization = res.data;
      }, (err) => {
        const msg = `PUT ${this.civilization.id} error: ${err}`;
        console.log(msg);
        this.$emit("log"< msg);
      });
    },

    handleEditedList(keyval) {
    }
  }
}
</script>

<style lang="scss">
@import '../../sass/_variables.scss';

*, *::before, *::after {
	box-sizing: border-box;
}


table {
  border-collapse: collapse;
  border: 1px solid rgb(200,200,200);
  letter-spacing: 1px;
  font-size: 0.8rem;
  width: 100%;
}

td, th {
  border: 1px solid #ddd;
  padding: 10px 20px;
}

th {
  background-color: rgb(235,235,235);
}

td {
  text-align: center;
}

.editable-text-row:nth-child(even) td {
  background-color: rgb(250,250,250);
}

.editable-text-row:nth-child(odd) td {
  background-color: rgb(235,235,235);
}

.civilization-card {
	max-width: 700px;
  padding: 10px;
  border: 1px solid #ddd;
	margin: 5px auto;
	line-height: 1.4;
	font-family: 'Nunito', sans-serif;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
}

.card-header {
  display: flex;
  justify-content: space-between;
  flex-direction: row;
  font-size: 1.2rem;
  font-weight: bold;
}

.card-footer {
  padding: 10px;
  display: flex;
  justify-content: space-between;
  flex-direction: row;
  font-size: 0.8rem;
  color: #888;
}

.civ-id {

}

.civ-name {
	color: $green;
}
</style>
