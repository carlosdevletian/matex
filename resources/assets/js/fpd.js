$(document).ready(function(){
    var $fpd = $('#fpd'),
        pluginOpts = {
            stageWidth: 1200,
            stageHeight: 200,
            // langJSON: "{{ URL::to('default.json') }}",
            // templatesDirectory: "{{ URL::to('fpd') . '/'}}",
        };

    var yourDesigner = new FancyProductDesigner($fpd, pluginOpts);
});