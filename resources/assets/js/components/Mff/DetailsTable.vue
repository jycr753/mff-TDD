<template>
    <table class="table is-striped is-narrow is-hoverable">
        <thead>
            <tr>
                <th>Type</th>
                <th><span class="is-pulled-right">Amount (DKK)</span></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Total:</th>
                <th>
                    <span class="is-pulled-right"><amount-count-up-effect :amount="parseInt(this.getData[0].totalNetAmount)"></amount-count-up-effect></span>
                </th>
                <th></th>
                <th></th>
            </tr>
        </tfoot>
        <tbody>
            <tr v-for="income in this.getData" :key="income.id">
                <td v-text="income.categoryName"></td>
                <td>
                    <span class="is-pulled-right">
                        <amount-count-up-effect :amount='income.net_amount'></amount-count-up-effect>
                    </span>
                </td>
                <td><i class="fas fa-pencil-alt"></i></td>
                <td><i class="fas fa-trash-alt"></i></td>
            </tr>
        </tbody>
    </table>
</template>
<script>
export default {
  props: ["getData"]
};
</script>
