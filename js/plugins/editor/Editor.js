/* 
 * Pseudo-Clase para el manejo del editor de actividades de 7th @rt
 * Universidad Nacional de Colombia
 * 7th @rt The Power & Magic of Films to Learn English
 * 7thart_bog@unal.edu.co
 * 2014
 * @param {object} params OObject with the class parameters
 * @param {function} callback Function to return the results
 */
var Editor = function(params,callback){
    /**************************************************************************/
    /******************************* ATTRIBUTES *******************************/
    /**************************************************************************/
    var self = this;
    
    self.countObjects=0;
    
    /**************************************************************************/
    /********************* CONFIGURATION AND CONSTRUCTOR **********************/
    /**************************************************************************/
    //Mix the user parameters with the default parameters
    var def = {
        appUrl:''
    };
    self.params = $.extend(def, params);
    self.appUrl=self.params.appUrl;
    self.ajaxUrl=self.appUrl+"index.php/designer/";
    /**
     * Constructor Method 
     */
    var Editor = function() {
        self.div=$("#editor_page");
        self.toolbar=self.div.find("#toolbar");
        self.workspace=self.div.find("#workspace");
    }();
    /**
     * Initialize the editor
     */
    self.init=function(){
        assignEvents();
    };
    /**************************************************************************/
    /****************************** SETUP METHODS *****************************/
    /**************************************************************************/
    /**
     * Assign the events to the buttons
     */
    function assignEvents(){
        self.toolbar.find("#button-object").draggable({
            appendTo: "body",
            containment: "#workspace",
            cursor: "move",
//                    helper: "clone",
            helper: function(){
                return $( "<div class='object-helper'></div>" );
            },
            opacity: 0.8,
            scroll: false
        });
        
        
        
        self.workspace.droppable({
            accept: ".button",
            drop: function( event, ui ) {
                if(ui.draggable.hasClass("object")){
                    self.countObjects++;
                    $(this).append('<div class="draggable object" id="object'+self.countObjects+'" data-id="'+self.countObjects+'"><div class="content"><div class="text"><div class="textContent"></div></div></div><div class="objectButton config"></div><div class="objectButton deleteObject">x</div></div>');
                    var object=$(this).find('#object'+self.countObjects);
                    object.draggable({
                        containment: "#workspace",
                        cursor: "move",
                        opacity: 0.4,
                        scroll: false
                    }).resizable({
//                        containment:"parent"
                    });
                    var displacement=$("#workspace").offset();
                    object.css({
                        left:ui.position.left-displacement.left,
                        top:ui.position.top-displacement.top
                    });
                    object.find(".deleteObject").click(function(){
                        object.remove();
                    });
                    object.find(".config").click(function(){
                        var id=parseInt($(this).parent().attr("data-id"));
                        $("#properties").attr("data-object",id);
                        $("#properties").dialog("open");
                    });
                    
                    var text=object.find(".text");
                    text.dblclick(function(){
                        var textObj=$(this);
                        $('<div><textarea id="dialogTextValue" placeholder="Inserte el texto"></textarea></div>').dialog({
                            height:500,
                            title:"Contenido del objeto",
                            modal:true,
                            width:800,
                            buttons:{
                                Cancelar:function(){
                                    $(this).find("#dialogTextValue").tinymce().remove();
                                    $(this).dialog("close");$(this).dialog('destroy').remove();
                                },
                                Aceptar:function(){
                                    textObj.find('.textContent').html($(this).find('#dialogTextValue').val());
                                    $(this).find("#dialogTextValue").tinymce().remove();
                                    $(this).dialog("close");$(this).dialog('destroy').remove();
                                }
                            },
                            open:function(){
                                var textEditor=$(this).find("#dialogTextValue");
                                
                                textEditor.tinymce({
                                     // Location of TinyMCE script
                                    script_url : self.appUrl+'js/plugins/tinymce/tinymce.min.js',
                                    language : 'es_MX',
                                    height:290,
                                    plugins: [
                                        "advlist autolink link image media lists charmap print preview hr pagebreak spellchecker",
                                        "searchreplace wordcount visualblocks visualchars code fullscreen nonbreaking",
                                        "save table contextmenu directionality template paste textcolor textcolor"
                                    ],
                                    toolbar: "advlist autolink link image media lists charmap print preview hr pagebreak spellchecker "+
                                            "searchreplace wordcount visualblocks visualchars code fullscreen nonbreaking"+
                                            "save table contextmenu directionality template paste textcolor textcolor forecolor backcolor",
                                    menubar : false,
                                    oninit:function(){
                                        tinyMCE.activeEditor.setContent(textObj.find('.textContent').html());
                                        
                                        
                                        
                                        tinyMCE.DOM.setStyle('body', 'background-color', 'red');
                                    }
                                });
                            },
                            close:function(){
                                try{
                                    $(this).find("#dialogTextValue").tinymce().remove();
                                }catch(e){};
                            }
                        });
                    });
                }else{
                    alert("I'm a prototype");
                }
            }
        });
        
        
        self.div.find("#properties").dialog({
            autoOpen: false,
            modal:true,
            open: function(event,ui){
                var id=parseInt($(this).attr("data-object"));
                var object=$("#object"+id).find('.text');
                var props=$("#properties");
                props.find("#id").text(id);
                props.find("#background").spectrum({
                    showAlpha: true,
                    color: hexc(object.css("background-color"))
                });
                props.find("#borders").spectrum({
                    showAlpha: true,
                    color: hexc(object.css("border-bottom-color"))
                });
            },
            buttons: {
                "Ok": function() {
                    var props=$("#properties");
                    var background=props.find("#background");
                    var borders=props.find("#borders");
                    var font=props.find("#font");
                    var bValid = true;
                    if (bValid){
                        var id=parseInt($(this).attr("data-object"));
                        var object=$("#object"+id).find('.text');
                        object.css({
                            'background':background.spectrum('get').toRgbString(),
                            'border-color':borders.spectrum('get').toRgbString(),
                            'font-size':font.val()+'px',
                            'line-height':font.val()+'px'
                        });
                        $(this).dialog("close");
                    }
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            }
        });
        self.toolbar.find('#save').click(function(){
            var objects=parseObjects();
            if(objects.length>0){
                saveObjects(objects,function(err){
                    if(!err){
                        alert('Se almacenaron los objetos correctamente');
                    }
                });
            }
        });
        
    };
    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
    
    function parseObjects(){
        var objects=new Array();
        self.workspace.find('.object').each(function(){
            objects.push(parseObject($(this)));
        });
        return objects;
    };
    
    function parseObject(objectElem){
        var text=objectElem.find('.text');
        var pos=objectElem.position();
        
        
//        console.debug(objectElem);
//        console.debug(text.attr('style'));
//        $('#button-object').attr('style',text.attr('style'));
        
        
        var object={
            id:parseInt(objectElem.attr('data-id')),
            left:pos.left,
            top:pos.top,
            height:text.height(),
            width:text.width(),
//            background:text.css('background-color'),
//            border:text.css('border-left-color'),
//            font_size:text.css('font-size'),
            text:{
                content:text.html()
            }
        };
        return object;
    };
    
    /**
     * Clear all data
     */
    function resetEditor(){
        
    };
    /**************************************************************************/
    /******************************* SYNC METHODS *****************************/
    /**************************************************************************/
    
    /**
     * Saves the driver collect
     * @param {function} callback Function to return the response
     */
    function saveObjects(objects,callback){
        $.ajax({
            url: self.ajaxUrl+'saveObjectsByAjax',
            type: "POST",
            data:{
                objects:objects
            }
        }).done(function(response) {
            var data = JSON.parse(response);
            if(callback){callback(false,data);}
        }).fail(function(error) {
            if(error.status===403){
                alert("Su sesión ha terminado, por favor ingrese de nuevo.");
                window.location=self.ajaxUrl;
            }else{
                if(callback){callback(error);}
            }
        }).always(function(){
            
        });
    };
    
    
    /**************************************************************************/
    /****************************** OTHER METHODS *****************************/
    /**************************************************************************/
    function checkRegexp( o, regexp, n ) {
        if ( !( regexp.test( o.val() ) ) ) {
            o.addClass( "ui-state-error" );
            alert( n );
            return false;
        } else {
            return true;
        }
        }
    function hexc(colorval) {
        var color;
        var parts = colorval.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
        delete(parts[0]);
        for (var i = 1; i <= 3; ++i) {
            parts[i] = parseInt(parts[i]).toString(16);
            if (parts[i].length == 1) parts[i] = '0' + parts[i];
        }
        color = '#' + parts.join('');

        return color;
    }
};