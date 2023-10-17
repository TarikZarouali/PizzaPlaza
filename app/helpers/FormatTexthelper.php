<?php
    class FormatTextHelper
    {
        /**
         *Format string to json readable result.
         * @param mixed $strData
         * @return void
         */
        public static function ConvertStringToJsonFormat(mixed $strData) 
        {
            // Convert string to json format.
            $json = json_encode($strData, JSON_PRETTY_PRINT);

            // Display readable json fromat.
            echo "<pre>" . $json . "<pre/>";
        }

        /**
         * Create info message.
         * @param string $message
         * @param string $type
         * @return string
         */
        public static function GetInfoMessage(string $message, string $type) : string
        {
            $cssInfoMessage  = ' <link rel="stylesheet" href="'.URLROOT.'/public/css/style.css">';
            $cssInfoMessage .= '<div class="alert '.$type.'">';
            $cssInfoMessage .= $message;
            $cssInfoMessage .= '</div>';

            return print($cssInfoMessage);
        }
    }
