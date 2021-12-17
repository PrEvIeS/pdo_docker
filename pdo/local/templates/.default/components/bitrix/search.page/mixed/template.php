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

$iblock_brands = \Project\Api\IBlockHelpers::getIBlockId('Brands', 'brands');
$iblock_personal = \Project\Api\IBlockHelpers::getIBlockId('documents', 'personal');

global $USER;
$isAuthorized = $USER->IsAuthorized();
?>

<?php
if(!empty($arResult['SEARCH'])):?>
    <?php
    $staticResults = [];
    $filterData = [
        'BRANDS' => [
            'ELEMENTS' => []
        ],
        'PERSONAL' => [
            'SECTIONS' => [],
            'ELEMENTS' => []
        ]
    ];
    foreach($arResult['SEARCH'] as $item) {
        if($item['MODULE_ID'] === 'iblock' && in_array($item['PARAM2'], [$iblock_brands, $iblock_personal])) {
            $target = ($item['PARAM2'] === $iblock_brands) ? 'BRANDS' : 'PERSONAL';
            if(substr($item['ITEM_ID'], 0, 1) !== 'S') {
                $filterData[$target]['ELEMENTS'][] = $item['ITEM_ID'];
            }
        } else {
            $staticResults[] = [
                'TITLE' => $item['TITLE'],
                'BODY' => $item['BODY_FORMATED'],
                'URL' => $item['URL']
            ];
        }
    }
    ?>
<?php endif;?>

<div class="search-result js-searchScroll">
    <div class="search-result__container">
        <?php if(empty($arResult['SEARCH']) || (!$isAuthorized && empty($filterData['BRANDS']['ELEMENTS']))):?>
            <div class="folder-grid" style="padding-top: 15px;">
                <div style="width: 100%; text-align: center;"><?=Loc::getMessage('PERSONAL_SEARCH_EMPTY')?></div>
            </div>
        <?php else:?>
            <?php if(!empty($filterData['BRANDS']['ELEMENTS'])):?>
                <div class="search-result__group">
                    <div class="search-result__header">
                        <div class="section-title"><?=Loc::getMessage('PERSONAL_SEARCH_PRODUCTS')?></div>
                    </div>
                    <div class="search-result__body">
                        <?php $APPLICATION->IncludeComponent(
                            'project:search.result.list',
                            '.default',
                            array(
                                'IBLOCK_TYPE' => 'brands',
                                'IBLOCK_ID' => $iblock_brands,
                                'ELEMENT_IDS' => $filterData['BRANDS']['ELEMENTS'],
                            )
                        );?>
                    </div>
                </div>
            <?php endif;?>
            <?php if($isAuthorized && !empty($filterData['PERSONAL']['ELEMENTS'])):?>
                <div class="search-result__group">
                    <div class="search-result__header">
                        <div class="section-title"><?=Loc::getMessage('PERSONAL_SEARCH_FILES')?></div>
                    </div>
                    <div class="search-result__body">
                        <?php $APPLICATION->IncludeComponent(
                            'project:personal.sections.list',
                            '.default',
                            array(
                                'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                                'IBLOCK_CODE' => 'documents',
                                'PARENT_SECTION_ID' => $arResult['VARIABLES']['SECTION_ID'],
                                'EXTENSION_FILTER' => $_REQUEST['extensions'],
                                'AJAX_KEY' => 'PERSONAL_AJAX',
                                'SEARCH_FILTER' => $filterData['PERSONAL'],
                                'CACHE_TYPE' => 'N'
                            )
                        );?>
                    </div>
                </div>
            <?php endif;?>
            <?php if(!empty($staticResults)):?>
                <div class="search-result__group">
                    <div class="search-result__header">
                        <div class="section-title"><?=Loc::getMessage('PERSONAL_SEARCH_TEXT')?></div>
                    </div>
                    <div class="search-result__body">
                        <div class="result-text">
                            <?php foreach($staticResults as $item):?>
                                <div class="result-text__elem">
                                    <div class="result-text__title"><a href="<?=$item['URL']?>"><?=$item['TITLE']?></a></div>
                                    <div class="result-text__desc"><?=$item['BODY']?></div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            <?php endif;?>
        <?php endif;?>
    </div>
</div>
