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

  }

    public function getFileJob($add_time_end = null,$add_time_start = null,$state = null){
        $client = new \Pingqu\OpenApi\Api($this->accessKeyId, $this->accessKeySecret,$this->endpoint.'/v4_0/admin/file/job');
        $params = [
            'add_time_end'=>isset($add_time_end)?$add_time_end:null,
            'add_time_start'=>isset($add_time_start)?$add_time_start:null,
            'state'=>isset($state)?$state:null
        ];
        $client->setParams($params);
        $respone = $client->sendRequest('GET');
        $body = json_decode($respone->body);
        if($body->errorId == 'OK'){
            //dd($body);
            return ['lists'=>$body->lists,'page'=>$body->page];
        }else{
            throw new \DdvPhp\DdvFile\Exception\Sys('添加失败',$body->message);
        }
    }

    public function getVideoJob($add_time_end = null,$add_time_start = null,$state = null){
        $client = new \Pingqu\OpenApi\Api($this->accessKeyId, $this->accessKeySecret,$this->endpoint.'/v4_0/admin/Video/job');
        $params = [
            'add_time_end'=>isset($add_time_end)?$add_time_end:null,
            'add_time_start'=>isset($add_time_start)?$add_time_start:null,
            'state'=>isset($state)?$state:null
        ];
        $client->setParams($params);
        $respone = $client->sendRequest('GET');
        $body = json_decode($respone->body);
        if($body->errorId == 'OK'){
            //dd($body);
            return ['lists'=>$body->lists,'page'=>$body->page];
        }else{
            throw new \DdvPhp\DdvFile\Exception\Sys('添加失败',$body->message);
        }
    }

    public function deleteFileJob($job_id){
        $client = new \Pingqu\OpenApi\Api($this->accessKeyId, $this->accessKeySecret,$this->endpoint.'/v4_0/admin/file/job/'.$job_id);
        $params = [

        ];
        $client->setParams($params);
        $respone = $client->sendRequest('DELETE');
        $body = json_decode($respone->body);
        if($body->errorId == 'OK'){
            return true;
        }else{
            throw new \DdvPhp\DdvFile\Exception\Sys('添加失败',$body->message);
        }
    }

    public function deleteVideoJob($job_id){
        $client = new \Pingqu\OpenApi\Api($this->accessKeyId, $this->accessKeySecret,$this->endpoint.'/v4_0/admin/Video/job/'.$job_id);
        $params = [

        ];
        $client->setParams($params);
        $respone = $client->sendRequest('DELETE');
        $body = json_decode($respone->body);
        if($body->errorId == 'OK'){
            return true;
        }else{
            throw new \DdvPhp\DdvFile\Exception\Sys('添加失败',$body->message);
        }
    }


}
