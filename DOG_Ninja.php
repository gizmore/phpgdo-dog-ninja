<?php
namespace GDO\DogNinja;

use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_Text;

final class DOG_Ninja extends GDO
{

    public function gdoColumns(): array
    {
        return [
            GDT_AutoInc::make('scroll_id'),
            GDT_Text::make('scroll_content')->notNull(),
        ];
    }

	public function renderCLI(): string
    {
        $text = $this->gdoVar('scroll_content');
        return t('msg_dog_ninja_scroll', [$this->getID(), $text]);
    }


}
