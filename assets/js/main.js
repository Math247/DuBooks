(function($){
    $.fn.scrollingTo = function( opts ) {
        var defaults = {
            animationTime : 1000,
            easing : '',
            callbackBeforeTransition : function(){},
            callbackAfterTransition : function(){}
        };

        var config = $.extend( {}, defaults, opts );

        $(this).click(function(e){
            var eventVal = e;
            e.preventDefault();

            var $section = $(document).find( $(this).data('section') );
            if ( $section.length < 1 ) {
                return false;
            };

            if ( $('html, body').is(':animated') ) {
                $('html, body').stop( true, true );
            };

            var scrollPos = $section.offset().top;

            if ( $(window).scrollTop() == scrollPos ) {
                return false;
            };

            config.callbackBeforeTransition(eventVal, $section);

            $('html, body').animate({
                'scrollTop' : (scrollPos+'px' )
            }, config.animationTime, config.easing, function(){
                config.callbackAfterTransition(eventVal, $section);
            });
        });
    };

    /* ========================================================================= */
    /*   Contact Form Validating
    /* ========================================================================= */

    $('#contact-form').validate({
        rules: {
            name: {
                required: true, minlength: 4
            }
            , email: {
                required: true, email: true
            }
            , subject: {
                required: false,
            }
            , message: {
                required: true,
            }
            ,
        }
        , messages: {
            user_name: {
                required: "Come on, you have a name don't you?", minlength: "Your name must consist of at least 2 characters"
            }
            , email: {
                required: "Please put your email address",
            }
            , message: {
                required: "Put some messages here?", minlength: "Your name must consist of at least 2 characters"
            }
            ,
        }
        , submitHandler: function(form) {
            $(form).ajaxSubmit( {
                type:"POST", data: $(form).serialize(), url:"sendmail.php", success: function() {
                    $('#contact-form #success').fadeIn();
                }
                , error: function() {
                    $('#contact-form #error').fadeIn();
                }
            }
            );
        }
    });


}(jQuery));



jQuery(document).ready(function(){
	"use strict";
	new WOW().init();


(function(){
 jQuery('.smooth-scroll').scrollingTo();
}());

});




$(document).ready(function(){

    $(window).scroll(function () {
        if ($(window).scrollTop() > 50) {
            $(".navbar-brand a").css("color","#fff");
            $("#top-bar").removeClass("animated-header");
        } else {
            $(".navbar-brand a").css("color","inherit");
            $("#top-bar").addClass("animated-header");
        }
    });

    $("#clients-logo").owlCarousel({
 
        itemsCustom : false,
        pagination : false,
        items : 5,
        autoplay: true,

    });


});



// fancybox
$(".fancybox").fancybox({
    padding: 0,

    openEffect : 'elastic',
    openSpeed  : 450,

    closeEffect : 'elastic',
    closeSpeed  : 350,

    closeClick : true,
    helpers : {
        title : { 
            type: 'inside' 
        },
        overlay : {
            css : {
                'background' : 'rgba(0,0,0,0.8)'
            }
        }
    }
});

function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mtel(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que n??o ?? d??gito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca par??nteses em volta dos dois primeiros d??gitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca h??fen entre o quarto e o quinto d??gitos
    return v;
}

function ValidaEmail(pEmail){
	var posicaoArroba=pEmail.indexOf("@");

	//if (posicaoArroba == -1 ) { return false; }
	// a @ n??o pode estar no ??ndice 0 (zero) e 
	// n??o pode ser -1 (n??o encontrado)
	if (posicaoArroba < 1 ) { return false; }
	// a @ n??o pode estar no ??ltimo ??ndice
	if (posicaoArroba == pEmail.length-1) { return false; }

	//?? necess??rio ter um ponto (.) depois da @
	//depois da @ vem o dom??nio e pelo menos um ponto ??
	// obrigat??rio
	// professor@p.net
	if (pEmail.indexOf(".",posicaoArroba+2)==-1) { return false; }

	//outros testes: n??o pode ter @.
	if (pEmail.indexOf("@.")>=0) { return false; }
	if (pEmail.indexOf("#")>=0) { return false; }
	if (pEmail.indexOf("%")>=0) { return false; }
	if (pEmail.indexOf("{")>=0) { return false; }
	if (pEmail.indexOf("*")>=0) { return false; }
	if (pEmail.indexOf("!")>=0) { return false; }

	return true;
}

