<?php
namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

final class EnumLeaveReasonType extends AbstractEnumType
{

    public final const PAID ='paid';
    public final const UNPAID ='unpaid';
    public final const EXCEPTIONAL ='exceptional';
    public final const SENIORITY ='seniority';

    protected static array $choices = [
        self::PAID => 'paid',
        self::UNPAID => 'unpaid',
        self::EXCEPTIONAL => 'exceptional',
        self::SENIORITY => 'seniority',
    ];
}