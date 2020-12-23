<?php
namespace CarloNicora\Minimalism\Services\Slack\Factories;

use CarloNicora\Minimalism\Core\Services\Abstracts\AbstractServiceFactory;
use CarloNicora\Minimalism\Core\Services\Exceptions\ConfigurationException;
use CarloNicora\Minimalism\Core\Services\Factories\ServicesFactory;
use CarloNicora\Minimalism\Services\Slack\Configurations\SlackConfigurations;
use CarloNicora\Minimalism\Services\Slack\Slack;
use Exception;

class ServiceFactory extends AbstractServiceFactory {
    /**
     * serviceFactory constructor.
     * @param ServicesFactory $services
     * @throws ConfigurationException
     * @throws Exception
     */
    public function __construct(ServicesFactory $services) {
        $this->configData = new SlackConfigurations();

        parent::__construct($services);
    }

    /**
     * @param servicesFactory $services
     * @return Slack
     */
    public function create(servicesFactory $services): Slack
    {
        return new Slack($this->configData, $services);
    }
}