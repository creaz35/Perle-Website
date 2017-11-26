
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ajouter une perle
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">General</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?= $this->Form->create($perle, ['role' => 'form']); ?>
            <div class="box-body">
                <div class="form-group">
                <label for="exampleInputPassword1">Adresse e-mail</label>
                <?= $this->Form->input('email', ['class' => 'form-control', 'label' => false]); ?>
                </div>
                <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <?= $this->Form->input('password', ['class' => 'form-control', 'label' => false]); ?>
                </div>
                <div class="form-group">
                <label for="exampleInputPassword1">Activer</label>
                <?= $this->Form->input('active', ['class' => 'form-control', 'label' => false]); ?>
                </div>
            </div>
            <div class="box-footer">
                <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?= $this->Form->end() ?>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->