<template>
    <div class="editable-list">
      <div class="editable-list-key">
        {{ label }}
        <a href="#"
           class="edit-icon"
           v-show="! editing"
           @click="startEditing" >
           <img tabindex="-1" height=15 width=15 src="/img/edit.svg" alt="edit this field" />
        </a>
      </div>
      <div class="editable-list-values">
        <textarea
          ref="input"
          class="editable-list-value-edit"
          @blur="finishEditing"
          v-model="linesepValues"
          :rows="Math.max(values.length, 3)"
          cols="60"
          v-if="editing" />
        <div
          class="editable-list-values-static"
          @keydown.enter="startEditing"
          @keydown.space="startEditing"
          v-else >
          <template v-if="values.length">
            <ul class="editable-list-values-list">
              <li
                v-for="(item, index) in values"
                :key="civilizationId.toString().concat(keyString).concat(index)" >
                <template v-if="renderLinks">
                  <a :href="item" target="_blank">
                    {{ item.split("/")[item.split("/").length - 1] }}
                  </a>
                </template>
                <template v-else>
                  {{ item }}
                </template>
              </li>
            </ul>
          </template>
          <template v-else>
            <span class="editable-list-placeholder">
              {{ placeholder }}
            </span>
          </template>
        </div>
      </div>
    </div>
</template>

<script>
export default {
  props: {
    civilizationId: Number,
    label: String,
    keyString: String,
    initialValues: String, // raw JSON representation of array
    placeholder: {
      type: String,
      default: "empty list"
    },
    renderLinks: {
      type: Boolean,
      default: false
    }
  },

  data() {
    return {
      editing: 0,
      values: this.initialValues ? JSON.parse(this.initialValues) : [],
      linesepValues: ""
    }
  },

  methods: {
    finishEditing() {
      this.editing = false;
      const trimmed = this.linesepValues.trim();
      if (trimmed) {
        this.values = this.linesepValues.trim().split("\n");
      } else {
        this.values = [];
      }

      const msg = `updating civ ${this.civilizationId}, ${this.keyString} with ${this.values.length} items`;
      console.log(msg);
      this.$root.$emit("log", msg);
      this.$emit("edited", [this.keyString, JSON.stringify(this.values)]);
    },

    startEditing(event) {
      event.preventDefault();
      this.linesepValues = this.values.join("\n");
      console.log('trying to edit');
      this.editing = true;
      this.$nextTick(() => {
        const input = this.$refs.input;
        input.focus();
      });
    }
  }
}
</script>

<style lang="scss">
.editable-list {
  display: flex;
  width: 100%;
  min-height: 2rem;
}

.editable-list-key {
  min-width: 200px;
  max-width: 350px;
  font-weight: bold;
}

.editable-text-value-edit {
  font-size: 1rem;
  font-family: sans-serif;
}

.editable-list-values-static {
  font-size: 1rem;
  font-family: sans-serif;
}

.editable-list-values-static:focus {
  background: #bbf;
  outline: none;
}

.editable-list-placeholder {
  color: #999;
  font-style: italic;
}

.editable-list-values-list {
  margin: 0;
  padding-left: 0px;
}
</style>
