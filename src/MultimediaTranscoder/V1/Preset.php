<?php
/**
 * Created by PhpStorm.
 * User: yuelin
 * Date: 2017/7/17
 * Time: 下午4:02
 */

namespace Pingqu\MultimediaTranscoder\V1;


class Preset
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

    public function getFilePreset(){
        $client = new \Pingqu\OpenApi\Api($this->accessKeyId, $this->accessKeySecret,$this->endpoint.'/v4_0/admin/file/Preset');
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

    public function getVideoPreset(){
        $client = new \Pingqu\OpenApi\Api($this->accessKeyId, $this->accessKeySecret,$this->endpoint.'/v4_0/admin/video/Preset');
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

    public function addFilePreset(){
        $client = new \Pingqu\OpenApi\Api($this->accessKeyId, $this->accessKeySecret,$this->endpoint.'/v4_0/admin/file/Preset');
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

    public function addVideoPreset(){
        $client = new \Pingqu\OpenApi\Api($this->accessKeyId, $this->accessKeySecret,$this->endpoint.'/v4_0/admin/video/Preset');
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


    public function deleteFilePreset(){
        $client = new \Pingqu\OpenApi\Api($this->accessKeyId, $this->accessKeySecret,$this->endpoint.'/v4_0/admin/file/Preset');
        $respone = $client->sendRequest('DELETE');
        $body = json_decode($respone->body);
        //dd($body);
        if($body->errorId == 'OK'){
            return ['lists'=>$body->lists,'page'=>$body->page];
        }else{
            throw new \DdvPhp\DdvFile\Exception\Sys('删除失败',$body->message);
        }
    }

    public function deleteVideoPreset(){
        $client = new \Pingqu\OpenApi\Api($this->accessKeyId, $this->accessKeySecret,$this->endpoint.'/v4_0/admin/video/Preset');
        $respone = $client->sendRequest('DELETE');
        $body = json_decode($respone->body);
        //dd($body);
        if($body->errorId == 'OK'){
            return ['lists'=>$body->lists,'page'=>$body->page];
        }else{
            throw new \DdvPhp\DdvFile\Exception\Sys('删除失败',$body->message);
        }
    }

    public function updateFilePreset($id){
        $client = new \Pingqu\OpenApi\Api($this->accessKeyId, $this->accessKeySecret,$this->endpoint.'/v4_0/admin/file/Preset/'.$id);
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

    public function updateVideoPreset($id){
        $client = new \Pingqu\OpenApi\Api($this->accessKeyId, $this->accessKeySecret,$this->endpoint.'/v4_0/admin/video/Preset/'.$id);
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