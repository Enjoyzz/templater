<?php

use Enjoys\SimplePhpTemplate\Template;

include __DIR__ . '/../vendor/autoload.php';

$tpl = new Template(__DIR__);
$tpl->setOption('sanitizeOutput', true);



$tpl->assign('title', 'Example Title');
$tpl->assign('test', [1,2,3,4,5,6,7,8,9,0]);
$tpl->fetch('module', __DIR__ . '/tpl/fetch.html');
echo $tpl->display('tpl/tpl.html');

