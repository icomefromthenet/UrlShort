(function (window, document) {

    Date.createFromMysql = function(mysql_string)
    { 
       if(typeof mysql_string === 'string')
       {
          var t = mysql_string.split(/[- :]/);
    
          //when t[3], t[4] and t[5] are missing they defaults to zero
          return new Date(t[0], t[1] - 1, t[2], t[3] || 0, t[4] || 0, t[5] || 0);          
       }
    
       return null;   
    }

   window.extend = function ( ns, ns_string ) {
        var parts = ns_string.split('.'),
            parent = ns,
            pl, i;
        if (parts[0] == "urlshort") {
            parts = parts.slice(1);
        }
        pl = parts.length;
        for (i = 0; i < pl; i++) {
            //create a property if it doesnt exist
            if (typeof parent[parts[i]] == 'undefined') {
                parent[parts[i]] = {};
            }
            parent = parent[parts[i]];
        }
        return parent;
    }


}(this, this.document));