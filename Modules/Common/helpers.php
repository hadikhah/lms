<?php

use Carbon\Carbon;
use Morilog\Jalali\Jalalian;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * @param string $title
 * @param string $body
 * @param string $type
 *
 * @return void
 * @throws ContainerExceptionInterface
 * @throws NotFoundExceptionInterface
 */
function newFeedback(string $title = 'عملیات موفقیت آمیز', string $body = 'عملیات با موفقیت انجام شد', string $type = 'success'): void
{
    $session   = session()->has('feedbacks') ? session()->get('feedbacks') : [];
    $session[] = ['title' => $title, "body" => $body, "type" => $type];
    session()->flash('feedbacks', $session);
}

/**
 * @param        $date
 * @param string $format
 *
 * @return Carbon|null
 */
function dateFromJalali($date, string $format = "Y/m/d"): ?Carbon
{
    return $date ? Jalalian::fromFormat($format, $date)->toCarbon() : null;
}

/**
 * @param        $date
 * @param string $format
 *
 * @return string
 */
function getJalaliFromFormat($date, string $format = "Y-m-d"): string
{
    return Jalalian::fromCarbon(Carbon::createFromFormat($format, $date))->format($format);
}

/**
 * @param Carbon $carbon
 *
 * @return Jalalian
 */
function createFromCarbon(Carbon $carbon): Jalalian
{
    return Jalalian::fromCarbon($carbon);
}
