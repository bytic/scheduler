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
        if ($this->executable === null) {
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
     * Get footer comment block.
     *
     * @return string
     */
    private function getFooterComment()
    {
        return '# End ' . $this->baseComment;
    }
    /**
     * Get header comment block.
     *
     * @return string
     */
    private function getHeaderComment()
    {
        return '# Begin ' . $this->baseComment;
    }
}
