/* 
 * Pseudo-Clase para el manejo del editor de actividades de 7th @rt
 * Universidad Nacional de Colombia
 * 7th @rt The Power & Magic of Films to Learn English
 * 7thart_bog@unal.edu.co
 * 2014
 * @param {object} params Object with the class parameters
 * @param {function} callback Function to return the results
 */
var Editor = function(params,callback){
    /**************************************************************************/
    /******************************* ATTRIBUTES *******************************/
    /**************************************************************************/
    var self = this;
    
    self.historyStack=[];   //Almacena versiones del workspace para volver a estados anteriores
    self.historyMax=30;      //Cantidad de estados del workspace que almacena
    self.historyIndex=0;    //Índice de el workspace que se está visualizando
    
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
    self.currentStep=false;
    /**
     * Constructor Method 
     */
    var Editor = function() {
        self.div=$("#editor_page");
        self.toolbar=self.div.find("#toolbar");
//        self.workspace=self.div.find("#workspace");
        self.stepsDivs=$("#navigation").find(".step");
        self.editingPathDiv=$("#editing_path");
    }();
    /**
     * Initialize the editor
     */
    self.init=function(){
        self.workspace=new Workspace({
            saveHistory:self.saveHistory
        });
        
        self.saveHistory();
        
        
        $("#button-undo").click(function(){
            if(self.historyIndex>0){
                self.historyIndex--;
                self.workspace=new Workspace({
                    logHistory:false,
                    saveHistory:self.saveHistory
                });
                self.workspace.div.empty();
                var entities=self.historyStack[self.historyIndex];
                self.workspace.deobjectify(JSON.parse(entities));
                self.workspace.logHistory=true;
            }
        });
        $("#button-redo").click(function(){
            if(self.historyIndex<self.historyStack.length-1){
                self.historyIndex++;
                self.workspace=new Workspace({
                    logHistory:false,
                    saveHistory:self.saveHistory
                });
                self.workspace.div.empty();
                var entities=self.historyStack[self.historyIndex];
                self.workspace.deobjectify(JSON.parse(entities));
                self.workspace.logHistory=true;
                
                console.debug(self.workspace.entities);
            }
        });
        
        $("#save").click(function(){
            for(var i in self.workspace.entities){
                var states=self.workspace.entities[i].states;
                
//                console.debug(self.workspace.entities[i].stringify());
                
//                for(var j in states){
//                    console.debug(states[j].stringify());
//                }
                
            }
        });
        
        
//        self.workspace.addObjeto(new Objeto({
//            pos:{left:10,top:10}
//        }));
//        self.workspace.addObjeto(new Objeto({
//            pos:{left:20,top:20}
//        }));
//        self.workspace.addObjeto(new Objeto({
//            pos:{left:30,top:30}
//        }));
//        self.workspace.addObjeto(new Objeto({
//            pos:{left:40,top:40}
//        }));
//        self.workspace.addObjeto(new Objeto({
//            pos:{left:50,top:50}
//        }));
//        self.workspace.addObjeto(new Objeto({
//            pos:{left:60,top:60}
//        }));
//        
//        self.workspace.deleteObjeto(-4);
        
        assignEvents();
    };
    
    /**
     * Guarda una versión del estado de las entidades del wokspace para "deshacer"
     */
    self.saveHistory=function(){
        
        self.historyStack.splice(self.historyIndex+1,self.historyStack.length);
        
        var entities=self.workspace.objectify();
        if(self.historyStack.length>=self.historyMax){
            self.historyStack.shift();
        }
        self.historyStack.push(JSON.stringify(entities));
        self.historyIndex=self.historyStack.length-1;
        
        console.debug(self.historyStack);
    };
    
    
    
    
    
    
    /**************************************************************************/
    /****************************** SETUP METHODS *****************************/
    /**************************************************************************/
    /**
     * Assign the events to the buttons
     */
    function assignEvents(){
        self.toolbar.find("#button-entity").draggable({
            appendTo: "body",
            containment: "#workspace",
            cursor: "move",
            helper: function(){
                return $( "<div class='entity-helper'></div>" );
            },
            opacity: 0.8,
            scroll: false,
            zIndex: 10000
        });
//        //True False
//        self.toolbar.find("#button-true-false").draggable({
//            appendTo: "body",
//            containment: "#workspace",
//            cursor: "move",
//            helper: function(){
//                return $( "<div class='object-true-false-helper'></div>" );
//            },
//            opacity: 0.8,
//            scroll: false
//        });
//        //Fill
//        self.toolbar.find("#button-fill").draggable({
//            appendTo: "body",
//            containment: "#workspace",
//            cursor: "move",
//            helper: function(){
//                return $( "<div class='object-fill-helper'></div>" );
//            },
//            opacity: 0.8,
//            scroll: false
//        });
        //Opción múltiple
        self.toolbar.find("#button-multi-single").draggable({
            appendTo: "body",
            containment: "#workspace",
            cursor: "move",
            helper: function(){
                return $( "<div class='entity-fill-helper'></div>" );
            },
            opacity: 0.8,
            scroll: false
        });
        self.toolbar.find("#button-multi-multi").draggable({
            appendTo: "body",
            containment: "#workspace",
            cursor: "move",
            helper: function(){
                return $( "<div class='entity-fill-helper'></div>" );
            },
            opacity: 0.8,
            scroll: false
        });
        self.toolbar.find("#button-true-false").draggable({
            appendTo: "body",
            containment: "#workspace",
            cursor: "move",
            helper: function(){
                return $( "<div class='entity-fill-helper'></div>" );
            },
            opacity: 0.8,
            scroll: false
        });
//        
//        //Eventos de los pasos
//        self.stepsDivs.click(function(){
//            resetEditor();
//            self.currentStep={
//                'stepId':parseInt($(this).attr('data-step-id')),
//                'stepName':$(this).attr('data-step-name'),
//                'activityId':parseInt($(this).attr('data-activity-id')),
//                'activityName':$(this).attr('data-activity-name'),
//                'versionId':parseInt($(this).attr('data-version-id')),
//                'versionName':$(this).attr('data-version-name'),
//                'sectionId':parseInt($(this).attr('data-section-id')),
//                'sectionName':$(this).attr('data-section-name'),
//                'activitySetId':$(this).attr('data-activity-set-id'),
//                'activitySetTitle':$(this).attr('data-activity-set-title')
//            };
//            self.editingPathDiv.find("#message").text(
//                self.currentStep.activitySetTitle+' > '+
//                self.currentStep.sectionName+' > '+
//                self.currentStep.versionName+' > '+
//                self.currentStep.activityName+' > '+
//                self.currentStep.stepName
//            );
//            self.editingPathDiv.attr('data-step-id',self.currentStep.stepId);
//            
//            
//            //Se cargan los anteriores objetos
//            loadStep(self.currentStep.stepId,function(err,response){
//                if(err){
//                    alert("No se pueden cargar el paso, por favor intente de nuevo.");
//                }else{
//                    for(var i in response.objects){
//                        addObject(response.objects[i]);
//                    }
//                }
//            });
//            
//        });
//        
//        
//        
//        
//        
//        self.div.find("#properties").dialog({
//            autoOpen: false,
//            modal:true,
//            open: function(event,ui){
//                var id=parseInt($(this).attr("data-object"));
//                var object=$("#object"+id).find('.text');
//                var props=$("#properties");
//                props.find("#id").text(id);
//                props.find("#background").spectrum({
//                    showAlpha: true,
//                    color: hexc(object.css("background-color"))
//                });
//                props.find("#borders").spectrum({
//                    showAlpha: true,
//                    color: hexc(object.css("border-bottom-color"))
//                });
//            },
//            buttons: {
//                "Ok": function() {
//                    var props=$("#properties");
//                    var background=props.find("#background");
//                    var borders=props.find("#borders");
//                    var bValid = true;
//                    if (bValid){
//                        var id=parseInt($(this).attr("data-object"));
//                        var object=$("#object"+id).find('.text');
//                        object.css({
//                            'background':background.spectrum('get').toRgbString(),
//                            'border-color':borders.spectrum('get').toRgbString()
//                        });
//                        $(this).dialog("close");
//                    }
//                },
//                Cancel: function() {
//                    $(this).dialog("close");
//                }
//            }
//        });
//        self.toolbar.find('#save').click(function(){
//            var objects=parseObjects();
//            if(objects.length>0){
//                saveObjects(self.currentStep.stepId,objects,function(err){
//                    if(!err){
//                        alert('Se almacenaron los objetos correctamente');
//                    }
//                });
//            }
//        });
        
    };
    
    /**
     * Agrega un objeto precargado al workspace
     * @param {object} object Objeto que se quiere mostrar en el editor
     */
//    function addObject(objectLoaded){
//        self.countObjects++;
//        self.workspace.append('<div class="draggable object" id="object'+objectLoaded.id+'" data-id="'+objectLoaded.id+'"><div class="content"><div class="text"><div class="textContent">'+objectLoaded.text.content+'</div></div></div><div class="objectButton config"></div><div class="objectButton deleteObject">x</div></div>');
//        var object=self.workspace.find('#object'+objectLoaded.id);
//        object.draggable({
//            containment: "#workspace",
//            cursor: "move",
//            opacity: 0.4,
//            scroll: false
//        }).resizable({
////                        containment:"parent"
//        });
//        object.css({
//            height:objectLoaded.height,
//            left:objectLoaded.left,
//            top:objectLoaded.top,
//            width:objectLoaded.width
//        });
//        object.find(".deleteObject").click(function(){
//            object.remove();
//        });
//        object.find(".config").click(function(){
//            var id=parseInt($(this).parent().attr("data-id"));
//            $("#properties").attr("data-object",id);
//            $("#properties").dialog("open");
//        });
//
//        var text=object.find(".text");
//        text.dblclick(function(){
//            var textObj=$(this);
//            $('<div><textarea id="dialogTextValue" placeholder="Inserte el texto"></textarea></div>').dialog({
//                height:500,
//                title:"Contenido del objeto",
//                modal:true,
//                width:800,
//                buttons:{
//                    Cancelar:function(){
//                        $(this).find("#dialogTextValue").tinymce().remove();
//                        $(this).dialog("close");$(this).dialog('destroy').remove();
//                    },
//                    Aceptar:function(){
//                        textObj.find('.textContent').html($(this).find('#dialogTextValue').val());
//                        $(this).find("#dialogTextValue").tinymce().remove();
//                        $(this).dialog("close");$(this).dialog('destroy').remove();
//                    }
//                },
//                open:function(){
//                    var textEditor=$(this).find("#dialogTextValue");
//                    textEditor.tinymce({
//                         // Location of TinyMCE script
//                        script_url : self.appUrl+'js/plugins/tinymce/tinymce.min.js',
//                        language : 'es_MX',
//                        height:290,
//                        plugins: [
//                            "advlist autolink link image media lists charmap print preview hr pagebreak spellchecker",
//                            "searchreplace wordcount visualblocks visualchars code fullscreen nonbreaking",
//                            "save table contextmenu directionality template paste textcolor textcolor jbimages"
//                        ],
//                        toolbar: "sizeselect bold italic textcolor forecolor backcolor fontselect fontsizeselect |"+
//                                " searchreplace wordcount fullscreen |"+
//                                " autolink link image media lists preview spellchecker table | jbimages code |" +
//                                " undo redo | styleselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent |",
//                        menubar : false,
//                        oninit:function(){
//                            tinyMCE.activeEditor.setContent(textObj.find('.textContent').html());
//                            tinyMCE.DOM.setStyle('body', 'background-color', 'red');
//                        }
//                    });
//                },
//                close:function(){
//                    try{
//                        $(this).find("#dialogTextValue").tinymce().remove();
//                        $(this).dialog("close");$(this).dialog('destroy').remove();
//                    }catch(e){};
//                }
//            });
//        });
//        return object;
//    };
//    
//    /**
//     * Agrega un objeto al workspace
//     * @param {int} left Distancia a la izquierda del workspace
//     * @param {int} top Distancia arriba del workspace
//     * @param {string} content Contenido opcional para el objeto
//     */
//    function addNewObject(left,top,content){
//        if(!content){
//            content="";
//        }
//        self.countObjects++;
//        self.workspace.append('<div class="draggable object" id="object'+self.countObjects+'" data-id="'+self.countObjects+'"><div class="content"><div class="text"><div class="textContent">'+content+'</div></div></div><div class="objectButton config"></div><div class="objectButton deleteObject">x</div></div>');
//        var object=self.workspace.find('#object'+self.countObjects);
//        object.draggable({
//            containment: "#workspace",
//            cursor: "move",
//            opacity: 0.4,
//            scroll: false
//        }).resizable({
////                        containment:"parent"
//        });
//        object.css({
//            left:left,
//            top:top
//        });
//        object.find(".deleteObject").click(function(){
//            object.remove();
//        });
//        object.find(".config").click(function(){
//            var id=parseInt($(this).parent().attr("data-id"));
//            $("#properties").attr("data-object",id);
//            $("#properties").dialog("open");
//        });
//
//        var text=object.find(".text");
//        text.dblclick(function(){
//            var textObj=$(this);
//            $('<div><textarea id="dialogTextValue" placeholder="Inserte el texto"></textarea></div>').dialog({
//                height:500,
//                title:"Contenido del objeto",
//                modal:true,
//                width:800,
//                buttons:{
//                    Cancelar:function(){
//                        $(this).find("#dialogTextValue").tinymce().remove();
//                        $(this).dialog("close");$(this).dialog('destroy').remove();
//                    },
//                    Aceptar:function(){
//                        textObj.find('.textContent').html($(this).find('#dialogTextValue').val());
//                        $(this).find("#dialogTextValue").tinymce().remove();
//                        $(this).dialog("close");$(this).dialog('destroy').remove();
//                    }
//                },
//                open:function(){
//                    var textEditor=$(this).find("#dialogTextValue");
//                    textEditor.tinymce({
//                         // Location of TinyMCE script
//                        script_url : self.appUrl+'js/plugins/tinymce/tinymce.min.js',
//                        language : 'es_MX',
//                        height:290,
//                        plugins: [
//                            "advlist autolink link image media lists charmap print preview hr pagebreak spellchecker",
//                            "searchreplace wordcount visualblocks visualchars code fullscreen nonbreaking",
//                            "save table contextmenu directionality template paste textcolor textcolor jbimages"
//                        ],
//                        toolbar: "sizeselect bold italic textcolor forecolor backcolor fontselect fontsizeselect |"+
//                                " searchreplace wordcount fullscreen |"+
//                                " autolink link image media lists preview spellchecker table | jbimages code |" +
//                                " undo redo | styleselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent |",
//                        menubar : false,
//                        oninit:function(){
//                            tinyMCE.activeEditor.setContent(textObj.find('.textContent').html());
//                            tinyMCE.DOM.setStyle('body', 'background-color', 'red');
//                        }
//                    });
//                },
//                close:function(){
//                    try{
//                        $(this).find("#dialogTextValue").tinymce().remove();
//                        $(this).dialog("close");$(this).dialog('destroy').remove();
//                    }catch(e){};
//                }
//            });
//        });
//        return object;
//    };
//        
//    
//    /**
//     * Agrega los eventos TrueFalse a un objeto
//     * @param {object} object Objeto al que se le asignarán lso eventos
//     */
//    function attachObjectEvents(object){
//        object.find(".editor-radio-object").buttonset();
////        object.find(".editor-fill-object").buttonset();
//    }
    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
    
//    function parseObjects(){
//        var objects=new Array();
//        self.workspace.find('.object').each(function(){
//            objects.push(parseObject($(this)));
//        });
//        return objects;
//    };
//    
//    function parseObject(objectElem){
//        var text=objectElem.find('.text');
//        var pos=objectElem.position();
//        
//        
//        //Elimina la funcionalidad para agregarla en el usuario
//        try{
//            objectElem.find(".editor-radio-object").buttonset( "destroy" );
//        }catch(e){
//            
//        }
//
//        
//        var object={
//            id:parseInt(objectElem.attr('data-id')),
//            css:text.attr('style')===undefined?"background: #fff;":text.attr('style'),
//            left:pos.left,
//            top:pos.top,
//            height:text.height(),
//            width:text.width(),
//            text:{
//                content:text.html()
//            }
//        };
//        
//        
//        
//        //Vuelve a agregar la funcionalidad para visualizar en el editor
//        try{
//            objectElem.find(".editor-radio-object").buttonset();
//        }catch(e){
//            
//        }
//        
//        
//        return object;
//    };
//    
//    /**
//     * Clear all data
//     */
//    function resetEditor(){
//        self.workspace.empty();
//    };
//    /**************************************************************************/
//    /******************************* SYNC METHODS *****************************/
//    /**************************************************************************/
//    
    /**
     * Guarda la lista de objetos
     * @param {function} callback Function to return the response
     */
    function saveEntities(stepId,entities,callback){
        $.ajax({
            url: self.ajaxUrl+'saveObjectsByAjax',
            type: "POST",
            data:{
                stepId:stepId,
                objects:entities
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
//    
//    /**
//     * Carga la lista de objetos para un paso de la base de datos (si existen) y los
//     * retorna a través del callback
//     * @param {function} callback Function to return the response
//     */
//    function loadStep(stepId,callback){
//        $.ajax({
//            url: self.ajaxUrl+'loadStepByAjax',
//            type: "POST",
//            data:{
//                stepId:stepId
//            }
//        }).done(function(response) {
//            var data = JSON.parse(response);
//            if(callback){callback(false,data);}
//        }).fail(function(error) {
//            if(error.status===403){
//                alert("Su sesión ha terminado, por favor ingrese de nuevo.");
//                window.location=self.ajaxUrl;
//            }else{
//                if(callback){callback(error);}
//            }
//        }).always(function(){
//            
//        });
//    };
//    
//    
//    /**************************************************************************/
//    /****************************** OTHER METHODS *****************************/
//    /**************************************************************************/
//    function checkRegexp( o, regexp, n ) {
//        if ( !( regexp.test( o.val() ) ) ) {
//            o.addClass( "ui-state-error" );
//            alert( n );
//            return false;
//        } else {
//            return true;
//        }
//        }
//    function hexc(colorval) {
//        var color;
//        var parts = colorval.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
//        delete(parts[0]);
//        for (var i = 1; i <= 3; ++i) {
//            parts[i] = parseInt(parts[i]).toString(16);
//            if (parts[i].length == 1) parts[i] = '0' + parts[i];
//        }
//        color = '#' + parts.join('');
//
//        return color;
//    }
};