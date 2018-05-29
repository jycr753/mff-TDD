<?php
namespace Tests\Feature\Mff\Income;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class IncomeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Create income
     *
     * @param array $overrides
     * @return void
     */
    protected function createIncome($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $income = make('App\Models\Income', $overrides);

        return $income;
    }

    /** @test */
    public function a_user_can_insert_monthly_income()
    {
        $income = $this->createIncome();

        $this->post(
            route(
                'income.store',
                $income->toArray()
            )
        )->assertSessionHas('flash', 'Your income is saved!');

        $this->assertDatabaseHas(
            'incomes',
            [
                'gross_amount' => $income['gross_amount'],
                'net_amount' => $income['net_amount'],
            ]
        );
    }

    /** @test */
    public function income_date_is_required()
    {
        $income = $this->createIncome(['income_date' => null]);

        $this->post(
            route(
                'income.store',
                $income->toArray()
            )
        )->assertSessionHasErrors('income_date');
    }

    /** @test */
    public function income_needs_category()
    {
        $income = $this->createIncome(['category_id' => null]);

        $this->post(
            route(
                'income.store',
                $income->toArray()
            )
        )->assertSessionHasErrors();
    }

    /** @test */
    public function gross_amount_is_required()
    {
        $income = $this->createIncome(['gross_amount' => 0]);

        $this->post(
            route(
                'income.store',
                $income->toArray()
            )
        )->assertSessionHasErrors('gross_amount');
    }

    /** @test */
    public function gross_amount_can_not_be_negative()
    {
        $income = $this->createIncome(['gross_amount' => -76544]);

        $this->post(
            route(
                'income.store',
                $income->toArray()
            )
        )->assertSessionHasErrors('gross_amount');
    }

    /** @test */
    public function gross_amount_must_be_digits()
    {
        $income = $this->createIncome(['gross_amount' => 'sdfsdjf']);

        $this->post(
            route(
                'income.store',
                $income->toArray()
            )
        )->assertSessionHasErrors('gross_amount');
    }

    /** @test */
    public function net_amount_is_required()
    {
        $income = $this->createIncome(['net_amount' => 0]);

        $this->post(
            route(
                'income.store',
                $income->toArray()
            )
        )->assertSessionHasErrors('net_amount');
    }

    /** @test */
    public function net_amount_can_not_be_negative()
    {
        $income = $this->createIncome(['net_amount' => -78954]);

        $this->post(
            route(
                'income.store',
                $income->toArray()
            )
        )->assertSessionHasErrors('net_amount');
    }

    /** @test */
    public function net_amount_must_be_digits()
    {
        $income = $this->createIncome(['net_amount' => 'sdfsdjf']);

        $this->post(
            route(
                'income.store',
                $income->toArray()
            )
        )->assertSessionHasErrors('net_amount');
    }

    /** @test */
    public function gross_amount_must_greater_then_net_amount()
    {
        $income = $this->createIncome(
            [
                'gross_amount' => '2000.00',
                'net_amount' => '5000.00',
            ]
        );

        $response = $this->post(
            route(
                'income.store',
                $income->toArray()
            )
        )->assertSessionHasErrors('gross_amount');
    }
}