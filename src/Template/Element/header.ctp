	<header id="header" role="banner">		
		<div class="main-nav">
			<div class="container">
				<div class="header-top">
					<div class="pull-right social-icons">
						<a href="https://www.facebook.com/Perle-260804667602029/" target="_blank"><i class="fa fa-facebook"></i></a>
						<a href="https://www.instagram.com/perle.0_0/" target="_blank"><i class="fa fa-instagram"></i></a>
					</div>
					<div class="pull-right social-icons">
						<?php if ($this->request->session()->read('Auth.User')): ?>
		                    <p class="navbar-text" style="margin-top: 0px;">
		                        Bonjour <?= $this->request->session()->read('Auth.User.first_name') . ' ' . $this->request->session()->read('Auth.User.last_name') ?>
		                    </p>
	                	<?php else:?>
	                 	<?php // User connexion ?>
						<?php endif;?>
					</div>
				</div>     
		        <div class="row">	        		
		            <div class="navbar-header">
		                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		                    <span class="sr-only">Toggle navigation</span>
		                    <span class="icon-bar"></span>
		                    <span class="icon-bar"></span>
		                    <span class="icon-bar"></span>
		                </button>
		                <a href="<?= $this->Url->build('/') ?>" class="navbar-brand">
		                	<?= $this->Html->image('front-end/logo.png', ['class' => 'img-responsive', 'alt' => 'Perle']) ?>
		                </a>                    
		            </div>
		            <div class="collapse navbar-collapse">
		                <ul class="nav navbar-nav navbar-right">                 
		                    <li class="scroll active"><a href="#home">Accueil</a></li>
		                    <li class="scroll"><a href="#about">A propos</a></li> 
		                    <li class="scroll"><a href="#explore">Lancement</a></li>
		                    <li class="scroll"><a href="#contact">Contact</a></li>       
		                </ul>
		            </div>
		        </div>
	        </div>
        </div>                    
    </header>
    <!--/#header--> 