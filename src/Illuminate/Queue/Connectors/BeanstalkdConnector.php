<?php

namespace Illuminate\Queue\Connectors;

use Illuminate\Queue\BeanstalkdQueue;
use Pheanstalk\Connection;
use Pheanstalk\Pheanstalk;
use Pheanstalk\PheanstalkInterface;

class BeanstalkdConnector implements ConnectorInterface
{
    /**
     * Establish a queue connection.
     *
     * @param  array $config
     * @return \Illuminate\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        $retryAfter = array_if($config, 'retry_after', Pheanstalk::DEFAULT_TTR);

        return new BeanstalkdQueue($this->pheanstalk($config), $config['queue'], $retryAfter);
    }

    /**
     * Create a Pheanstalk instance.
     *
     * @param  array $config
     * @return \Pheanstalk\Pheanstalk
     */
    protected function pheanstalk(array $config)
    {
        return new Pheanstalk(
            $config['host'],
            array_if($config, 'port', PheanstalkInterface::DEFAULT_PORT),
            array_if($config, 'timeout', Connection::DEFAULT_CONNECT_TIMEOUT),
            array_if($config, 'persistent', false)
        );
    }
}
