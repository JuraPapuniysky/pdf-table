<?php

declare(strict_types=1);

namespace frontend\services;

use common\models\Data;

class DataConverterService
{
    public function getDataModels(string $text): array
    {
        $arrayText = explode(PHP_EOL, $text);
        $dates = [];
        $popNrs = [];
        $data = [];
        for ($i = 0; $i < count($arrayText); $i++) {
            if (\DateTime::createFromFormat('d.m.Y H:i:s', trim($arrayText[$i])) !== false) {
                array_push($dates, $arrayText[$i]);
            }

            if (strstr(trim($arrayText[$i]), 'POP') !== false) {
                array_push($popNrs, $arrayText[$i] . $arrayText[$i + 1] . $arrayText[$i + 2] . $arrayText[$i + 3] . $arrayText[$i + 4]);
            }

            if (strstr(trim($arrayText[$i]), 'Вхідне') !== false) {
                array_push($popNrs, $arrayText[$i] . $arrayText[$i + 1] . $arrayText[$i + 2] . $arrayText[$i + 3]);
            }

            if (strstr(trim($arrayText[$i]), 'Вих.') !== false) {
                array_push($data, $arrayText[$i] . $arrayText[$i + 1] . $arrayText[$i + 2]);
            }

            if (strstr(trim($arrayText[$i]), 'Вх.') !== false) {
                array_push($data, $arrayText[$i]);
            }
        }

        return [$dates, $popNrs, $data];
    }

    public function createXlsFromDataModels(array $dataModels): array
    {
        return $dataModels;
    }
}