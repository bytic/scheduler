<?php

namespace Bytic\Scheduler\Crontab;

use Bytic\Scheduler\Exception\InvalidIdentifierException;

/**
 * Class Cronfile
 * @package Bytic\Scheduler\Crontab
 */
class Cronfile
{
    protected $content;

    protected $header;
    protected $footer;

    protected $hasHeader;
    protected $hasFooter;

    /**
     * Cronfile constructor.
     * @param $header
     * @param $footer
     * @param $content
     */
    public function __construct($content, $header, $footer)
    {
        $this->header = $header;
        $this->footer = $footer;
        $this->content = $content;

        $this->detectHeaderFooter();
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    protected function detectHeaderFooter()
    {
        $this->hasHeader = preg_match("/^" . preg_quote($this->header, "/") . "\s*$/m", $this->content) === 1;
        $this->hasFooter = preg_match("/^" . preg_quote($this->footer, "/") . "\s*$/m", $this->content) === 1;

        if ($this->hasHeader && !$this->hasFooter) {
            throw new InvalidIdentifierException(sprintf('Unclosed identifier. Your crontab contains "%s", but no "%s".',
                $this->header, $this->footer));
        } elseif (!$this->hasHeader && $this->hasFooter) {
            throw new InvalidIdentifierException(sprintf('Unopened identifier. Your crontab contains "%s", but no "%s".',
                $this->footer, $this->header));
        }
    }

    /**
     * @param $content
     */
    public function updateContent($content)
    {
        $content = $this->header . PHP_EOL . $content . PHP_EOL . $this->footer;

        if ($this->hasHeader && $this->hasFooter) {
            $this->content = preg_replace("/^$header\s*$.*?^$footer\s*$/sm", $content, $this->content);
        } else {
            $this->content .= PHP_EOL . $content;
        }
    }
}
