<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

use App\Models\Loan;
use Illuminate\View\View;
use App\Http\Requests\LoanCreateRequest;

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
}