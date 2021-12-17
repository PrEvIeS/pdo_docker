<?php  if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use Bitrix\Main\Localization\Loc as Loc;

Loc::loadMessages(__FILE__);
$this->setFrameMode(true);
?>

<?php  if (count($arResult['ITEMS'])): ?>
    <h2><?= Loc::getMessage('STANDARD_ELEMENTS_LIST_TEMPLATE_TITLE'); ?></h2>
    <?php  foreach ($arResult['ITEMS'] as $item): ?>
        <div>
            <div><strong><?= $item['DATE']; ?></strong> <a href="<?= $item['URL']; ?>"><?= $item['NAME']; ?></a></div>
            <div><?= $item['TEXT']; ?></div>
        </div>
    <?php  endforeach; ?>
    <?= $arResult['NAV_STRING']; ?>
<?php  endif; ?>
