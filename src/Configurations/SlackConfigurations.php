<?php
namespace CarloNicora\Minimalism\Services\Slack\Configurations;

use CarloNicora\Minimalism\Core\Services\Abstracts\AbstractServiceConfigurations;
use Exception;

class SlackConfigurations extends AbstractServiceConfigurations
{
    /** @var string|null  */
    private ?string $URL;

    /** @var string|null  */
    private ?string $token;

    /** @var string|null  */
    private ?string $environment;

    /**
     * rabbitMqConfigurations constructor.
     * @throws Exception
     */
    public function __construct() {
        $this->URL = getenv('MINIMALISM_SERVICE_SLACK_URL');
        $this->environment = getenv('MINIMALISM_SERVICE_SLACK_ENVIRONMENT');
        $this->token = getenv('MINIMALISM_SERVICE_SLACK_TOKEN');
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
    public function getEnvironment(): ?string
    {
        return $this->environment;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }
}