// Application Namespaces
var urlshort = urlshort || {};
 
extend(urlshort,'queue.common');

// Common API parent class
// Our API requires a common set of credentials using 
// and API key and must map clientOption (form values) into the
// values used by the server (request params)
!function(window, document, m) {
    
    var Request = urlshort.queue.common.Request = function(apiKey,apiEndpoint,optionsMap) {
        
         /*
          * Url to use in creating the request
          *
          * @var string the url
          */
        this.apiEndpoint = m.prop(apiEndpoint);
         
          /*
          * Object that has the API key to sent to
          * the server to validate a request
          *
          * @var object {key}
          */
        this.apiKey = m.prop(apiKey);
        
        /**
         * Promise to chain xhr config callbacks 
         * 
         * @var Promise a promise object
         */ 
        this.xhrConfigPromise = m.deferred();
        
        /**
         *  Object that maps client data struct to a request data struct
         * 
         * @var object {server:client}
         */ 
        this.optionsMap = m.prop(optionsMap);
        
        if(!apiKey) {
            throw new Error('Api Key must not be empty');
        }
        
        if(!apiEndpoint) {
            throw new Error('api url must not be empty');
        }
        
        if(!optionsMap) {
            throw new Error('Options map must not be empty');
        }
        
        this.requestConfig = {
            unwrapSuccess: function(response) {
                return response.data;
            },
            unwrapError: function(response) {
                return response.error;
            },
            extract : function(xhr) {
                return xhr.status > 200 ? JSON.stringify(xhr.responseText) : xhr.responseText;
            }
        };
        
        /**
         * Error callback for a requet error
         */ 
        this.onRequestError = function(e) {
            console.log(e);

        }.bind(this);
        
        /**
         * Helper to add a callback to configurre
         * the xhr request object
         * 
         * @var function func A function that configure the xhr object
         */ 
        this.addXHRConfig = function(func) {
            this.xhrConfigPromise.then(func,this.onRequestError);
            
        }.bind(this); 
        
        /**
         * Map a collection client params to server params
         * 
         * @param object the options to map
         */ 
        this.mapOptions = function(options) {
          var mappedOptions = [];
          var optionsMap    = this.optionsMap();
          
          for (var serverOpt in optionsMap ) {
              // option defined on client
              var clientOption = optionsMap[serverOpt];
              
              // map client into api options
              if(options[clientOption]) {
                 mappedOptions[serverOpt] = options[clientOption];
              }
          }
           
          return mappedOptions;
          
        }.bind(this);
        
        /**
         * Map a collection server params to clien params
         * 
         * @param object the options to map
         */
        this.mapOptionsReverse = function(options) {
          var mappedOptions = [];
          var optionsMap    = this.optionsMap();
          
          for (var serverOpt in optionsMap ) {
              // option defined on client
              var clientOption = optionsMap[serverOpt];
              
              // map client into api options
              if(options[serverOpt]) {
                 mappedOptions[clientOption] = options[serverOpt];
              }
          }
           
          return mappedOptions;
          
        }.bind(this);
        
        
        this.prepareRequest = function(opts) {
            
            if(!opts.data) {
                throw new Error('Request must have a data attribute');
            }
            
            if(!opts.method) {
                throw new Error('Request must have a method');
            }
            
            if(opts.config) {
                throw new Error('Request config not allowed to override xhr config callback');
            }
            
            var requestConfig = jQuery.extend(this.requestConfig,opts,{
                                url   : this.apiEndpoint(),
                                data  : this.mappedOptions(opts.data),
                                config: function(xhr) {
                                    // do default config
                                
                                
                                    // execute the callbacks
                                    this.xhrConfigPromise.resolve(xhr);
                                }.bind(this)
                     
            });
          
            return m.request(requestConfig);
          
        }.bind(this);
        
    };
    
}(window, document, m);  
  
  