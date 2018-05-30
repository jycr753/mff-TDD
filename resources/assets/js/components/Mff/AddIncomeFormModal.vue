<template>
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
                            <select class="form-control c-select" name="incomeIntervel">
                                <option disabled value="">Please select one</option>
                                <option value="Y">Yearly</option>
                                <option value="M" selected="selected">Monthly</option>
                                <option value="W">Weekly</option>
                                <option value="D">Daily</option>
                                <option value="H">Hourly</option>
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
                                v-model="currentMonth">
                        </datepicker>
                    </div>
                </b-field>
            </div>
        </div>
        <div class="columns is-mobile">
            <div class="column">
                <b-field label="Amount before SKAT">
                    <div class="control has-icons-left">
                        <vue-autonumeric
                            v-model="incomeBeforeSkat"
                            :options="{
                                digitGroupSeparator: '.',
                                decimalCharacter: ',',
                                decimalCharacterAlternative: '.',
                                currencySymbol: '\u00a0DKK',
                                currencySymbolPlacement: 's',
                                roundingMethod: 'U',
                                minimumValue: '0'
                            }"
                            class="input incomeAmount">
                        </vue-autonumeric>
                    </div>
                </b-field>
            </div>

            <div class="column">
                <b-field label="Amount after SKAT">
                    <div class="control has-icons-left">
                        <vue-autonumeric
                                v-model="incomeAfterSkat"
                                :options="{
                                digitGroupSeparator: '.',
                                decimalCharacter: ',',
                                decimalCharacterAlternative: '.',
                                currencySymbol: '\u00a0DKK',
                                currencySymbolPlacement: 's',
                                roundingMethod: 'U',
                                minimumValue: '0',
                            }"
                                class="input incomeAmount">
                        </vue-autonumeric>
                    </div>
                </b-field>
            </div>
        </div>
        <div class="columns is-mobile">
            <div class="column">
                <div class="control">
                    <wysiwyg name="body" v-model="incomeDescription" placeholder="Have something to say?"></wysiwyg>
                </div>
            </div>
        </div>    
    </section>
    <footer class="modal-card-foot">
      <button class="button is-success">Add</button>
      <button class="button" @click="$emit('close')">Cancel</button>
    </footer>
  </div>
</div>
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
      incomeBeforeSkat: 0.0,
      incomeAfterSkat: 0.0,
      incomeDescription: ""
    };
  },

  computed: {
    currentMonth() {
      return moment()
        .startOf("month")
        .format("YYYY-MM-DD hh:mm");
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