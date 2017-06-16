<?php
namespace Pingqu\VideoTranscode;

/**
 * Class Util
 * @package Pingqu\VideoTranscode
 */
class Util
{

  public static function isVideoOrAudio($type, $extName){
    return self::isVideo($type, $extName) || self::isAudio($type, $extName);
  }
  public static function isDocument($type, $extName){
    return
    self::isPDF($type, $extName) ||
    self::isPPT($type, $extName) ||
    self::isPPTX($type, $extName) ||
    self::isImage($type, $extName);
  }
  public static function isVideo($type, $extName){
  	return (self::contextTypeToType($type)==='video' || ExtNameToType::ExtNameToType($extName)==='video');
  }
  public static function isAudio($type, $extName){
  	return (self::contextTypeToType($type)==='audio' || ExtNameToType::ExtNameToType($extName)==='audio');
  }
  public static function isPDF($type, $extName){
  	return (self::contextTypeToType($type)==='pdf' || ExtNameToType::ExtNameToType($extName)==='pdf');
  }
  public static function isPPT($type, $extName){
  	return (self::contextTypeToType($type)==='ppt' || ExtNameToType::ExtNameToType($extName)==='ppt');
  }
  public static function isPPTX($type, $extName){
  	return (self::contextTypeToType($type)==='pptx' || ExtNameToType::ExtNameToType($extName)==='pptx');
  }
  public static function isImage($type, $extName){
  	return (self::contextTypeToType($type)==='image' || ExtNameToType::ExtNameToType($extName)==='image');
  }
  public static function contextTypeToType($type){
	$types = explode('/',$type);
	$type = empty($types[0]) ? 'unknow' : $types[0];
	return $type;
  }
}
