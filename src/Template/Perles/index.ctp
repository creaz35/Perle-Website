<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Perle'), ['action' => 'add']) ?></li>
    </ul>
</div>
<div class="perles index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('content') ?></th>
            <th><?= $this->Paginator->sort('created') ?></th>
            <th><?= $this->Paginator->sort('modified') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($perles as $perle): ?>
        <tr>
            <td><?= $this->Number->format($perle->id) ?></td>
            <td><?= h($perle->content) ?></td>
            <td><?= h($perle->created) ?></td>
            <td><?= h($perle->modified) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $perle->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $perle->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $perle->id], ['confirm' => __('Are you sure you want to delete # {0}?', $perle->id)]) ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
