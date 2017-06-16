<?php
namespace Pingqu\VideoTranscode;

/**
 * Class Util
 * @package Pingqu\VideoTranscode
 */
class ExtNameToType
{
  public static function ExtNameToType($ext){
    $extLower = strtolower($ext);
    foreach (self::$ext as $type => $exts) {
      if (in_array($ext, $exts)) {
        return $type;
      }
    }
    return 'unknow';
  }
  public static $ext = array(
    'audio'=>array(
      'mid',
      'midi',
      'mpga',
      'mp2',
      'mp3',
      'aif',
      'aiff',
      'aifc',
      'ram',
      'rm',
      'rpm',
      'ra',
      'rv',
      'wav',
      'm4a',
      'aac',
      'au',
      'ac3',
      'flac',
      'ogg',
      'amr',
      'ape',
    ),
    'video'=>array(
      'avi',
      'mpg',
      'mpeg',
      'asf',
      'mov',
      'wmv',
      'rm',
      'rmvb',
      'mp4',
      '3g2',
      '3gp',
      'mp4',
      'f4v',
      'flv',
      'webm',
      'mkv',
    ),
    'image'=>array(
      'bmp',
      'gif',
      'jpeg',
      'jpg',
      'jpe',
      'png',
      'tiff',
      'tif',
    ),
    'ppt'=>array(
      'ppt',
      'pps',
      'ppsx',
      'potx',
      'pot',
      'pptm',
      'potm',
      'ppsm',
      'odp'
    ),
    'pptx'=>array(
     'pptx'
    ),
    'pdf'=>array(
      'pdf'
    ),
  );
}