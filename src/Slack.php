<?php
namespace CarloNicora\Minimalism\Services\Slack;

use CarloNicora\Minimalism\Core\Services\Abstracts\AbstractService;
use CarloNicora\Minimalism\Core\Services\Factories\ServicesFactory;
use CarloNicora\Minimalism\Core\Services\Interfaces\ServiceConfigurationsInterface;
use CarloNicora\Minimalism\Services\Slack\Configurations\SlackConfigurations;
use Exception;
use RuntimeException;

class Slack extends AbstractService
{
    /** @var SlackConfigurations  */
    public SlackConfigurations $configData;

    /**
     * abstractApiCaller constructor.
     * @param ServiceConfigurationsInterface $configData
     * @param ServicesFactory $services
     */
    public function __construct(ServiceConfigurationsInterface $configData, ServicesFactory $services) {
        parent::__construct($configData, $services);

        /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
        $this->configData = $configData;
    }

    /**
     * @param string $serviceName
     * @param string $message
     * @throws Exception
     */
    public function sendError(string $serviceName, string $message): void
    {
        $this->sendMessage('error', $serviceName, $message);
    }

    /**
     * @param string $serviceName
     * @param string $message
     * @throws Exception
     */
    public function sendWarning(string $serviceName, string $message): void
    {
        $this->sendMessage('warning', $serviceName, $message);
    }

    /**
     * @param string $serviceName
     * @param string $message
     * @throws Exception
     */
    public function sendNotification(string $serviceName, string $message): void
    {
        $this->sendMessage('notification', $serviceName, $message);
    }

    /**
     * @param string $type
     * @param string $serviceName
     * @param string $message
     * @throws Exception
     */
    private function sendMessage(string $type, string $serviceName, string $message): void
    {
        if ($this->configData->getURL() === null || $this->configData->getChannel() === null){
            throw new RuntimeException('Slack not configured');
        }

        $msg = [
            'blocks' => [
                'type' => 'context',
                'elements' => [
                    'type' => 'mrkdwn',
                    'text' => '*minimalism ' . $type . '* identified in `' . $serviceName . '`'
                ],
            ],[
                'type' => 'divider'
            ],[
                'type' => 'context',
                'elements' => [
                    'type' => 'mrkdwn',
                    'text' => $message
                ],
            ]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_URL,$this->configData->getURL());
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($msg, JSON_THROW_ON_ERROR));

        curl_exec($ch);
        curl_close($ch);
    }
}