<?php

namespace App\Services\Phone;

class PhoneService{
    public function validatePhone($phone = 0){
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        try {
            $swissNumberProto   = $phoneUtil->parse($phone, "ID");
            $correctPhone       = $phoneUtil->format($swissNumberProto, \libphonenumber\PhoneNumberFormat::E164);

            return str_replace('+', '', $correctPhone);
        } catch (\libphonenumber\NumberParseException $e) {
            return false;
        }
    }
}
