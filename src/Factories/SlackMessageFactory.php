<?php
namespace CarloNicora\Minimalism\Services\Slack\Factories;

use CarloNicora\Minimalism\Services\Slack\Objects\SlackMessage;

class SlackMessageFactory
{
    /**
     * @param string $text
     * @return SlackMessage
     */
    public function createSimpleMessage(string $text): SlackMessage
    {
        return new SlackMessage($text);
    }

    /**
     * @return SlackMessage
     */
    public function createMessage(): SlackMessage
    {
        return new SlackMessage();
    }
}