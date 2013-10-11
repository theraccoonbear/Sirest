var Sirest = Class.extend({
	constructor: function() {
		Sirest.super.constructor.call(this);
	},
	
	authenticate: function(user, pass) {
		$.post('/actions/authenticate', {username:user,password:pass}, function(data, status, xhr) {
			console.log(data);
		}, 'json');
	}
});