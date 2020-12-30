<?php
namespace CarloNicora\Minimalism\Services\Slack;

use CarloNicora\Minimalism\Interfaces\ServiceInterface;
use CarloNicora\Minimalism\Services\Slack\Objects\SlackMessage;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use RuntimeException;

class Slack implements ServiceInterface
{
    /**
     * abstractApiCaller constructor.
     * @param string $MINIMALISM_SERVICE_SLACK_TOKEN
     */
    public function __construct(private string $MINIMALISM_SERVICE_SLACK_TOKEN) {}

    /**
     * @param SlackMessage $message
     * @param string $channel
     * @throws Exception|GuzzleException
     */
    public function sendSlackMessage(SlackMessage $message, string $channel): void
    {
        if ($this->MINIMALISM_SERVICE_SLACK_TOKEN === null){
            throw new RuntimeException('Slack not configured');
        }

        $client = new Client([
            'headers' => [
                'Authorization' => 'Bearer ' . $this->MINIMALISM_SERVICE_SLACK_TOKEN,
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

    /**
     *
     */
    public function initialise(): void {}

    /**
     *
     */
    public function destroy(): void {}
}