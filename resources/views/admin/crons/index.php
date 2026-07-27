<?php
/**
 * Admin view: list all registered cron events.
 *
 * Variables available:
 *   $events  array  Each element: ['event' => Event, 'isPaused' => bool]
 */
?>
<div class="scheduler-crons">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Scheduled Crons</h2>
    </div>

    <?= $this->Flash()->render($this->controller); ?>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Name / Description</th>
                <th>Expression</th>
                <th>Driver</th>
                <th>Status</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($events)): ?>
            <tr>
                <td colspan="5" class="text-center text-muted">No cron events registered.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($events as $row): ?>
                <?php
                /** @var \Bytic\Scheduler\Events\Event $event */
                $event    = $row['event'];
                $isPaused = $row['isPaused'];
                ?>
                <tr class="<?= $isPaused ? 'table-secondary' : '' ?>">
                    <td>
                        <?= htmlspecialchars($event->getSummaryForDisplay()) ?>
                        <br>
                        <small class="text-muted"><?= htmlspecialchars($event->getIdentifier()) ?></small>
                    </td>
                    <td><code><?= htmlspecialchars($event->getExpression()) ?></code></td>
                    <td><?= htmlspecialchars($event->getDriver()) ?></td>
                    <td>
                        <?php if ($isPaused): ?>
                            <span class="badge bg-warning text-dark">Paused</span>
                        <?php else: ?>
                            <span class="badge bg-success">Active</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <a href="?action=view&identifier=<?= urlencode($event->getIdentifier()) ?>"
                           class="btn btn-sm btn-outline-primary">View</a>
                        <?php if ($isPaused): ?>
                            <a href="?action=resume&identifier=<?= urlencode($event->getIdentifier()) ?>"
                               class="btn btn-sm btn-outline-success">Resume</a>
                        <?php else: ?>
                            <a href="?action=pause&identifier=<?= urlencode($event->getIdentifier()) ?>"
                               class="btn btn-sm btn-outline-warning"
                               onclick="return confirm('Pause this cron?')">Pause</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
