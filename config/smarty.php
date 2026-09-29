<?php

use Smarty\Smarty;

$smarty = new Smarty();

$smarty->setTemplateDir(__DIR__ . '/../resources/templates');
$smarty->setCompileDir(__DIR__ . '/../storage/compile');
$smarty->setCacheDir(__DIR__ . '/../storage/cache');
$smarty->setConfigDir(__DIR__ . '/../config/smarty');

return $smarty;
