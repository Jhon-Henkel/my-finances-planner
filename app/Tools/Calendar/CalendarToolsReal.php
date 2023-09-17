<?php

namespace App\Tools\Calendar;

use App\DTO\Date\DatePeriodDTO;
use App\Enums\DateEnum;
use DateInterval;
use DateTime;
use Exception;

class CalendarToolsReal
{
    public function salutation(null|string $name, int $hour): string
    {
        if($hour >= 4 && $hour <= 12) {
            return 'Bom dia ' . $name ?? '';
        } elseif ($hour > 12 && $hour < 19) {
            return 'Boa tarde ' . $name ?? '';
        } else {
            return 'Boa noite ' . $name ?? '';
        }
    }

    /**
     * @throws Exception
     */
    public function stringUsToBrDate(string $date): string
    {
        $date = new DateTime($date);
        return $date->format(DateEnum::DEFAULT_BR_DATE_FORMAT);
    }

    public function getThisMonth(): string
    {
        $date = $this->getDateNow();
        return $date->format(DateEnum::ONLY_MONTH);
    }

    public function getThisYear(): string
    {
        $date = $this->getDateNow();
        return $date->format(DateEnum::ONLY_COMPLETE_YEAR);
    }

    public function getDateNow(): DateTime
    {
        return new DateTime();
    }

    /**
     * @throws Exception
     */
    public function getMonthFromStringDate(string $date): string
    {
        $date = new DateTime($date);
        $month = $date->format(DateEnum::ONLY_MONTH);
        return str_pad($month, 2, '0', STR_PAD_LEFT);
    }

    /**
     * @throws Exception
     */
    public function getYearFromStringDate(string $date): string
    {
        $date = new DateTime($date);
        return $date->format(DateEnum::ONLY_COMPLETE_YEAR);
    }

    /**
     * @throws Exception
     */
    public function getDayFromStringDate(string $date): string
    {
        $date = new DateTime($date);
        return $date->format(DateEnum::ONLY_DAY);
    }

    public function getThisMonthPeriod(): DatePeriodDTO
    {
        $thisMonth = $this->getThisMonth();
        $thisYear = $this->getThisYear();
        $startDate = $this->mountStringDateTime($thisYear, $thisMonth, 1, '00:00:00');
        $lastDay = $this->getLastDayOfData($startDate);
        $endDate = $this->mountStringDateTime($thisYear, $thisMonth, $lastDay, '23:59:59');
        return new DatePeriodDTO($startDate, $endDate);
    }

    public function getLastMonthPeriod(): DatePeriodDTO
    {
        $thisMonth = (int)$this->getThisMonth();
        $thisYear = (int)$this->getThisYear();
        if ($thisMonth == DateEnum::JANUARY_MONTH_NUMBER) {
            $lastMonth = DateEnum::DECEMBER_MONTH_NUMBER;
            $year = $thisYear - 1;
        } else {
            $lastMonth = $thisMonth - 1;
            $year = $thisYear;
        }
        $startDate = $this->mountStringDateTime($year, $lastMonth, 1, '00:00:00');
        $lastDay = $this->getLastDayOfData($startDate);
        $endDate = $this->mountStringDateTime($year, $lastMonth, $lastDay, '23:59:59');
        return new DatePeriodDTO($startDate, $endDate);
    }

    public function getThisYearPeriod(): DatePeriodDTO
    {
        return $this->getYearPeriod((int)$this->getThisYear());
    }

    public function getYearPeriod(int $year): DatePeriodDTO
    {
        $startDate = $this->mountStringDateTime($year, DateEnum::JANUARY_MONTH_NUMBER, 1, '00:00:00');
        $endDate = $this->mountStringDateTime($year, DateEnum::DECEMBER_MONTH_NUMBER, 31, '23:59:59');
        return new DatePeriodDTO($startDate, $endDate);
    }

    public function getLastFiveYearPeriod(): DatePeriodDTO
    {
        $year = (int)$this->getThisYear();
        $lastYear = $year - 5;
        $startDate = $this->mountStringDateTime($lastYear, DateEnum::JANUARY_MONTH_NUMBER, 1, '00:00:00');
        $endDate = $this->mountStringDateTime($year, DateEnum::DECEMBER_MONTH_NUMBER, 31, '23:59:59');
        return new DatePeriodDTO($startDate, $endDate);
    }

    public function getLastDayOfData(string $data): string
    {
        $day = date('t', strtotime($data));
        return str_pad($day, 2, '0', STR_PAD_LEFT);
    }

    public function mountStringDateTime(string|int $year, string|int $month, string|int $day, string $time): string
    {
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);
        $day = str_pad($day, 2, '0', STR_PAD_LEFT);
        return $year . '-' . $month . '-' . $day . ' ' . $time;
    }

    /**
     * @throws Exception
     */
    public function addMonthInDate(string $date, int $months, string $format = DateEnum::DEFAULT_DB_DATE_FORMAT): string
    {
        $date = new DateTime($date);
        return $date->add(new DateInterval('P'. $months . 'M'))->format($format);
    }

    /**
     * @throws Exception
     */
    public function getIntervalMonthPeriodByMonthAndYear(int $month, int $year, int $interval): DatePeriodDTO
    {
        $dateStart = $this->mountStringDateTime($year, $month, 1, '00:00:00');
        $dateEnd = $this->addMonthInDate($dateStart, $interval);
        return new DatePeriodDTO($dateStart, $dateEnd);
    }

    /**
     * @throws Exception
     */
    public function getMonthLabelWithYear(string $date): string
    {
        $date = new DateTime($date);
        $month = $date->format(DateEnum::ONLY_MONTH);
        $year = $date->format(DateEnum::ONLY_COMPLETE_YEAR);
        return $month . '/' . $year;
    }

    /**
     * @throws Exception
     */
    public function getMonthPeriodFromDate(string $date): DatePeriodDTO
    {
        $month = $this->getMonthFromStringDate($date);
        $year = $this->getYearFromStringDate($date);
        $startDate = $this->mountStringDateTime($year, $month, 1, '00:00:00');
        $lastDay = $this->getLastDayOfData($startDate);
        $endDate = $this->mountStringDateTime($year, $month, $lastDay, '23:59:59');
        return new DatePeriodDTO($startDate, $endDate);
    }
}