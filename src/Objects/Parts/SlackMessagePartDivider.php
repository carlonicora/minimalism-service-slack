<?php
namespace CarloNicora\Minimalism\Services\Slack\Objects\Parts;

use CarloNicora\Minimalism\Services\Slack\Interfaces\SlackMessagePartInterface;

class SlackMessagePartDivider implements SlackMessagePartInterface
{
    /**
     * @return string[]
     */
    public function getContent(): array
    {
        return ['type' => 'divider'];
    }
}