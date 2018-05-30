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
                        <amount-count-up-effect :amount='150004000'></amount-count-up-effect>
                    </p>
                </div>
            </div>
        </div>

        <details-table></details-table>

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
