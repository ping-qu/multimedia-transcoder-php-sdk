<?php
namespace Pingqu\MultimediaTranscoder\V1;

use \Pingqu\OpenApi\Util as Util;

/**
 * Class Client
 * @package Pingqu\MultimediaTranscoder\V1
 *
 * Pingqu MultimediaTranscoder\V1(PQVT) 的客户端类，封装了用户通过VT API对PQVT服务的各种操作，
 * 用户通过Client实例可以进行Bucket，Object，MultipartUpload, ACL等操作，具体
 * 的接口规则可以参考官方PQVT API文档
 */
class Job
{

    private static $params = array();
    private static $header = array();
  /**
   * 构造函数
   *必须传$accessKeyId, $accessKeySecret, $endpoint
   *
   */
  public function __construct($accessKeyId, $accessKeySecret, $endpoint)
  {
      $accessKeyId = trim($accessKeyId);
      $accessKeySecret = trim($accessKeySecret);
      $endpoint = trim(trim($endpoint), "/");

      if (empty($accessKeyId)) {
          throw new Exception("access key id is empty");
      }
      if (empty($accessKeySecret)) {
          throw new Exception("access key secret is empty");
      }
      if (empty($endpoint)) {
          throw new Exception("endpoint is empty");
      }
      $this->accessKeyId = $accessKeyId;
      $this->accessKeySecret = $accessKeySecret;
      $this->endpoint = $endpoint;
      self::checkEnv();
  }

    /*
     * 设置请求参数
     *
     */
    public function set_params($params = array()){
        self::$params = $params;
    }

    /*
     * 设置请求头
     */
    public function set_header($header = array()){
        self::$header = $header;
    }

    /*
     * 携带签名信息发送http请求
     */
    public function send_request($method = null){
        \Pingqu\OpenApi\Auth\Sign::setConfig([
            'accessKeyId'=>$this->accessKeyId,
            'accessKey'=>$this->accessKeySecret
        ]);
        $method = empty($method)?'GET':$method;
        $para = empty(self::$params)?[]:self::$params;
        $httpCore = new \Pingqu\OpenApi\Http\RequestCore($this->endpoint);
        $httpCore->set_body(\DdvPhp\DdvUrl::buildQuery($para));
        $httpCore->set_method($method);
        foreach (self::$header as $key=>$item) {
            $httpCore->add_header($key,$item);
        }
        $httpCore->add_header('Authorization', \Pingqu\OpenApi\Auth\Sign::getAuth($httpCore));
        $httpResponse = $httpCore->send_request(true);
        return $httpResponse;
    }

  /**
   * 用来检查sdk所以来的扩展是否打开
   *
   * @throws Exception
   */
  public static function checkEnv()
  {
      if (function_exists('get_loaded_extensions')) {
          //检测curl扩展
          $enabled_extension = array("curl");
          $extensions = get_loaded_extensions();
          if ($extensions) {
              foreach ($enabled_extension as $item) {
                  if (!in_array($item, $extensions)) {
                      throw new Exception("Extension {" . $item . "} is not installed or not enabled, please check your php env.");
                  }
              }
          } else {
              throw new Exception("function get_loaded_extensions not found.");
          }
      } else {
          throw new Exception('Function get_loaded_extensions has been disabled, please check php config.');
      }
  }
  // 域名类型
  const PQVT_HOST_TYPE_NORMAL = "normal";//http://bucket.oss-cn-hangzhou.aliyuncs.com/object
  const PQVT_HOST_TYPE_IP = "ip";  //http://1.1.1.1/bucket/object
  const PQVT_HOST_TYPE_SPECIAL = 'special'; //http://bucket.guizhou.gov/object
  const PQVT_HOST_TYPE_CNAME = "cname";  //http://mydomain.com/object
}
