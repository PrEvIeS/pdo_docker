<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main;
use Bitrix\Main\Localization\Loc as Loc;

Loc::loadMessages(__FILE__);

try {
    if (!Main\Loader::includeModule('iblock')) {
        throw new Main\LoaderException(Loc::getMessage('STANDARD_ELEMENTS_PARAMETERS_IBLOCK_MODULE_NOT_INSTALLED'));
    }

    $iblockTypes = \CIBlockParameters::GetIBlockTypes(["-" => " "]);

    $iblocks = [0 => " "];
    $iblocksCode = ["" => " "];
    if (isset($arCurrentValues['IBLOCK_TYPE']) && strlen($arCurrentValues['IBLOCK_TYPE'])) {
        $filter = [
            'TYPE' => $arCurrentValues['IBLOCK_TYPE'],
            'ACTIVE' => 'Y',
        ];
        $iterator = \CIBlock::GetList(['SORT' => 'ASC'], $filter);
        while ($iblock = $iterator->GetNext()) {
            $iblocks[$iblock['ID']] = $iblock['NAME'];
            $iblocksCode[$iblock['CODE']] = $iblock['NAME'];
        }
    }

    $sortFields = [
        'ID' => Loc::getMessage('STANDARD_ELEMENTS_PARAMETERS_SORT_ID'),
        'NAME' => Loc::getMessage('STANDARD_ELEMENTS_PARAMETERS_SORT_NAME'),
        'ACTIVE_FROM' => Loc::getMessage('STANDARD_ELEMENTS_PARAMETERS_SORT_ACTIVE_FROM'),
        'SORT' => Loc::getMessage('STANDARD_ELEMENTS_PARAMETERS_SORT_SORT'),
    ];

    $sortDirection = [
        'ASC' => Loc::getMessage('STANDARD_ELEMENTS_PARAMETERS_SORT_ASC'),
        'DESC' => Loc::getMessage('STANDARD_ELEMENTS_PARAMETERS_SORT_DESC'),
    ];

    $arComponentParameters = [
        'GROUPS' => [
        ],
        'PARAMETERS' => [
            'IBLOCK_TYPE' => [
                'PARENT' => 'BASE',
                'NAME' => Loc::getMessage('STANDARD_ELEMENTS_PARAMETERS_IBLOCK_TYPE'),
                'TYPE' => 'LIST',
                'VALUES' => $iblockTypes,
                'DEFAULT' => '',
                'REFRESH' => 'Y',
            ],
            'IBLOCK_ID' => [
                'PARENT' => 'BASE',
                'NAME' => Loc::getMessage('STANDARD_ELEMENTS_PARAMETERS_IBLOCK_ID'),
                'TYPE' => 'LIST',
                'VALUES' => $iblocks,
            ],
            'IBLOCK_CODE' => [
                'PARENT' => 'BASE',
                'NAME' => Loc::getMessage('STANDARD_ELEMENTS_PARAMETERS_IBLOCK_CODE'),
                'TYPE' => 'LIST',
                'VALUES' => $iblocksCode,
            ],
            'SHOW_NAV' => [
                'PARENT' => 'BASE',
                'NAME' => Loc::getMessage('STANDARD_ELEMENTS_PARAMETERS_SHOW_NAV'),
                'TYPE' => 'CHECKBOX',
                'DEFAULT' => 'N',
            ],
            'COUNT' => [
                'PARENT' => 'BASE',
                'NAME' => Loc::getMessage('STANDARD_ELEMENTS_PARAMETERS_COUNT'),
                'TYPE' => 'STRING',
                'DEFAULT' => '0',
            ],
            'SORT_FIELD1' => [
                'PARENT' => 'BASE',
                'NAME' => Loc::getMessage('STANDARD_ELEMENTS_PARAMETERS_SORT_FIELD1'),
                'TYPE' => 'LIST',
                'VALUES' => $sortFields,
            ],
            'SORT_DIRECTION1' => [
                'PARENT' => 'BASE',
                'NAME' => Loc::getMessage('STANDARD_ELEMENTS_PARAMETERS_SORT_DIRECTION1'),
                'TYPE' => 'LIST',
                'VALUES' => $sortDirection,
            ],
            'SORT_FIELD2' => [
                'PARENT' => 'BASE',
                'NAME' => Loc::getMessage('STANDARD_ELEMENTS_PARAMETERS_SORT_FIELD2'),
                'TYPE' => 'LIST',
                'VALUES' => $sortFields,
            ],
            'SORT_DIRECTION2' => [
                'PARENT' => 'BASE',
                'NAME' => Loc::getMessage('STANDARD_ELEMENTS_PARAMETERS_SORT_DIRECTION2'),
                'TYPE' => 'LIST',
                'VALUES' => $sortDirection,
            ],
            'SEF_MODE' => [
                'index' => [
                    'NAME' => GetMessage('STANDARD_ELEMENTS_PARAMETERS_INDEX_PAGE'),
                    'DEFAULT' => 'index.php',
                    'VARIABLES' => [],
                ],
                'detail' => [
                    "NAME" => GetMessage('STANDARD_ELEMENTS_PARAMETERS_DETAIL_PAGE'),
                    "DEFAULT" => '#ELEMENT_ID#/',
                    "VARIABLES" => ['ELEMENT_ID'],
                ],
            ],
            'CACHE_TIME' => [
                'DEFAULT' => 3600,
            ],
        ],
    ];
} catch (Main\LoaderException $e) {
    ShowError($e->getMessage());
}
?>