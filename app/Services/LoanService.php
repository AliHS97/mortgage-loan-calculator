<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\LoanAmortizationSchedule;

class LoanService
{
    /**
     * Generate an amortization schedule for a loan and store it in the database.
     *
     * This function calculates and generates an amortization schedule for a given loan,
     * taking into account the loan amount, annual interest rate, loan term, and any extra payments.
     * The schedule is then stored in the database table 'loan_amortization_schedules'.
     *
     * @param \App\Models\Loan $loan The loan for which to generate the amortization schedule.
     *
     * @return void
     */
    public function generateAmortizationSchedule(Loan $loan): void
    {
        $schedule = [];

        // Initialize remaining loan balance
        $remainingLoanBalance = $loan->amount;

        // Calculate monthly interest rate and total number of months
        $monthlyInterestRate = ($loan->annual_interest_rate / 12) / 100;
        $numberOfMonths = $loan->loan_term * 12;

        // Calculate the monthly payment using the amortization formula
        $monthlyPayment = ($loan->amount * $monthlyInterestRate) / (1 - pow((1 + $monthlyInterestRate), (-$numberOfMonths)));

        for ($month = 1; $month <= $numberOfMonths; $month++) {
            // Calculate interest and principal payments for the current month
            $interestPayment = $remainingLoanBalance * $monthlyInterestRate;
            $principalPayment = $monthlyPayment - $interestPayment;

            // Update the remaining loan balance after the principal payment
            $remainingLoanBalance -= $principalPayment;

            // Add the current month's data to the schedule array
            $schedule[] = [
                'loan_id' => $loan->id,
                'month' => $month,
                'starting_balance' => round($remainingLoanBalance + $principalPayment, 2),
                'monthly_payment' => round($monthlyPayment, 2),
                'principal_payment' => round($principalPayment, 2),
                'interest_payment' => round($interestPayment, 2),
                'ending_balance' => round($remainingLoanBalance, 2),
            ];
        }

        // Insert the generated schedule into the 'loan_amortization_schedules' table
        LoanAmortizationSchedule::insert($schedule);
    }
}