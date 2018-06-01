<template>
<form @submit.prevent="validateIncome">
    <div class="modal is-active">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
        <p class="modal-card-title">Add monthly income</p>
        <button class="delete" aria-label="close" @click="$emit('close')"></button>
        </header>
        <section class="modal-card-body">
            <div class="columns is-mobile">
                <div class="column">
                    <b-field label="Income categories">
                        <div class="control">
                            <div class="select is-primary">
                                <select v-model="category" class="form-control c-select" name="category">
                                    <option value="" selected>Please select one</option>
                                    <option v-for="item in this.categories" :key="item.id" :value="item">{{item.name}}</option>
                                </select>
                            </div>
                        </div>
                    </b-field>
                </div>

                <div class="column">
                    <b-field label="Income collected month">
                        <div class="control">
                            <datepicker
                                    name="incomeDate"
                                    input-class="input incomeAmount"
                                    :minimumView="'month'"
                                    :placeholder="'Select 1st of the month'"
                                    v-model="this.currentMonth"
                                >
                            </datepicker>
                        </div>
                    </b-field>
                </div>
            </div>
            <div class="columns is-mobile">
                <div class="column">
                    <b-field label="Gross Income">
                        <div class="control has-icons-left">
                            <vue-autonumeric
                                v-model="grossIncome"
                                :options="{
                                    digitGroupSeparator: '.',
                                    decimalCharacter: ',',
                                    decimalCharacterAlternative: '.',
                                    currencySymbol: '\u00a0DKK',
                                    currencySymbolPlacement: 's',
                                    roundingMethod: 'U',
                                    minimumValue: '0'
                                }"
                                class="input incomeAmount"
                            >
                            </vue-autonumeric>
                        </div>
                    </b-field>
                </div>

                <div class="column">
                    <b-field label="Net Income">
                        <div class="control has-icons-left">
                            <vue-autonumeric
                                    v-model="netIncome"
                                    :options="{
                                    digitGroupSeparator: '.',
                                    decimalCharacter: ',',
                                    decimalCharacterAlternative: '.',
                                    currencySymbol: '\u00a0DKK',
                                    currencySymbolPlacement: 's',
                                    roundingMethod: 'U',
                                    minimumValue: '0',
                                }"
                                    class="input incomeAmount"
                                >
                            </vue-autonumeric>
                        </div>
                    </b-field>
                </div>
            </div>
            <div class="columns is-mobile">
                <div class="column">
                    <div class="control">
                        <wysiwyg name="body" v-model="description" placeholder="Have something to say?"></wysiwyg>
                    </div>
                </div>
            </div>    
        </section>
        <footer class="modal-card-foot">
        <button type="submit" class="button is-primary">Add</button>
        <button class="button" @click="$emit('close')">Cancel</button>
        </footer>
    </div>
    </div>
</form>
</template>
<script>
import Datepicker from "vuejs-datepicker";
import VueAutonumeric from "vue-autonumeric/src/components/VueAutonumeric";
import moment from "moment";

export default {
  props: ["incomes", "categories"],

  components: {
    Datepicker,
    VueAutonumeric
  },

  data() {
    return {
      showIncomeForm: false,
      category: "",
      incomeDate: "",
      getDate: this.currentMonth,
      grossIncome: 0.0,
      netIncome: 0.0,
      description: ""
    };
  },

  computed: {
    currentMonth() {
      return moment()
        .startOf("month")
        .format("YYYY-MM-DD");
    }
  },

  methods: {
    validateIncome() {
      axios
        .post("mff/incomes", {
          income_date: this.currentMonth,
          category_id: this.category.id,
          gross_amount: this.grossIncome + ".00",
          net_amount: this.netIncome + ".00",
          description: this.description
        })
        .then(response => {
          console.log(response.data.message);
          flash(response.data.message);
        });
    }
  }
};
</script>
<style scoped>
/*
    TODO import css vue2-autocomplete.css
     */
.modal-card {
  width: auto;
}
input {
  padding: 0.5em 0.5em;
  font-size: 100%;
  border: 1px solid #ccc;
  width: 100%;
}
.label {
  padding: 5px 0px 0px 5px;
}

.incomeAmount {
  padding: 0.5em 0.5em;
  font-size: 14px;
  font-weight: bold;
  border: 1px solid #ccc;
  width: 100%;
  text-align: right;
}
</style>