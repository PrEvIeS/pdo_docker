<?php
if (! defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

class StandardElementsComponent extends \CBitrixComponent
{
    /**
     * шаблоны путей по умолчанию
     *
     * @var array
     */
    protected $defaultUrlTemplates404 = [];

    /**
     * переменные шаблонов путей
     *
     * @var array
     */
    protected $componentVariables = [];

    /**
     * страница шаблона
     *
     * @var string
     */
    protected $page = '';

    /**
     * определяет переменные шаблонов и шаблоны путей
     */
    protected function setSefDefaultParams()
    {
        $this->defaultUrlTemplates404 = [];
        $this->componentVariables = ['ELEMENT_ID'];
    }

    /**
     * получение результатов
     */
    protected function getResult()
    {
        $urlTemplates = [];
        $variables = [];
        $variableAliases = [];
        if ($this->arParams['SEF_MODE'] == 'Y') {
            $variables = [];
            $urlTemplates = \CComponentEngine::MakeComponentUrlTemplates(
                $this->defaultUrlTemplates404,
                $this->arParams['SEF_URL_TEMPLATES']
            );
            $variableAliases = \CComponentEngine::MakeComponentVariableAliases(
                $this->defaultUrlTemplates404,
                $this->arParams['VARIABLE_ALIASES']
            );
            $engine = new CComponentEngine($this);
            if (CModule::IncludeModule('iblock')) {
                $engine->addGreedyPart('#SECTION_CODE_PATH#');
                $engine->setResolveCallback(['CIBlockFindTools', 'resolveComponentEngine']);
            }
            $this->page = $engine->guessComponentPath(
                $this->arParams['SEF_FOLDER'],
                $urlTemplates,
                $variables
            );

            if (strlen($this->page) <= 0) {
                \Bitrix\Iblock\Component\Tools::process404('Page not found', true, true, true);
            }

            \CComponentEngine::InitComponentVariables(
                $this->page,
                $this->componentVariables, $variableAliases,
                $variables
            );
        } else {
            $this->page = 'index';
        }

        $this->arResult = [
            'FOLDER' => $this->arParams['SEF_FOLDER'],
            'URL_TEMPLATES' => $urlTemplates,
            'VARIABLES' => $variables,
            'ALIASES' => $variableAliases,
        ];
    }

    /**
     * выполняет логику работы компонента
     */
    public function executeComponent()
    {
        try {
            $this->setSefDefaultParams();
            $this->getResult();
            $this->includeComponentTemplate($this->page);
        } catch (Exception $e) {
            ShowError($e->getMessage());
        }
    }
}
