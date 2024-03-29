<?php
namespace GDO\DogNinja;

use GDO\Core\GDO_DBException;
use GDO\Core\GDO_Module;
use GDO\Core\GDT_UInt;
use GDO\DogNinja\Method\Update;

/**
 *
 */
final class Module_DogNinja extends GDO_Module
{

    public function getDependencies(): array
    {
        return [
            'Dog',
            'Net',
        ];
    }

    public function getClasses(): array
    {
        return [
            DOG_Ninja::class,
        ];
    }

    /**
     * @throws GDO_DBException
     */
    public function onInstall(): void
    {
//        Update::dogNinja();
    }

    public function onLoadLanguage(): void
    {
        $this->loadLanguage('lang/ninja');
    }

    public function getConfig(): array
    {
        return [
            GDT_UInt::make('last_scroll')->initial('0'),
        ];
    }

    public function cfgLastScroll(): int
    {
        return $this->getConfigValue('last_scroll');
    }


}
