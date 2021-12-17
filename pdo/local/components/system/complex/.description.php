<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc as Loc;

Loc::loadMessages(__FILE__);

$arComponentDescription = [
    "NAME" => Loc::getMessage('STANDARD_ELEMENTS_DESCRIPTION_NAME'),
    "DESCRIPTION" => Loc::getMessage('STANDARD_ELEMENTS_DESCRIPTION_DESCRIPTION'),
    "ICON" => '/images/icon.gif',
    "SORT" => 10,
    "PATH" => [
        "ID" => 'ds',
        "NAME" => Loc::getMessage('STANDARD_ELEMENTS_DESCRIPTION_GROUP'),
        "SORT" => 10,
        "CHILD" => [
            "ID" => 'standard',
            "NAME" => Loc::getMessage('STANDARD_ELEMENTS_DESCRIPTION_DIR'),
            "SORT" => 10,
        ],
    ],
];

?>