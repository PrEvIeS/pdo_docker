<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

CJSCore::Init();
?>

<div id="modalLogin" class="modal_auth modal mfp-hide">
    <div class="modal-close js-modalClose">
        <svg class="icon icon-menu-close ">
            <use xlink:href="#icon-menu-close"></use>
        </svg>
    </div>
    <div class="modal-header">
        <div class="modal-title"><?=Loc::getMessage('AUTH_FORM_TITLE')?></div>
    </div>
    <div class="modal-body">
        <form action="<?=$arResult['AUTH_URL']?>" method="post" name="system_auth_form<?=$arResult['RND']?>" class="modal-form js-validate js-password-reset-form">
            <?php if($arResult['BACKURL'] <> ''):?>
                <input type="hidden" name="backurl" value="<?=$arResult['BACKURL']?>"/>
            <?php endif?>
            <?php foreach ($arResult['POST'] as $key => $value):?>
                <input type="hidden" name="<?=$key?>" value="<?=$value?>"/>
            <?php endforeach?>
            <input type="hidden" name="AUTH_FORM" value="Y"/>
            <input type="hidden" name="TYPE" value="AUTH"/>
            <input type="hidden" name="RETURN_JSON" value="Y"/>
            <div class="form-fieldset">
                <div class="form-field">
                    <input type="text" name="USER_LOGIN" maxlength="50" value="" size="17" required class="form-input"/>
                    <span for="USER_LOGIN" class="label-error js-error-display"></span>
                    <div class="form-field__placeholder"><?=Loc::getMessage('AUTH_FORM_LOGIN_CAPTION')?></div>
                    <div class="form-field__focus"></div>
                    <script>
                        BX.ready(function() {
                            var loginCookie = BX.getCookie("<?=CUtil::JSEscape($arResult['~LOGIN_COOKIE_NAME'])?>");
                            if (loginCookie)
                            {
                                var form = document.forms["system_auth_form<?=$arResult['RND']?>"];
                                var loginInput = form.elements["USER_LOGIN"];
                                loginInput.value = loginCookie;
                            }
                        });
                    </script>
                </div>
            </div>
            <div class="form-fieldset">
                <div class="form-field">
                    <input type="password" name="USER_PASSWORD" maxlength="50" size="17" autocomplete="off" required class="form-input"/>
                    <div class="form-field__placeholder"><?=Loc::getMessage('AUTH_FORM_PASSWORD_CAPTION')?></div>
                    <div class="form-field__focus"></div>
                </div>
            </div>
            <div class="form-fieldset">
                <div class="form-error"></div>
            </div>
            <div class="form-fieldset">
                <div class="form-controls modal-form__controls">
                    <button type="submit" class="button style_dark_blue"><span class="button__text"><?=Loc::getMessage('AUTH_FORM_SUBMIT_CAPTION')?></span>
                    </button>
                    <div class="form-fieldset__link"><a href="javascript:;" data-mfp-src="#modalPasswordRecovery"
                                                        class="form-link js-modalLink"><?=Loc::getMessage('AUTH_FORM_FORGOT_PASSWORD')?></a></div>
                </div>
            </div>
        </form>
    </div>
</div>
