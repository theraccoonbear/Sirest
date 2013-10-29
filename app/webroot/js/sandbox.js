$(function() {
        var sirest = new Sirest();
        
        $('#authDisplayForm').submit(function(e) {
                sirest.authenticate($('#username').val(), $('#password').val(), {
                          callback: function(d) {
                                  $('#output').html('<pre>' + JSON.stringify(d) + '</pre>');
                        }
                });
                e.preventDefault();
                return false;
        });

        $('#storeDisplayForm').submit(function(e) {
                sirest.store($('#storeKey').val(), $('#data').val(), {
                          callback: function(d) {
                                  $('#output').html('<pre>' + JSON.stringify(d) + '</pre>');
                        }
                });
                e.preventDefault();
                return false;
        });

        $('#retrieveDisplayForm').submit(function(e) {
                sirest.retrieve($('#retrieveKey').val(), {
                          callback: function(d) {
                                  $('#output').html('<pre>' + JSON.stringify(d) + '</pre>');
                        }
                });
                e.preventDefault();
                return false;
        });
});