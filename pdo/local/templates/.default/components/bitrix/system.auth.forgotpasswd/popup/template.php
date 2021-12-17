<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

CJSCore::Init();
?>

<div id="modalPasswordRecovery" class="modal_auth modal mfp-hide">
    <div class="modal-close js-modalClose">
        <svg class="icon icon-menu-close ">
            <use xlink:href="#icon-menu-close"></use>
        </svg>
    </div>
    <div class="modal-header">
        <div class="modal-title"><?=Loc::getMessage('AUTH_FORM_RESET_TITLE')?></div>
    </div>
    <div class="modal-body">
        <form action="<?=$arResult["AUTH_URL"]?>" method="post" name="system_auth_form<?=$arResult['RND']?>" class="modal-form js-validate js-auth-form">
            <?php if($arResult['BACKURL'] <> ''):?>
                <input type="hidden" name="backurl" value="<?=$arResult['BACKURL']?>"/>
            <?php endif?>
            <input type="hidden" name="AUTH_FORM" value="Y"/>
            <input type="hidden" name="TYPE" value="SEND_PWD"/>
            <input type="hidden" name="RETURN_JSON" value="Y"/>
            <div class="form-fieldset">
                <div class="form-field">
                    <input type="text" name="USER_EMAIL" maxlength="50" size="17" autocomplete="off" required class="form-input"/>
                    <span for="USER_EMAIL" class="label-error js-error-display"></span>
                    <div class="form-field__placeholder"><?=Loc::getMessage('AUTH_FORM_EMAIL_CAPTION')?></div>
                    <div class="form-field__focus"></div>
                </div>
            </div>
            <div class="form-fieldset">
                <div class="form-error"></div>
            </div>
            <div class="form-fieldset">
                <div class="form-controls modal-form__controls">
                    <button type="submit" class="button style_dark_blue"><span
                                class="button__text"><?=Loc::getMessage('AUTH_FORM_RESET_PASSWORD')?></span></button>
                    <div class="form-fieldset__link"><a href="javascript:;" data-mfp-src="#modalLogin"
                                                        class="form-link js-modalLink"><?=Loc::getMessage('AUTH_FORM_RETURN_TO_AUTH')?></a></div>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="modalText" class="modal_auth modal mfp-hide">
    <div class="modal-close js-modalClose">
        <svg class="icon icon-menu-close ">
            <use xlink:href="#icon-menu-close"></use>
        </svg>
    </div>
    <div class="modal-header">
        <div class="modal-title"><?=Loc::getMessage('AUTH_FORM_PASSWORD_RESET_MESSAGE')?></div>
    </div>
    <div class="modal-body">
        <div class="modal-text">
            <p>text</p>
        </div>
    </div>
</div>