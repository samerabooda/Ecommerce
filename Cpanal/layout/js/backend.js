// JavaScript Document
$(function (){
	'use strict';


	$('#tags').tagsInput();


	$("select").selectBoxIt({
		autoWidth: false

	});
	
	var passfiled = $('.password');
	
	$('.show-pass').hover(function(){
		
		passfiled.attr('type','text');
	},function(){
		passfiled.attr('type','password');
		
	});	
	
});