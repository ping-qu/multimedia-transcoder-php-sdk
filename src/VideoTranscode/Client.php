<?php
namespace Pingqu\VideoTranscode;

/**
 * Class OssClient
 * @package Pingqu\VideoTranscode
 *
 * VideoTranscode(VT) 的客户端类，封装了用户通过VT API对OSS服务的各种操作，
 * 用户通过OssClient实例可以进行Bucket，Object，MultipartUpload, ACL等操作，具体
 * 的接口规则可以参考官方OSS API文档
 */
class Client
{
  /**
   * 构造函数
   *
   * 构造函数有几种情况：
   * 1. 一般的时候初始化使用 $ossClient = new OssClient($id, $key, $endpoint)
   * 2. 如果使用CNAME的，比如使用的是www.testoss.com，在控制台上做了CNAME的绑定，
   * 初始化使用 $ossClient = new OssClient($id, $key, $endpoint, true)
   * 3. 如果使用了阿里云SecurityTokenService(STS)，获得了AccessKeyID, AccessKeySecret, Token
   * 初始化使用  $ossClient = new OssClient($id, $key, $endpoint, false, $token)
   * 4. 如果用户使用的endpoint是ip
   * 初始化使用 $ossClient = new OssClient($id, $key, “1.2.3.4:8900”)
   *
   * @param string $accessKeyId 从OSS获得的AccessKeyId
   * @param string $accessKeySecret 从OSS获得的AccessKeySecret
   * @param string $endpoint 您选定的OSS数据中心访问域名，例如oss-cn-hangzhou.aliyuncs.com
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
   * 用来检查sdk所以来的扩展是否打开
   *
   * @throws OssException
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
                      throw new OssException("Extension {" . $item . "} is not installed or not enabled, please check your php env.");
                  }
              }
          } else {
              throw new OssException("function get_loaded_extensions not found.");
          }
      } else {
          throw new OssException('Function get_loaded_extensions has been disabled, please check php config.');
      }
  }
}
