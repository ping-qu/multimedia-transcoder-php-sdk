<?php
/**
 * Created by PhpStorm.
 * User: yuelin
 * Date: 2017/7/17
 * Time: 下午4:02
 */

namespace Pingqu\MultimediaTranscoder\V1;


class Notification
{
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
        $this->params = array();
    }

    public function setParams($params = array()){
        $this->params = $params;
    }

    public function getFileNotification(){
        $client = new \Pingqu\OpenApi\Api($this->accessKeyId, $this->accessKeySecret,$this->endpoint.'/v4_0/admin/file/Notification');
        $client->setParams($this->params);
        $respone = $client->sendRequest('GET');
        $body = json_decode($respone->body);
        //dd($body);
        if($body->errorId == 'OK'){
            return ['lists'=>$body->lists,'page'=>$body->page];
        }else{
            throw new \DdvPhp\DdvFile\Exception\Sys('获取失败',$body->message);
        }
    }

    public function getVideoNotification(){
        $client = new \Pingqu\OpenApi\Api($this->accessKeyId, $this->accessKeySecret,$this->endpoint.'/v4_0/admin/video/Notification');
        $client->setParams($this->params);
        $respone = $client->sendRequest('GET');
        $body = json_decode($respone->body);
        //dd($body);
        if($body->errorId == 'OK'){
            return ['lists'=>$body->lists,'page'=>$body->page];
        }else{
            throw new \DdvPhp\DdvFile\Exception\Sys('获取失败',$body->message);
        }
    }

    public function addFileNotification(){
        $client = new \Pingqu\OpenApi\Api($this->accessKeyId, $this->accessKeySecret,$this->endpoint.'/v4_0/admin/file/Notification');
        $client->setParams($this->params);
        $respone = $client->sendRequest('POST');
        $body = json_decode($respone->body);
        //dd($body);
        if($body->errorId == 'OK'){
            return ['lists'=>$body->lists,'page'=>$body->page];
        }else{
            throw new \DdvPhp\DdvFile\Exception\Sys('添加失败',$body->message);
        }
    }

    public function addVideoNotification(){
        $client = new \Pingqu\OpenApi\Api($this->accessKeyId, $this->accessKeySecret,$this->endpoint.'/v4_0/admin/video/Notification');
        $client->setParams($this->params);
        $respone = $client->sendRequest('POST');
        $body = json_decode($respone->body);
        //dd($body);
        if($body->errorId == 'OK'){
            return ['lists'=>$body->lists,'page'=>$body->page];
        }else{
            throw new \DdvPhp\DdvFile\Exception\Sys('添加失败',$body->message);
        }
    }


    public function deleteFileNotification(){
        $client = new \Pingqu\OpenApi\Api($this->accessKeyId, $this->accessKeySecret,$this->endpoint.'/v4_0/admin/file/Notification');
        $respone = $client->sendRequest('DELETE');
        $body = json_decode($respone->body);
        //dd($body);
        if($body->errorId == 'OK'){
            return ['lists'=>$body->lists,'page'=>$body->page];
        }else{
            throw new \DdvPhp\DdvFile\Exception\Sys('删除失败',$body->message);
        }
    }

    public function deleteVideoNotification(){
        $client = new \Pingqu\OpenApi\Api($this->accessKeyId, $this->accessKeySecret,$this->endpoint.'/v4_0/admin/video/Notification');
        $respone = $client->sendRequest('DELETE');
        $body = json_decode($respone->body);
        //dd($body);
        if($body->errorId == 'OK'){
            return ['lists'=>$body->lists,'page'=>$body->page];
        }else{
            throw new \DdvPhp\DdvFile\Exception\Sys('删除失败',$body->message);
        }
    }

    public function updateFileNotification($id){
        $client = new \Pingqu\OpenApi\Api($this->accessKeyId, $this->accessKeySecret,$this->endpoint.'/v4_0/admin/file/Notification/'.$id);
        $client->setParams($this->params);
        $respone = $client->sendRequest('PUT');
        $body = json_decode($respone->body);
        //dd($body);
        if($body->errorId == 'OK'){
            return ['lists'=>$body->lists,'page'=>$body->page];
        }else{
            throw new \DdvPhp\DdvFile\Exception\Sys('更新失败',$body->message);
        }
    }

    public function updateVideoNotification($id){
        $client = new \Pingqu\OpenApi\Api($this->accessKeyId, $this->accessKeySecret,$this->endpoint.'/v4_0/admin/video/Notification/'.$id);
        $client->setParams($this->params);
        $respone = $client->sendRequest('PUT');
        $body = json_decode($respone->body);
        //dd($body);
        if($body->errorId == 'OK'){
            return ['lists'=>$body->lists,'page'=>$body->page];
        }else{
            throw new \DdvPhp\DdvFile\Exception\Sys('更新失败',$body->message);
        }
    }
}