<?php

/**
 * @see       https://github.com/laminas/laminas-progressbar for the canonical source repository
 * @copyright https://github.com/laminas/laminas-progressbar/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-progressbar/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ProgressBar\Adapter;

use Laminas\Json\Json;

/**
 * Laminas\ProgressBar\Adapter\JsPush offers a simple method for updating a
 * progressbar in a browser.
 */
class JsPush extends AbstractAdapter
{
    /**
     * Name of the JavaScript method to call on update
     *
     * @var string
     */
    protected $updateMethodName = 'Laminas\ProgressBar\ProgressBar\Update';

    /**
     * Name of the JavaScript method to call on finish
     *
     * @var string
     */
    protected $finishMethodName;

    /**
     * Set the update method name
     *
     * @param  string $methodName
     * @return \Laminas\ProgressBar\Adapter\JsPush
     */
    public function setUpdateMethodName($methodName)
    {
        $this->updateMethodName = $methodName;

        return $this;
    }

    /**
     * Set the finish method name
     *
     * @param  string $methodName
     * @return \Laminas\ProgressBar\Adapter\JsPush
     */
    public function setFinishMethodName($methodName)
    {
        $this->finishMethodName = $methodName;

        return $this;
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
            'text'          => $text
        ];

        $data = '<script type="text/javascript">'
              . 'parent.' . $this->updateMethodName . '(' . Json::encode($arguments) . ');'
              . '</script>';

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
        if ($this->finishMethodName === null) {
            return;
        }

        $data = '<script type="text/javascript">'
              . 'parent.' . $this->finishMethodName . '();'
              . '</script>';

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
        // 1024 padding is required for Safari, while 256 padding is required
        // for Internet Explorer. The <br /> is required so Safari actually
        // executes the <script />
        echo str_pad($data . '<br />', 1024, ' ', STR_PAD_RIGHT) . "\n";

        flush();
        ob_flush();
    }
}
