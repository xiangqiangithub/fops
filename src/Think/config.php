<?php
//将该文件拷贝到项目配置目录下
return [
        'app_id'=>'123456',
        'app_code'=>'123456',
        'format'=>'JSON',
        /******以下配置为固定值*****/
        'charset'=>'UTF-8',
        'sign_type'=>'RSA2',
        /******以上配置为固定值*****/
        'timestamp_format'=>'YmdHis',
        'version'=>'0.0.1',
        'public_key'=>'/tmp/fop_key.pub',
        'private_key'=>'/tmp/fop_key.pem',
        'cipher' =>'AES-256-CBC',
        'base_url'=> 'http://127.0.0.1/'
];
