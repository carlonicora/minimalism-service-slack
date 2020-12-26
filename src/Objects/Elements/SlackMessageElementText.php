<?php
namespace CarloNicora\Minimalism\Services\Slack\Objects\Elements;

use CarloNicora\Minimalism\Services\Slack\Interfaces\SlackMessageElementInterface;
use CarloNicora\Minimalism\Services\Slack\Interfaces\SlackMessagePartInterface;

class SlackMessageElementText implements SlackMessagePartInterface, SlackMessageElementInterface
{
    /** @var int  */
    private int $textType;

    /** @var string  */
    private string $text;

    /**
     * SlackMessagePartText constructor.
     * @param string $text
     * @param int $textType
     */
    public function __construct(string $text, int $textType=SlackMessageElementInterface::TEXT_TYPE_PLAIN_TEXT)
    {
        $this->text = $text;
        $this->textType = $textType;
    }

    /**
     * @return array
     */
    public function getContent(): array
    {
        if ($this->textType === SlackMessageElementInterface::TEXT_TYPE_PLAIN_TEXT){
            return [
                'type' => 'plain_text',
                'emoji' => true,
                'text' => $this->text
            ];
        }

        return [
            'type' => 'mrkdwn',
            'text' => $this->text
        ];
    }
}