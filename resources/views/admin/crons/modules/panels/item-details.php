<?php
/**
 * Admin partial: detail panel for a single cron event.
 *
 * Variables available (inherited from view.php):
 *   $event     \Bytic\Scheduler\Events\Event
 *   $isInstalled  bool
 *   $isPaused  bool
 *   $status    string
 */
?>
<div class="card">
    <div class="card-header">Cron Details</div>
    <div class="card-body">
        <table class="table table-sm mb-0">
            <tbody>
                <tr>
                    <th style="width:35%">Identifier</th>
                    <td><code><?= htmlspecialchars($event->getIdentifier()) ?></code></td>
                </tr>
                <tr>
                    <th>Human Readable ID</th>
                    <td><?= htmlspecialchars($event->getIdentifierHumanRead()) ?></td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td><?= htmlspecialchars($event->getSummaryForDisplay()) ?></td>
                </tr>
                <tr>
                    <th>Command</th>
                    <td><code><?= htmlspecialchars($event->getCommand()) ?></code></td>
                </tr>
                <tr>
                    <th>Cron Expression</th>
                    <td><code><?= htmlspecialchars($event->getExpression()) ?></code></td>
                </tr>
                <tr>
                    <th>Driver</th>
                    <td><?= htmlspecialchars($event->getDriver()) ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <?php if ($isPaused): ?>
                            <span class="badge bg-warning text-dark">Paused</span>
                        <?php elseif ($status === 'not_installed'): ?>
                            <span class="badge bg-secondary">Not installed</span>
                        <?php else: ?>
                            <span class="badge bg-success">Active</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
