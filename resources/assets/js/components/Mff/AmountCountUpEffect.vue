<template>
    <ICountUp
        :startVal="startVal"
        :endVal="endVal"
        :decimals="decimals"
        :duration="duration"
        :options="options"
        @ready="onReady"
        />
</template>

<script>
import ICountUp from "vue-countup-v2";

export default {
  props: ["amount"],

  name: "AmountCountUpEffect",

  components: {
    ICountUp
  },

  data() {
    return {
      startVal: 0,
      endVal: this.amount,
      decimals: 2,
      duration: 2.5,
      options: {
        useEasing: true,
        useGrouping: true,
        separator: ",",
        decimal: ".",
        prefix: "DKK ",
        suffix: ""
      }
    };
  },

  methods: {
    onReady: function(instance, CountUp) {
      const that = this;
      instance.update(that.endVal);
    }
  }
};
</script>
<style scoped>
.iCountUp {
  font-size: 12em;
  margin: 0;
  color: #4d63bc;
}
</style>
