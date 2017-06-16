<?php

namespace Pingqu\MultimediaTranscoder\V1\Exception;

class Input extends \Pingqu\MultimediaTranscoder\V1\Exception
{
  // 魔术方法
  public function __construct( $message = 'Input data error', $errorId = 'INPUT_ERROR' , $code = '400' )
  {
    parent::__construct( $message , $errorId , $code );
  }
}