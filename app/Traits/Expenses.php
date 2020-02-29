<?php

namespace App\Traits;

trait Expenses
{

    /**
     * Generate next invoice number
     *
     * @return string
     */
    public function getNextBillNumber()
    {
        $prefix = setting('general.bill_number_prefix', 'BILL-');
        $next = setting('general.bill_number_next', '1');
        $digit = setting('general.bill_number_digit', '5');

        $number = $prefix . str_pad($next, $digit, '0', STR_PAD_LEFT);

        return $number;
    }

    /**
     * Increase the next invoice number
     */
    public function increaseNextBillNumber()
    {
        // Update next invoice number
        $next = setting('general.bill_number_next', 1) + 1;
        setting(['general.bill_number_next' => $next]);
        setting()->save();
    }
}