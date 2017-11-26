 
<div id="head_banner">
    <div class="content">
        <img class="img-responsive" src="http://perle.io/img/front-end/head-banner.jpg" alt="slider">                       
        <div class="head-title text-center">
            <h2 class="animated bounceInDown">Connectez-vous à votre compte Perle</h2>
        </div>        
    </div>
</div>      

<div class="container page-content">

    <div class="row">
        <div class="col-md-12">
            <?= $this->Flash->render() ?>
        </div>
    </div>

    <div class="row">

         <div class="col-md-4">

            <img src="http://www.perle.io/img/perle-mascott.jpg" class="img-responsive pt-sm">

        </div>

        <div class="col-md-8">

            <h2 class="text-orange pt-sm">Connexion</h2>

            <p class="text-left text-grey pb-md pt-sm">Connectez-vous sur Perle et partager les perles de vos amis. Avez-vous aussi déjà eu l'envie de vous moquer de vos amis, de leurs bugs de languages ou leurs phrases délirantes ? <br /><br /><strong>Avec Perle vous pouvez les partager avec votre réseau !</strong></p>

            <section class="section animated bounceInRight form-perle">
                 <?= $this->Form->create() ?>
                <?= $this->Form->input('method', ['type' => 'hidden', 'value' => 'login']) ?>
                    <div class="form-group">
                            <?= $this->Form->input(
                                'email',
                                [
                                    'label' => false,
                                    'class' => 'form-field',
                                    'placeholder' => 'Adresse e-mail',
                                                    'error' => false
                                ]
                            ) ?>
                        <?= $this->Form->error('email') ?>
                    </div>
                    <div class="form-group">
                            <?= $this->Form->input(
                                'password',
                                [
                                    'label' => false,
                                    'class' => 'form-field',
                                    'placeholder' => 'Mot de passe',
                                                    'error' => false
                                ]
                            ) ?>
                        <?= $this->Form->error('password') ?>
                    </div>
                    <div class="col-md-6">
                        <a href="#" class="btn btn-orange-transparent mt-md">Je veux m'inscrire toi</a>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group pull-right">
                            <?= $this->Form->button(
                                __('Connexion'),
                                ['class' => 'btn btn-orange-transparent mt-md']
                            ); ?>
                        </div>
                    </div>
                <?= $this->Form->end(); ?>
            </section>
        </div>
    </div>
</div>