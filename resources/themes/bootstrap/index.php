<!DOCTYPE html>

<?php
    header("Content-type: text/html; charset=utf-8");
    // 网站名称
    $web_title = $lister->getConfig('web_title');
    // 当前路径
    $listed_path = $lister->getAbsoluteListedPath();
    // 当前目录中的 README 文档内容
    $readme_html = $lister->getReadme();
?>

<html>

    <head>

        <!-- Title -->
        <?php if ($listed_path != "") : ?>
            <title><?php echo $web_title . " | " . $listed_path; ?></title>
        <?php else : ?>
            <title><?php echo $web_title; ?></title>
        <?php endif; ?>

        <!-- Favicon -->
        <link rel="shortcut icon" href="<?php echo THEMEPATH; ?>/img/folder.png">

        <!-- STYLES -->
        <!-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"> -->
        <!-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"> -->
        <link href="https://cdn.bootcss.com/twitter-bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo THEMEPATH; ?>/css/style.css">
        <!-- 代码高亮样式 -->
        <link rel="stylesheet" href="/<?php echo THEMEPATH; ?>/css/prism.css" />

        <!-- SCRIPTS -->
        <!-- <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
        <!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script> -->
        <script src="https://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://cdn.bootcss.com/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo THEMEPATH; ?>/js/directorylister.js"></script>
        <!-- 代码高亮 JS 依赖 -->
        <script src="/<?php echo THEMEPATH; ?>/js/prism.js"></script>

        <!-- FONTS -->
        <!-- <link rel="stylesheet" type="text/css"  href="//fonts.googleapis.com/css?family=Cutive+Mono"> -->
        <link rel="stylesheet" type="text/css"  href="<?php echo THEMEPATH; ?>/font/font.css">

        <!-- META -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">

        <?php file_exists('analytics.inc') ? include('analytics.inc') : false; ?>

    </head>

    <body>

        <div id="page-navbar" class="navbar navbar-default navbar-fixed-top">
            <div class="container">

                <?php $breadcrumbs = $lister->listBreadcrumbs(); ?>

                <p class="navbar-text">
                    <?php foreach($breadcrumbs as $breadcrumb): ?>
                        <?php if ($breadcrumb != end($breadcrumbs)): ?>
                                <a href="<?php echo $breadcrumb['link']; ?>"><?php echo $breadcrumb['text']; ?></a>
                                <span class="divider">/</span>
                        <?php else: ?>
                            <?php echo $breadcrumb['text']; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </p>

                <div class="navbar-right">

                    <ul id="page-top-nav" class="nav navbar-nav">
                        <li>
                            <a href="javascript:void(0)" id="page-top-link">
                                <i class="fa fa-arrow-circle-up fa-lg"></i>
                            </a>
                        </li>
                    </ul>

                    <?php  if ($lister->isZipEnabled()): ?>
                        <ul id="page-top-download-all" class="nav navbar-nav">
                            <li>
                                <a href="?zip=<?php echo $lister->getDirectoryPath(); ?>" id="download-all-link">
                                    <i class="fa fa-download fa-lg"></i>
                                </a>
                            </li>
                        </ul>
                    <?php endif; ?>

                </div>

            </div>
        </div>

        <div id="page-content" class="container">

            <?php file_exists('header.php') ? include('header.php') : include($lister->getThemePath(true) . "/default_header.php"); ?>

            <?php if($lister->getSystemMessages()): ?>
                <?php foreach ($lister->getSystemMessages() as $message): ?>
                    <div class="alert alert-<?php echo $message['type']; ?>">
                        <?php echo $message['text']; ?>
                        <a class="close" data-dismiss="alert" href="#">&times;</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <div id="directory-list-header">
                <div class="row">
                    <div class="col-md-7 col-sm-6 col-xs-10">文件</div>
                    <div class="col-md-2 col-sm-2 col-xs-2 text-right">大小</div>
                    <div class="col-md-3 col-sm-4 hidden-xs text-right">更新时间</div>
                </div>
            </div>

            <ul id="directory-listing" class="nav nav-pills nav-stacked">

                <?php foreach($dirArray as $name => $fileInfo): ?>
                    <li data-name="<?php echo $name; ?>" data-href="<?php echo $fileInfo['url_path']; ?>">
                        <a href="<?php echo $fileInfo['url_path']; ?>" class="clearfix" data-name="<?php echo $name; ?>">


                            <div class="row">
                                <span class="file-name col-md-7 col-sm-6 col-xs-9">
                                    <i class="fa <?php echo $fileInfo['icon_class']; ?> fa-fw"></i>
                                    <?php echo $name; ?>
                                </span>

                                <span class="file-size col-md-2 col-sm-2 col-xs-3 text-right">
                                    <?php echo $fileInfo['file_size']; ?>
                                </span>

                                <span class="file-modified col-md-3 col-sm-4 hidden-xs text-right">
                                    <?php echo $fileInfo['mod_time']; ?>
                                </span>
                            </div>

                        </a>

                        <?php if (is_file($fileInfo['file_path'])): ?>

                            <a href="javascript:void(0)" class="file-info-button">
                                <i class="fa fa-info-circle"></i>
                            </a>

                        <?php endif; ?>

                    </li>
                <?php endforeach; ?>

            </ul>
        </div>

        <!-- READMNE start -->
        <?php
        if ($readme_html != "") {
            // 多行字符串开始
            $readme_top = '
                        <div class="container readme-background" id="readmeTop">
                            <div class="Box-header px-2 clearfix">
                                <h3 class="Box-title pr-3">
                                    <svg class="octicon octicon-book" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true">
                                        <path fill-rule="evenodd" 
                                            d="M3 5h4v1H3V5zm0 3h4V7H3v1zm0 2h4V9H3v1zm11-5h-4v1h4V5zm0 2h-4v1h4V7zm0 2h-4v1h4V9zm2-6v9c0 .55-.45 1-1 1H9.5l-1 1-1-1H2c-.55 0-1-.45-1-1V3c0-.55.45-1 1-1h5.5l1 1 1-1H15c.55 0 1 .45 1 1zm-8 .5L7.5 3H2v9h6V3.5zm7-.5H9.5l-.5.5V12h6V3z">
                                        </path>
                                    </svg> README
                                </h3>
                            </div>
                            <div class="readme" id="readme">
                            ';
            echo $readme_top . $readme_html . "</div></div>";
        }
        ?>
        <!-- READMNE end -->

        <?php file_exists('footer.php') ? include('footer.php') : include($lister->getThemePath(true) . "/default_footer.php"); ?>

        <div id="file-info-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{modal_header}}</h4>
                    </div>

                    <div class="modal-body">

                        <table id="file-info" class="table table-bordered">
                            <tbody>

                                <tr>
                                    <td class="table-title">MD5</td>
                                    <td class="md5-hash">{{md5_sum}}</td>
                                </tr>

                                <tr>
                                    <td class="table-title">SHA1</td>
                                    <td class="sha1-hash">{{sha1_sum}}</td>
                                </tr>

                                <tr>
                                    <td class="table-title">SHA256</td>
                                    <td class="sha256-hash">{{sha256_sum}}</td>
                                </tr>

                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>

    </body>

</html>
