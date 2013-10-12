var Sirest = Class.extend({
	options: {'jsonp': false},

	constructor: function(o) {
		Sirest.super.constructor.call(this);
		$.extend(this.options, o);;
	},
	
	authenticate: function(user, pass, opts) {
		this.makeRequest('authenticate', {User: {username:user,password:pass}}, opts);
		// var cb = typeof opts.callback == 'function' ? opts.callback : function() {};
		// $.post('/actions/authenticate', {User: {username:user,password:pass}}, function(dat, status, xhr) {
		// 	console.log(dat);
		// 	cb(dat);
		// }, 'json');
	},

	store: function(key, data, opts) {
		this.makeRequest('store', {Store: {key:key,data:data}}, opts);
		// var cb = typeof opts.callback == 'function' ? opts.callback : function() {};
		// $.post('/actions/store', {Store: {key:key,data:data}}, function(dat, status, xhr) {
		// 	console.log(dat);
		// 	cb(dat);
		// }, 'json');
	},

	retrieve: function(key, opts) {
		this.makeRequest('retrieve', {Store: {key:key}}, opts);
		//var cb = typeof opts.callback == 'function' ? opts.callback : function() {};		
		// $.post('/actions/retrieve', {Store: {key:key}}, function(dat, status, xhr) {
		// 	console.log(dat);
		// 	cb(dat);
		// }, 'json');
	},

	makeRequest: function(url, params, opts) {
		var cb = typeof opts.callback == 'function' ? opts.callback : function() {};

		if (this.options.jsonp) {
			$.ajax({
		        type: 'POST',
		        url: 'http://sirest.snm.com/actions/' + url,
		        dataType: 'jsonp',
		        data: params,
		        success: cb
		    });
		} else {
			$.post('/actions/' + url, params, cb, 'json');
		}
	}


});