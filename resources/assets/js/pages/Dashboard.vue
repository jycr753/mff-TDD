<script>
import Incomes from "../components/Mff/Incomes";
import MonthlyExpensesChart from "../components/Mff/MonthlyExpensesChart";
import DashboardMenu from "../components/Mff/DashboardMenu";

export default {
  props: ["incomes"],

  components: {
    Incomes,
    MonthlyExpensesChart,
    DashboardMenu
  }
};
</script>
