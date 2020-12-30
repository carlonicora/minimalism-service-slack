<?php
namespace CarloNicora\Minimalism\Services\Slack\Objects\Parts;

use CarloNicora\Minimalism\Services\Slack\Factories\SlackElementFactory;
use CarloNicora\Minimalism\Services\Slack\Interfaces\SlackMessagePartInterface;
use CarloNicora\Minimalism\Services\Slack\Objects\Elements\SlackMessageElementText;
use JetBrains\PhpStorm\ArrayShape;

class SlackMessagePartHeader implements SlackMessagePartInterface
{
    /** @var SlackMessageElementText  */
    private SlackMessageElementText $text;

    /**
     * SlackMessagePartHeader constructor.
     * @param string $text
     */
    public function __construct(string $text)
    {
        $elemebtBuilder = new SlackElementFactory();
        $this->text = $elemebtBuilder->createText($text);
    }

    /**
     * @return array
     */
    #[ArrayShape(['type' => "string", 'text' => "array"])] public function getContent(): array
    {
        return [
            'type' => 'header',
            'text' => $this->text->getContent()
        ];
    }
}