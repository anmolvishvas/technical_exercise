<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\LeaveCalculator;
use DateTime;
use PHPUnit\Framework\TestCase;

class LeaveCalculatorTest extends TestCase
{
    public function testCalculateWorkingDaysWithWeekend(): void
    {
        $leaveCalculator = new LeaveCalculator();

        $calculateWorkingDays = $leaveCalculator->calculateWorkingDays(new DateTime('2023-05-24T10:23:31.088Z'), new DateTime('2023-05-30T10:23:31.088Z'));

        $this->assertEquals(5,$calculateWorkingDays);
    }

    public function testCalculateWorkingDaysWithoutWeekend(): void
    {
        $leaveCalculator = new LeaveCalculator();

        $calculateWorkingDays = $leaveCalculator->calculateWorkingDays(new DateTime('2023-05-29T10:23:31.088Z'), new DateTime('2023-06-01T10:23:31.088Z'));

        $this->assertEquals(4,$calculateWorkingDays);
    }

    public function testCalculateWorkingDaysWithStartDateLaterThanEndDate(): void
    {
        $leaveCalculator = new LeaveCalculator();

        $calculateWorkingDays = $leaveCalculator->calculateWorkingDays(new DateTime('2023-06-29T10:23:31.088Z'), new DateTime('2023-06-01T10:23:31.088Z'));

        $this->assertEquals(0,$calculateWorkingDays);
    }

}
