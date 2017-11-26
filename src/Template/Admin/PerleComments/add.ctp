
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ajouter un commentaire
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      <?= $this->Form->create($perle_comment, ['role' => 'form']); ?>
        <!-- left column -->
        <!--/.col (left) -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">General</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="form-group">
                <label for="exampleInputPassword1">Contenu</label>
                <?= $this->Form->input('content', ['class' => 'form-control', 'label' => false]); ?>
                </div>
                <div class="form-group">
                <label for="exampleInputPassword1">User</label>
                <?= $this->Form->input('user_id', ['options' => $users, 'class' => 'form-control', 'label' => false]) ?>
                </div>
                <div class="form-group">
                <label for="exampleInputPassword1">Perle</label>
                <?= $this->Form->input('perle_id', ['options' => $perles, 'class' => 'form-control', 'label' => false]) ?>
                </div>
            </div>
            <div class="box-footer">
                <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary pull-right']) ?>
            </div>
            <?= $this->Form->end() ?>
          </div>
          <!-- /.box -->
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->