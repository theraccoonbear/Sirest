var Sirest = Class.extend({
	chunkRgx: null,

	options: {
		'jsonp': true,
		'maxChunk': 2000
	},
	
	
	constructor: function(o) {
		Sirest.super.constructor.call(this);
		$.extend(this.options, o);
		this.chunkRgx = new RegExp(".{1," + this.options.maxChunk + "}", 'g');
	},
	
	errHandler: function(event, xhr, settings, error) {
		console.log('Event:'); console.log(event);
		console.log('XHR:'); console.log(xhr);
		console.log('Settings:'); console.log(settings);
		console.log('Error:'); console.log(error);
	},
	
	authenticate: function(user, pass, opts) {
		this.makeRequest('authenticate', {'User': {'username': user, 'password': pass}}, opts);
	},

	store: function(key, data, opts) {
		//data = JSON.stringify(data);

		if (data.length > this.options.maxChunk) {
			this.storeChunked(key, data, opts);
		} else {
			this.makeRequest('store', {Store: {'key': key, 'data': data}}, opts);
		}
	},

	chunkIndexOffset: function(idx) {
		return this.options.maxChunk * idx;
	},

	storeChunked: function(key, data, opts) {
		var ctxt = this;
		var chunks = data.match(this.chunkRgx);
		var chunkIdx = 0;
		var finalCallback = typeof opts.callback === 'function' ? opts.callback : function() {};

		

		var chunkedCallback = function(resp) {
			if (resp.success) {
				chunkIdx++;
				if (chunkIdx < chunks.length) {
					makeChunkedCall();
				} else {
					finalCallback(resp);
				}

			} else {
				console.log('Chunked failed');
				console.log(resp);
			}
		};

		var makeChunkedCall = function() {
			ctxt.makeRequest('store', {Store: {'key': key, 'data': chunks[chunkIdx], 'chunkOffset': ctxt.chunkIndexOffset(chunkIdx)}}, opts);
		};

		opts.callback = chunkedCallback;
		makeChunkedCall();


		//console.log(this.chunkRgx);
		//console.log(chunks);

		//this.makeRequest('store', {Store: {key:key, data:data}}, opts);
	},

	retrieve: function(key, opts) {
		this.makeRequest('retrieve', {'Store': {'key': key}}, opts);
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