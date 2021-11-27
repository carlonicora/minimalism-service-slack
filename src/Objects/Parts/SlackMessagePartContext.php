<?php
namespace CarloNicora\Minimalism\Services\Slack\Objects\Parts;

use CarloNicora\Minimalism\Services\Slack\Interfaces\SlackMessageElementInterface;
use CarloNicora\Minimalism\Services\Slack\Interfaces\SlackMessagePartInterface;

class SlackMessagePartContext implements SlackMessagePartInterface
{
    /** @var array|SlackMessageElementInterface[]  */
    private array $elements = [];

    /**
     * @param SlackMessageElementInterface $element
     * @return $this
     */
    public function withElement(
        SlackMessageElementInterface $element,
    ): SlackMessagePartContext
    {
        $this->addElement($element);

        return $this;
    }

    /**
     * @param SlackMessageElementInterface $element
     */
    public function addElement(
        SlackMessageElementInterface $element,
    ): void
    {
        $this->elements[] = $element;
    }

    /**
     * @return array
     */
    public function getContent(
    ): array
    {
        $response = [
            'type' => 'context',
            'elements' => []
        ];

        foreach ($this->elements ?? [] as $element) {
            $response['elements'][] = $element->getContent();
        }

        return $response;
    }
}