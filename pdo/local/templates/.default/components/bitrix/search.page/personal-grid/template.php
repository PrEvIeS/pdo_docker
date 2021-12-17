<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>

<?php if(empty($arResult['SEARCH'])):?>
    <div class="folder-grid" style="padding-top: 15px;">
        <div style="width: 100%; text-align: center;"><?=Loc::getMessage('PERSONAL_SEARCH_EMPTY')?></div>
    </div>
<?php else:?>
    <?php
    $filterData = [
        'SECTIONS' => [],
        'ELEMENTS' => []
    ];
    foreach($arResult['SEARCH'] as $item) {
        if(substr($item['ITEM_ID'], 0, 1) === 'S') {
            $filterData['SECTIONS'][] = substr($item['ITEM_ID'], 1);
        } else {
            $filterData['ELEMENTS'][] = $item['ITEM_ID'];
        }
    }

    $APPLICATION->IncludeComponent(
        'project:personal.sections.list',
        '.default',
        array(
            'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
            'IBLOCK_CODE' => 'documents',
            'PARENT_SECTION_ID' => $arResult['VARIABLES']['SECTION_ID'],
            'EXTENSION_FILTER' => $_REQUEST['extensions'],
            'AJAX_KEY' => 'PERSONAL_AJAX',
            'SEARCH_FILTER' => $filterData,
            'CACHE_TYPE' => 'N'
        )
    );?>
<?php endif;?>