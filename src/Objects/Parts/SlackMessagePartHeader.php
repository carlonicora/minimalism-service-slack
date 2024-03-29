<?php
namespace CarloNicora\Minimalism\Services\Slack\Objects\Parts;

use CarloNicora\Minimalism\Services\Slack\Factories\SlackElementFactory;
use CarloNicora\Minimalism\Services\Slack\Interfaces\SlackMessagePartInterface;
use CarloNicora\Minimalism\Services\Slack\Objects\Elements\SlackMessageElementText;

class SlackMessagePartHeader implements SlackMessagePartInterface
{
    /** @var SlackMessageElementText  */
    private SlackMessageElementText $text;

    /**
     * SlackMessagePartHeader constructor.
     * @param string $text
     */
    public function __construct(
        string $text,
    )
    {
        $this->text = (new SlackElementFactory())->createText($text);
    }

    /**
     * @return array
     */
    public function getContent(
    ): array
    {
        return [
            'type' => 'header',
            'text' => $this->text->getContent()
        ];
    }
}