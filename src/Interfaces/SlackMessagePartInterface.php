<?php
namespace CarloNicora\Minimalism\Services\Slack\Interfaces;

interface SlackMessagePartInterface
{
    /**
     * @return array
     */
    public function getContent(): array;
}