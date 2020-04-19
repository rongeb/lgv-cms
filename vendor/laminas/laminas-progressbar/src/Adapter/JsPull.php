<?php

/**
 * @see       https://github.com/laminas/laminas-progressbar for the canonical source repository
 * @copyright https://github.com/laminas/laminas-progressbar/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-progressbar/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ProgressBar\Adapter;

use Laminas\Json\Json;

/**
 * Laminas\ProgressBar\Adapter\JsPull offers a simple method for updating a
 * progressbar in a browser.
 */
class JsPull extends AbstractAdapter
{
    /**
     * Whether to exit after json data send or not
     *
     * @var bool
     */
    protected $exitAfterSend = true;

    /**
     * Set whether to exit after json data send or not
     *
     * @param  bool $exitAfterSend
     * @return \Laminas\ProgressBar\Adapter\JsPull
     */
    public function setExitAfterSend($exitAfterSend)
    {
        $this->exitAfterSend = $exitAfterSend;
    }

    /**
     * Defined by Laminas\ProgressBar\Adapter\AbstractAdapter
     *
     * @param  float   $current       Current progress value
     * @param  float   $max           Max progress value
     * @param  float   $percent       Current percent value
     * @param  int $timeTaken     Taken time in seconds
     * @param  int $timeRemaining Remaining time in seconds
     * @param  string  $text          Status text
     * @return void
     */
    public function notify($current, $max, $percent, $timeTaken, $timeRemaining, $text)
    {
        $arguments = [
            'current'       => $current,
            'max'           => $max,
            'percent'       => ($percent * 100),
            'timeTaken'     => $timeTaken,
            'timeRemaining' => $timeRemaining,
            'text'          => $text,
            'finished'      => false
        ];

        $data = Json::encode($arguments);

        // Output the data
        $this->_outputData($data);
    }

    /**
     * Defined by Laminas\ProgressBar\Adapter\AbstractAdapter
     *
     * @return void
     */
    public function finish()
    {
        $data = Json::encode(['finished' => true]);

        $this->_outputData($data);
    }

    /**
     * Outputs given data the user agent.
     *
     * This split-off is required for unit-testing.
     *
     * @param  string $data
     * @return void
     */
    // @codingStandardsIgnoreStart
    protected function _outputData($data)
    {
        // @codingStandardsIgnoreEnd
        echo $data;

        if ($this->exitAfterSend) {
            exit;
        }
    }
}
