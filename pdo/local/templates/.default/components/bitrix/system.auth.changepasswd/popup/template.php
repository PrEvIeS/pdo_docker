<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
?>

<div id="modalResetPassword" class="modal_auth modal mfp-hide">
    <div class="modal-close js-modalClose">
        <svg class="icon icon-menu-close ">
            <use xlink:href="#icon-menu-close"></use>
        </svg>
    </div>
    <div class="modal-header">
        <div class="modal-title"><?=Loc::getMessage('AUTH_RESET_FORM_TITLE')?></div>
    </div>
    <div class="modal-body">
        <form action="<?=$arResult["AUTH_FORM"]?>" method="post" name="system_auth_form<?=$arResult['RND']?>" class="modal-form js-validate js-password-reset-form">
            <?php if($arResult['BACKURL'] <> ''):?>
                <input type="hidden" name="backurl" value="<?=$arResult['BACKURL']?>"/>
            <?php endif?>
            <?php foreach ($arResult['POST'] as $key => $value):?>
                <input type="hidden" name="<?=$key?>" value="<?=$value?>"/>
            <?php endforeach?>
            <input type="hidden" name="AUTH_FORM" value="Y">
            <input type="hidden" name="TYPE" value="CHANGE_PWD">
            <input type="hidden" name="RETURN_JSON" value="Y"/>
            <input type="hidden" name="USER_CHECKWORD" value="<?=$arResult['USER_CHECKWORD']?>"/>
            <div class="form-fieldset">
                <div class="form-field">
                    <input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" required class="form-input"/>
                    <span for="USER_LOGIN" class="label-error js-error-display"></span>
                    <div class="form-field__placeholder"><?=Loc::getMessage('AUTH_RESET_FIELD_LOGIN')?></div>
                    <div class="form-field__focus"></div>
                </div>
            </div>
            <div class="form-fieldset">
                <div class="form-field">
                    <input type="password" name="USER_PASSWORD" maxlength="50" required class="form-input" autocomplete="off"/>
                    <span for="USER_PASSWORD" class="label-error"></span>
                    <div class="form-field__placeholder"><?=Loc::getMessage('AUTH_RESET_FIELD_PASS')?></div>
                    <div class="form-field__focus"></div>
                </div>
            </div>
            <div class="form-fieldset">
                <div class="form-field">
                    <input type="password" name="USER_CONFIRM_PASSWORD" maxlength="50" required class="form-input" autocomplete="off"/>
                    <span for="USER_CONFIRM_PASSWORD" class="label-error"></span>
                    <div class="form-field__placeholder"><?=Loc::getMessage('AUTH_RESET_FIELD_CONFIRM_PASS')?></div>
                    <div class="form-field__focus"></div>
                </div>
            </div>
            <div class="form-fieldset">
                <div class="form-error"></div>
            </div>
            <div class="form-fieldset">
                <div class="form-controls modal-form__controls">
                    <button type="submit" class="button style_dark_blue"><span class="button__text"><?=Loc::getMessage('AUTH_RESET_FIELD_RESET')?></span></button>
                </div>
            </div>
        </form>
    </div>
</div>
