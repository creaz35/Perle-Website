  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="padding-bottom: 30px;">
      <h1 class="pull-left">
        Management
        <small>Notifications</small>
      </h1>
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
                  <th><?= $this->Paginator->sort('user_id') ?></th>
                  <th><?= $this->Paginator->sort('foreign_key') ?></th>
                  <th><?= $this->Paginator->sort('type') ?></th>
                  <th><?= $this->Paginator->sort('data') ?></th>
                  <th><?= $this->Paginator->sort('is_read') ?></th>
                  <th><?= $this->Paginator->sort('created') ?></th>
                  <th class="actions"><?= __('Actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($notifications as $notification): ?>
                <tr>
                    <td><?= $this->Number->format($notification->id) ?></td>
                    <td><?= h($notification->user_id) ?></td>
                    <td><?= h($notification->foreign_key) ?></td>
                    <td><?= h($notification->type) ?></td>
                    <td><?= h($notification->data) ?></td>
                    <td><?= h($notification->is_read) ?></td>
                    <td><?= h($notification->created) ?></td>
                    <td class="actions">
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $notification->id], ['class' => 'btn btn-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $notification->id)]) ?>
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