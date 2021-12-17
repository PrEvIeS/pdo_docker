<?php

if (isset($_REQUEST['RETURN_JSON']) && $_REQUEST['RETURN_JSON'] === 'Y' && $_REQUEST['AUTH_FORM'] === 'Y')
{
    global $APPLICATION;
    $APPLICATION->RestartBuffer();

    $result = [
        'result' => $arResult['ERROR'] ? 'error' : 'success',
        'error' => $arResult['ERROR_MESSAGE']['MESSAGE'] ? $arResult['ERROR_MESSAGE']['MESSAGE'] : null,
        'type' => $arResult['ERROR_MESSAGE']['TYPE'] ?: null,
        'backdir' => $arResult['ERROR'] ? $APPLICATION->GetCurPage() : SITE_DIR . 'personal/'
    ];

    echo json_encode($result);
    die;
}