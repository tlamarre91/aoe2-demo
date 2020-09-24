<template>
  <div class="editable-text-row">
    <div class="editable-text-key">
      {{ label }}
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
        @click="startEditing"
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
      default: "click to set value"
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
      console.log(`done editing civ ${this.civilizationId}, { ${this.keyString}: ${this.value} }`);
      this.$emit('edited', [this.keyString, this.value]);
      this.editing = false;
    },

    startEditing() {
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
.editable-text-row {
  display: flex;
  width: 100%;
  height: 2rem;
  align-items: center;
}

.editable-text-key {
  min-width: 200px;
  max-width: 350px;
  font-weight: bold;
}

.editable-text-value {
}

.editable-text-placeholder {
  color: #999;
  font-style: italic;
}
</style>