<?php
namespace CarloNicora\Minimalism\Services\Slack\Factories;

use CarloNicora\Minimalism\Services\Slack\Objects\Parts\SlackMessagePartContext;
use CarloNicora\Minimalism\Services\Slack\Objects\Parts\SlackMessagePartDivider;
use CarloNicora\Minimalism\Services\Slack\Objects\Parts\SlackMessagePartHeader;

class SlackMessagePartFactory
{
    /**
     * @return SlackMessagePartDivider
     */
    public function createDivider(): SlackMessagePartDivider
    {
        return new SlackMessagePartDivider();
    }

    /**
     * @param string $text
     * @return SlackMessagePartHeader
     */
    public function createHeader(string $text): SlackMessagePartHeader
    {
        return new SlackMessagePartHeader($text);
    }

    /**
     * @return SlackMessagePartContext
     */
    public function createContext(): SlackMessagePartContext
    {
        return new SlackMessagePartContext();
    }
}