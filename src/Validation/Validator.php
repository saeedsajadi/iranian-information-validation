<?php

namespace SmartTwists\IranianInformationValidation;

class Validator
{
    /**
     * Checks if given value is valid International Bank Account Number (IBAN).
     *
     * @param  mixed $value
     * @return boolean
     */
    public static function isIban($value)
    {
        // build replacement arrays
        $iban_replace_chars = range('A', 'Z');
        foreach (range(10, 35) as $tempvalue) {
            $iban_replace_values[] = strval($tempvalue);
        }

        // prepare string
        $tempiban = strtoupper($value);
        $tempiban = str_replace(' ', '', $tempiban);

        // check iban length
        if (self::getIbanLength($tempiban) != strlen($tempiban)) {
            return false;
        }

        // build checksum
        $tempiban = substr($tempiban, 4) . substr($tempiban, 0, 4);
        $tempiban = str_replace($iban_replace_chars, $iban_replace_values, $tempiban);
        $tempcheckvalue = intval(substr($tempiban, 0, 1));

        for ($strcounter = 1; $strcounter < strlen($tempiban); $strcounter++) {
            $tempcheckvalue *= 10;
            $tempcheckvalue += intval(substr($tempiban, $strcounter, 1));
            $tempcheckvalue %= 97;
        }

        // only modulo 1 is iban
        return $tempcheckvalue == 1;
    }

    /**
     * Returns the designated length of IBAN for given IBAN
     *
     * @param  string $iban
     * @return integer
     */
    private static function getIbanLength($iban)
    {
        $countrycode = substr($iban, 0, 2);

        $lengths = array(
            'AL' => 28,
            'AD' => 24,
            'AT' => 20,
            'AZ' => 28,
            'BH' => 22,
            'BE' => 16,
            'BA' => 20,
            'BR' => 29,
            'BG' => 22,
            'CR' => 21,
            'HR' => 21,
            'CY' => 28,
            'CZ' => 24,
            'DK' => 18,
            'DO' => 28,
            'TL' => 23,
            'EE' => 20,
            'FO' => 18,
            'FI' => 18,
            'FR' => 27,
            'GE' => 22,
            'DE' => 22,
            'GI' => 23,
            'GR' => 27,
            'GL' => 18,
            'GT' => 28,
            'HU' => 28,
            'IS' => 26,
            'IE' => 22,
            'IL' => 23,
            'IT' => 27,
            'JO' => 30,
            'KZ' => 20,
            'XK' => 20,
            'KW' => 30,
            'LV' => 21,
            'LB' => 28,
            'LI' => 21,
            'LT' => 20,
            'LU' => 20,
            'MK' => 19,
            'MT' => 31,
            'MR' => 27,
            'MU' => 30,
            'MC' => 27,
            'MD' => 24,
            'ME' => 22,
            'NL' => 18,
            'NO' => 15,
            'PK' => 24,
            'PS' => 29,
            'PL' => 28,
            'PT' => 25,
            'QA' => 29,
            'RO' => 24,
            'SM' => 27,
            'SA' => 24,
            'RS' => 22,
            'SK' => 24,
            'SI' => 19,
            'ES' => 24,
            'SE' => 24,
            'CH' => 21,
            'TN' => 24,
            'TR' => 26,
            'AE' => 23,
            'GB' => 22,
            'VG' => 24,
            'DZ' => 24,
            'AO' => 25,
            'BJ' => 28,
            'BF' => 27,
            'BI' => 16,
            'CM' => 27,
            'CV' => 25,
            'IR' => 26,
            'CI' => 28,
            'MG' => 27,
            'ML' => 28,
            'MZ' => 25,
            'SN' => 28,
            'UA' => 29
        );

        return isset($lengths[$countrycode]) ? $lengths[$countrycode] : false;
    }

    /**
     * Checks if value is valid creditcard number.
     *
     * @param  mixed $card_number
     * @return boolean
     */
    public static function isCreditcard($card_number)
    {
        if (strlen($card_number) < 16 || !is_numeric($card_number)) return false;
        $card_number_checksum = '';

        foreach (str_split(strrev((string)$card_number)) as $i => $d) {
            $card_number_checksum .= $i % 2 !== 0 ? $d * 2 : $d;
        }

        return array_sum(str_split($card_number_checksum)) % 10 === 0;
    }

