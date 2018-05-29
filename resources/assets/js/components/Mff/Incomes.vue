<template>
    <div class="box">
    <div class="level">
        <div class="level-left">
          <div class="level-item">
            <div class="heading">Incomes</div>
          </div>
        </div>
        <div class="level-right">
          <div class="level-item">
            <button type="button" class="button is-small">
              << March >>
            </button>
          </div>
        </div>
      </div>
    <div class="title">
        <ICountUp
            :startVal="startVal"
            :endVal="endVal"
            :decimals="decimals"
            :duration="duration"
            :options="options"
            @ready="onReady"
            />
    </div>
        <div class="level">
            <table class="table is-striped is-narrow is-hoverable">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Amount (DKK)</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Total:</th>
                        <th><ICountUp
                            :startVal="startVal"
                            :endVal="endVal"
                            :decimals="decimals"
                            :duration="duration"
                            :options="options"
                            @ready="onReady"
                            /></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td>Salary</td>
                        <td><ICountUp
                            :startVal="startVal"
                            :endVal="endVal"
                            :decimals="decimals"
                            :duration="duration"
                            :options="options"
                            @ready="onReady"
                            /></td>
                        <td><i class="fas fa-pencil-alt"></i></td>
                        <td><i class="fas fa-trash-alt"></i></td>
                    </tr>
                    <tr>
                        <td>Extra</td>
                        <td><ICountUp
                            :startVal="startVal"
                            :endVal="endVal"
                            :decimals="decimals"
                            :duration="duration"
                            :options="options"
                            @ready="onReady"
                            /></td>
                        <td><i class="fas fa-pencil-alt"></i></td>
                        <td><i class="fas fa-trash-alt"></i></td>
                    </tr>
                    <tr>
                        <td class="strikethrough">SKAT</td>
                        <td class="strikethrough"><ICountUp
                            :startVal="startVal"
                            :endVal="endVal"
                            :decimals="decimals"
                            :duration="duration"
                            :options="options"
                            @ready="onReady"
                            /></td>
                        <td></td>
                        <td><i class="far fa-trash-alt"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer level">
            <button type="button" class="btn btn-default btn-default btn-sm">
                <i class="fas fa-chart-line"></i>
            </button>
            <button type="button" class="btn btn-default btn-default btn-sm">
                <i class="fas fa-plus-circle"></i>
            </button>
        </div>
    </div>
</template>

<script>
import ICountUp from "vue-countup-v2";
export default {
  name: "demo",
  components: {
    ICountUp
  },
  data() {
    return {
      startVal: 0,
      endVal: 120500,
      decimals: 0,
      duration: 2.5,
      options: {
        useEasing: true,
        useGrouping: true,
        separator: ",",
        decimal: ".",
        prefix: "",
        suffix: ""
      }
    };
  },
  methods: {
    onReady: function(instance, CountUp) {
      const that = this;
      instance.update(that.endVal + 100);
    }
  }
};
</script>
