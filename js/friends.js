/* global jQuery */
( function ( $, wp, friends ) {
	const $document = $( document );
	let alreadySearching = '';
	let alreadyLoading = false;
	const bottomOffsetLoadNext = 2000;
	let searchResultFocused = false;

	wp = wp || { ajax: { send() {}, post() {} } };

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

	$('a.comments.btn').html('<span class="dashicons dashicons-admin-comments"></span>');
	$('a.new-reaction.btn').html('<i class="dashicons dashicons-plus"></i>');

} )( jQuery, window.wp, window.friends );
