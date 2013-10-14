var Sirest = Class.extend({
	options: {'jsonp': true},
	
	
	constructor: function(o) {
		Sirest.super.constructor.call(this);
		$.extend(this.options, o);
	},
	
	errHandler: function(event, xhr, settings, error) {
		console.log('Event:'); console.log(event);
		console.log('XHR:'); console.log(xhr);
		console.log('Settings:'); console.log(settings);
		console.log('Error:'); console.log(error);
	},
	
	authenticate: function(user, pass, opts) {
		this.makeRequest('authenticate', {User: {username:user,password:pass}}, opts);
	},

	store: function(key, data, opts) {
		this.makeRequest('store', {Store: {key:key, data:data}}, opts);
	},

	retrieve: function(key, opts) {
		this.makeRequest('retrieve', {Store: {key:key}}, opts);
	},

	makeRequest: function(url, params, opts) {
		var cb = typeof opts.callback == 'function' ? opts.callback : function() {};

		if (this.options.jsonp) {
			$.ajax({
		        type: 'GET',
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