var templateLoader = (function($,host){
	//Loads external templates from path and injects in to page DOM
	return{
		loadExtTemplate: function(path){
			var tmplLoader = $.get(path)
				.success(function(result){
					//Add templates to DOM
					//$("body").prepend(result);
                                         $("body").append(result);
				})
				.error(function(result){
					alert("Error Loading Templates -- TODO: Better Error Handling");
				});
				
			tmplLoader.complete(function(){
                           
				$(host).trigger("TEMPLATE_LOADED", [path]);
			});
		}
	};
})(jQuery, document);