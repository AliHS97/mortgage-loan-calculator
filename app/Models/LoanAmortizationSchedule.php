<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanAmortizationSchedule extends Model
{
    use HasFactory;

    protected $table = 'loan_amortization_schedule';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'loan_id',
        'month',
        'monthly_payment',
        'principal_payment',
        'interest_payment',
        'ending_balance'
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}