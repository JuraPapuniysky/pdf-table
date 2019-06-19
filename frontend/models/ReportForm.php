<?php

declare(strict_types=1);

namespace frontend\models;

use yii\base\Model;

/**
 * @property string $text
 */
class ReportForm extends Model
{
    public $text;

    public function rules(): array
    {
        return [
            [['text',], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'text' => 'Вставте текст',
        ];
    }
}