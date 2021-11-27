<?php
namespace CarloNicora\Minimalism\Services\Slack\Objects;

use CarloNicora\Minimalism\Services\Slack\Interfaces\SlackMessagePartInterface;
use Exception;
use RuntimeException;

class SlackMessage
{
    /** @var array|SlackMessagePartInterface[]  */
    private array $parts=[];

    /** @var string|null  */
    private ?string $text;

    /**
     * SlackMessage constructor.
     * @param string|null $text
     */
    public function __construct(
        ?string $text=null,
    )
    {
        $this->text = $text;
    }

    /**
     * @param SlackMessagePartInterface $part
     * @return $this
     * @throws Exception
     */
    public function withPart(
        SlackMessagePartInterface $part,
    ): SlackMessage
    {
        $this->addPart($part);

        return $this;
    }

    /**
     * @param SlackMessagePartInterface $part
     * @throws Exception
     */
    public function addPart(
        SlackMessagePartInterface $part,
    ): void
    {
        if ($this->text !== null){
            throw new RuntimeException('The message has been setup as a simpel text and cannot contain parts', 412);
        }

        $this->parts[] = $part;
    }

    /**
     * @return array
     */
    public function getPayload(
    ): array
    {
        if ($this->text !== null){
            return ['text' => $this->text];
        }

        $response = [
            'blocks' => []
        ];

        foreach ($this->parts ?? [] as $part){
            $response['blocks'][] = $part->getContent();
        }

        return $response;
    }
}