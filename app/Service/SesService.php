<?php

namespace App\Service;

class SesService
{
    /**
     * calculate the single exponential smoothing
     * @param float $a the smoothing factor or alpha
     * @param array $b the array of observed values
     * @return array the array of forecasted values
     */
    public function singleExponentialSmoothing(float $a, array $b, bool $nextPeriod = false): array|string
    {
        if (count($b) < 2) {
            throw new \Exception('Data tidak boleh kosong dan minimal harus ada dua data');
        }

        $forecast = [];
        $forecast[0] = $b[0]; // forecast pertama = aktual pertama

        for ($i = 1; $i < count($b); $i++) {
            $forecast[$i] = round($a * $b[$i] + (1 - $a) * $forecast[$i - 1]);
        }
        return $forecast;
    }

    /**
     * Calculate the mean squared error between the actual and forecasted values.
     *
     * @param array $aktual The array of actual values.
     * @param array $forcast The array of forecasted values.
     * @return float|string The mean squared error or an exception message if the array is empty.
     */
    public function meanSquaredError(array $aktual, array $forcast): float|string
    {
        $n = count($aktual);
        if ($n === 0) {
            return new \Exception('Array is empty');
        }
        $totalerror = 0;
        $counter = 0;
        for ($i = 1; $i < $n; $i++) {
            $error = $aktual[$i] - $forcast[$i-1];
            $totalerror += pow($error, 2);
            $counter++;
        }
        $mse = $totalerror / $counter;
        return $mse;
    }

    /**
     * Calculate the mean absolute deviation between the actual and forecasted values.
     *
     * @param array $aktual
     * @param array $forcast
     * @return float|string
     */
    public function meanAbsoluteDeviation(array $aktual, array $forcast): float|string
    {
        $mad = 0;
        $n = count($aktual);
        if ($n === 0 || count($forcast) === 0) {
            return new \Exception('Array is empty');
        }

        $count = 0;
        for ($i = 1; $i < $n; $i++) {
            $r = $aktual[$i] - $forcast[$i-1];
            $mad += abs($r);
            $count++;
        }

        return $mad / $count;
    }

    /**
     * Calculate the mean absolute percentage error between the actual and forecasted values.
     *
     * @param array $aktual
     * @param array $forcast
     * @return float|string
     */
    public function meanAbsolutePercentageError(array $aktual, array $forcast): float|string
    {
        $sum = 0;
        $n = count($aktual);
        if ($n === 0 || count($forcast) === 0) {
            throw new \Exception('Array is empty');
        }
        $count = 0;
        for ($i = 1; $i < $n; $i++) {
            $r = $aktual[$i] - $forcast[$i-1];
            $sum += abs($r / $aktual[$i]);
            $count++;
        }
        return ($sum / $count) * 100;
    }
}
