<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

use App\Models\Loan;
use Illuminate\View\View;
use App\Http\Requests\LoanCreateRequest;
use App\Models\ExtraRepaymentSchedule;
use App\Services\LoanService;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index(): View
    {
        return view('loans.index', [
            'loans' => Loan::all()
        ]);
    }

    public function create(): View
    {
        return view('loans.create');
    }

    public function store(LoanCreateRequest $loanCreateRequest): RedirectResponse
    {
        Loan::create($loanCreateRequest->validated());
        return Redirect::route('loans.index')->with('status', 'loan-created');
    }

    public function getFetchAmortizationSchedule(Loan $loan): View
    {
        return view('loans.amortization', [
            'loan' => $loan,
            'schedule' => $loan->getLatestSchedule()
        ]);
    }

    public function postMakeExtraPayment(Request $request, Loan $loan)
    {
        $extraPaymentMonths = $request->extraPaymentMonths ?? [];
        (new LoanService())->generateAmortizationSchedule($loan, $extraPaymentMonths);
        return Redirect::route('loans.amortization.schedule', ['loan' => $loan]);
    }
}