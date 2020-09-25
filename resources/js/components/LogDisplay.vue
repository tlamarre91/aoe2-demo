<template>
  <div class="log-display">
    <div v-for="entry in entries" class="log-display-entry">
      {{ entry }}
    </div>
  </div>
</template>

<script>
export default {
  props: {
    maxEntries: {
      type: Number,
      default: 5
    }
  },

  data() {
    return {
      entries: []
    }
  },

  methods: {
    putEntry(entry) {
      console.log(`logging ${entry}`);
      if (this.entries.length >= this.maxEntries) {
        this.entries = this.entries.slice(1);
      }

      this.entries.push(entry);
    }
  }
}
</script>

<style lang="scss">
@import '../../sass/_variables.scss';

.log-display {
  width: 100%;
  border: 1px solid #ddd;
  margin: 10 auto;
  height: 5.3rem;
  font-family: monospace;
}

.log-display-entry {
  text-overflow: ellipsis;
  overflow: hidden;
  white-space: nowrap;
}

</style>
