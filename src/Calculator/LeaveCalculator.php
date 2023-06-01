<?php

declare(strict_types=1);

namespace App\Calculator;

class LeaveCalculator
{
    public function calculateWorkingDays(\DateTime $startDate, \DateTime $endDate): int
    {
        $days = 0;
        $currentDate = clone $startDate;

        while ($currentDate <= $endDate) {
            if (!$this->isWeekend($currentDate)) {
                ++$days;
            }

            $currentDate->modify('+1 day');
        }

        return $days;
    }

    private function isWeekend(\DateTime $date): bool
    {
        $dayOfWeek = $date->format('N');

        return $dayOfWeek >= 6;
    }
}
