<?php
namespace CarloNicora\Minimalism\Services\Slack\Configurations;

use CarloNicora\Minimalism\Core\Services\Abstracts\AbstractServiceConfigurations;
use Exception;

class SlackConfigurations extends AbstractServiceConfigurations
{
    /** @var string|null  */
    private ?string $URL;

    /** @var string|null  */
    private ?string $channel;

    /**
     * rabbitMqConfigurations constructor.
     * @throws Exception
     */
    public function __construct() {
        $this->URL = getenv('MINIMALISM_SERVICE_SLACK_URL');
        $this->channel = getenv('MINIMALISM_SERVICE_SLACK_CHANNEL');
    }

    /**
     * @return string|null
     */
    public function getURL(): ?string
    {
        return $this->URL;
    }

    /**
     * @return string|null
     */
    public function getChannel(): ?string
    {
        return $this->channel;
    }
}