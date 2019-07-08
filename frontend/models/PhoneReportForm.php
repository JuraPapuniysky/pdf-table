<?php

declare(strict_types=1);

namespace frontend\models;

use yii\base\Model;

class PhoneReportForm extends Model
{
    public $file;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, XLS'],
        ];
    }
}