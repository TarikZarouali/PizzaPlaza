<?php
    class DateTimeHelper
    {
        /**
         * Convert string date time to string date
         * @param [type] $strDateTime
         * @return void
         */
        public static function ConvertStringDateTimeToStringDate($strDate)
        {
            $timestamp = strtotime($strDate);
            $date      = date("Y-m-d", $timestamp);
            return $date;
        }

        /**
         * Convert system date time to string date time
         * @return string
         */
    }
?>