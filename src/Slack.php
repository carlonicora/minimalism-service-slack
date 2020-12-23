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
    private const TYPE_NOTIFY=1;
    private const TYPE_WARNING=2;
    private const TYPE_ERROR=3;

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
     * @param Exception|null $e
     * @throws Exception
     */
    public function sendError(string $serviceName, string $message, ?Exception $e=null): void
    {
        if ($e !== null) {
            $message .= PHP_EOL
                . '```'
                . $this->generateCallTrace($e)
                . '```';
        }
        $this->sendMessage(self::TYPE_ERROR, $serviceName, $message);
    }

    /**
     * @param string $serviceName
     * @param string $message
     * @throws Exception
     */
    public function sendWarning(string $serviceName, string $message): void
    {
        $this->sendMessage(self::TYPE_WARNING, $serviceName, $message);
    }

    /**
     * @param string $serviceName
     * @param string $message
     * @throws Exception
     */
    public function sendNotification(string $serviceName, string $message): void
    {
        $this->sendMessage(self::TYPE_NOTIFY, $serviceName, $message);
    }

    /**
     * @param int $type
     * @param string $serviceName
     * @param string $message
     * @throws Exception
     */
    private function sendMessage(int $type, string $serviceName, string $message): void
    {
        if ($this->configData->getURL() === null || $this->configData->getChannel() === null){
            throw new RuntimeException('Slack not configured');
        }

        switch ($type){
            case self::TYPE_WARNING:
                $messageType = 'warning';
                $messageImage = 'https://media.giphy.com/media/XS39abnCjfv5m/giphy.gif';
                break;
            case self::TYPE_ERROR:
                $messageType = 'error';
                $messageImage = 'https://media.giphy.com/media/TqiwHbFBaZ4ti/giphy.gif';
                break;
            default:
                $messageType = 'notification';
                $messageImage = 'https://media.giphy.com/media/XD9LHOATb4HdwsPpCm/giphy.gif';
                break;
        }

        $title = '*minimalism ' . $messageType . '* identified in `' . $serviceName . '`';
        if ($this->configData->getEnvironment() !== null){
            $title .= ' on `' . $this->configData->getEnvironment() . '`';
        }

        $msg = [
            'blocks' => [
                [
                    'type' => 'context',
                    'elements' => [
                        [
                            'type' => 'mrkdwn',
                            'text' => $title,
                        ]
                    ]
                ],[
                    'type' => 'divider'
                ],[
                    'type' => 'context',
                    'elements' => [
                        [
                            'type' => 'image',
                            'image_url' => $messageImage,
                            'alt_text' => $messageType
                        ],[
                            'type' => 'mrkdwn',
                            'text' => $message
                        ]
                    ]
                ]
            ]
        ];

        $data = "payload=" . json_encode($msg, JSON_THROW_ON_ERROR);

        $ch = curl_init($this->configData->getURL());
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }

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
}