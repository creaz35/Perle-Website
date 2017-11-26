
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
      <?= $this->Form->create($user, ['role' => 'form']); ?>
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Connexion</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="form-group">
                <label for="exampleInputPassword1">Prénom</label>
                <?= $this->Form->input('first_name', ['class' => 'form-control', 'label' => false]); ?>
                </div>
                <div class="form-group">
                <label for="exampleInputPassword1">Nom de famille</label>
                <?= $this->Form->input('last_name', ['class' => 'form-control', 'label' => false]); ?>
                </div>
                <div class="form-group">
                <label for="exampleInputPassword1">Adresse e-mail</label>
                <?= $this->Form->input('email', ['class' => 'form-control', 'label' => false]); ?>
                </div>
                <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <?= $this->Form->input('password', ['class' => 'form-control', 'label' => false]); ?>
                </div>
                <div class="form-group">
                <?php $choices = ['0' => 'Non', '1' => 'Oui']; ?>
                <label for="exampleInputPassword1">Activer</label>
                <?php
                    echo $this->Form->select('active', $choices, ['default' => 1, 'class' => 'form-control']);
                  ?>
                </div>
            </div>
          </div>
          <!-- /.box -->
        </div>
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
                <label for="exampleInputPassword1">Localisation</label>
                <?= $this->Form->input('location', ['class' => 'form-control', 'label' => false]); ?>
                </div>
                <div class="form-group">
                <label for="exampleInputPassword1">Perle (Couleur)</label>
                <?= $this->Form->input('perle_color', ['class' => 'form-control', 'label' => false]); ?>
                </div>
                <div class="form-group">
                <label for="exampleInputPassword1">Biography</label>
                <?= $this->Form->input('biography', ['class' => 'form-control', 'label' => false]); ?>
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