<?php

namespace Tests\Feature;

use App\Models\Loan;
use App\Models\User;
use App\Services\LoanService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoanTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_loan_page_is_displayed()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/loans/create');

        $response->assertOk();
    }

    public function test_loan_can_be_created()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post('/loans', [
                'amount' => 10000,
                'annual_interest_rate' => 2,
                'loan_term' => 2,
                'monthly_fixed_extra_payment' => 100
            ]);

        $response->assertSessionHasNoErrors();

        $user->refresh();
    }

    public function test_loan_is_created()
    {
        $loan = Loan::create([
            'amount' => 10000,
            'annual_interest_rate' => 2,
            'loan_term' => 2,
            'monthly_fixed_extra_payment' => 100
        ]);

        $this->assertSame(10000, $loan->amount);
        $this->assertSame(2, $loan->annual_interest_rate);
        $this->assertSame(2, $loan->loan_term);
        $this->assertSame(100, $loan->monthly_fixed_extra_payment);
    }

    public function test_amortization_schedule_is_created()
    {
        $loan = Loan::create([
            'amount' => 10000,
            'annual_interest_rate' => 2,
            'loan_term' => 2,
            'monthly_fixed_extra_payment' => 100
        ]);

        $this->assertGreaterThanOrEqual(1, $loan->loanAmortizationSchedule->count());
    }

    public function test_monthly_extra_repayment_can_be_made()
    {
        $loan = Loan::create([
            'amount' => 10000,
            'annual_interest_rate' => 2,
            'loan_term' => 2,
            'monthly_fixed_extra_payment' => 100
        ]);

        (new LoanService())->generateAmortizationSchedule($loan, [1, 2, 3]);

        $this->assertGreaterThanOrEqual(1, $loan->extraRepaymentSchedule->count());
    }
}