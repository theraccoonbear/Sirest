var Sirest = Class.extend({
	chunkRgx: null,
	
	options: {
		'jsonp': true,
		'maxChunk': 2000,
		'app': 'default',
		'hostname': '{{hostname}}',
		'basepath': '{{basepath}}',
		'encrypt': false,
		'password': false
	},
	
	
	constructor: function(o) {
		Sirest.super.constructor.call(this);
		this.options.jsonp = document.location.hostname != this.options.hostname;

		$.extend(this.options, o);
		this.chunkRgx = new RegExp(".{1," + parseInt(this.options.maxChunk) + "}", 'g');

	},
	
	errHandler: function(event, xhr, settings, error) {
		console.log('Event:'); console.log(event);
		console.log('XHR:'); console.log(xhr);
		console.log('Settings:'); console.log(settings);
		console.log('Error:'); console.log(error);
	},
	
	setApp: function(app) {
		this.options.app = app;
	},
	
	authenticate: function(user, pass, opts) {
		this.makeRequest('authenticate', {'User': {'username': user, 'password': pass}}, opts);
	},

	store: function(key, data, opts) {
		var ctxt = this;
		if (ctxt.options.encrypt === true && ctxt.options.password !== false) {
			data = sjcl.encrypt(ctxt.options.password, data);
		}
		
		data = JSON.stringify(data);
		
		var app = typeof opts.app !== 'undefined' ? opts.app : ctxt.options.app;

		if (this.options.jsonp && data.length > this.options.maxChunk) {
			this.storeChunked(key, data, opts);
		} else {
			this.makeRequest('store', {Store: {'key': key, 'app': app, 'data': data}}, opts);
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
		var app = typeof opts.app !== 'undefined' ? opts.app : ctxt.options.app;
		var progressCallback = typeof opts.progress === 'function' ? opts.progress : function() {};
		

		var chunkedCallback = function(resp) {
			if (resp.success) {
				progressCallback(chunkIdx, chunks.length, resp);
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
			ctxt.makeRequest('store', {Store: {'app': app, 'key': key, 'data': chunks[chunkIdx], 'chunkOffset': ctxt.chunkIndexOffset(chunkIdx)}}, opts);
		};

		opts.callback = chunkedCallback;
		makeChunkedCall();


		//console.log(this.chunkRgx);
		//console.log(chunks);

		//this.makeRequest('store', {Store: {key:key, data:data}}, opts);
	},

	retrieve: function(key, opts) {
		var ctxt = this;
		var app = typeof opts.app !== 'undefined' ? opts.app : ctxt.options.app;
		
		this.makeRequest('retrieve', {'Store': {'app': app, 'key': key}}, {
			callback: function(resp) {
				if (typeof resp.payload === 'string') {
					resp.payload = JSON.parse(resp.payload);
					if (ctxt.options.encrypt === true && ctxt.options.password !== false) {
						resp.payload = sjcl.decrypt(ctxt.options.password, resp.payload);
					}
				}
				opts.callback(resp);
			}
		});
	},

	makeRequest: function(url, params, opts) {
		var cb = typeof opts.callback == 'function' ? opts.callback : function() {};

		if (this.options.jsonp) {
			$.ajax({
		        type: 'GET',
		        url: 'http://' + this.options.hostname + this.options.basepath + 'actions/' + url,
		        dataType: 'jsonp',
		        data: params,
		        success: cb
		    });
		} else {
			$.post(this.options.basepath + 'actions/' + url, params, cb, 'json');
		}
	}


});