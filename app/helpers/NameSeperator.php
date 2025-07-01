<?php

namespace App\helpers;

class NameSeperator
{
    public static function spit(string $name)
    { {
            $result = [
                "firstName" => "",
                "middleName" => "",
                "lastName" => "",
            ];

            $seperatedFullName = explode(" ", $name);

            switch (count($seperatedFullName)) {
                case 1:
                    $result["firstName"] = $seperatedFullName[0];
                    break;
                case 2:
                    $result["firstName"] = $seperatedFullName[0];
                    $result["lastName"] = $seperatedFullName[1];
                    break;

                case 3:
                    $result["firstName"] = $seperatedFullName[0];
                    $result["middleName"] = $seperatedFullName[1];
                    $result["lastName"] = $seperatedFullName[2];
                    break;
            }
            return $result;
        }
    }
}
