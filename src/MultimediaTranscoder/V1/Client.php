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
class Client
{
  /**
   * 构造函数
   *
   * 构造函数有几种情况：
   * 1. 一般的时候初始化使用 $client = new Client($id, $key, $endpoint)
   * 2. 如果使用CNAME的，比如使用的是www.testoss.com，在控制台上做了CNAME的绑定，
   * 初始化使用 $client = new Client($id, $key, $endpoint, true)
   * 3. 如果使用了阿里云SecurityTokenService(STS)，获得了AccessKeyID, AccessKeySecret, Token
   * 初始化使用  $client = new Client($id, $key, $endpoint, false, $token)
   * 4. 如果用户使用的endpoint是ip
   * 初始化使用 $client = new Client($id, $key, “1.2.3.4:8900”)
   *
   * @param string $accessKeyId 从PQVT获得的AccessKeyId
   * @param string $accessKeySecret 从PQVT获得的AccessKeySecret
   * @param string $endpoint 您选定的PQVT数据中心访问域名，例如oss-cn-hangzhou.aliyuncs.com
   * @param boolean $isCName 是否对Bucket做了域名绑定，并且Endpoint参数填写的是自己的域名
   * @param string $securityToken
   * @throws Exception
   */
  public function __construct($accessKeyId, $accessKeySecret, $endpoint, $isCName = false, $securityToken = NULL)
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
      $this->hostname = $this->checkEndpoint($endpoint, $isCName);
      $this->accessKeyId = $accessKeyId;
      $this->accessKeySecret = $accessKeySecret;
      $this->securityToken = $securityToken;
      self::checkEnv();
  }

  /**
   * 检查endpoint的种类
   * 如有有协议头，剥去协议头
   * 并且根据参数 is_cname 和endpoint本身，判定域名类型，是ip，cname，还是专有域或者官网域名
   *
   * @param string $endpoint
   * @param boolean $isCName
   * @return string 剥掉协议头的域名
   */
  private function checkEndpoint($endpoint, $isCName)
  {
      $ret_endpoint = null;
      if (strpos($endpoint, 'http://') === 0) {
          $ret_endpoint = substr($endpoint, strlen('http://'));
      } elseif (strpos($endpoint, 'https://') === 0) {
          $ret_endpoint = substr($endpoint, strlen('https://'));
          $this->useSSL = true;
      } else {
          $ret_endpoint = $endpoint;
      }

      if ($isCName) {
          $this->hostType = self::PQVT_HOST_TYPE_CNAME;
      } elseif (Util::isIPFormat($ret_endpoint)) {
          $this->hostType = self::PQVT_HOST_TYPE_IP;
      } else {
          $this->hostType = self::PQVT_HOST_TYPE_NORMAL;
      }
      return $ret_endpoint;
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
