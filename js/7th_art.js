 jQuery(document).ready(function($) {
	// My Account
	$('#myAccount').css({'right':parseInt($('#myAccount').width())*-1})
	$('.tabMyAccount','#myAccount').click(function() {
		$(this).toggleClass('active');
		$b=$('body');
		$s=$('#myAccount');
		$s.height($(window).height()).toggleClass('active');
		$('ul',$s).height($(window).height());
		$('.row-offcanvas').toggleClass('active');
		if($b.hasClass('active')){
		  $b.css({'right':$('#myAccount').width(),'overflow':'hidden'})
		  $s.css({'right':0})
		}else{
		  $b.css({'right':0,'overflow':''})
		  $s.css({'right':parseInt($('#myAccount').width())*-1})
		}
	});
});