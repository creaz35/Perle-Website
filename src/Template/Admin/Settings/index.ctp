
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ajouter un utilisateur
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
            <?= $this->Form->create($settings, ['role' => 'form']); ?>
            <div class="box-body">
                <div class="form-group">
                <label for="exampleInputPassword1">Nom</label>
                <?= $this->Form->input('name', ['class' => 'form-control', 'label' => false]); ?>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Maintenance</label>
                  <?php
                    echo $this->Form->select('maintenance', $choices, ['default' => $settings->maintenance, 'class' => 'form-control']);
                  ?>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Message Apple Store (Update)</label>
                  <?php
                    echo $this->Form->select('apple_store', $choices, ['default' => $settings->apple_store, 'class' => 'form-control']);
                  ?>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Activer Pub</label>
                  <?php
                    echo $this->Form->select('pub', $choices, ['default' => $settings->pub, 'class' => 'form-control']);
                  ?>
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