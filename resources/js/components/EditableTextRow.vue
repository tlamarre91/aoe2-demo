<template>
  <div class="editable-text-row">
    <div class="editable-text-key">
      {{ label }}
      <a href="#"
         class="edit-icon"
         v-show="! editing"
         @click="startEditing"
         tabindex="0">
         <img height=15 width=15 src="/img/edit.svg" alt="edit this field" />
      </a>
    </div>
    <div class="editable-text-value">
      <input
        ref="input"
        class="editable-text-value-edit"
        @keydown.enter="finishEditing"
        @blur="finishEditing"
        v-model="value"
        v-if="editing" />
      <span
        class="editable-text-value-static"
        @keydown.enter="startEditing"
        @keydown.space="startEditing"
        v-else >
        <template v-if="value">
          {{ value }}
        </template>
        <template v-else>
          <span class="editable-text-placeholder">
            {{ placeholder }}
          </span>
        </template>
      </span>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    civilizationId: Number,
    label: String,
    keyString: String,
    initialValue: String,
    placeholder: {
      type: String,
      default: "empty value"
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
      if (this.value) {
        this.value = this.value.trim().slice(0, 255);
        if (this.value != this.oldValue) {
          const msg = `updating civ ${this.civilizationId}, ${this.keyString}: ${this.oldValue} => ${this.value}`;
          console.log(msg);
          this.$root.$emit("log", msg);
          this.$emit('edited', [this.keyString, this.value]);
        }
      }
      this.editing = false;
    },

    startEditing(event) {
      event.preventDefault(); // don't let the keypress event have any further effect
      this.editing = true;
      // wait a tick so that we actually have the <input> rendered and available for focus/selection
      this.$nextTick(() => {
        const input = this.$refs.input;
        this.oldValue = this.value;
        input.focus();
        if (this.value && this.value.length) {
          input.setSelectionRange(0, this.value.length);
        }
      });
    }
  },
}
</script>

<style lang="scss">
@import '../../sass/_variables.scss';

.editable-text-row {
  display: flex;
  width: 100%;
  align-items: center;
  padding-top: 5px;
  padding-bottom: 5px;
}

.editable-text-key {
  min-width: 200px;
  max-width: 350px;
  font-weight: bold;
}

.editable-text-value-edit {
  font-size: 1rem;
  font-family: sans-serif;
}

.editable-text-value-static {
  font-size: 1rem;
  font-family: sans-serif;
}

.editable-text-value-static:focus {
  background: #bbf;
  outline: none;
}

.editable-text-placeholder {
  color: #999;
  font-style: italic;
}
</style>
