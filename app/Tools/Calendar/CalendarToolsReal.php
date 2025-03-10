<?php

namespace App\Tools\Calendar;

use App\DTO\Date\DatePeriodDTO;
use App\Enums\CalendarMonthsNumberEnum;
use App\Enums\DateFormatEnum;
use DateInterval;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Date;

class CalendarToolsReal
{
    public function salutation(null|string $name, int $hour): string
    {
        if ($hour >= 4 && $hour <= 12) {
            return 'Bom dia ' . ($name ?? '');
        } elseif ($hour > 12 && $hour < 19) {
            return 'Boa tarde ' . ($name ?? '');
        } else {
            return 'Boa noite ' . ($name ?? '');
        }
    }

    public function getThisMonth(): string
    {
        $date = $this->getDateNow();
        return $date->format(DateFormatEnum::OnlyMonth->value);
    }

    public function getThisMonthString(?DateFormatEnum $format = null): string
    {
        $date = $this->getDateNow();
        return $date->format($format ? $format->value : DateFormatEnum::DefaultDbDateFormat->value);
    }

    public function getThisYear(): string
    {
        $date = $this->getDateNow();
        return $date->format(DateFormatEnum::OnlyCompleteYear->value);
    }

    public function getDateNow(): DateTime
    {
        return new DateTime();
    }

    /** @throws Exception */
    public function getDayFromStringDate(string $date): string
    {
        $date = new DateTime($date);
        return $date->format(DateFormatEnum::OnlyDay->value);
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
        if ($thisMonth == CalendarMonthsNumberEnum::January->value) {
            $lastMonth = CalendarMonthsNumberEnum::December->value;
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
        $startDate = $this->mountStringDateTime($year, CalendarMonthsNumberEnum::January->value, 1, '00:00:00');
        $endDate = $this->mountStringDateTime($year, CalendarMonthsNumberEnum::December->value, 31, '23:59:59');
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

    /** @throws Exception */
    public function addMonthInDate(string $date, int $months, string $format = DateFormatEnum::DefaultDbDateFormat->value): string
    {
        $date = new DateTime($date);
        return $date->add(new DateInterval('P'. $months . 'M'))->format($format);
    }

    /** @throws Exception */
    public function subMonthInDate(string $date, int $months, string $format = DateFormatEnum::DefaultDbDateFormat->value): string
    {
        $date = new DateTime($date);
        return $date->sub(new DateInterval('P'. $months . 'M'))->format($format);
    }

    /** @throws Exception */
    public function getIntervalMonthPeriodByMonthAndYear(int $month, int $year, int $interval): DatePeriodDTO
    {
        $dateStart = $this->mountStringDateTime($year, $month, 1, '00:00:00');
        $dateEnd = $this->addMonthInDate($dateStart, $interval);
        return new DatePeriodDTO($dateStart, $dateEnd);
    }

    /** @throws Exception */
    public function mountDatePeriodFromIsoDateRange(array $rangeDate): DatePeriodDTO
    {
        $dateStart = new DateTime($rangeDate['dateStart']);
        $dateEnd = new DateTime($rangeDate['dateEnd']);
        return new DatePeriodDTO(
            $dateStart->format(DateFormatEnum::UsaDateFormatWithoutTime->value) . ' 00:00:00',
            $dateEnd->format(DateFormatEnum::UsaDateFormatWithoutTime->value) . ' 23:59:59'
        );
    }

    public function makeDateRangeByDefaultFilterParams(array $dates): DatePeriodDTO
    {
        if (! isset($dates['dateStart'], $dates['dateEnd'])) {
            return CalendarTools::getThisMonthPeriod();
        }
        return CalendarTools::mountDatePeriodFromIsoDateRange($dates);
    }

    /** @throws Exception */
    public function makeDateByCreditCardClosingDay(string|int $closingDay, string|int $dueDay): DateTime
    {
        $month = $this->getThisMonth();
        $year = $this->getThisYear();
        $date =  new DateTime($this->mountStringDateTime($year, $month, $closingDay, '00:00:00'));
        if ((int)$dueDay < (int)$closingDay) {
            $date->add(new DateInterval('P1M'));
        }
        return $date;
    }

    public function getTodayDay(): string
    {
        return $this->getDateNow()->format(DateFormatEnum::OnlyDay->value);
    }

    /** @throws Exception */
    public function mountDateTimeByDateString(string $date): DateTime
    {
        return new DateTime($date);
    }

    public function getDateLabelByQueryParams(array $queryParams): string
    {
        $date = Date::createFromDate($queryParams['year'], $queryParams['month'], 1);
        $month = CalendarMonthsNumberEnum::getMonthName($date->month);
        return "$month de $date->year";
    }
}
