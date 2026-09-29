<?php

require __DIR__ . '/../vendor/autoload.php';

$smarty = require __DIR__ . '/../config/smarty.php';

$smarty->assign('metaTitle', 'Home | AbeloHost');
$smarty->assign('metaDescription', 'Home page');

$smarty->assign('title', 'Start blog');

$smarty->display('home.tpl');