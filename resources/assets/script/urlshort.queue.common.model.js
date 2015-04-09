// Application Namespaces
var urlshort = urlshort || {};
 
extend(urlshort,'queue.common');


!function(window, document, m, $, moment) {
    
    
    var isFunction = function(functionToCheck) {
        var getType = {};
        return functionToCheck && getType.toString.call(functionToCheck) === '[object Function]';
    }
    
    
    // Our API requires a common set of credentials using 
    // and API key and must map clientOption (form values) into the
    // values used by the server (request params)
    // this is a replacement for m.request in our application
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
                return response.result;
            },
            unwrapError: function(response) {
                return response.msg;
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
          var mappedOptions = {};
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
         * Makes a Web Request
         * 
         * @param object config options used by m.request
         * @return m.request
         */ 
        this.request = function(opts) {
            
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
                                data  : this.mapOptions(opts.data),
                                config: function(xhr) {
                                    // do default config
                                
                                
                                    // execute the callbacks
                                    this.xhrConfigPromise.resolve(xhr);
                                }.bind(this)
                     
            });
          
            return m.request(requestConfig);
          
        }.bind(this);
        
        
        
    };
    
    /**
     * List of possible activity state values that can be
     * used to generate a list for UI
     */ 
    urlshort.queue.common.ActivityStateList = function() {
        
        return [ new urlshort.queue.common.ActivityState(1)    
                ,new urlshort.queue.common.ActivityState(2)    
                ,new urlshort.queue.common.ActivityState(3)    
                ,new urlshort.queue.common.ActivityState(4)    
                ,new urlshort.queue.common.ActivityState(5)];
     
   };
  
  /** 
  *  Model entity for a Queue State
  * 
  *  Each transition weather it be for job or a worker have a fixed number
  *  of status this object used to represent these states in meanful manner
  */
  urlshort.queue.common.ActivityState = function(stateId) {
    
    this.stateId = m.prop(stateId);
    
    this.getList = function() {
      // this map so we know which int constant means where state
      return  ['STATE_ADD','STATE_START','STATE_FINISH','STATE_ERROR','STATE_FAIL']; 
      
    }.bind(this);
      
    this.isValid = function(stateId) {
        
        var isValid   = false;
        var stateDesc = this.getList();
          
        if(stateDesc[stateId-1]) {
          isValid = true;
        } 
        
        return isValid;
   }.bind(this);
   
   this.getLiteral = function() {
        var stateDesc = this.getList();    
        
        return stateDesc[this.stateId()-1];  
          
    }.bind(this); 
    
    
    if(!this.isValid(stateId)) {
       throw new Error('Invalid state id at '+stateId);
    }  
       
       
    return this;   
      
  };
  
  
  /**
   * Proxy Store to cache records using page windows
   * 
   * Users setup a query by calling onRefresh with query params
   * and after that a page forward with onPageForwards and a page back with onPageBackwards
   * 
   * Cache is used if the page is already loaded.
   * 
   * Note: Cant load page x unless all pages up to x are already loaded
   * also if the query params other than limit or offset change onRefresh must
   * be called to clear out cache.
   */ 
  urlshort.queue.common.PageDataStore = function() {
      
      /**
       * A collection that derives from Iterator
       *  
       * @var Iterator
       */ 
      this.recordCollection = m.prop();
      
      /**
       * A class that derives from our queue.common.Request
       * 
       */ 
      this.requestAPI = m.prop();
      
      /**
       * Object that contains the request params
       */ 
      this.requestParams = m.prop();
      
      /**
       * Config options for the xhr object
       * 
       * e.g http method to use GET|POST|DELETE 
       */ 
      this.requestConfig = m.prop();
      
      /**
       * page displayed
       * 
       * @var int
       */ 
      this.displayPage = m.prop();
      
      /**
       * Last Page that was loaded from server API
       * 
       * @var int
       */ 
      this.lastLoadedPage = m.prop();
      
      /**
       * Calculates the offset of the display page
       * 
       * return int the offset.
       */ 
      var calculateOffset = function(displayPage) {
            
            if(typeof displayPage === 'undefined') {
                var displayPage = this.displayPage();     
            }
            
            return (displayPage * this.requestConfig().pageLimit);
            
      }.bind(this);
      
      /**
       * Prepre an request using the Request class
       * will override the API data limit and offset to
       * set the page of data to return
       * 
       * @param int limit the max number of data items to return
       * @param int offset the last item in prev page 
       */ 
      this.prepareRequest = function(limit,offset) {
          
          var config = $.extend({},this.requestConfig(), {
              data : this.requestParams()
                          
          });
            
          // override the limit and offset params in request
          config.data.limit  = limit;
          config.data.offset = offset
        
          // up to the user to attach error hander to this promise chanin      
          return this.requestAPI().request(config).then(function(data){
              // add new records to the collection
              var self = this;
              data.forEach(function(element,index,array) {
                    self.recordCollection().push(element);
              });
                  
          }.bind(this));
          
      }
        
      /*
      * Fetch a page from the cache, will not change the current display page
      * 
      * @param int page
      */
      this.fetchPageFromCache = function(page) {
            var start   = calculateOffset(page);
            var limit   =  this.requestConfig().pageLimit;
           
            // create a new deferred to return to caller
            // and load with data from the cache
            var def     =  m.deferred();
            var data    = this.recordCollection().slice(start,start+limit);
            def.resolve(data);
            
            return def.promise;
            
      }.bind(this);
      
      
      /**
       * Will init the store
       * 
       * @param object                           requestConfig  The config options e.g pageLimit,method
       * @param urlshort.queue.common.Request    oRequest       The common API Request classs
       */ 
      this.init = function(requestConfig,oRequest) {
          this.requestAPI(oRequest);
          this.recordCollection([]);
          this.requestConfig(requestConfig)
          
           if(!requestConfig.method) {
                throw new Error('Request must have a method');
           }
           
           if(!requestConfig.pageLimit) {
                throw new Error('Request must have a method');
           }
          
      }.bind(this);
      
      
      this.onPageForwards = function() {
          var promise        = null;
          var newDisplayPage = this.displayPage() +1;
          var limit          =  this.requestConfig().pageLimit;
          
          
          // check if we have this page cached
          if(newDisplayPage <= this.lastLoadedPage()) {
            
            promise = this.fetchPageFromCache(newDisplayPage);
            
            // change the display page to current value
            this.displayPage(newDisplayPage);
            
              
          } else {
            
              // return request and increment the page if it was a success
              promise =  this.prepareRequest(limit,calculateOffset(newDisplayPage)).then(function(data){
                this.displayPage(this.displayPage() + 1);
                this.lastLoadedPage(this.lastLoadedPage() + 1);
         
              }.bind(this));
              
          }
          
          return promise;
          
      }.bind(this);
      
      this.onPageBackwards = function() {
          var promise        = null;
          var newDisplayPage = this.displayPage() -1;
          
          // check if we have this page cached
          if(newDisplayPage >= 0) {
            
            promise = this.fetchPageFromCache(newDisplayPage);
            
            // change the display page to current value
            this.displayPage(newDisplayPage);
              
         } else {
            throw new Error('Already at the first page unable to go back further'); 
         }    
         
         return promise;
            
      }.bind(this);
      
      /**
       * Refresh the records using a new set
       * of query parameters
       * 
       * @param object requestParams (data attribute to inject into m.request)
       */ 
      this.onRefresh = function(requestParams) {
          this.recordCollection([]);
          this.requestParams(requestParams);
          this.displayPage(-1);
          this.lastLoadedPage(-1);
          
          
          return this.onPageForwards(); 
          
      }.bind(this);
      
      
      return this;
  };    
    
}(window, document, m, $, moment);  
  
  