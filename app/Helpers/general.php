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

if (!function_exists('amountInWords')) {
    function amountInWords($amount)
    {
        $amount = number_format($amount, 2, '.', '');
        $number = floor($amount);
        $decimal = round(($amount - $number) * 100);

        $words = [
            0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four',
            5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen',
            14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen',
            17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen',
            20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty',
            60 => 'Sixty', 70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
        ];

        $digits = ['', 'Hundred', 'Thousand', 'Lakh', 'Crore'];
        $str = [];
        $i = 0;

        while ($number > 0) {
            $divider = ($i == 1) ? 10 : 100;
            $number_part = $number % $divider;
            $number = (int)($number / $divider);

            if ($number_part) {
                $plural = ($i && $number_part > 9) ? '' : '';
                $hundred = ($i == 1 && $str[0]) ? ' and ' : '';

                if ($number_part < 21) {
                    $str[] = $words[$number_part] . ' ' . $digits[$i] . $plural . ' ' . $hundred;
                } else {
                    $str[] = $words[floor($number_part / 10) * 10]
                        . ' ' . $words[$number_part % 10]
                        . ' ' . $digits[$i] . $plural . ' ' . $hundred;
                }
            } else {
                $str[] = '';
            }

            $i++;
        }

        $taka = trim(implode('', array_reverse($str)));
        $paisa = $decimal ? " and {$words[$decimal / 10 * 10]} {$words[$decimal % 10]} Paisa" : '';

        return $taka . " Taka Only" . $paisa;
    }
}


