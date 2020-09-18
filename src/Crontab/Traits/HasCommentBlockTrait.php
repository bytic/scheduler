<?php

namespace Bytic\Scheduler\Crontab\Traits;

/**
 * Trait HasCommentBlockTrait
 * @package Bytic\Scheduler\Crontab\Traits
 */
trait HasCommentBlockTrait
{
    /**
     * @var string
     */
    protected $baseComment;

    /**
     * @return string
     */
    public function getBaseComment()
    {
        if ($this->baseComment === null) {
            $this->initBaseComment();
        }

        return $this->baseComment;
    }

    /**
     * @param string $baseComment
     */
    public function setBaseComment($baseComment)
    {
        $this->baseComment = $baseComment;
    }

    protected function initBaseComment()
    {
        $this->baseComment = 'BYTIC cron generated tasks';
    }

    /**
     * Get header comment block.
     *
     * @return string
     */
    protected function getHeaderComment()
    {
        return '# Begin ' . $this->getBaseComment() . ' for [' . $this->getIdentifier() . ']';
    }

    /**
     * Get footer comment block.
     *
     * @return string
     */
    protected function getFooterComment()
    {
        return '# End ' . $this->getBaseComment() . ' for [' . $this->getIdentifier() . ']';
    }

    abstract public function getIdentifier();
}
