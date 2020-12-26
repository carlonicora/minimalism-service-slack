<?php
namespace CarloNicora\Minimalism\Services\Slack\Configurations;

use CarloNicora\Minimalism\Core\Services\Abstracts\AbstractServiceConfigurations;
use Exception;

class SlackConfigurations extends AbstractServiceConfigurations
{
    /** @var string|null  */
    private ?string $token;

    /**
     * rabbitMqConfigurations constructor.
     * @throws Exception
     */
    public function __construct() {
        $this->token = getenv('MINIMALISM_SERVICE_SLACK_TOKEN');
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }
}