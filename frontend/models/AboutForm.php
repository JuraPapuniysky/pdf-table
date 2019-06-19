<?php

declare(strict_types=1);

namespace frontend\models;

use yii\base\Model;

/**
 * @property string $data
 * @property string $time
 */
class AboutForm extends Model
{
    public $data;
    public $time;

    public function rules(): array
    {
        return [
            [['data', 'time',], 'string'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'data' => 'Приклад вхідних даних для конвертеру по трафіку',
            'time' => 'Приклад вхідних даних для конвертеру по часу',
        ];
    }
}