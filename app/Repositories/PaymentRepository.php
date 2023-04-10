<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepository extends Repository
{
    protected $eloquent = Payment::class;
}
