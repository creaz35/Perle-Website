  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="padding-bottom: 30px;">
      <h1 class="pull-left">
        Management
        <small>Pages</small>
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
                  <th><?= $this->Paginator->sort('name') ?></th>
                  <th><?= $this->Paginator->sort('created') ?></th>
                  <th><?= $this->Paginator->sort('modified') ?></th>
                  <th class="actions"><?= __('Actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($pages as $page): ?>
                <tr>
                    <td>#<?= $this->Number->format($page->id) ?></td>
                    <td><?= h($page->name) ?></td>
                    <td><?= h($page->created) ?></td>
                    <td><?= h($page->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $page->id], ['class' => 'btn btn-info']) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $page->id], ['class' => 'btn btn-primary']) ?>
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