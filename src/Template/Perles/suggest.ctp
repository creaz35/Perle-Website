
<?= $this->element('meta', [
    'title' => 'Suggestion'
]) ?>

<?php $this->start('scriptBottom');
    echo $this->Html->script([
        'front-end/ckeditor/ckeditor'
    ])
?>
<script type="text/javascript">
    CKEDITOR.replace('suggestBox', {
        customConfig: 'config/suggest.js'
    });
</script>

<?php $this->end() ?>

<div id="head_banner">
    <div class="content">
        <img class="img-responsive" src="http://perle.io/img/front-end/head-banner.jpg" alt="slider">                       
        <div class="head-title text-center">
            <h2 class="animated bounceInDown">Proposer votre perle</h2>
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

        <div class="col-md-6 col-md-offset-3">

            <p class="text-center text-grey pb-md">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla sagittis dolor turpis, vel ornare sem rhoncus sed. Aliquam at semper sapien. Quisque posuere tellus in sagittis lacinia. Ut pretium quis lacus vitae cursus.</p>

            <section class="section animated bounceInRight form-perle">
                <?= $this->Form->create() ?>
                    <div class="form-group">
                            <?= $this->Form->textarea(
                                'content',
                                [
                                    'label' => false,
                                    'class' => 'form-field suggestBox',
                                    'placeholder' => 'Votre perle...',
                                    'error' => true,
                                    'height' => '450px'
                                ]
                            ) ?>
                        <?= $this->Form->error('email') ?>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->button(
                            __('Connexion'),
                            ['class' => 'btn btn-orange-transparent']
                        ); ?>
                    </div>
                <?= $this->Form->end(); ?>
            </section>
        </div>
    </div>
</div>