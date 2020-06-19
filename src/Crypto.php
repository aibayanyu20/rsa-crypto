<?php
/**
 * @author: aibayanyu
 * Time: 2020/6/19 13:00
 */

namespace aibayanyu\rsa;

use Exception;

class Crypto
{
    private $puk;

    private $pvk;

    public function __construct($puk,$pvk)
    {
        $this->pvk = openssl_pkey_get_private($pvk);
        if (!$this->pvk) throw new Exception("私钥格式不正确");
        $this->puk = openssl_pkey_get_public($puk);
        if (!$this->puk) throw new Exception("公钥格式不正确");
    }

    /**
     * 公钥加密
     * @param string $originalData
     * @return string
     * @throws Exception
     * @author: aibayanyu
     * Time: 2020/6/19 10:51
     */
    public function puEncrypt($originalData){
        if (!is_string($originalData)) throw new Exception("传入的数据只能为字符串");
        $crypto = '';
        foreach (str_split($originalData, 117) as $chunk) {
            openssl_public_encrypt($chunk, $encryptData, $this->puk);
            $crypto .= $encryptData;
        }
        return base64_encode($crypto);
    }

    /**
     * 公钥解密
     * @param string $encryptData
     * @return string
     * @throws Exception
     */
    public function puDecrypt($encryptData){
        if (!is_string($encryptData)) throw new Exception("需要解密的数据不正确");
        $crypto = '';
        foreach (str_split(base64_decode($encryptData), 128) as $chunk) {
            openssl_public_decrypt($chunk, $decryptData, $this->puk);
            $crypto .= $decryptData;
        }
        return $crypto;
    }

    /**
     * 私钥加密
     * @param string $originalData
     * @return string
     * @throws Exception
     */
    public function pkEncrypt($originalData){
        if (!is_string($originalData)) throw new Exception("私钥加密数据不正确");
        $crypto = '';
        foreach (str_split($originalData, 117) as $chunk) {
            openssl_private_encrypt($chunk, $encryptData, $this->pvk);
            $crypto .= $encryptData;
        }
        return base64_encode($crypto);
    }

    /**
     * 私钥解密
     * @param string $encryptData
     * @return string
     * @throws Exception
     * @author: aibayanyu
     * Time: 2020/6/19 11:25
     */
    public function pkDecrypt($encryptData){
        if (!is_string($encryptData)) throw new Exception("需要解密的数据不正确");
        $crypto = '';
        foreach (str_split(base64_decode($encryptData), 128) as $chunk) {
            openssl_private_decrypt($chunk, $decryptData, $this->pvk);
            $crypto .= $decryptData;
        }
        return $crypto;
    }
}