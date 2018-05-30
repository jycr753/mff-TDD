<template>
    <div class="box">
        <div class="level">
          <div class="level-item is-centered">
            <month-selector></month-selector>
          </div>
        </div>
        <div class="title">
            <div class="level-item has-text-centered">
                <div>
                    <p class="heading">Incomes</p>
                    <p class="title is-4">
                        <amount-count-up-effect :amount='parseInt(this.incomes[0].totalNetAmount)'></amount-count-up-effect>
                    </p>
                </div>
            </div>
        </div>

        <details-table :getData="this.incomes"></details-table>

        <div class="card-footer level">
            <button type="button" class="btn btn-default btn-default btn-sm">
                <i class="fas fa-chart-line"></i>
            </button>
            <button type="button" class="btn btn-default btn-default btn-sm" @click="showIncomeForm = true">
                <i class="fas fa-plus-circle"></i>
            </button>
        </div>

        <add-income-modal 
            :incomes="this.incomes" 
            :categories="this.categories"
            v-if="showIncomeForm" 
            @close="showIncomeForm = false">
        </add-income-modal>
        
    </div>
</template>
<script>
import AddIncomeModal from "./AddIncomeFormModal";

export default {
  props: ["incomes", "categories"],

  components: {
    AddIncomeModal
  },

  data() {
    return {
      showIncomeForm: false
    };
  },

  methods: {
    getCurrentMonthIncome() {
      return this.incomes;
    }
  }
};
</script>

