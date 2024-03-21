<?php
namespace GDO\DogNinja\Method;

use GDO\Core\Application;
use GDO\Core\GDO_DBException;
use GDO\Core\GDT_Hook;
use GDO\Cronjob\MethodCronjob;
use GDO\DogNinja\DOG_Ninja;
use GDO\DogNinja\Module_DogNinja;
use GDO\Net\GDT_HTTP;

final class Update extends MethodCronjob
{

    public static function getNinjaURL(int $number): string
    {
        return "https://raw.githubusercontent.com/gizmore/anonymous-zen-book/master/{$number}";
    }

    public function announce(DOG_Ninja $scroll): void
    {
        GDT_Hook::callWithIPC('NinjaScrollCreated', $scroll->getID());
    }

    /**
     * @throws GDO_DBException
     */
    public static function dogNinja(): void
    {
        self::make()->run();
    }

    public function runAt(): string
    {
        return $this->runHourly();
    }

    /**
     * @throws GDO_DBException
     */
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
            $scroll++;
        }
    }

    /**
     * @throws GDO_DBException
     */
    private function fetchNextScroll(int $number): bool
    {
        $url = self::getNinjaURL($number);
        $content = GDT_HTTP::make()->var($url)->render();
        if (str_starts_with($content, '404'))
        {
            return false;
        }
        $scroll = DOG_Ninja::blank([
            'scroll_id' => (string)$number,
            'scroll_content' => $content,
        ])->softReplace();
        if (!Application::instance()->isInstall())
        {
            $this->announce($scroll);
        }
        return true;
    }


}
