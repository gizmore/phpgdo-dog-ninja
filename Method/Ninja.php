<?php
namespace GDO\DogNinja\Method;

use GDO\Core\GDO_ArgError;
use GDO\Core\GDO_DBException;
use GDO\Core\GDT;
use GDO\Core\GDT_Object;
use GDO\Core\Method;
use GDO\DogNinja\DOG_Ninja;
use GDO\UI\GDT_HTML;

final class Ninja extends Method
{

    public function gdoParameters(): array
    {
        return [
            GDT_Object::make('id')->table(DOG_Ninja::table()),
        ];
    }

    /**
     * @throws GDO_ArgError
     */
    private function getScroll(): DOG_Ninja
    {
        return $this->gdoParameterValue('id');
    }

    /**
     * @throws GDO_DBException
     * @throws GDO_ArgError
     */
    public function execute(): GDT
    {
        $freedom = $this->getEnlightment();
        return GDT_HTML::make()->var($freedom);
    }

    /**
     * @throws GDO_DBException
     * @throws GDO_ArgError
     */
    private function getEnlightment(): DOG_Ninja
    {
        if (!($scroll = $this->getScroll()))
        {
            $scroll = DOG_Ninja::table()->select()->first()->orderRand()->exec()->fetchObject();
        }
        return $scroll;
    }

}
