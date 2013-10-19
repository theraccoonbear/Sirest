$(function() {
		var sirest = new Sirest({
			app: 'Sirest Test'
		});
		
		var TESTS = Class.extend({
				$output: null,
				maxSize: 65536,
				size: 4,
				
				constructor: function() {
						this.$output = $('#output');
				},
				
				clearLog: function() {
					this.$output.html('');
				},
				
				log: function(msg) {
						this.$output.append(msg + '<br>');
				},
				
				tick: function() {
					this.$output.append('.');	
				},
				
				start: function() {
						this.clearLog();
						this.log('Testing storage');
						this.size = 32;
						this.authenticate();
				},
				
				authenticate: function() {
						var ctxt = this;
						this.log('Authenticating...');
						sirest.authenticate('testuser', 't35t', {
								callback: function(d) {
									if (d.success) {
										ctxt.log('Authenticated.');
										ctxt.nextTest();
									} else {
										ctxt.log('Authentication failed!');
									}
								}
						});
				},
				
				nextTest: function() {
						this.size *= 2;
						if (this.size > this.maxSize) {
								this.log('Completed');
								return;
						}
						this.log('Testing storage of ' + this.size + ' bytes...');
						this.testStore(this.size);
				},
				
				testStore: function(length) {
						var ctxt = this;
						var str = [];
						for (var i = 0; i < length; i++) {
								str.push(String.fromCharCode(Math.floor(Math.random() * 26 + 65)));
						}
						
						str = str.join('');
						
						sirest.store('testKey' + this.size, str, {
							progress: function(idx, count, resp) {
								ctxt.tick();
							},
							callback: function(resp) {
									if (resp.success) {
											ctxt.log('Stored.  Confirming...');
											sirest.retrieve('testKey' + ctxt.size, {
													callback: function(resp) {
															console.log(resp);
															if (resp.success && resp.payload == str) {
																	ctxt.log('Success!');
																	ctxt.nextTest();
															} else {
																	ctxt.log('Failed! stored = ' + (str.length) + ' bytes, retrieved = ' + (resp.payload.length))
															}
															
													}
											});
									} else {
										ctxt.log('Storage failed!');
									}
							}
						});
				}
		});
		
		var test = new TESTS();
		
		
		$('#testDisplayForm').submit(function(e) {
			test.start();
			e.preventDefault();
		});
});