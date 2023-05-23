<?php

declare(strict_types=1);

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

final class EnumLeaveReasonType extends AbstractEnumType
{
    final public const PAID = 'paid';
    final public const UNPAID = 'unpaid';
    final public const EXCEPTIONAL = 'exceptional';
    final public const SENIORITY = 'seniority';

    protected static array $choices = [
        self::PAID => 'paid',
        self::UNPAID => 'unpaid',
        self::EXCEPTIONAL => 'exceptional',
        self::SENIORITY => 'seniority',
    ];
}
