
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ajouter une page
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">General</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?= $this->Form->create($page, ['role' => 'form']); ?>
            <div class="box-body">
                <div class="form-group">
                <label for="exampleInputPassword1">Titre</label>
                <?= $this->Form->input('name', ['class' => 'form-control', 'label' => false]); ?>
                </div>
                <div class="form-group">
                <label for="exampleInputPassword1">Contenu</label>
                <?= $this->Form->input('content', ['class' => 'form-control', 'label' => false, 'id' => 'ckeditor']); ?>
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