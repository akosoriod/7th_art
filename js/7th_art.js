 jQuery(document).ready(function($) {
	// My Account
	$('#myAccount').css({'right':-261})
                //.css({'right':parseInt($('#myAccount').width())*-1})
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
		  $s.css({'right':-261})
		}
	});
});
var pathname = window.location.pathname;
window.rootPath=pathname.substring(0,pathname.indexOf("index.php"));


/** Function count the occurrences of substring in a string;
 * @param {String} string   Required. The string;
 * @param {String} subString    Required. The string to search for;
 * @param {Boolean} allowOverlapping    Optional. Default: false;
 */
window.occurrences=function(string, subString, allowOverlapping){
    string+=""; subString+="";
    if(subString.length<=0) return string.length+1;

    var n=0, pos=0;
    var step=(allowOverlapping)?(1):(subString.length);

    while(true){
        pos=string.indexOf(subString,pos);
        if(pos>=0){ n++; pos+=step; } else break;
    }
    return(n);
};