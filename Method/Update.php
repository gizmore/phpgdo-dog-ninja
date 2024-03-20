<?php
namespace GDO\DogNinja\Method;

use GDO\Cronjob\MethodCronjob;
use GDO\Net\GDT_HTTP;

final class Update extends MethodCronjob
{

    public static function getNinjaURL(string $number): void
    {

    }

    public static function dogNinja(): void
    {
        self::make()->run();
    }

    public function runAt(): string
    {
        return $this->runHourly();
    }

    public function run(): void
    {
        $content = GDT_HTTP::make()->var()->render();
    }



}
