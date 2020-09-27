<template>
  <div class="editable-text-header-container">
    <input
      ref="input"
      class="editable-text-header-edit"
      @keydown.enter="finishEditing"
      @blur="finishEditing"
      v-model="value"
      v-if="editing" />
    <span
      class="editable-text-header-static"
      @click="startEditing"
      @keydown.enter="startEditing"
      @keydown.space="startEditing"
      tabindex="0"
      v-else >
      <template v-if="value">
        {{ value }}
      </template>
      <template v-else>
        <span class="editable-text-header-placeholder">
          {{ placeholder }}
        </span>
      </template>
      <a href="#"
         class="edit-icon"
         @click="startEditing"
         >
         <img tabindex="-1" height=20 width=20 src="/img/edit.svg" alt="edit this field" />
      </a>
    </span>
  </div>
</template>

<script>
export default {
  props: {
    civilizationId: Number,
    initialValue: String,
    placeholder: {
      type: String,
      default: "click to set name"
    }
  },

  data() {
    return {
      editing: false,
      value: this.initialValue,
      oldValue: this.initialValue
    }
  },

  methods: {
    finishEditing() {
      this.value = this.value.trim().slice(0, 255);
      if (this.value != this.oldValue) {
        const msg = `updating civ ${this.civilizationId}, name: ${this.oldValue} => ${this.value}`;
        console.log(msg);
        this.$root.$emit("log", msg);
        this.$emit("edited", ["name", this.value]);
      }
      this.editing = false;
    },

    startEditing(event) {
      event.preventDefault();
      this.editing = true;
      this.$nextTick(() => {
        const input = this.$refs.input;
        this.oldValue = this.value;
        input.focus();
        if (this.value && this.value.length) {
          input.setSelectionRange(0, this.value.length);
        }
      });
    }
  }
}
</script>

<style lang="scss">
@import '../../sass/_variables.scss';

.editable-text-header-static {
	color: $green;
}

.editable-text-header-static:focus {
  background: #bbf;
  outline: none;
}

.editable-text-header-placeholder {
  color: #999;
  font-style: italic;
}
</style>
