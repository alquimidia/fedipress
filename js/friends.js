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
	$('input[name=status]').val('publish');
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
		$('form.friends-post-inline').prev().remove();
		$('form.friends-post-inline br').remove();
		$('form.friends-post-inline small').remove();
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
		// Customiza formulário para adicionar amigos
		$('form.form-horizontal').addClass('input-group input-inline form-autocomplete');
		$('form.form-horizontal div.form-group:nth-of-type(2)').remove();
		$('form.form-horizontal div.form-group').html('<div class="has-icon-right"><input class="form-input" type="text" tabindex="2" name="friend_url" placeholder="@login@url" ><i class="form-icon"></i></div>');
		$('form.form-horizontal div.form-group').addClass('form-autocomplete-input form-input');
		$('form.form-horizontal div.form-group').after('<button class="btn btn-primary input-group-btn"><span class="dashicons dashicons-search"></span></button>');
		$('form.form-horizontal div.form-group').removeClass('form-group');
		$('form.form-horizontal').removeClass('form-horizontal');
	});

	$('a.comments.btn').html('<span class="dashicons dashicons-admin-comments"></span>');
	$('a.new-reaction.btn').html('<i class="dashicons dashicons-plus"></i>');

	// Insere item em menu da barra lateral para voltar para dshboard do WP
	$('.friends-widget:last-of-type').after('<div class="friends-widget"><h5><a href="/wp-admin"><i class="dashicons dashicons-wordpress"></i> Painel</a></h5></div>');


} )( jQuery, window.wp, window.friends );
