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
                  <th><?= $this->Paginator->sort('content') ?></th>
                  <th><?= $this->Paginator->sort('Poster par') ?></th>
                  <th><?= $this->Paginator->sort('created') ?></th>
                  <th><?= $this->Paginator->sort('location') ?></th>
                  <th class="actions"><?= __('Actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($perles as $perle): ?>
                <tr>
                    <td><?= $this->Number->format($perle->id) ?></td>
                    <td><?=
                            $this->Text->truncate(
                                $perle->content,
                                10,
                                [
                                    'ellipsis' => '...',
                                    'exact' => false
                                ]
                            ) ?>
                    </td>
                    <td><?= h($perle['user']['full_name']) ?></td>
                    <td><?= h($perle->created) ?></td>
                    <td><?= h($perle->location) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $perle->id], ['class' => 'btn btn-info']) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $perle->id], ['class' => 'btn btn-primary']) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $perle->id], ['class' => 'btn btn-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $perle->id)]) ?>
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