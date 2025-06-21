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
        $forecast[0] = (float) $b[0]; // forecast pertama = aktual pertama

        for ($i = 1; $i <= count($b); $i++) {
            $value = $a * $b[$i-1] + (1 - $a) * $forecast[$i - 1];
            $forecast[$i] = round($value, 1);
            if ($nextPeriod === true) {
                return $forecast[$i];
            }
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
    public function meanSquaredError(array $aktual, array $forcast, $nextPreode = false): array|string|float
    {
        $n = count($aktual);
        if ($n === 0) {
            return new \Exception('Array is empty');
        }
        if ($nextPreode === true) {
            $mse = 0;
            $counter = 0;
            for ($i = 1; $i < $n; $i++) {
                $error = $aktual[$i] - $forcast[$i];
                $mse += pow($error, 2);
                $counter++;
            }
            return $mse/$counter;
        }
        $mse = [];
        $mse[0] = 0;
        for ($i = 1; $i < $n; $i++) {
            $error = $aktual[$i] - $forcast[$i];
            $mse[$i] = pow($error, 2);

        }
        return $mse;
    }

    /**
     * Calculate the mean absolute deviation between the actual and forecasted values.
     *
     * @param array $aktual
     * @param array $forcast
     * @return float|string
     */
    public function meanAbsoluteDeviation(array $aktual, array $forcast, $nextPreode = false): array|string|float
    {
        $mad = [];
        $n = count($aktual);
        if ($n === 0 || count($forcast) === 0) {
            return new \Exception('Array is empty');
        }
        if($nextPreode === true) {
            $mad = 0;
            $counter = 0;
           for ($i = 1; $i < $n; $i++) {
               $r = $aktual[$i] - $forcast[$i];
               $mad += abs($r);
               $counter++;
           }
            return $mad/$counter;
        }
        $mad[0] = 0;
        for ($i = 1; $i < $n; $i++) {
            $r = $aktual[$i] - $forcast[$i];
            $mad[$i] = abs($r);
        }
        return $mad;
    }

    /**
     * Calculate the mean absolute percentage error between the actual and forecasted values.
     *
     * @param array $aktual
     * @param array $forcast
     * @return float|string
     */
    public function meanAbsolutePercentageError(array $aktual, array $forcast, $nextPreode = false): array|string|float
    {
        $mape = [];
        $n = count($aktual);
        if ($n === 0 || count($forcast) === 0) {
            throw new \Exception('Array is empty');
        }
        $count = 0;
        if ($nextPreode === true) {
            $map = 0;
            for ($i = 1; $i < $n; $i++) {
                $r = $aktual[$i] - $forcast[$i];
                $a = abs($r / $aktual[$i]);
                $map += $a;
                $count++;
            }
            return ($map/$count) * 100;
        }
        $mape[0] =0;
        for ($i = 1; $i < $n; $i++) {
            $r = $aktual[$i] - $forcast[$i];
            $a = abs($r / $aktual[$i]);
            $mape[$i] = $a * 100;
        }

        return $mape;
    }

}
