jQuery(function($) {'use strict',
	
	//Countdown js
	 $("#countdown").countdown({
			date: "10 january 2017 12:00:00",
			format: "on"
		},
		
		function() {
			// callback function
		});
	
	//Scroll Menu

	function menuToggle()
	{
		var windowWidth = $(window).width();

		if(windowWidth > 767 ){
			$(window).on('scroll', function(){
				if( $(window).scrollTop()>405 ){
					$('.main-nav').addClass('fixed-menu animated slideInDown');
				} else {
					$('.main-nav').removeClass('fixed-menu animated slideInDown');
				}
			});
		}else{
			
			$('.main-nav').addClass('fixed-menu animated slideInDown');
				
		}
	}

	menuToggle();
	
	
	// Carousel Auto Slide Off
	$('#event-carousel, #twitter-feed, #sponsor-carousel ').carousel({
		interval: false
	});

	$(".sendContactForm").bind("click", function () {
        
        // Contact form variables.
		var full_name = $('.contact-form').find('[name="full_name"]');
		var email = $('.contact-form').find('[name="email"]');
		var message = $('.contact-form').find('[name="message"]');

        $.ajax({
            type : "POST",
            url : $(this).attr("data-url"),
            data : {
                full_name : full_name.val(),
                email : email.val(),
                message : message.val()
            },
            dataType: "json",
            success : function (data) {

            	if (full_name.val() == '') { full_name.addClass('required_field'); } else { full_name.removeClass('required_field'); }
            	if (email.val() == '') { email.addClass('required_field'); } else { email.removeClass('required_field'); }
            	if (message.val() == '') { message.addClass('required_field'); } else { message.removeClass('required_field'); }

            	if (data.error == false) {
            		$('.notification-contact').show().html('<p class="success-contact-msg">Nous vous remercions pour votre message<br /> Nous vous contacterons dans les prochaines 24 heures.</p>')
            	} else {
            		$('.notification-contact').show().html('<p class="error-contact-msg">Tous les champs sont requis!</p>')
            	}
            },
            error : function (e) {
              console.log('error');
            }
        });
        return false;
	});

	$( window ).resize(function() {
		menuToggle();
	});

	$('.main-nav ul').onePageNav({
		currentClass: 'active',
	    changeHash: false,
	    scrollSpeed: 900,
	    scrollOffset: 0,
	    scrollThreshold: 0.3,
	    filter: ':not(.no-scroll)'
	});

});

// Facebook
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.8&appId=1571566813065807";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));