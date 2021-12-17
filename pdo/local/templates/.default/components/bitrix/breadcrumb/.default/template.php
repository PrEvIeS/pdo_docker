<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

//delayed function must return a string
if(empty($arResult))
	return '';

ob_start();
?>

<div class="page-account__breadcrumb">
    <div class="breadcrumb">
        <?php foreach ($arResult as $key => $item):
            $notLast = $key < (count($arResult) - 1);?>
            <div class="breadcrumb-elem">
                <div class="breadcrumb-title"><a<?php if($notLast):?> href="<?=$item['LINK']?>"<?php endif;?>><?=$item['TITLE']?></a><?php if($notLast):?>&nbsp-&nbsp<?php endif;?></div>
            </div>
        <?php endforeach;?>
    </div>
</div>

<?php
$str = ob_get_contents();
ob_end_clean();
return $str;
?>