// JavaScript Document
$(function (){
	'use strict';

	$('#tags').tagsInput();
	

	$('.login-page h1 span').click(function () {
		$(this).addClass('selected').siblings().removeClass('selected');

		$('.login-page form').hide();

		$('.' + $(this).data('class')).fadeIn(100);
	});






	$("select").selectBoxIt({
		autoWidth: false

	});



	
	var passfiled = $('.password');
	
	$('.show-pass').hover(function(){
		
		passfiled.attr('type','text');
	},function(){
		passfiled.attr('type','password');
		
	});	


	$('.live-name').keyup(function(){
		$('.live-preview .caption h3').text($(this).val());
	});
	$('.live-desc').keyup(function(){
		$('.live-preview .caption p').text($(this).val());
	});
	$('.live-price').keyup(function(){
		$('.live-preview .price-tag').text( '$' + $(this).val());
	});

	
});