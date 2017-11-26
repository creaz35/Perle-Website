    <section id="home"> 
        <div id="main-slider" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="item active">
                    <img class="img-responsive" src="http://www.perle.io/img/front-end/slider/bg1.jpg" alt="slider">                       
                    <div class="carousel-caption">
                        <h2>" J'ai qu'une main donc je suis autodidacte "</h2>
                    </div>
                </div>          
            </div>
        </div>      
    </section>
    <!--/#home-->

    <section id="about">
      <div class="col-md-12">
        <div class="col-md-6">               
            <img class="img-responsive" src="http://www.perle.io/img/front-end/perles_mockup.png" alt="A propos de perles">
        </div>
        <div class="col-md-6 about-content">                 
            <h2>Qu'est ce qu'une perle ?</h2>
            <p>C'est le moment juste avant l'éclat de rire, le moment où tu te retournes pour savoir qui a dit une chose pareil, le moment qui normalement s'envole et ne revient pas. Une perle c'est comme une photo, mais où la photo immortalise le moment, la perle immortalise l'éclat de rire.</p>  
        </div>
      </div>
    </section><!--/#about-->

    <section id="explore">
        <div class="container">
            <div class="row">
                <div class="watch">
                    <img class="img-responsive" src="http://www.perle.io/img/front-end/watch.png" alt="Perle mobile application">
                </div>              
                <div class="col-md-4 col-md-offset-2 col-sm-5">
                    <h2>App disponible dans</h2>
                </div>              
                <div class="col-sm-7 col-md-6">                 
                    <ul id="countdown">
                        <li>                    
                            <span class="days time-font">00</span>
                            <p>jours </p>
                        </li>
                        <li>
                            <span class="hours time-font">00</span>
                            <p class="">heures </p>
                        </li>
                        <li>
                            <span class="minutes time-font">00</span>
                            <p class="">minutes</p>
                        </li>
                        <li>
                            <span class="seconds time-font">00</span>
                            <p class="">secondes</p>
                        </li>               
                    </ul>
                </div>
            </div>
        </div>
    </section><!--/#explore-->

    <section id="donation">
      <div class="col-md-12">
        <div class="col-md-6 donation-content">                 
            <h2>A propos de Perle</h2>
            <p>C'est le moment juste avant l'éclat de rire, le moment où tu te retournes pour savoir qui a dit une chose pareil, le moment qui normalement s'envole et ne revient pas. Une perle c'est comme une photo, mais où la photo immortalise le moment, la perle immortalise l'éclat de rire.</p>  
        </div>
        <div class="col-md-6">               
            <img class="img-responsive" src="http://www.perle.io/img/front-end/perles_mockup.png" alt="A propos de perles">
        </div>
      </div>
    </section><!--/#donation-->
    
    <section id="contact">
        <div class="contact-section">
            <div class="ear-piece">
                <img class="img-responsive" src="http://www.perle.io/img/front-end/ear-piece.png" alt="">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 col-sm-offset-4">
                        <div class="fb-page" data-href="https://www.facebook.com/perle.00/" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/perle.00/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/perle.00/">Perle</a></blockquote></div>
                    </div>
                    <div class="col-sm-5">
                        <div id="contact-section">
                            <h3>Envoyez-nous un message</h3>
                            <div class="contact-desc">
                                <h3>Contact</h3>
                                <p>Merci de bien vouloir remplir le formulaire de contact pour que nous puissions vous contacter et répondre à toutes vos questions !</p>
                            </div>
                            <div class="notification-contact" style="display: none"></div>
                            <form id="main-contact-form" class="contact-form" name="contact-form" method="post">
                                <div class="form-group">
                                    <input type="text" name="full_name" class="form-control" placeholder="Nom Complet *">
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Adresse e-mail *">
                                </div>
                                <div class="form-group">
                                    <textarea name="message" id="message" class="form-control" rows="4" placeholder="Votre message... *"></textarea>
                                </div>                        
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary pull-right sendContactForm" data-url="<?= $this->Url->build('/sendEmail') ?>">Envoyer</button>
                                </div>
                            </form>        
                        </div>
                    </div>
                </div>
            </div>
        </div>      
    </section>
    <!--/#contact-->