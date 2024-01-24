<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\ExtraRepaymentSchedule;
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
    public function generateAmortizationSchedule(Loan $loan, array $extraPaymentMonths): void
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

            // Check if the current month is in the array of extra payment months
            $extraPayment = 0;
            if (in_array($month, $extraPaymentMonths)) {
                $extraPayment = min($loan->monthly_fixed_extra_payment, $remainingLoanBalance);
                $principalPayment += $extraPayment;
                $remainingLoanBalance -= $extraPayment;
            }

            // Update the remaining loan balance after the principal payment
            $remainingLoanBalance -= $principalPayment;
            $remainingLoanBalance = $remainingLoanBalance < 0 ? 0 : $remainingLoanBalance;
            
            // Build the current month's data
            $scheduleEntry = [
                'loan_id' => $loan->id,
                'month' => $month,
                'starting_balance' => round($remainingLoanBalance + $principalPayment, 2),
                'monthly_payment' => round($monthlyPayment, 2),
                'principal_payment' => round($principalPayment, 2),
                'interest_payment' => round($interestPayment, 2),
                'ending_balance' => round($remainingLoanBalance, 2),
            ];

            // if we have extra months array passed to the function then we're creating extra payments schedule
            if (count($extraPaymentMonths)) {
                $scheduleEntry['extra_repayment'] = $extraPayment;
            }

            // Add the current month's data to the schedule array
            $schedule[] = $scheduleEntry;

            // break the loop if the ending balance is 0
            if ($remainingLoanBalance == 0) {
                break;
            }
        }
        // Insert the generated schedule into the 'loan_amortization_schedules' or 'extra_repayment_schedule' table
        if ($extraPaymentMonths) {
            $loan->extraRepaymentSchedule()->delete();
            ExtraRepaymentSchedule::insert($schedule);
        } else {
            LoanAmortizationSchedule::insert($schedule);
        }
    }
}