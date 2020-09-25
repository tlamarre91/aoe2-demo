<template>
  <div class="input">
    <input
      type="text"
      class="input-text"
      :placeholder="placeholder"
      :value="value"
      v-on="listeners" >
    <a class="input-submit"
       tabindex="0"
       href="#"
       @click="$emit('submit')" >
      add
    </a>
  </div>
</template>

<script>
export default {
  props: {
    value: {
      type: String,
      default: '',
    },

    placeholder: String
  },
  computed: {
    listeners () {
      return {
        // Pass all component listeners directly to input
        ...this.$listeners,
        // Override input listener to work with v-model
        input: event => this.$emit('input', event.target.value)
      }
    }
  }
}
</script>

<style lang="scss" scoped>

@import '../../sass/_variables.scss';

.input {
  display: flex;
  flex-direction: row;
}

.input-text {
  width: 90%;
  height: 3rem;
  padding: 8px 10px;
  border: 1px solid $blue;
  font-size: 1.2rem;
  font-family: sans-serif;
}

.input-submit {
  width: 10%;
  height: 3rem;
  color: $white;
  background-color: $green;
  font-size: 1rem;
  font-weight: bold;
  text-decoration: none;
  align-self: center;
  padding: 0.7rem 1.2rem;;
}
.input-submit:hover {
  background-color: #555;
}

.input-submit:focus {
  background-color: #555;
}
</style>

