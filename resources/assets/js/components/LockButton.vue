<template>
    <button type="button" class="btn btn-default btn-default ml-a" @click="lockIt">
        <i :class="classes"></i>
    </button>
</template>
 
<script>
export default {
  computed: {
    classes() {
      return ["fa", this.locked ? "fa fa-lock" : "fa fa-unlock"];
    }
  },

  methods: {
      lockIt() {
        this.locked = true
      }
  }
};
</script>
