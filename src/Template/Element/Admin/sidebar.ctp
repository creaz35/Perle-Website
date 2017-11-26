  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Brian Millot</p>
        </div>
      </div>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">Menu</li>
        <li>
          <a href="<?= $this->Url->build(['controller' => 'admin', 'action' => 'index', 'prefix' => 'admin']) ?>">
            <i class="fa fa-dashboard"></i> <span>Tableau de bord</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i> <span>Utilisateurs</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?= $this->Url->build(['controller' => 'users', 'action' => 'index', 'prefix' => 'admin']) ?>"><i class="fa fa-circle-o"></i> Utilisateurs</a></li>
            <li><a href="<?= $this->Url->build(['controller' => 'groups', 'action' => 'index', 'prefix' => 'admin']) ?>"><i class="fa fa-circle-o"></i> Groupes</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Perles</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?= $this->Url->build(['controller' => 'perles', 'action' => 'index', 'prefix' => 'admin']) ?>"><i class="fa fa-circle-o"></i> Perles</a></li>
            <li><a href="<?= $this->Url->build(['controller' => 'perle_comments', 'action' => 'index', 'prefix' => 'admin']) ?>"><i class="fa fa-circle-o"></i> Commentaires</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Data</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?= $this->Url->build(['controller' => 'notifications', 'action' => 'index', 'prefix' => 'admin']) ?>"><i class="fa fa-circle-o"></i> Notifications</a></li>
          </ul>
        </li>
        <li><a <a href="<?= $this->Url->build(['controller' => 'pages', 'action' => 'index', 'prefix' => 'admin']) ?>"><i class="fa fa-book"></i> <span>Pages</span></a></li>
        <li><a href="<?= $this->Url->build(['controller' => 'settings', 'action' => 'index', 'prefix' => 'admin']) ?>"><i class="fa fa-book"></i> <span>Paramètres</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>