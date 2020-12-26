<?php
namespace CarloNicora\Minimalism\Services\Slack;

use CarloNicora\Minimalism\Core\Services\Abstracts\AbstractService;
use CarloNicora\Minimalism\Core\Services\Factories\ServicesFactory;
use CarloNicora\Minimalism\Core\Services\Interfaces\ServiceConfigurationsInterface;
use CarloNicora\Minimalism\Services\Slack\Configurations\SlackConfigurations;
use CarloNicora\Minimalism\Services\Slack\Objects\SlackMessage;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
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
     * @param SlackMessage $message
     * @param string $channel
     * @throws Exception|GuzzleException
     */
    public function sendSlackMessage(SlackMessage $message, string $channel): void
    {
        if ($this->configData->getToken() === null){
            throw new RuntimeException('Slack not configured');
        }

        $client = new Client([
            'headers' => [
                'Authorization' => 'Bearer ' . $this->configData->getToken(),
                'Content-Type' => 'application/json'
            ]
        ]);

        $payload = $message->getPayload();
        $payload['channel'] = $channel;

        $client->post(
            'https://slack.com/api/chat.postMessage',
             [RequestOptions::JSON => $payload]
        );
    }

    /*
    private function generateCallTrace(Exception $e): string
    {
        $trace = explode("\n", $e->getTraceAsString());
        // reverse array to make steps line up chronologically
        $trace = array_reverse($trace);
        array_shift($trace); // remove {main}
        array_pop($trace); // remove call to this method
        $result = array();

        foreach ($trace as $i => $iValue) {
            $result[] = ($i + 1)  . ')' . substr($iValue, strpos($iValue, ' ')); // replace '#someNum' with '$i)', set the right ordering
        }

        return "\t" . implode("\n\t", $result);
    }
    */
}