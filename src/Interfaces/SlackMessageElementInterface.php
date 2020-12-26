<?php
namespace CarloNicora\Minimalism\Services\Slack\Interfaces;

interface SlackMessageElementInterface
{
    public const TEXT_TYPE_PLAIN_TEXT=1;
    public const TEXT_TYPE_MARKDOWN=2;

    /**
     * @return array
     */
    public function getContent(): array;
}