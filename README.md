### RSA 数据加密解密方法
```php
function test(){
    $rsa = new \aibayanyu\rsa\RSA();
    // win下需要自己携带openssl.cnf
    $rsa->create("C:\usr\local\ssl\openssl.cnf");
    // linux下不需要携带任何参数
    $rsa->create();
}
```
### 加密解密数据
```php
function crypto(){
    $pk = new \aibayanyu\rsa\Crypto("public_key","private_key");
    $str = "ssss";
    dump("字符串");
    dump($str);
    // 使用公钥加密数据
    $pkStr = $pk->puEncrypt($str);
    dump("公钥加密数据");
    dump($pkStr);
    // 使用公钥解密
    $pkStr1 = $pk->pkDecrypt($pkStr);
    dump("私钥解密数据");
    dump($pkStr1);
    // 使用私钥加密数据
    $puStr = $pk->pkEncrypt($str);
    dump("私钥加密数据");
    dump($puStr);
    // 使用公钥解密数据
    $puStr1 = $pk->puDecrypt($puStr);
    dump("公钥解密数据");
    dump($puStr1);  
}
```