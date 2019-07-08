<?php

declare(strict_types=1);

namespace frontend\services;

use frontend\models\PhoneReportForm;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\web\UploadedFile;

class PhoneReportService
{
    const subdivisions = [
        '5940000071813744' => '',
        '5900100071813063' => '55',
        '5900110071813062' => '46',
        '5903000000000570' => '47',
        '5900120071813032' => '42',
        '5900160071813778' => '49',
        '5902000001000100' => '44',
        '5903010000000008' => '54',
        '5904000000730059' => '48',
        '5905010010940077' => '57',
        '5905020001880189' => '58',
        '5906000000760076' => '43',
        '5906010000640058' => '59',
        '5906020000210021' => '45',
        '5901010000600060' => '49',
        '5902010000790079' => '53',
    ];

    const UPLOAD_PATH = 'uploads/phone-report';

    public function uploadPhoneReport(PhoneReportForm $phoneReportForm): string
    {
        $phoneReportForm->file = UploadedFile::getInstance($phoneReportForm, 'file');

        $fileName = '';

        if ($phoneReportForm->validate()) {
            if (!file_exists(self::UPLOAD_PATH)) {
                mkdir(self::UPLOAD_PATH);
            }

            $fileName = self::UPLOAD_PATH . '/' . $phoneReportForm->file->baseName . '.' . $phoneReportForm->file->extension;
            $phoneReportForm->file->saveAs($fileName);
        }

        return $fileName;
    }

    public function createPhoneReportFile(string $inputXlsFileName): string
    {
        $outCSVFileName = 'uploads/phone-report/' . date('d-m-Y') . '.csv';
        $spreadsheed = IOFactory::load($inputXlsFileName);
        $sheetData = $spreadsheed->getActiveSheet()->toArray(null, true, true, true);
        $csvFp = fopen($outCSVFileName, 'w');
        $currentDivision = '';
        foreach ($sheetData as $item) {
            if (is_numeric($item['B']) && (strlen($item['B']) != 1)) {
                $currentDivision = self::subdivisions[$item['B']];
            }
            if (is_numeric($item['B']) && (strlen($item['B']) == 1)) {
                fputcsv($csvFp, [
                    '',
                    $this->formatDate($item['F']),
                    $this->formatTime($item['F']),
                    "($currentDivision)" . $item['C'],
                    str_replace(' ', '', $item['E']),
                    $item['D'],
                    $item['Q'],
                    (float)$item['S'],
                    '',
                ], '|');
            }
        }
        fclose($csvFp);
        $f = file_get_contents($outCSVFileName);
        $f = iconv("UTF-8", "WINDOWS-1251", $f);
        file_put_contents($outCSVFileName, $f);

        return $outCSVFileName;
    }

    private function formatDate($xlsDateTime)
    {
        $currentYear = date('Y');
        $currenntMonth = date('m');
        if ($currenntMonth == '01') {
            $currentYear = date('Y') - 1;
        }
        return str_replace('/', '.', substr($xlsDateTime, 0, 5)) . '.' . $currentYear;
    }

    private function formatTime($xlsDateTime)
    {
        return str_replace('.', ':', substr($xlsDateTime, 6));
    }
}