var _DataIniObrigatorio="Data In??cio ?? campo obrigat??rio.<br />";
var _DataFimObrigatorio="Data Fim ?? campo obrigat??rio.<br />";
var _NomeObrigatorio="Nome ?? campo obrigat??rio.<br />";
var _EmailObrigatorio="E-mail ?? campo obrigat??rio.<br />";
var _EmailInvalido="E-mail ?? inv??lido.<br />";
var _MensagemObrigatorio="Mensagem ?? campo obrigat??rio.<br />";
var _TelefoneObrigatorio="Telefone ?? campo obrigat??rio. <br />";
var _ComoChegou="Como chegou a n??s ?? campo obrigat??rio.<br />";

function ValidaFormulario(){
	var msg = "";
	
	if(document.getElementById("ComoChegou").value=="")
	{ 
		msg+=_ComoChegou;
	}
	
	if(document.getElementById("datepicker").value=="")
	{ 
		msg+=_DataIniObrigatorio;
	}
	
	if(document.getElementById("datepicker2").value=="")
	{ 
		msg+=_DataFimObrigatorio;
	}
	
	
	if(document.getElementById("nome").value=="")
	{ 
		msg+=_NomeObrigatorio;
	}
	
//	if(document.getElementById("mensagem").value=="")
//	{ 
//		msg+=_MensagemObrigatorio;
//	}
	
	if(document.getElementById("telOne").value=="")
	{ 
		msg+=_TelefoneObrigatorio;
	}
	
	var email = document.getElementById("email").value;
	if(email=="")
	{ 
		msg+=_EmailObrigatorio;
	}
	else if (!ValidaEmail(email)){
		msg+=_EmailInvalido;
	}
	
	document.getElementById("divDadosIncorretos").innerHTML=msg;

	if (msg==""){
		return true;
	}
	else {
		alert('H?? erros. Favor Corrijir e re-enviar. Obrigado!');
		return false;
	}
}

//+++++++++++++++++++++++++++++++++

function ValidaFormularioPJ(){
	var msg = "";
	
	if(document.getElementById("ComoChegou").value=="")
	{ 
		msg+=_ComoChegou;
	}
	
	if(document.getElementById("datepicker").value=="")
	{ 
		msg+=_DataIniObrigatorio;
	}
	
	if(document.getElementById("nome").value=="")
	{ 
		msg+=_NomeObrigatorio;
	}
	
	if(document.getElementById("telOne").value=="")
	{ 
		msg+=_TelefoneObrigatorio;
	}
	
	var email = document.getElementById("email").value;
	if(email=="")
	{ 
		msg+=_EmailObrigatorio;
	}
	else if (!ValidaEmail(email)){
		msg+=_EmailInvalido;
	}
	
	document.getElementById("divDadosIncorretos").innerHTML=msg;

	if (msg==""){
		return true;
	}
	else {
		alert('H?? erros. Favor Corrijir e re-enviar. Obrigado!');
		return false;
	}
}

//+++++++++++++++++++++++++++++++++

function ValidaFormularioFC(){
	var msg = "";
	
	if(document.getElementById("ComoChegou").value=="")
	{ 
		msg+=_ComoChegou;
	}
	
	if(document.getElementById("nome").value=="")
	{ 
		msg+=_NomeObrigatorio;
	}
	
	if(document.getElementById("mensagem").value=="")
	{ 
		msg+=_MensagemObrigatorio;
	}
	
	if(document.getElementById("telOne").value=="")
	{ 
		msg+=_TelefoneObrigatorio;
	}
	
	var email = document.getElementById("email").value;
	if(email=="")
	{ 
		msg+=_EmailObrigatorio;
	}
	else if (!ValidaEmail(email)){
		msg+=_EmailInvalido;
	}
	
	document.getElementById("divDadosIncorretos").innerHTML=msg;

	if (msg==""){
		return true;
	}
	else {
		alert('H?? erros. Favor Corrijir e re-enviar. Obrigado!');
		return false;
	}
}