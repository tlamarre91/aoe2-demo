<template>
    <div class="editable-list">
      <div class="editable-list-key">
        {{ label }}
        <a
          v-if="! editing"
          href="#"
          class="edit-icon"
          @click="startEditing" >
          <img tabindex="0" height=15 width=15 src="/img/edit.svg" alt="edit this field" />
        </a>
          <!--
          <a
            v-else
            href="#"
            class="save-icon"
            @click="finishEditing" >
            save
          </a>
          -->
      </div>
      <div class="editable-list-values">
        <div class="editable-list-item-container" v-if="editing">
          <div class="editable-list-item" v-for="(item, index) in values">
            <input
              class="editable-list-item-edit"
              v-model="item.value"
              :key="index"
              ref="inputs"
              />
            <a href="#"
               class="delete-icon"
               @click="deleteItem($event, index)" >
               <img tabindex="0" height=15 width=15 src="/img/delete.svg" alt="delete this row" />
            </a>
          </div>
          <a href="#"
             class="edit-button"
             @click="pushNewItem" >
             add item
          </a>
          <br />
          <a href="#"
             class="edit-button"
             @click="finishEditing" >
             save list
          </a>
        </div>
        <div
          class="editable-list-values-static"
          @keydown.enter="startEditing"
          @keydown.space="startEditing"
          v-else >
          <template v-if="values.length">
            <ul class="editable-list-values-list">
              <li
                v-for="(item, index) in values"
                :key="civilizationId.toString() + '-' + keyString + '-' + index.toString()" >
                <template v-if="renderLinks">
                  <a class="link-item" :href="item" target="_blank">
                    {{ item.value.split("/")[item.value.split("/").length - 1] }}
                  </a>
                </template>
                <template v-else>
                  {{ item.value }}
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
      values: (this.initialValues ? JSON.parse(this.initialValues) : []).map(item => ({ value: item })),
    }
  },

  methods: {
    finishEditing(event) {
      if (event) {
        event.preventDefault();
      }

      this.editing = false;
      this.values = this.values
        .map(v => ({ value: v.value.trim() }))
        .filter(v => v.value.length != 0);

      const msg = `updating civ ${this.civilizationId}, ${this.keyString} with ${this.values.length} items`;
      console.log(msg);
      this.$root.$emit("log", msg);
      const str = JSON.stringify(this.values.map(v => v.value));
      console.log(str);
      this.$emit("edited", [this.keyString, str]);
    },

    startEditing(event) {
      event.preventDefault();
      this.editing = true;
    },

    deleteItem(event, index) {
      event.preventDefault();
      this.values.splice(index, 1);
    },

    pushNewItem() {
      event.preventDefault();
      this.values.push({ value: "" });
    }
  }
}
</script>

<style lang="scss">
@import '../../sass/_variables.scss';
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

.editable-list-item-edit {
  display: block;
  width: 300px;
}

.editable-list-item-container {
}

.editable-list-item {
  display: flex;
  flex-direction: row;
  align-items: center;
}

.edit-button {
  color: $green;
  font-style: italic;
  text-decoration: none;
}

.edit-button:visited {
  color: $green;
}
.link-item {
  color: $blue;
  text-decoration: none;
}

.link-item:visited {
  color: $blue;
}
</style>
