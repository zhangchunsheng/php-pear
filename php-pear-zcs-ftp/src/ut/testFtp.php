<?php
/**
 * @title Ftp test
 * @description
 * Ftp test
 * @author zhangchunsheng
 * @email zhangchunsheng423@gmail.com
 * @version V1.0
 * @date 2015-12-23
 * @copyright  Copyright (c) 2015-2016 Luomor Inc. (http://www.luomor.com)
 */

require(__DIR__ . '/../LL/Ftp.php');

$ftp = new \LL\Ftp('');
$ftp->login('', '');

$remoteFiles = $ftp->dir('installations');

//data
$ftp->getTexts(__DIR__ . '/../data', $remoteFiles);
