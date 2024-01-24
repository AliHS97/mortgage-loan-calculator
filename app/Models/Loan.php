<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
        'annual_interest_rate',
        'loan_term',
        'monthly_fixed_extra_payment',
    ];

    public function loanAmortizationSchedule()
    {
        return $this->hasMany(LoanAmortizationSchedule::class);
    }

    public function extraRepaymentSchedule()
    {
        return $this->hasMany(ExtraRepaymentSchedule::class);
    }

    public function getLatestSchedule()
    {
        return $this->extraRepaymentSchedule->count() ? $this->extraRepaymentSchedule()->orderBy('id', 'ASC')->take($this->loan_term * 12)->get() : $this->loanAmortizationSchedule;
    }
}