<?php

namespace App\Bots;

use Telegram\Bot\Actions;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Storage;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Commands\Command;
/**
 * Class HelpCommand.
 */
class AbsenCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'help';
    /**
     * @var array Command Aliases
     */
    protected $aliases = ['listcommands'];
    /**
     * @var string Command Description
     */
    protected $description = 'Untuk menampilkan seluruh command';
    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $commands = $this->telegram->getCommands();
        $text = '';
        foreach ($commands as $name => $handler) {
            /* @var Command $handler */
            $text .= sprintf('/%s - %s'.PHP_EOL, $name, $handler->getDescription());
        }
        $this->replyWithMessage(compact('text'));
    }
}
