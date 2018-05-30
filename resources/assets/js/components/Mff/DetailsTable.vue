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
                    <span class="is-pulled-right"><amount-count-up-effect :amount='150004000'></amount-count-up-effect></span>
                </th>
                <th></th>
                <th></th>
            </tr>
        </tfoot>
        <tbody>
            <tr>
                <td>Salary</td>
                <td><span class="is-pulled-right"><amount-count-up-effect :amount='150000000'></amount-count-up-effect></span></td>
                <td><i class="fas fa-pencil-alt"></i></td>
                <td><i class="fas fa-trash-alt"></i></td>
            </tr>
            <tr>
                <td>Extra</td>
                <td><span class="is-pulled-right"><amount-count-up-effect :amount='4000'></amount-count-up-effect></span></td>
                <td><i class="fas fa-pencil-alt"></i></td>
                <td><i class="fas fa-trash-alt"></i></td>
            </tr>
            <tr>
                <td class="strikethrough">SKAT</td>
                <td><span class="is-pulled-right strikethrough"><amount-count-up-effect :amount='7000'></amount-count-up-effect></span></td>
                <td></td>
                <td><i class="far fa-trash-alt"></i></td>
            </tr>
        </tbody>
    </table>
</template>
