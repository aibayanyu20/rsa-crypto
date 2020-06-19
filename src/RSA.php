<?php
/**
 * @author: aibayanyu
 * Time: 2020/6/19 12:59
 */

namespace aibayanyu\rsa;

use Exception;

class RSA
{
    public function checkOs()
    {
        $os_name = PHP_OS;
        if (strpos($os_name, "Linux") !== false) {
            return true;
        } elseif (strpos($os_name, "WIN") !== false) {
            return false;
        }
    }

    /**
     * create public_key and private_key
     * @param array $configs
     * @return array
     * @throws Exception
     * @author: aibayanyu
     * Time: 2020/6/19 13:01
     */
    public function create($configs = [])
    {
        // 创建一个公钥和私钥
        $config = [
//            "digest_alg" => "sha256",
            "private_key_bits" => 1024,
            "private_key_type" => OPENSSL_KEYTYPE_RSA
        ];
        if (!$this->checkOs()) {
            // 当前是win系统需要设置openssl.cnf
            if (empty($configs)) throw new Exception("win系统下openssl.cnf需要手动配置");
            $config1['config'] = $configs;
            $res = openssl_pkey_new($config + $config1);
            openssl_pkey_export($res, $private_key, null, $config);
        } else {
            $res = openssl_pkey_new($config);
            openssl_pkey_export($res, $private_key);
        }
        $key = openssl_pkey_get_details($res);
        return [
            'private_key' => $private_key,
            'public_key' => $key['key']
        ];
    }
}
