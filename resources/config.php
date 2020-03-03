<?php

return array(

    // 基本设置
    'web_title'                 => '文件目录列表',
    'home_label'                => 'Home',
    'hide_dot_files'            => true,
    'list_folders_first'        => true,
    'list_sort_order'           => 'natcasesort',
    // theme - bootstrap, vpsmm
    'theme_name'                => 'vpsmm',
    'date_format'               => 'Y-m-d H:i:s', // See: http://php.net/manual/en/function.date.php
    // README 文档的解析模式：html、md
    'readme_mode'               => "md",

    // 隐藏文件
    'hidden_files' => array(
        '.ht*',
        '*/.ht*',
        'resources',
        'resources/*',
        'analytics.inc',
        'header.php',
        'footer.php',
        '*/@eaDir*',
    ),

    // Files that, if present in a directory, make the directory
    // a direct link rather than a browse link.
    'index_files' => array(
        'index.htm',
        'index.html',
        'index.php',
        '*/README.*',
        'README.*'
    ),

    // 文件 hash 阈值
    'hash_size_limit' => 268435456, // 256 MB

    // 自定义排序顺序
    'reverse_sort' => array(
        // 'path/to/folder'
    ),

    // 允许以 zip 文件格式下载目录
    'zip_dirs' => false,

    // 直接将 zip 文件内容流式传输到客户端，
    // 没有任何临时文件
    'zip_stream' => true,

    'zip_compression_level' => 0,

    // 禁用特定目录的 zip 下载
    'zip_disable' => array(
        // 'path/to/folder'
    ),

);
