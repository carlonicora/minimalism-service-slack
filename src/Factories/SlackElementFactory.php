<?php
namespace CarloNicora\Minimalism\Services\Slack\Factories;

use CarloNicora\Minimalism\Services\Slack\Interfaces\SlackMessageElementInterface;
use CarloNicora\Minimalism\Services\Slack\Objects\Elements\SlackMessageElementText;

class SlackElementFactory
{
    /**
     * @param string $text
     * @param int $textType
     * @return SlackMessageElementText
     */
    public function createText(
        string $text,
        int $textType=SlackMessageElementInterface::TEXT_TYPE_PLAIN_TEXT,
    ): SlackMessageElementText
    {
        return new SlackMessageElementText($text, $textType);
    }
}