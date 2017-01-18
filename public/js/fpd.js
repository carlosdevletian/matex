$(document).ready(function(){
    var $fpd = $('#fpd'),
        pluginOpts = {
            stageWidth: 1200,
            stageHeight: 200,
        };

    var yourDesigner = new FancyProductDesigner($fpd, pluginOpts);
});