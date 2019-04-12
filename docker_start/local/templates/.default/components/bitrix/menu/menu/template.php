<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<?if (!empty($arResult)):?>
    <div class="menu">
        <div class="menu-close js-menuClose">
            <div class="menu-close__icon">
                <svg class="icon icon-menu-close ">
                    <use xlink:href="#icon-menu-close"></use>
                </svg>
            </div>
            <div class="menu-close__title"><?=GetMessage('CLOSE')?></div>
        </div>
        <div class="menu-container">
            <div class="menu-nav">
              <?$previousLevel = 0;
                foreach($arResult as $arItem):?>
                    <?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
                        <?=str_repeat("</div></div></div>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
                    <?endif?>

                    <?if ($arItem["IS_PARENT"]):?>

                        <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                            <div class="menu-nav__elem">
                                <a href="javascript:;" class="menu-nav__link js-menuNavToggle">
                                    <?=$arItem["TEXT"]?>
                                </a>
                                <div class="menu-nav__sublist">
                                    <div class="menu-subnav">
                        
                            <?else:?>
                            <div  class="menu-subnav__elem">
                                <a href="<?=$arItem["LINK"]?>" class="menu-subnav__link js-menuNavToggle">
                                    <?=$arItem["TEXT"]?>
                                </a>
                                <div class="menu-nav__sublist">
                                    <div class="menu-subnav">
                        <?endif?>
                    <?else:?>
                        <?if ($arItem["PERMISSION"] > "D"):?>
                            <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                                <div class="menu-nav__elem <?=$arItem['PARAMS']['visible-xs'] ? $arItem['PARAMS']['visible-xs'] : '';?>">
                                    <a href="<?=$arItem["LINK"]?>"
                                        <?if ($arItem["PARAMS"]["popup"]):?>  data-mfp-src="<?=$arItem["PARAMS"]["popup"];?>" <?endif?>
                                       class="menu-nav__link <?if ($arItem["PARAMS"]["special"]): echo $arItem["PARAMS"]["special"]; endif?>">
                                        <?=$arItem["TEXT"]?>
                                    </a>
                                </div>

                            <?else:?>
                                <div class="menu-subnav__elem">
                                    <a href="<?=$arItem["LINK"]?>" class="menu-subnav__link <?if ($arItem["PARAMS"]["special"]): echo $arItem["PARAMS"]["special"]; endif?>">
                                        <?=$arItem["TEXT"]?>
                                    </a>
                                </div>
                            <?endif?>
                        <?else:?>
                            <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                                <div class="menu-nav__elem <?=$arItem['PARAMS']['visible-xs'] ? $arItem['PARAMS']['visible-xs'] : '';?>">
                                    <a href="" class="menu-nav__link" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>">
                                        <?=$arItem["TEXT"]?>
                                    </a>
                                </div>
                            <?else:?>
                                <div class="menu-subnav__elem">
                                    <a href="" class="menu-subnav__link denied" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>">
                                        <?=$arItem["TEXT"]?>
                                    </a>
                                </div>
                            <?endif?>
                        <?endif?>
                    <?endif?>
                    <?$previousLevel = $arItem["DEPTH_LEVEL"];?>
                <?endforeach?>

                <?if ($previousLevel > 1)://close last item tags?>
                    <?=str_repeat("</div></div></div>", ($previousLevel-1) );?>
                <?endif?>
            </div>
        </div>
        <div class="menu-bottom">
            <? if (SITE_ID == 's1') {
                $link = '/ru' .$APPLICATION->GetCurPage();
            } elseif (SITE_ID == 'ru') {
                $link = str_replace('/ru', '', $APPLICATION->GetCurPage());
            }?>
            <div class="header-lang">
                <a href="<?= $link; ?>" class="header-lang__link js-langControl <?=SITE_ID == 'ru' ? 'is-active' : '';?>">RU</a>
                <a href="<?= $link; ?>" class="header-lang__link js-langControl <?=SITE_ID == 's1' ? 'is-active' : '';?>">EN</a>
                <div class="header-lang__circle"></div>
            </div>
            <div class="menu-social">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "social",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "",
                        "EDIT_TEMPLATE" => "",
                        "PATH" => SITE_DIR . "include/social_link.php",
                        'STYLE' => '',
                    )
                );?>
            </div>
        </div>
        <div class="menu-dev"><?=GetMessage('MADE_BY')?>
            <a target="_blank" href="https://catzwolf.ru/">
                <img src="<?=MARKUP_PATH?>/images/cd_logo.svg">
            </a>
        </div>
    </div>
<?endif?>