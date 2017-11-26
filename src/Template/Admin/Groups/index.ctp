  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="padding-bottom: 30px;">
      <h1 class="pull-left">
        Management
        <small>Users</small>
      </h1>
      <div class="pull-right">
        <?= $this->Html->link(__('New Pearl'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th><?= $this->Paginator->sort('id') ?></th>
                  <th><?= $this->Paginator->sort('name') ?></th>
                  <th><?= $this->Paginator->sort('created') ?></th>
                  <th><?= $this->Paginator->sort('modified') ?></th>
                  <th class="actions"><?= __('Actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($groups as $group): ?>
                <tr>
                    <td><?= $this->Number->format($group->id) ?></td>
                    <td><?= h($group->name) ?></td>
                    <td><?= h($group->created) ?></td>
                    <td><?= h($group->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $group->id], ['class' => 'btn btn-info']) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $group->id], ['class' => 'btn btn-primary']) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $group->id], ['class' => 'btn btn-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $group->id)]) ?>
                    </td>
                </tr>
               <?php endforeach; ?>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>