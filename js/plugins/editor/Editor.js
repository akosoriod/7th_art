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
    
    self.currentStep=false;           //Paso que se está editando actualmente
    
    self.historyStack=[];           //Almacena versiones del workspace para volver a estados anteriores
    self.historyMax=30;             //Cantidad de estados del workspace que almacena
    self.historyIndex=0;            //Índice de el workspace que se está visualizando
    
    self.dialogEditEntity=false;    //Diálogo para editar entidad
    self.editingEntity=false;       //Entidad que se está editando en el diálogo
    
    self.numberLoadings=0;          //Cuenta el número de loadings para mostrar el gif
    self.saving=false;              //Indica si está guardando, para no repetir el proceso
    self.loading=false;             //Indica si está cargando, para no repetir el proceso
    self.autosaveFrequency=0;      //Cada cuantos segundos se autoguarda
    
    
    /**************************************************************************/
    /********************* CONFIGURATION AND CONSTRUCTOR **********************/
    /**************************************************************************/
    //Mix the user parameters with the default parameters
    var def = {
        appUrl:'',
        mode:'edition' /*'solution'*/
    };
    self.params = $.extend(def, params);
    self.appUrl=self.params.appUrl;
    self.mode=self.params.mode;
    self.ajaxUrl=self.appUrl+"index.php/designer/";
    /**
     * Constructor Method 
     */
    var Editor = function() {
        self.div=$("#editor_page");
        self.toolbar=self.div.find("#toolbar");
        self.stepsDivs=$("#navigation").find(".step");
        self.editingPathDiv=$("#editing_path");
    }();
    /**
     * Initialize the editor
     */
    self.init=function(){
        //Set the loading html
        $('#toolbar').prepend(htmlLoading());
        //Se crea el espacio de trabajo y se configura
        self.workspace=new Workspace({
            saveHistory:self.saveHistory
        });
        self.saveHistory();
        attachEvents();
        
        //Se inicia el proceso de autoguardado
        if(self.autosaveFrequency>0){
            setInterval(self.save,self.autosaveFrequency*1000);
        }
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
    };
    
    /**
     * Muestra las opciones de edición para una entidad
     * @param {Entity} entity Entidad a editar
     */
    self.editEntity=function(entity){
        self.editingEntity=new Entity();
        self.editingEntity.deobjectify(JSON.parse(JSON.stringify(entity.objectify())));
        self.dialogEditEntity.dialog("option","title","Editando entidad: "+entity.id);
        self.dialogEditEntity.dialog("open");
    };

    /**************************************************************************/
    /***************************** EVENTS METHODS *****************************/
    /**************************************************************************/
    /**
     * Assign the events to the buttons
     */
    function attachEvents(){
        $( document ).tooltip();
        //Asigna los eventos
        attachEventsNavbar();
        attachEventsBarEntities();
        attachEventsBarActions();
        attachEventsDialogEntity();
    };
    
    /**
     * Eventos de la barra de entidades
     */
    function attachEventsNavbar(){
        self.div.find('#sections_tree').tabelize({
            fullRowClickable : true
	});
        var steps=self.div.find('#sections_tree').find('.step');
        steps.click(function(){
            self.currentStep={
                'stepId':parseInt($(this).attr('data-step-id')),
                'stepName':$(this).attr('data-step-name'),
                'activityId':parseInt($(this).attr('data-activity-id')),
                'activityName':$(this).attr('data-activity-name'),
                'versionId':parseInt($(this).attr('data-version-id')),
                'versionName':$(this).attr('data-version-name'),
                'sectionId':parseInt($(this).attr('data-section-id')),
                'sectionName':$(this).attr('data-section-name'),
                'activitySetId':$(this).attr('data-activity-set-id'),
                'activitySetTitle':$(this).attr('data-activity-set-title')
            };
            self.editingPathDiv.find("#message").text(
                self.currentStep.sectionName+' > '+
                self.currentStep.versionName+' > '+
                self.currentStep.activityName+' > '+
                self.currentStep.stepName
            );
            self.editingPathDiv.attr('data-step-id',self.currentStep.stepId);
            self.load();
        });
    };
    
    /**
     * Eventos de la barra de entidades
     */
    function attachEventsBarEntities(){
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
    };
    
    /**
     * Eventos de la barra de entidades
     */
    function attachEventsBarActions(){
        var stateButtons=self.toolbar.find(".state_button");
        self.toolbar.find("#button-undo").click(function(){
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
        
        stateButtons.click(function(){
            var stateButton=$(this);
            stateButtons.removeClass("state_selected");
            stateButton.addClass("state_selected");
            self.workspace.showState(stateButton.attr("data-state"));
        });
        
        self.toolbar.find("#save").click(function(){
            self.save();
        });
    };
    
    /**
     * Eventos del cuadro de diálogo de edición de entidades
     */
    function attachEventsDialogEntity(){
        self.dialogEditEntity=self.div.find("#edit_entity");
        self.copyPassiveState=self.div.find(".copy_passive");
        self.dialogEditEntity.dialog({
            autoOpen:false,
            height:620,
            modal:true,
            resizable:false,
            width:1000,
            buttons:{
                Cancelar:function(){
                    $(this).dialog("close");
                },
                "Guardar valores":function(){
                    self.workspace.updateEntityAfterEditing(self.editingEntity);
                    $(this).dialog("close");
                }
            },
            close:function(){
                self.editingEntity=false;
                self.dialogEditEntity.find(".state_container").empty();
            },
            open: function(e,ui){
                self.dialogEditEntity.find(".copy_passive").button();
                self.dialogEditEntity.find("#tabs").tabs({
                    heightStyle: "fill",
                    create:function(){
                        attachEventsDialogEntityStates($(this));
                    },
                    activate:function(e,ui){
                        
                    }
                });
                self.dialogEditEntity.find(".passive").click();
            },
            position:{
                my: "center", 
                at: "center", 
                of: self.workspace.div
            }
        });
        self.copyPassiveState.click(function(){
            var passive=self.editingEntity.getState("passive");
            for(var i in self.editingEntity.states){
                self.editingEntity.states[i].content=passive.content;
            }
            self.dialogEditEntity.find(".selected").click();
        });
    };
    
    /**
     * Eventos del selector de estados en la edición de entidades
     * @param {element} tabs Elemento Tabs del diálogo
     */
    function attachEventsDialogEntityStates(tabs){
        var stateButtons=tabs.find(".state_button");
        var container=tabs.find(".state_container");
        stateButtons.click(function(){
            var stateButton=$(this);
            stateButtons.removeClass("selected");
            stateButton.addClass("selected");
            showEntityState(container,stateButton.attr("data-state"),self.editingEntity);
        });
    };
    
    /**
     * Eventos de la entidad que se está editando
     * @param {string} stateName Nombre del estado que se está editando
     */
    function attachEventsEditingEntity(stateName){
        var entityContentDialog=$('<div id="edit_entity_content" title="Editando contenido de la entidad"><div id="text_content"></div></div>');
        var textEditor=entityContentDialog.find("#text_content");
        var state=self.editingEntity.getState(stateName);
        entityContentDialog.dialog({
            height:620,
            modal:true,
            resizable:false,
            width:1000,
            buttons:{
                Cancelar:function(){
                    $(this).dialog("close");
                },
                Guardar:function(){
                    state.content=textEditor.val();
                    self.editingEntity.draw(stateName);
                    self.dialogEditEntity.find("."+stateName).click();
                    $(this).dialog("close");
                }
            },
            close:function(){
                try{
                    textEditor.tinymce().remove();
                    $(this).dialog("close");
                    $(this).dialog('destroy').remove();
                }catch(e){};
            },
            open:function(){
                textEditor.tinymce({
                     // Location of TinyMCE script
                    script_url : self.appUrl+'js/plugins/tinymce/tinymce.min.js',
                    language : 'es_MX',
                    height:360,
                    plugins: [
                        "advlist autolink link image media lists charmap print preview hr pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen nonbreaking",
                        "save table contextmenu directionality template paste textcolor textcolor jbimages"
                    ],
                    toolbar: "sizeselect bold italic textcolor forecolor backcolor fontselect fontsizeselect |"+
                            " searchreplace wordcount fullscreen |"+
                            " autolink link image media lists preview spellchecker table | jbimages code |" +
                            " undo redo | styleselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent |",
                    menubar : false,
                    oninit:function(){
                        tinyMCE.activeEditor.setContent(state.content);
                    }
                });
            },
            position:{
                my: "center", 
                at: "center", 
                of: self.dialogEditEntity
            }
        });
    };
    
    /**
     * Dibuja un estado de la entidad en el editor de estados
     * @param {element} container Elemento donde se dibujará el estado de la entidad
     * @param {string} stateName Nombre del estado a dibujar
     * @param {Entity} entity Entidad a dibujar
     */
    function showEntityState(container,stateName,entity){
        container.empty();
        entity.container=container;
        entity.entities={};
        entity.updatePosition(0,0);
        entity.draw(stateName);
        entity.div.draggable("destroy");
        entity.div.attr("title","Doble click para editar el contenido");
        entity.div.css("position","relative");
        self.editingEntity.div.dblclick(function(){
            attachEventsEditingEntity(stateName);
        });
    };
    
    /**************************************************************************/
    /***************************** MESSAGING METHODS **************************/
    /**************************************************************************/
    
    /**
     * Shows a message in the interface
     * @param {string} message description
     * @param {object} options Options for the messenger
     * @return {object} Object messenger to hide or anything
     */
    self.message=function(message,options){
        alert(message);
//        var defaults={
//            message: message,
//            type: 'info',
//            showCloseButton: false
//        };
//        if (screen.width < 980){
//            return self.alert(message);
//        }
//        else{
//            return Messenger().post($.extend(defaults,options));
//        }
    };
    
    /**************************************************************************/
    /******************************* SYNC METHODS *****************************/
    /**************************************************************************/
    
    /**
     * Guarda los cambios del editor para el paso actual
     */
    self.save=function(){
        var entities=self.workspace.objectify();
        if(entities.length>0){
            saveEntities(self.currentStep.stepId,entities,function(err){
                if(err){
                    self.message("No se pueden guardar los cambios, por favor intente más tarde.");
                    editor.hideLoading();
                    self.saving=false;
                }
            });
        }
    };
    
    /**
     * Carga las entidades para el paso actual
     */
    self.load=function(stepId){
        if(!stepId){
            stepId=self.currentStep.stepId;
        }
        self.workspace.clear();
        loadEntities(stepId,function(err,response){
            if(err){
                self.message("No se pueden cargar los datos, por favor intente más tarde.");
                editor.hideLoading();
                self.loading=false;
            }else{
                self.workspace.deobjectify(response.entities);
            }
        });
    };
    
    /**
     * Guarda la lista de objetos
     * @param {id} stepId Id del paso actual
     * @param {Entity[]} entities Entidades a guardar
     * @param {function} callback Function to return the response
     */
    function saveEntities(stepId,entities,callback){
        if(!self.saving){
            self.saving=true;
            editor.showLoading();
            $.ajax({
                url: self.ajaxUrl+'saveEntitiesByAjax',
                type: "POST",
                data:{
                    stepId:stepId,
                    entities:JSON.stringify(entities)
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
                editor.hideLoading();
                self.saving=false;
            });
        }
    };
    
    /**
     * Carga la lista de entidades para el paso seleccionado
     * @param {id} stepId Id del paso actual
     * @param {function} callback Function to return the response
     */
    function loadEntities(stepId,callback){
        if(!self.loading){
            self.loading=true;
            editor.showLoading();
            $.ajax({
                url: self.ajaxUrl+'loadEntitiesByAjax',
                type: "POST",
                data:{
                    stepId:stepId
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
                editor.hideLoading();
                self.loading=false;
            });
        }
    };

    /**
     * Add a show loading message to the pile
     */
    self.showLoading=function(){
        self.numberLoadings++;
        evaluateLoading();
    };
    /**
     * Remove a show loading message for the pile
     */
    self.hideLoading=function(){
        self.numberLoadings--;
        evaluateLoading();
    };
    /**
     * Evaluate if must show or hide the loader
     */
    function evaluateLoading(){
        if(self.numberLoadings>0){
            $('#loadingMessage').show();
        }else{
            $('#loadingMessage').hide();
            self.numberLoadings=0;
        }
    };
    
    /**
     * Return the html for the loading message
     */
    function htmlLoading(){
        var html=
            '<div id="loadingMessage">'+
                '<div id="loading">'+
                    '<img src="'+self.appUrl+'/images/loading.gif" alt="cargando...">'+
                '</div>'+
            '</div>';
        return html;
    }
};