<?php

namespace App\Observers;

use App\Models\Loan;
use App\Services\LoanService;

class LoanObserver
{
    private $loanService;

    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }
    /**
     * Handle the Loan "created" event.
     */
    public function created(Loan $loan): void
    {
        $this->loanService->generateAmortizationSchedule($loan, []);
    }
}
