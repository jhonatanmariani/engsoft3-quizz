<?php
/**
 * Created by PhpStorm.
 * User: werlich
 * Date: 13/01/20
 * Time: 17:50
 */

namespace App\Helpers;


class Utils
{

    public static function getAcessData():array {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";
        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'Linux';
        }elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'Mac';
        }elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }
        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)){
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }elseif(preg_match('/Firefox/i',$u_agent)){
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        }elseif(preg_match('/OPR/i',$u_agent)){
            $bname = 'Opera';
            $ub = "Opera";
        }elseif(preg_match('/Chrome/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
            $bname = 'Google Chrome';
            $ub = "Chrome";
        }elseif(preg_match('/Safari/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
            $bname = 'Apple Safari';
            $ub = "Safari";
        }elseif(preg_match('/Netscape/i',$u_agent)){
            $bname = 'Netscape';
            $ub = "Netscape";
        }elseif(preg_match('/Edge/i',$u_agent)){
            $bname = 'Edge';
            $ub = "Edge";
        }elseif(preg_match('/Trident/i',$u_agent)){
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }
        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }
        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                $version= $matches['version'][0];
            }else {
                $version= $matches['version'][1];
            }
        }else {
            $version= $matches['version'][0];
        }

        // check if we have a number
        if ($version==null || $version=="") {$version="?";}

        return [
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern,
            'ip' => $_SERVER['REMOTE_ADDR']
        ];
    }

    public static function formatCpf(string $cpf): string
    {
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cpf);
    }

    public static function formatCnpj(string $cnpj): string
    {
        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/",
            "\$1.\$2.\$3/\$4-\$5", $cnpj);
    }

    public static function onlyNumbers(string $str)
    {
        return preg_replace("/[^0-9]/", "", $str);
    }

    public static function formatPhone(string $phone) {
        if(strlen($phone) == 10) {
            return preg_replace("/(\d{2})(\d{4})(\d{4})/", "(\$1) \$2-\$3", $phone);
        }
        if(strlen($phone) == 11) {
            return preg_replace("/(\d{2})(\d{5})(\d{4})/", "(\$1) \$2-\$3", $phone);
        }
    }

    public static function generateToken(int $length = 50){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function formatMoney(float $value): string
    {
        return "R$ " . number_format($value, 2, ',', '.');
    }

    public static function formatAttachment(string $attachment): string
    {
        $attachment = explode("uploads/", $attachment);
        return count($attachment) > 1 ? BASEURL . "uploads/{$attachment[1]}" : '';
    }

    public static function moneyToFloat(string $str)
    {
        $str = str_replace('R$', '', $str);
        $str = trim($str);
        $str = str_replace('.', '', $str);
        return str_replace(',', '.', $str);
    }

    public static function firstUpper($word): string
    {
        $word = strtolower($word);
        $words = explode(' ', $word);
        $result = '';
        foreach ($words as $word) {
            $result .= ucfirst($word) . ' ';
        }
        return $result;
    }

}