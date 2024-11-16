/* global jQuery */
( function ( $, wp, friends ) {
	const $document = $( document );
	let alreadySearching = '';
	let alreadyLoading = false;
	const bottomOffsetLoadNext = 2000;
	let searchResultFocused = false;

	wp = wp || { ajax: { send() {}, post() {} } };

	// Aplica classe em itens do formulário
	$('input[name=title]').addClass('form-input');
	$('textarea').addClass('form-input');
	$('button').addClass('btn btn-primary input-group-btn');
	$('details').removeAttr('open');

	// Substitui nome da logo
	$('.friends-brand a.friends-logo').html('<h2>Fedipress</h2>');

	// Customiza menu Subscriptions
	if ($("details summary h5 span").hasClass( "subscription-count" )) {
		var subscriptioncount = $(".subscription-count").prop('outerHTML');
		$(".subscription-count").parent().html('<span class="dashicons dashicons-admin-users"></span> Seguindo '+subscriptioncount);
	}
	// Customiza menu Friends
	if ($("details summary h5 span").hasClass( "friend-count" )) {
		var friendCount = $(".friend-count").prop("outerHTML");
		$(".friend-count").parent().html('<span class="dashicons dashicons-admin-users"></span> Amigos '+friendCount);
	}
	// Customiza menu Friends Request
	if ($("details summary h5 a").hasClass( "open-requests" )) {
		var openRequests = $(".open-requests .friend-count").prop("outerHTML");
		$(".open-requests").parent().html('<span class="dashicons dashicons-admin-users"></span> Solicitações '+openRequests);
	}
	$('.friends-widget').each(function(index, div) {
		$('form').prev().remove();
		$('br').remove();
		$('small').remove();
		$(div).find('button').each(function(index, button) {
			var itemText = $(button).text();
			if (itemText == 'Post to your friends') {
				$(button).html('Publicar');
				$(button).parent().css('text-align', 'right');
			}
		});
		// Customiza menu Recent Friends
		$(div).find('h5').each(function(index, h5) {
			var itemText = $(h5).text();
			if (itemText == 'Recent Friends') {
				$(h5).html('<span class="dashicons dashicons-admin-users"></span> Amigos recentes');
			}
			if(itemText == 'Filter'){
				$(h5).html('<span class="dashicons dashicons-filter"></span> Filtro');
			}
		});
		// Customiza menu Refresh
		$(div).find('a').each(function(index, a) {
			var itemText = $(a).text();
			if (itemText == 'Refresh') {
				var itemHtml = $(div).html();
				$(div).html('<h5><span class="dashicons dashicons-admin-comments"></span>'+itemHtml+'</h5>');
			}
		});
	});

	$('a.comments.btn').html('<span class="dashicons dashicons-admin-comments"></span>');
	$('a.new-reaction.btn').html('<i class="dashicons dashicons-plus"></i>');


} )( jQuery, window.wp, window.friends );
