  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="padding-bottom: 30px;">
      <h1 class="pull-left">
        Management
        <small>Commentaires de perle</small>
      </h1>
      <div class="pull-right">
        <?= $this->Html->link(__('Nouveau commentaire'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
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
                  <th><?= $this->Paginator->sort('perle') ?></th>
                  <th><?= $this->Paginator->sort('user') ?></th>
                  <th><?= $this->Paginator->sort('content') ?></th>
                  <th><?= $this->Paginator->sort('created') ?></th>
                  <th><?= $this->Paginator->sort('modified') ?></th>
                  <th class="actions"><?= __('Actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($perle_comments as $comment): ?>
                <tr>
                    <td><?= $this->Number->format($comment->id) ?></td>
                    <td><?= h($comment->perle_id) ?></td>
                    <td><?= h($comment['user']['full_name']) ?></td>
                    <td><?=
                            $this->Text->truncate(
                                $comment->content,
                                10,
                                [
                                    'ellipsis' => '...',
                                    'exact' => false
                                ]
                            ) ?>
                    </td>
                    <td><?= h($comment->created) ?></td>
                    <td><?= h($comment->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $comment->id], ['class' => 'btn btn-info']) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $comment->id], ['class' => 'btn btn-primary']) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $comment->id], ['class' => 'btn btn-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $comment->id)]) ?>
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