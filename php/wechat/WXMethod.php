<?php
/**
 * Created by PhpStorm.
 * User: lqh
 * Date: 2018/1/18
 * Time: 上午4:27
 */

namespace App\Methods;


use Curl\Curl;

class WXMethod
{
    private $appId;
    private $appSecret;

    /**
     * WXBizDataCrypt constructor.
     * @param $appId string 小程序的appId
     * @param $appSecret string 小程序的appSecret
     */
    public function __construct($appId,$appSecret)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    /**
     * 检验数据的真实性，并且获取解密后的明文.
     * @param $code string 加密的用户数据
     * @return string 成功0，失败返回对应的错误码
     */
    public function decryptData($code)
    {
        try{
            $curl = new Curl();
            $request = $curl->get("https://api.weixin.qq.com/sns/jscode2session?appid={$this->appId}&secret={$this->appSecret}&js_code={$code}&grant_type=authorization_code");
            $request = json_decode($request,true);
            return isset($request['openid'])?$request['openid']:null;
        }catch (\Exception $ex){
            return null;
        }
    }
}
