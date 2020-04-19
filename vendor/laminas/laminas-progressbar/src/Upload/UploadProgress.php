<?php

/**
 * @see       https://github.com/laminas/laminas-progressbar for the canonical source repository
 * @copyright https://github.com/laminas/laminas-progressbar/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-progressbar/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ProgressBar\Upload;

use Laminas\ProgressBar\Exception;

/**
 * Progress Bar Upload Handler for the UploadProgress extension
 */
class UploadProgress extends AbstractUploadHandler
{
    /**
     * @param  string $id
     * @return array|bool
     * @throws Exception\PhpEnvironmentException
     */
    protected function getUploadProgress($id)
    {
        if (! $this->isUploadProgressAvailable()) {
            throw new Exception\PhpEnvironmentException(
                'UploadProgress extension is not installed'
            );
        }

        $uploadInfo = uploadprogress_get_info($id);
        if (! is_array($uploadInfo)) {
            return false;
        }

        $status  = [
            'total'    => 0,
            'current'  => 0,
            'rate'     => 0,
            'message'  => '',
            'done'     => false
        ];
        $status = $uploadInfo + $status;
        $status['total']   = $status['bytes_total'];
        $status['current'] = $status['bytes_uploaded'];
        $status['rate']    = $status['speed_average'];
        if ($status['total'] == $status['current']) {
            $status['done'] = true;
        }

        return $status;
    }

    /**
     * Checks for the UploadProgress extension
     *
     * @return bool
     */
    public function isUploadProgressAvailable()
    {
        return is_callable('uploadprogress_get_info');
    }
}
