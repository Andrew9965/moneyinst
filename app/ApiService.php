<?php

namespace App;

class ApiService{

    private $cryptParams = ['user_id' => 'encrypt_id', 'api_key' => 'encrypt_str'];

    function __construct()
    {
        $this->prot = config('api.prot');
        $this->host = config('api.host');
        $this->username = config('api.username');
        $this->key_api = config('api.key_api');
        $this->password = config('api.password');
    }

    public function overall_stats($sid, $user_id=false)
    {
        $timestamps = [];
        $timestamps['time_start'] = strtotime((request()->date_from && count(explode('.', request()->date_from))==3 ? request()->date_from : date('d.m.Y')).' 00:00:00');
        $timestamps['time_finish'] = strtotime((request()->date_to && count(explode('.', request()->date_to))==3 ? request()->date_to : date('d.m.Y')).' 23:59:59');

        $user = [];
        $user['status_user_id'] = $user_id ? $user_id : \Auth::user()->id;
        $user['user_site_id'] = $sid;

        $link = $this->getLink('overall_stats', array_merge([
            'user' => $this->username,
            'password' => $this->password
        ], $timestamps, $user));

        return $this->response($link);
    }

    public function set_key_api()
    {
        if(!\Auth::user()->api_key){
            \Auth::user()->api_key = md5(bcrypt(\Auth::user()->id));
            \Auth::user()->save();
        }
        $link = $this->getLink('set_key_api', [
            'user_id' => \Auth::user()->id,
            'api_key' => \Auth::user()->api_key
        ]);

        return $this->response($link);
    }

    private function response($link){
        $result = file_get_contents($link);
        $result = json_decode($result, true);
        if($result['error']){
            \Log::error($link);
            \Log::error($result);
            return $result;
            dd($result, $link);
            abort(500);
        }
        return $result;
    }

    private function getLink($method, $params){
        return $this->prot.'://'.$this->host.'/api/'.$method.'/'.implode('/', $this->encryptor($params));
    }

    private function encryptor($params){
        foreach ($params as $key => $val) {
            if(isset($this->cryptParams[$key])) $params[$key] = $this->{$this->cryptParams[$key]}($val);
        }
        return $params;
    }

    private function encrypt_str($s)
    {
        $pwd = 'peunae7O'; $n= 8 - strlen($s) % 8;
        if ($n == 8) $n=0;
        $s .= str_repeat(" ", $n);
        $ds = $this->encrypt_data($pwd, $s);
        $base=$this->safe_b64encode($ds);
        return trim($base, '=');
    }

    private function encrypt_id($id)
    {
        $str = (string)$id;
        $n = 16-strlen($str);
        return $this->encrypt_str(str_repeat("0", $n) . $str);
    }

    private function decrypt_str($s)
    {
        $pwd = "peunae7O";
        $str = $this->safe_b64decode($s);
        $ds = $this->decrypt_data($pwd, $str);
        $ds = rtrim($ds, " ");
        return $ds;
    }

    private function decrypt_id($str)
    {
        $str = $this->decrypt_str($str);
        return ltrim($str, "0");
    }

    private function safe_b64decode($string)
    {
        $data = str_replace(array("-","_"),array("+","/"),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) $data .= substr("====", $mod4);
        return base64_decode($data);
    }

    private function safe_b64encode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(array("+","/","="),array("-","_",""),$data);
        return $data;
    }
    private function encrypt_data($key, $text)
    {
        $iv_size = @mcrypt_get_iv_size(MCRYPT_DES, MCRYPT_MODE_ECB);
        $iv = @mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $encrypted_text = @mcrypt_encrypt(MCRYPT_DES, $key, $text, MCRYPT_MODE_ECB, $iv);
        return $encrypted_text;
    }

    private function decrypt_data($key, $text){

        $iv_size = @mcrypt_get_iv_size(MCRYPT_DES, MCRYPT_MODE_ECB);
        $iv = @mcrypt_create_iv($iv_size, MCRYPT_RAND);
        return @mcrypt_decrypt(MCRYPT_DES, $key, $text, MCRYPT_MODE_ECB, $iv);
    }

}

