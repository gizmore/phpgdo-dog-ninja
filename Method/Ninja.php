<?php
namespace GDO\DogNinja\Method;

use GDO\Core\GDO_ArgError;
use GDO\Core\GDO_DBException;
use GDO\Core\GDT;
use GDO\Core\GDT_Object;
use GDO\Core\Method;
use GDO\Dog\DOG_Command;
use GDO\DogNinja\DOG_Ninja;
use GDO\UI\GDT_HTML;

final class Ninja extends DOG_Command
{

    public function isCLI(): bool
    {
        return true;
    }

    public function getCLITrigger(): string
    {
        return 'ninja';
    }


    public function gdoParameters(): array
    {
        return [
            GDT_Object::make('id')->table(DOG_Ninja::table()),
        ];
    }

    /**
     * @throws GDO_ArgError
     */
    private function getScroll(): ?DOG_Ninja
    {
        if ($scroll = $this->gdoParameterValue('id'))
        {
            return $scroll;
        }
        return $this->getRandomScroll();
    }

    /**
     * @throws GDO_DBException
     * @throws GDO_ArgError
     */
    public function execute(): GDT
    {
        $freedom = $this->getEnlightment();
        $html = $freedom->render();
        return GDT_HTML::make()->var($html);
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

    private function getRandomScroll(): ?DOG_Ninja
    {
        return DOG_Ninja::table()->select()->first()->orderRand()->exec()->fetchObject();
    }

}