    /**
     * Checks if given value is valid International Standard Book Number (ISBN).
     *
     * @param  mixed $value
     * @return boolean
     */
    public static function isIsbn($value)
    {
        $value = str_replace(array(' ', '-', '.'), '', $value);
        $length = strlen($value);
        $checkdigit = substr($value, -1);

        if ($length == 10) {

            if (!is_numeric(substr($value, -10, 9))) {
                return false;
            }

            $checkdigit = (!is_numeric($checkdigit)) ? $checkdigit : strtoupper($checkdigit);
            $checkdigit = ($checkdigit == 'X') ? '10' : $checkdigit;

            $sum = 0;

            for ($i = 0; $i < 9; $i++) {
                $sum = $sum + ($value[$i] * (10 - $i));
            }

            $sum = $sum + $checkdigit;
            $mod = $sum % 11;

            return ($mod == 0);

        } elseif ($length == 13) {

            $sum = 0;

            $sum = $value[0] + ($value[1] * 3) + $value[2] + ($value[3] * 3) +
                $value[4] + ($value[5] * 3) + $value[6] + ($value[7] * 3) +
                $value[8] + ($value[9] * 3) + $value[10] + ($value[11] * 3);

            $mod = $sum % 10;

            $correct_checkdigit = 10 - $mod;
            $correct_checkdigit = ($correct_checkdigit == "10") ? "0" : $correct_checkdigit;

            return ($checkdigit == $correct_checkdigit);

        }

        return false;
    }

    /**
     * Checks if given value is date in ISO 8601 format.
     *
     * @param  mixed $value
     * @return boolean
     */
    public static function isIsodate($value)
    {
        $pattern = '/^([\+-]?\d{4}(?!\d{2}\b))((-?)((0[1-9]|1[0-2])(\3([12]\d|0[1-9]|3[01]))?|W([0-4]\d|5[0-2])(-?[1-7])?|(00[1-9]|0[1-9]\d|[12]\d{2}|3([0-5]\d|6[1-6])))([T\s]((([01]\d|2[0-3])((:?)[0-5]\d)?|24\:?00)([\.,]\d+(?!:))?)?(\17[0-5]\d([\.,]\d+)?)?([zZ]|([\+-])([01]\d|2[0-3]):?([0-5]\d)?)?)?)?$/';
        return (boolean)preg_match($pattern, $value);
    }

    /**
     * Checks if given value is date in ISO 8601 format.
     *
     * @param  mixed $value
     * @return boolean
     */
    public static function isZipcode($value)
    {
        $value = trim($value);
        $value = str_replace(array(' ', '-', '_', '.'), '', $value);
        if (strlen($value) != 10 || !is_numeric($value)) return false;
        return true;
    }

    /**
     * National Validation Code
     *
     * @access Public
     * @var Integer
     * @return bool
     */
    public static function isNationalcode($value)
    {
        $value = trim($value);

        if ((is_numeric($value)) && (strlen($value) == 10) && (strspn($value, $value[0]) != strlen($value))) {
            $subMid = self::subMidNumbers($value, 10, 1);
            $getNum = 0;
            for ($i = 1; $i < 10; $i++) {
                $getNum += (self::subMidNumbers($value, $i, 1) * (11 - $i));
            }
            $modulus = ($getNum % 11);
            if ((($modulus < 2) && ($subMid == $modulus)) || (($modulus >= 2) && ($subMid == (11 - $modulus))))
                return true;
        }
        return false;
    }

    /**
     * IR mobile validation
     *
     * @access Public
     * @var String
     * @return bool
     */
    public static function isIrMobile($value)
    {
        $value = self::convert2en_number($value);
        return ((!!preg_match('/(09)[0-9]{9}/', $value)) && (strlen($value) == 11));
    }

    /**
     * IR phone validation
     *
     * @access Public
     * @var String
     * @return bool
     */
    public static function isIrPhone($value)
    {
        $value = self::convert2en_number($value);
        if(strlen($value) != 11 || preg_match('/(0)[0-9]{10}/', $value) == false){
            return false;
        }

        $iran_provinces_code = [
            '021',
            '026',
            '025',
            '086',
            '024',
            '023',
            '081',
            '028',
            '031',
            '044',
            '011',
            '074',
            '083',
            '051',
            '045',
            '017',
            '041',
            '054',
            '087',
            '071',
            '066',
            '034',
            '056',
            '013',
            '077',
            '076',
            '061',
            '038',
            '058',
            '035',
            '084',
        ];

        if(in_array(substr($value,0, 3), $iran_provinces_code)) {
            return true;
        }

        return false;
    }

    /**
     * Get Portion of String Specified
     *
     * @access Protected
     * @var Integer
     * @return bool|string
     */
    protected static function subMidNumbers($number, $start, $length)
    {
        $number = substr($number, ($start - 1), $length);
        return $number;
    }
    
    private static function convert2en_number($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١','٠'];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

        return $englishNumbersOnly;
    }

}
