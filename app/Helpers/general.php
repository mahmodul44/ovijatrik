<?php

use Carbon\Carbon;

if (!function_exists('getFiscalYearFromDate')) {
    /**
     * Get the fiscal year for a given date.
     * Fiscal year: July 1 - June 30
     *
     * @param string|Carbon $date
     * @return string
     */
    function getFiscalYearFromDate($date)
    {
        $date = Carbon::parse($date);

        $year = $date->year;
        $startOfFiscalYear = Carbon::createFromDate($year, 7, 1);

        if ($date->lt($startOfFiscalYear)) {
            return ($year - 1) . '-' . $year;
        } else {
            return $year . '-' . ($year + 1);
        }
    }
}


if (! function_exists('getStatusLabel')) {
    function getStatusLabel($status)
    {
        $labels = [
            0 => ['label' => 'Pending',  'class' => 'bg-yellow-200 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100'],
            1 => ['label' => 'Approved', 'class' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'],
            -1 => ['label' => 'Declined','class' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'],
        ];

        return $labels[$status] ?? ['label' => 'Unknown', 'class' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200'];
    }
}

