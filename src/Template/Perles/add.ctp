<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Perles'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="perles form large-10 medium-9 columns">
    <?= $this->Form->create($perle); ?>
    <fieldset>
        <legend><?= __('Add Perle') ?></legend>
        <?php
            echo $this->Form->input('content');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
