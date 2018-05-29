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
    <div class="title">56,950</div>
        <div class="level">
            <table class="table is-striped is-narrow is-hoverable">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Amount</th>
                        <th></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Total:</th>
                        <th>270,000</th>
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td>Salary</td>
                        <td>250,000</td>
                        <td><i class="fa fa-edit"></i></td>
                    </tr>
                    <tr>
                        <td>Extra</td>
                        <td>20,000</td>
                        <td><i class="fa fa-edit"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer level">
            <button type="button" class="btn btn-default btn-default btn-sm">
                <i class="fa fa-bar-chart"></i>
            </button>
            <button type="button" class="btn btn-default btn-default btn-sm">
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </div>
</template>

<script>
export default {};
</script>
