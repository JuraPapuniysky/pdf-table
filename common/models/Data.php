<?php

declare(strict_types=1);

namespace common\models;


use yii\base\Model;

/**
 * @property string $time
 * @property string $serviceType
 * @property string $direct
 * @property string $bits
 * @property string $phone
 * @property string $extraTime
 * @property float $cost
 * @property float $internationalRoamingCost
 * @property float $nationalRoamingCost
 * @property string $tariffZone
 * @property string $tariffTime
 * @property string $tariffGroup
 */
class Data extends Model
{
    public $time;
    public $serviceType;
    public $direct;
    public $bits;
    public $phone;
    public $extraTime;
    public $cost;
    public $internationalRoamingCost;
    public $nationalRoamingCost;
    public $tariffZone;
    public $tariffTime;
    public $tariffGroup;

    public function rules(): array
    {
        return [
            [['serviceType', 'direct', 'bits', 'phone', 'tariffZone', 'tariffGroup'], 'string'],
            [['cost', 'internationalRoamingCost', 'nationalRoamingCost',], 'float'],
            [['tariffTime', 'time', 'extraTime'], 'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'time' => 'Час',
            'serviceType' => 'Тип сервісу',
            'direct'=> 'Напрямок',
            'bits' => 'Кількість Сек/Kb',
            'phone' => 'Номер телефону/APN',
            'extraTime' => 'Використано пакетних/додаткових хвилин/грн.',
            'cost' => 'Вартість (без ПДВ), грн.',
            'internationalRoamingCost' => 'Вартість послуг міжнародного роумінгу**, грн',
            'nationalRoamingCost' => 'Вартість послуг національного роумінгу, грн.',
            'tariffZone' => 'Тарифна зона',
            'tariffTime' => 'Тарифний час',
            'tariffGroup' => 'Тарифна група',
        ];
    }
}