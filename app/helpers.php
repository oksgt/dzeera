<?php

if (! function_exists('formatCurrency')) {
    /**
     * Format a number as Indonesian currency.
     *
     * @param  float|int  $amount
     * @return string
     */
    function formatCurrency($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}
