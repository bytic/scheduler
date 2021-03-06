<?php

namespace Bytic\Scheduler\Events\Traits;

/**
 * Trait HasOutput
 * @package Bytic\Scheduler\Events\Traits
 */
trait HasOutput
{
    /**
     * The location that output should be sent to.
     *
     * @var string
     */
    public $output = '/dev/null';

    /**
     * Event generated output.
     *
     * @var string|null
     */
    public $outputStream;

    /** @var string[] */
    protected $wholeOutput = [];

    /**
     * Get the default output depending on the OS.
     *
     * @return string
     */
    public function getDefaultOutput()
    {
        return (DIRECTORY_SEPARATOR === '\\') ? 'NUL' : '/dev/null';
    }

//    /**
//     * Ensure that the command output is being captured.
//     *
//     * @return void
//     */
//    protected function ensureOutputIsBeingCaptured()
//    {
//        if (is_null($this->output) || $this->output == $this->getDefaultOutput()) {
//            $this->sendOutputTo(storage_path('logs/schedule-'.sha1($this->mutexName()).'.log'));
//        }
//    }

    /**
     * Return event's full output.
     *
     * @return string|null
     */
    public function getOutputStream()
    {
        return $this->outputStream;
    }

    /**
     * @return \Closure
     */
    protected function outputCaptureProcessCallback()
    {
        return function ($type, $content): void {
            $this->wholeOutput[] = $content;
        };
    }

    /** @return string */
    public function wholeOutput()
    {
        return \implode('', $this->wholeOutput);
    }
}
