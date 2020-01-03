<?php

namespace Bytic\Scheduler\Scheduler;

use Bytic\Scheduler\Helper;

/**
 * Class FileDetector
 * @package Bytic\Scheduler\Scheduler
 */
class FileDetector
{
    protected $scheduler;
    protected $basePath;

    /**
     * FileDetector constructor.
     * @param $scheduler
     * @param $basePath
     */
    public function __construct($scheduler, $basePath = null)
    {
        $this->scheduler = $scheduler;
        $this->basePath = $basePath ? $basePath : Helper::getBasePath();
    }

    /**
     * @return mixed|null
     * @throws \Exception
     */
    public function getPath()
    {
        $paths = $this->generatePathTries();
        foreach ($paths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }
        throw new \Exception("Scheduler path could not be determined");
    }

    /**
     * @return array
     */
    protected function generatePathTries()
    {
        return [
            $this->basePath . DIRECTORY_SEPARATOR . $this->filename(),
            $this->basePath . DIRECTORY_SEPARATOR . 'crons' . DIRECTORY_SEPARATOR . $this->filename(),
        ];
    }

    /**
     * @return string
     */
    protected function filename()
    {
        return 'scheduler.php';
    }
}