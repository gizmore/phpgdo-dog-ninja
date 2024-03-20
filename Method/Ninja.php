<?php
namespace GDO\DogNinja\Method;

use GDO\Core\GDT;
use GDO\Core\GDT_Object;
use GDO\Core\Method;
use GDO\UI\GDT_HTML;

final class Ninja extends Method
{

    public function gdoParameters(): array
    {
        return [
            GDT_Object::make('id')
        ];
    }

    public function execute(): GDT
    {
        $freedom = $this->getEnlightment();
        return GDT_HTML::make()->var($freedom);
    }
}
