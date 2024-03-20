<?php
namespace GDO\DogNinja\Method;

use GDO\Cronjob\MethodCronjob;
use GDO\DogNinja\DOG_Ninja;
use GDO\DogNinja\Module_DogNinja;
use GDO\Net\GDT_HTTP;
use function RingCentral\Psr7\str;

final class Update extends MethodCronjob
{

    public static function getNinjaURL(int $number): void
    {
        return "https://raw.githubusercontent.com/gizmore/anonymous-zen-book/master/{$number}";
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
        $mod = Module_DogNinja::instance();
        $scroll = $mod->cfgLastScroll();
        while (true)
        {
            if (!$this->fetchNextScroll($scroll + 1))
            {
                break;
            }
            $mod->increaseConfigVar('last_scroll');
        }
    }

    private function fetchNextScroll(int $scroll): bool
    {
        $url = self::getNinjaURL($scroll);
        $content = GDT_HTTP::make()->var($url)->render();
        if (str_starts_with($content, '404'))
        {
            return false;
        }
        DOG_Ninja::blank([
            'scroll_id' => (string)$scroll,
            'scroll_content' => $content,,
        ])->insert();
        return true;
    }


}
