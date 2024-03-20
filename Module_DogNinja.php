<?php

use GDO\Core\GDO_Module;
use GDO\Core\GDT_UInt;
use GDO\DogNinja\DOG_Ninja;
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

    public function onInstall(): void
    {
        Update::dogNinja();
    }

    public function getConfig(): array
    {
        return [
            GDT_UInt::make('last_scroll')->initial('0'),
        ];
    }

    public


}
