 
<div id="head_banner">
    <div class="content">
        <img class="img-responsive" src="http://perle.io/img/front-end/head-banner.jpg" alt="slider">                       
        <div class="head-title text-center">
            <h2 class="animated bounceInDown">Créer votre compte Perle</h2>
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

            <h2 class="text-orange pt-sm">Inscription gratuite !</h2>

            <p class="text-left text-grey pb-md pt-sm">Inscrivez-vous sur Perle et partager les perles de vos amis. Avez-vous aussi déjà eu l'envie de vous moquer de vos amis, de leurs bugs de languages ou leurs phrases délirantes ? <br /><br /><strong>Avec Perle vous pouvez les partager avec votre réseau !</strong></p>

            <section class="section animated bounceInRight form-perle">
                <?= $this->Form->create($userRegister) ?>
                <?= $this->Form->input('method', ['type' => 'hidden', 'value' => 'register']) ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                    <?= $this->Form->input(
                                        'first_name',
                                        [
                                            'label' => false,
                                            'class' => 'form-field',
                                            'placeholder' => 'Prénom',
                                                            'error' => false
                                        ]
                                    ) ?>
                                <?= $this->Form->error('first_name') ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                    <?= $this->Form->input(
                                        'last_name',
                                        [
                                            'label' => false,
                                            'class' => 'form-field',
                                            'placeholder' => 'Nom de famille',
                                                            'error' => false
                                        ]
                                    ) ?>
                                <?= $this->Form->error('last_name') ?>
                            </div>
                        </div>
                    </div>
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
                    <div class="row">
                        <div class="col-md-6">
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
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                    <?= $this->Form->input(
                                        'password_confirm',
                                        [
                                            'label' => false,
                                            'class' => 'form-field',
                                            'placeholder' => 'Mot de passe (Confirmation)',
                                            'error' => false,
                                            'type' => 'password'
                                        ]
                                    ) ?>
                                <?= $this->Form->error('password_confirm') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <a href="#" class="btn btn-orange-transparent mt-md">J'ai déjà un compte toi</a>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group pull-right">
                            <?= $this->Form->button(
                                __('Inscription'),
                                ['class' => 'btn btn-orange-transparent mt-md']
                            ); ?>
                        </div>
                    </div>
                <?= $this->Form->end(); ?>
            </section>
        </div>
    </div>
</div>