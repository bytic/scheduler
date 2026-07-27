<?php
/**
 * Admin view: detail page for a single cron event.
 *
 * Variables available:
 *   $event     \Bytic\Scheduler\Events\Event
 *   $isInstalled  bool
 *   $isPaused  bool
 *   $status    string
 */
?>
<div class="scheduler-cron-view">
    <?= $this->Flash()->render($this->controller); ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>
            <?= htmlspecialchars($event->getSummaryForDisplay()) ?>
            <?php if ($status === 'not_installed'): ?>
                <span class="badge bg-secondary ms-2">Not installed</span>
            <?php elseif ($isPaused): ?>
                <span class="badge bg-warning text-dark ms-2">Paused</span>
            <?php else: ?>
                <span class="badge bg-success ms-2">Active</span>
            <?php endif; ?>
        </h2>
        <a href="?action=index" class="btn btn-secondary">&larr; Back to list</a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <?= $this->load('/crons/modules/panels/item-details'); ?>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Actions</div>
                <div class="card-body d-grid gap-2">
                    <?php if (!$isInstalled): ?>
                        <span class="btn btn-outline-secondary disabled">Not installed in driver</span>
                    <?php elseif ($isPaused): ?>
                        <a href="?action=resume&identifier=<?= urlencode($event->getIdentifier()) ?>"
                           class="btn btn-success">
                            &#9654; Resume Cron
                        </a>
                    <?php else: ?>
                        <a href="?action=pause&identifier=<?= urlencode($event->getIdentifier()) ?>"
                           class="btn btn-warning"
                           onclick="return confirm('Are you sure you want to pause this cron?')">
                            &#9646;&#9646; Pause Cron
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
