<?php 
namespace app\helpers\classes;

class Filter
{
    public function filter($type, $value)
    {
        switch ($type) {
            case 'string':
                $string =  htmlspecialchars($value, ENT_QUOTES);
                return $string;
                break;
            case 'int':
                $int = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
                return filter_var($int, FILTER_VALIDATE_INT);
                break;
            case 'email':
                $email = filter_var($value, FILTER_SANITIZE_EMAIL);
                return filter_var($email, FILTER_VALIDATE_EMAIL);
                break;
            default:
                # code...
                break;
        }
    }
}





?>