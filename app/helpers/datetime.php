<?php


/**
 * @param $date
 * @return false|string
 */
function defaultDateTimeFormat($date)
{
    return date('Y-m-d H:i:s', strtotime($date));
}

/**
 * @param $date
 * @return false|string
 */
function defaultDateFormat($date)
{
    return date('Y-m-d', strtotime($date));
}

/**
 * @param $format
 * @param $date
 * @return false|string
 */
function customDateFormat($format, $date) {
    return date($format, strtotime($date));
}
