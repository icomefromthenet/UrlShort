!function(window, document, m, $, moment) { 
  
  var activity = urlshort.queue.activity;
  var common   = urlshort.queue.common;
  
  activity.controller = function() {
      
      // Init Page Store
      var pageStore = new common.PageDataStore();
      pageStore.init({
           'method'     : 'GET'
          ,'pageLimit'  : 500
      },activity.ActivityRequest);
      
      // Init View Model
      activity.vm.init({
          'store'        : pageStore
         ,'listedStates' : [1,2,3,4,5]
         ,'dateRange'    : 'P7D'
      });
      
  };
  
  
}(window, document, m, $, moment);  
  