<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$APPLICATION->RestartBuffer();
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

use Bitrix\Main\Localization\Loc as Loc;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle('404');
?>
    <div class="page-404">
        404 page    
     </div>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
