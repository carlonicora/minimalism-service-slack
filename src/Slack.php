<?php
namespace CarloNicora\Minimalism\Services\Slack;

use CarloNicora\Minimalism\Abstracts\AbstractService;
use CarloNicora\Minimalism\Enums\HttpCode;
use CarloNicora\Minimalism\Services\Slack\Objects\SlackMessage;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use RuntimeException;

class Slack extends AbstractService
{
    /**
     * abstractApiCaller constructor.
     * @param string|null $MINIMALISM_SERVICE_SLACK_TOKEN
     */
    public function __construct(
        private ?string $MINIMALISM_SERVICE_SLACK_TOKEN=null,
    )
    {
    }

    /**
     * @param SlackMessage $message
     * @param string $channel
     * @throws Exception|GuzzleException
     */
    public function sendSlackMessage(
        SlackMessage $message,
        string $channel,
    ): void
    {
        if ($this->MINIMALISM_SERVICE_SLACK_TOKEN === null){
            throw new RuntimeException('MINIMALISM_SERVICE_SLACK_TOKEN missing', HttpCode::InternalServerError);
        }
        $client = new Client([
            'headers' => [
                'Authorization' => 'Bearer ' . $this->MINIMALISM_SERVICE_SLACK_TOKEN,
                'Content-Type' => 'application/json'
            ]
        ]);

        $payload = $message->getPayload();
        $payload['channel'] = $channel;

        /** @noinspection UnusedFunctionResultInspection */
        $client->post(
            'https://slack.com/api/chat.postMessage',
            [RequestOptions::JSON => $payload]
        );
    }
}