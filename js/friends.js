/* global jQuery */
( function ( $, wp, friends ) {
	const $document = $( document );
	let alreadySearching = '';
	let alreadyLoading = false;
	const bottomOffsetLoadNext = 2000;
	let searchResultFocused = false;

	wp = wp || { ajax: { send() {}, post() {} } };

	// Customiza layout dos ítens da barra lateral
	$('input[name=title]').addClass('form-input');
	$('textarea').addClass('form-input');
	$('button').addClass('btn btn-primary input-group-btn');
	$('details').removeAttr('open');
	// Customiza menu Subscriptions
	if ($("details summary h5 span").hasClass( "subscription-count" )) {
		var subscriptioncount = $(".subscription-count").prop('outerHTML');
		$(".subscription-count").parent().html('<span class="dashicons dashicons-admin-users"></span> Seguidores '+subscriptioncount);
	}
	// Customiza menu de Friends Request
	if ($("details summary h5 a").hasClass( "open-requests" )) {
		var openRequests = $(".open-requests .friend-count").text();
		$(".open-requests").parent().html('<span class="dashicons dashicons-admin-users"></span> Solicitações <span class="subscription-count">'+openRequests+'</span>');
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

	$('.friends-widget:nth-of-type(4)').after('<div class="friends-widget"><h5><a href="/friends/reaction2b50"><span class="dashicons dashicons-star-filled"></span> Favoritos</a></h5></div>');


	$('a.comments.btn').html('<span class="dashicons dashicons-admin-comments"></span>');
	$('a.new-reaction.btn').html('<i class="dashicons dashicons-plus"></i>');
	// $('article footer a').removeClass('btn');

} )( jQuery, window.wp, window.friends );
