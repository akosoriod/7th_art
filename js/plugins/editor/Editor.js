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
    
    self.currentStep=false;         //Paso que se está editando actualmente
    
    self.historyStack=[];           //Almacena versiones del workspace para volver a estados anteriores
    self.historyMax=30;             //Cantidad de estados del workspace que almacena
    self.historyIndex=0;            //Índice de el workspace que se está visualizando
    
    self.dialogEditEntity=false;    //Diálogo para editar entidad
    self.editingEntity=false;       //Entidad que se está editando en el diálogo
    
    self.numberLoadings=0;          //Cuenta el número de loadings para mostrar el gif
    self.saving=false;              //Indica si está guardando, para no repetir el proceso
    self.loading=false;             //Indica si está cargando, para no repetir el proceso
    self.autosaveFrequency=0;       //Cada cuantos segundos se autoguarda
    
    self.currentState='passive';    //Estado actual, seleccionado por los botones de estado
    
    
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
        self.divSolution=$("#activity_set_home");
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
        attachEventsSolutionMode();
        
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
        self.toolbar.find(".button-basic,.button-dragdrop").draggable({
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
//        self.toolbar.find("#button-multi-single").draggable({
//            appendTo: "body",
//            containment: "#workspace",
//            cursor: "move",
//            helper: function(){
//                return $( "<div class='entity-fill-helper'></div>" );
//            },
//            opacity: 0.8,
//            scroll: false
//        });
//        self.toolbar.find("#button-multi-multi").draggable({
//            appendTo: "body",
//            containment: "#workspace",
//            cursor: "move",
//            helper: function(){
//                return $( "<div class='entity-fill-helper'></div>" );
//            },
//            opacity: 0.8,
//            scroll: false
//        });
//        self.toolbar.find("#button-true-false").draggable({
//            appendTo: "body",
//            containment: "#workspace",
//            cursor: "move",
//            helper: function(){
//                return $( "<div class='entity-fill-helper'></div>" );
//            },
//            opacity: 0.8,
//            scroll: false
//        });
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
            self.currentState=stateButton.attr("data-state");
            self.workspace.showState(self.currentState);
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
                    var content=identifyElementsOfContent(textEditor.val());
                    state.content=content;
                    self.editingEntity.draw(stateName);
                    self.dialogEditEntity.find("."+stateName).click();
                    //Espera unos segundos para volver a hacer click, no funciona inmediatamente
                    window.setTimeout(function(){
                        self.dialogEditEntity.find("."+stateName).click();
                    }, 500);
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
                        //Guarda el estado en el atributo data-val de los elementos en el editor
                        var iContent=$('#text_content_ifr').contents().find("#tinymce");
                        attachEventsDataValueAttribute(iContent);
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
        //Elimina el z-index para poder editar
        entity.div.css('z-index',0);
        self.editingEntity.div.dblclick(function(){
            attachEventsEditingEntity(stateName);
        });
    };
    
    /**************************************************************************/
    /*************************** QUALIFICATION METHODS ************************/
    /**************************************************************************/
    
    /**
     * Agrega el estado de los elementos del editor tinymce a partir de su estado
     * en el editor
     * @param {element} container Contenedor al que se agregan los eventos
     */
    function attachEventsDataValueAttribute(container){
        //Guarda el estado de los input
        container.find("input:text").keyup(function(){
            $(this).attr("data-val",$(this).val());
        });
        container.find('input:radio').change(function(){
            var radios=container.find('input:radio[name="'+$(this).attr('name')+'"]');
            radios.each(function(){
                $(this).attr("data-val",false);
                $(this).removeAttr("checked");
            });
            $(this).attr("data-val",true);
            $(this).attr("checked","checked");
        });
        container.find('input:checked').change(function(){
            $(this).attr("data-val",true);
            $(this).attr("checked","checked");
        });

    };
    
    /**
     * Inserta identificadores en los elementos calificables en un html luego de
     * la edición de un estado
     * @param {Entity} entity Entidad a la que pertenece el estado
     * @param {string} stateContent Contenido luego de editar el estado
     * @returns {string} Texto del contenido con los elementos calificables identificados
     */
    function identifyElementsOfContent(stateContent){
        var text="";
        var container=$('#elementsIdentificator');
        container.append('<div id="entityTemporalContent">'+stateContent+'</div>');
        var contentElements=container.find('#entityTemporalContent');
        
        
        
        
        //Se procesan los elementos input:text
        contentElements.find('input:text').each(function(){
            $(this).attr("value",$(this).attr("data-val"));
            if($.trim($(this).attr("data-element-id"))===""){
                $(this).attr("data-element-id","entityElement_"+guid());
            }
            $(this).addClass("entityElement inputText");
        });
        
        //Se procesan los elementos input:radio
        contentElements.find("input:radio").each(function(){
            if($(this).attr("data-val")==="true"||$(this).attr("checked")==="checked"){
                $(this).attr("checked","checked");
                $(this).attr("data-val","true");
            }else{
                $(this).removeAttr("checked");
                $(this).attr("data-val","false");
            }
            if($.trim($(this).attr("data-element-id"))===""){
                $(this).attr("data-element-id","entityElement_"+guid());
            }
            $(this).addClass("entityElement inputRadio");
        });
        
        //Se procesan los elementos input:checkbox
        contentElements.find("input:checkbox").each(function(){
            if($(this).attr("data-val")==="true"||$(this).attr("checked")==="checked"){
                $(this).attr("checked","checked");
                $(this).attr("data-val","true");
            }else{
                $(this).removeAttr("checked");
                $(this).attr("data-val","false");
            }
            if($.trim($(this).attr("data-element-id"))===""){
                $(this).attr("data-element-id","entityElement_"+guid());
            }
            $(this).addClass("entityElement inputCheckbox");
        });
        
        
        
        //TODO: Cargar este valor de la entidad
        var importanceEntity=10;
        //Divide la importancia entre todos los elementos
        contentElements.find('.entityElement').each(function(){
//            $(this).attr("data-entity-id",entity.id);
            $(this).attr("data-entity-importance",importanceEntity);
            $(this).attr("data-element-importance",1/contentElements.find('.entityElement').size());
        });
        
        text=contentElements.html();
        
        
        container.empty();
        return text;
    };
    
    /**
     * Eventos para el editor en modo solución: espacio de usuarios
     */
    function attachEventsSolutionMode(){
        var solutionDiv=self.divSolution.find("#status_solved");
        var userResponse=self.workspace.div;
        var deltaPos=15;    //Diferencia máxima en left y pos para calcular distancia
        
        self.divSolution.find('#check_button').click(function(){
            //Valores para calificar
            var T=100;                                  //Máximo valor para un ejercicio
            var n=userResponse.find(".entity").length;  //Cantidad de entidades en el ejercicio
            var r=10;                                   //Máximo valor de importancia para una entidad
            var x=T/(n*r);                              //Multiplicador para mapeo
            var totalExercise=0;                        //Suma de calificación del ejercicio
            var mappedResult=0;                         //Resultado luego de ser mapeado de 0 a T
//            var stateButton=$(this);
//            stateButtons.removeClass("state_selected");
//            stateButton.addClass("state_selected");

            for(var i in self.workspace.entities){
                var correct=true;
                var entity=self.workspace.entities[i];
                var right=entity.getState('right');

                //Pone el estado resuelto en el DOM
                solutionDiv.append('<div id="entitySolution'+entity.id+'" class="entitySolution">'+right.content+'</div>');
                //Retorna el elemento de solución de la entidad y compara uno a uno los elementos con el estado activo
                var solutionEntity=solutionDiv.find('#entitySolution'+entity.id);
                //Califica la posición del objeto, solo debería cambiar si es dragdrop
                if(solutionEntity.hasClass("dragdrop")){
                    var position=userResponse.find("#entity"+entity.id).position();
                    if(Math.abs(right.pos.left-position.left)<=deltaPos&&Math.abs(right.pos.top-position.top)<=deltaPos){
                        correct=true;
                        totalExercise+=entity.weight;
                    }else{
                        correct=false;
                    }
                }
                
                //Califica los elementos dentro de la entidad
                var elementImportances=0;
                solutionEntity.find('.entityElement').each(function(){
                    var solutionElement=$(this);
                    var answerElement=userResponse.find('[data-element-id="'+solutionElement.attr('data-element-id')+'"]');
                    var elementQualification=qualifyElements(solutionElement,answerElement);
                    correct=correct&&elementQualification;
                    //Suma la calilficación
                    if(elementQualification){
                        elementImportances+=parseFloat(answerElement.attr("data-element-importance"));
                    }
                });
                totalExercise+=elementImportances*entity.weight;
                
                if(correct){
                    entity.draw("right");
                }else{
                    entity.draw("wrong");
                }
                
                console.warn("entity.weight: "+entity.weight);
                console.warn("elementImportances: "+elementImportances);
                console.warn("totalExercise: "+totalExercise);
            }
            
            mappedResult=x*totalExercise;
            
            
            console.warn("TOTAL PUNTOS");
            console.debug(mappedResult);
            
            solutionDiv.empty();
        });
    };
    
    /**
     * Califica si la respuesta dada a un elemento es correcta
     * @param {element} solution Elemento con la respuesta correcta
     * @param {element} answer Elemento con la respuesta dada por el estudiante
     * @returns {bool} Verdadero si la respuesta es correcta
     */
    function qualifyElements(solution,answer){
        var correct=false;
        
        //Revisa los input:text
        if(solution.is('input:text')){
            if(solution.attr("data-val")===$.trim(answer.val())){
                correct=true;
            }
        }
        //Revisa los input:radio
        if(solution.is('input:radio')){
            if(solution.attr("data-val")===answer.attr("data-val")){
                correct=true;
            }
        }
        //Revisa los input:checkbox
        if(solution.is('input:checkbox')){
            if(solution.attr("data-val")===answer.attr("data-val")){
                correct=true;
            }
        }
        
        return correct;
    };
    
    /**
     * Agrega los eventos a las entidades en solution mode
     */
    function attachEventsSolutionModeEntities(){
//        self.workspace.div.find('.entity').keyup(function() {
//            updateSolvedState($(this));
//        }).click(function(){
//            updateSolvedState($(this));
//        });
    };
    
    /**
     * Actualiza el estado solved con la información del userspace
     * @param {element} entityElement Elemento del DOM de la entidad
     */
//    function updateSolvedState(entityElement){
//        var entity=self.workspace.getEntity(parseInt(entityElement.attr('data-id')));
//        
////        console.warn("Activo de la entidad");
////        console.debug(escapeHtmlEntities(entity.states.active.content));
//        
//        var htmlContent=entityElement.find('.content').clone();
////        console.warn($(entity.states.active.content));
//        
//        $(entity.states.active.content).find('*').each(function(){
//            var entitySubelement=$(this);
////            console.warn(entitySubelement);
////            htmlContent.find("*").each(function(){
////                console.debug($(this));
////            });
//            
//        });
//        
//        console.warn("Contenido del html");
//        console.debug(escapeHtmlEntities(entityElement.find('.content').html()));
//    };
    
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
                if(self.mode==='solution'){
                    //Se crean los eventos adicionales para las entidades
                    attachEventsSolutionModeEntities();
                }
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
    };
    
    /**
     * Retorna un ID aleatorio para los elementos
     * @returns {String} Id aleatorio
     */
    function guid() {
        function s4() {
            return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
        }
        return s4() + s4() + '_' + s4() + '_' + s4() + '_' +s4() + '_' + s4() + s4() + s4();
    }
};