<?php
namespace CarloNicora\Minimalism\Services\Slack\Objects\Parts;

use CarloNicora\Minimalism\Services\Slack\Interfaces\SlackMessagePartInterface;
use JetBrains\PhpStorm\ArrayShape;

class SlackMessagePartDivider implements SlackMessagePartInterface
{
    /**
     * @return string[]
     */
    #[ArrayShape(['type' => "string"])] public function getContent(): array
    {
        return ['type' => 'divider'];
    }
}