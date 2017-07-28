# multimedia-transcoder

Installation - 安装
------------

```bash
composer require ping-qu/multimedia-transcoder
```

```bash
$job = new \Pingqu\MultimediaTranscoder\V1\Job(accessKeyId,accessKeySecret,'http://yun.linyue.hznwce.com');
        $job->setParams(['pipeline_id'=>'111',
            'input_file'=>'111',
            'preset_id'=>'111',
           ]);
        $data = $job->addFileJob();
        return $data;
```

------