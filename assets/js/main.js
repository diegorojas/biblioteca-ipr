jQuery(document).ready(function($) {

//	//cria uma senha padrão falsa (a pedido do cliente)
//	$('.ginput_container_password input, #user_pass, #loginform #user_pass').attr('autocomplete','off').val('sem_senha').hide();
//	$('.ginput_container_password input, .page-id-4210 #user_pass').attr('autocomplete','off').val('sem_senha').hide();
//	$('.login-password, .login-remember').hide();
	
//	$('#user_login').keypress(function() {
//		$('.ginput_container_password input, #user_pass').val('sem_senha');
//		$('.ginput_container_password input, .page-id-4210 #user_pass').val('sem_senha');
//		console.log($('#user_pass').val());

//	});
	
//	console.log( $('.page-id-4210 #user_pass').val() );
	
var dt = new Date();
var month = new Array();
month[0] = "01";
month[1] = "02";
month[2] = "03";
month[3] = "04";
month[4] = "05";
month[5] = "06";
month[6] = "07";
month[7] = "08";
month[8] = "09";
month[9] = "10";
month[10] = "11";
month[11] = "12";
var day = new Array();
day[1] = "01";
day[2] = "02";
day[3] = "03";
day[4] = "04";
day[5] = "05";
day[6] = "06";
day[7] = "07";
day[8] = "08";
day[9] = "09";

var mes = month[dt.getMonth()];

if(dt.getDate() < 10){
	var dia = day[dt.getDate()];
}else{
	var dia = dt.getDate();
}

var data_cheia = dt.getFullYear() +"-"+ mes +"-"+ dia +" "+ dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();

	$('#input_2_22').val(data_cheia);
	//console.log($('#input_2_22').val());

	
	$('.hide').show();
	$('.campo-primeiro-nome input').keypress(function() {
		//id unico
		var dt = new Date();
		var time = dt.getHours() + "" + dt.getMinutes() + "" + dt.getSeconds();
		var login = $(this).val().replace('@','').replace('_','').replace('-','').replace(' ','').replace('.','');

		$('.campo-login input').val(login+time);
	});
	
	$('.gfield_select').selectpicker();
	
	$(document).bind('gform_post_render', function(){
		$('.gfield_select').selectpicker();
	});	

	var escola_selected = $('.campo-profissao .gfield_select').find("option:selected").val();
	if(escola_selected == 'Rolfer' || escola_selected == 'Rolfer Student' || escola_selected == 'Rolfing' || escola_selected == 'Rolfing Student' || escola_selected == 'Structural integrator'){
			$('.campo-escola').slideDown();		
	}
		
	/*
		
	$('.campo-profissao .gfield_select').on('change', function(){
		var selected = $(this).find("option:selected").val();
		if(selected == 'Rolfer' || selected == 'Rolfer Student' || selected == 'Rolfing' || selected == 'Rolfing Student' || selected == 'Structural integrator'){
			//$('.campo-escola').slideDown();
		}else{
			//$('.campo-escola').slideUp();			
		}
	});	
	
	*/

	// Tooltip.
	$( '.odin-tooltip' ).tooltip();

	$(".login-username input, .login-password input").focus(function() {
		$(this).prev("label").hide();
	});
	    
	  
	 $('.login-username input, .login-password input').blur(function(){
		if( !$(this).val() ) {
			$(this).prev("label").show();
		}
	});
	
	 
 		
	$('.selectpicker').on('changed.bs.select', function (e) {
		var selected = $(e.currentTarget).val();
		window.location.href = selected;
	});	

	$('.language-dropdown button span.lang-flag').addClass($('.qtranxs_language_chooser li.active a').attr('class'));
//	$('.language-dropdown').text($('.qtranxs_language_chooser li.active').text());
	$('.qtranxs_language_chooser li').appendTo('.language-chooser.dropdown-menu');


	$('.total-artigos').each(function(){
		$(this).load( "/pb/author/?id="+$( this ).data('id'))
	})
	
if (document.cookie.indexOf('visited=true') == -1) {
        var fifteenDays = 1000*60*60*24*15;
        var expires = new Date((new Date()).valueOf() + fifteenDays);
        document.cookie = "visited=true;expires=" + expires.toUTCString();
		$('#myModal').modal('show');
}
	
	$(document).bind('gform_confirmation_loaded', function(event, formId){

	    var conteudo = $('#gform_confirmation_message_'+ formId +' #ajax-send');
	
		$.ajax({
			method: "POST",
			url: "http://pedroprado.com.br/enviar_email.php",
			data: { 
				mensagem: conteudo.html(), 
				destino: conteudo.data('destino'),
				assunto: conteudo.data('assunto'),
				remetente: conteudo.data('remetente'),
				responder_para: conteudo.data('responder_para'),
			}
		});
	
		$('#gform_confirmation_message_'+ formId +' #ajax-send').remove();
	});
	
	// limpa o texto do artigo que aparece [:en]
	 
	$('.single-content:contains("[:en]")').each(function(){
	    $(this).html($(this).html().split("[:en]").join(""));
	});

	$('.single-content:contains("[:de]")').each(function(){
	    $(this).html($(this).html().split("[:de]").join(""));
	});

	$('.single-content:contains("[:fr]")').each(function(){
	    $(this).html($(this).html().split("[:fr]").join(""));
	});

	$('.single-content:contains("[:es]")').each(function(){
	    $(this).html($(this).html().split("[:es]").join(""));
	});

	$('.single-content:contains("[:ja]")').each(function(){
	    $(this).html($(this).html().split("[:ja]").join(""));
	});

	$('.single-content:contains("[:it]")').each(function(){
	    $(this).html($(this).html().split("[:it]").join(""));
	});

	$('.single-content:contains("[:pb]")').each(function(){
	    $(this).html($(this).html().split("[:pb]").join(""));
	});

	$('.single-content:contains("[:]")').each(function(){
	    $(this).html($(this).html().split("[:]").join(""));
	});

		
});
