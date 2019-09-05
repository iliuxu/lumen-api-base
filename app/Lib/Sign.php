<?php


namespace App\Lib;


use Illuminate\Support\Facades\Request;

class Sign
{
    public static function authVerify($request, $secret)
    {
        if (empty($request) || empty($secret)) {
            return false;
        }

        if (isset($request['sign'])) {
            $sign = $request['sign'];
            unset($request['sign']);
        } else {
            return false;
        }
        ksort($request);
        $request = collect($request);
        $signStr = $request->map(function ($item, $key) {
            $value = is_array($item) ? json_encode($item, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) : $item;
            return $key . '=' . $value;
        })->implode('&');
        $signStr .= $secret;
        if ($sign !== md5($signStr)) {
            $request = $request->toArray();
            $request['sign'] = $sign;
            $request['success_sign'] = md5($signStr);
            $request['sign_str'] = $signStr;
            $request['ip'] = Request::getClientIps();
            app('logger')->info('auth verify error', $request);
            return false;
        }
        return true;
    }
}
