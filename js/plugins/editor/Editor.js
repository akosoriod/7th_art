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
    
    self.currentStep=false;         //OBJETO: Paso que se está editando actualmente, en modo edición
                                    //INTEGER: Id del paso actual cuando está en modo de usuario
    
    self.historyStack=[];           //Almacena versiones del workspace para volver a estados anteriores
    self.historyMax=30;             //Cantidad de estados del workspace que almacena
    self.historyIndex=0;            //Índice de el workspace que se está visualizando
    
    self.dialogEditEntity=false;    //Diálogo para editar entidad
    self.editingEntity=false;       //Entidad que se está editando en el diálogo
    
    self.numberLoadings=0;          //Cuenta el número de loadings para mostrar el gif
    self.saving=false;              //Indica si está guardando, para no repetir el proceso
    self.creatingStep=false;        //Indica si está creando un paso, para no repetir el proceso
    self.deletingStep=false;        //Indica si está borrando un paso, para no repetir el proceso
    self.instructionStep=false;     //Indica si está actualizando la instrucción un paso, para no repetir el proceso
    self.loading=false;             //Indica si está cargando, para no repetir el proceso
    self.autosaveFrequency=0;       //Cada cuantos segundos se autoguarda
    
    self.currentState='passive';    //Estado actual, seleccionado por los botones de estado
    
    self.record='';                 //Se carga el audio grabado para el paso actual, si existe
    
    
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
    self.imagesUrl=self.appUrl+"images/";
    self.mode=self.params.mode;
    self.ajaxUrl=self.appUrl+"index.php/designer/";
    self.activitySet={ //Actual activitySet
        name:"",
        url:""
    };
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
        //Busca el último paso visto
        self.lastStepId=parseInt(self.div.attr("data-last-step-id"));
        //Carga los datos del activity set
        self.activitySet.name=$(".editor_main_space").attr("data-activity-set-name");
        self.activitySet.url=self.appUrl+"protected/data/sets/"+self.activitySet.name+"/";
        
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
        
        //Si está en modo de usuario, carga el id del paso actual
        if(self.mode==="solution"){
            self.currentStep=parseInt(self.divSolution.attr('data-step-id'));
            //Si hay una grabación realizada, la carga
            self.record=self.divSolution.find("#audio_recorded").attr('data-record');
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
        //Ajuste a la grilla
        self.div.find('#toggle_snap').button().change(function() {
            if($(this).is(":checked")) {
                self.div.find(".entity").draggable( "option","grid",[10,10]);
            }else{
                self.div.find(".entity").draggable( "option","grid",[1,1]);
            }
        });
        //Crear un paso
        var addStep=self.div.find('#sections_tree').find('.activity').find('.add_step');
        addStep.click(function(e){
            e.stopPropagation();
            var activity=$(this).closest('.activity');
            var activityId=parseInt(activity.attr("data-activity-id"));
            createStep(activityId,function(err,data){
                if(err||!data.success){
                    self.message("No se puede crear el paso, por favor recargue la página e intente de nuevo.");
                }else{
                    self.message("El paso se ha creado con éxito.");
                    if(activity.hasClass("contracted")){
                        activity.click();
                    }
                    var html=htmlStep(data.stepData);
                    var last=activity.nextAll(".l3-last").first();
                    last.removeClass("l3-last l2-last l1-last");
                    last.after(html);
                    //Reordena los pasos de la actividad
                    reorderSteps(activity);
                    attachStepEvents(self.div.find('#sections_tree').find(".step[data-step-id="+data.stepData.stepId+"]"));
                }
            });
        });
        
        
        var steps=self.div.find('#sections_tree').find('.step');
        steps.each(function(){
            attachStepEvents($(this));
        });
        
        //Busca el último paso visto y lo muestra
        var lastStep=self.div.find('#sections_tree').find('.step[data-step-id="'+self.lastStepId+'"]');
        if(lastStep.length>0){
            var section=self.div.find('#sections_tree').find('.section[data-section-id="'+lastStep.attr("data-section-id")+'"]');
            var version=self.div.find('#sections_tree').find('.version[data-version-id="'+lastStep.attr("data-version-id")+'"]');
            var activity=self.div.find('#sections_tree').find('.activity[data-activity-id="'+lastStep.attr("data-activity-id")+'"]');
            section.click();
            version.click();
            activity.click();
            lastStep.click();
        }
        
        //Configurar el set de actividades
        //Pendiente, por ahora se sube con una entidad de estilos interna
//        self.div.find('.button-config').click(function(){
//            $(htmlConfigActivitySet()).dialog({
//                height:270,
//                modal:true,
//                width:420,
//                open:function(){
//                    
//                    $(this).find(".upload_set_css").css({
//                        height:150,
//                        width: 200
//                    });
//                    $(this).find(".upload_set_css").uploadFile({
//                        url:self.appUrl+"protected/views/designer/upload.php",
//                        fileName:"file",
//                        showStatusAfterSuccess:false,
//                        dragdropWidth:350,
//                        dynamicFormData: function() {
//                            var data ={
//                                activitySetName:self.activitySet.name,
//                                type: "style_set",
//                                extension:"css"
//                            };
//                            return data;
//                        },
//                        onSuccess:function(files,data,xhr){
//                            var response=JSON.parse(data);
//                            self.editingEntity.states['passive'].content='<p class="style_entity" data-file="'+response.file+'">Archivo cargado correctamente</p>';
//                            self.editingEntity.div.attr('data-file',response.file);
//                            if(previous){
//                                $('#'+previous.replace(".","_")).remove();
//                            }
//                        }
//                    });
//                }
//            });
//	});
    };
    
    /**
     * Eventos de la barra de entidades
     */
    function attachEventsBarEntities(){
        self.toolbar.find(".button-basic,.button-dragdrop,.button-list,.button-audio,.button-record,.button-style,.button-check,.button-answers,.button-script").draggable({
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
//        self.toolbar.find("#button-crosswordmapper").click(function(){
//            alert("MAP This");
//        });
        
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
                self.dialogEditEntity.find("#select-optional")[0].selectedIndex = self.editingEntity.optional;
                self.dialogEditEntity.find("#select-optional").change(function(){
                   self.editingEntity.optional = $(this).val() === "false"? 1:0;
                });
                //Si se edita una entidad de estilo, solo se muestra el estado pasivo
                if(self.editingEntity.type==="style"||self.editingEntity.type==="audio"||self.editingEntity.type==="script"){
                    self.dialogEditEntity.find(".state_buttons").find(".passive").hide();
                    self.dialogEditEntity.find(".state_buttons").find(".wrong").hide();
                    self.dialogEditEntity.find(".state_buttons").find(".right").hide();
                    self.dialogEditEntity.find(".copy_passive").hide();
                }else{
                    self.dialogEditEntity.find(".state_buttons").find(".passive").show();
                    self.dialogEditEntity.find(".state_buttons").find(".wrong").show();
                    self.dialogEditEntity.find(".state_buttons").find(".right").show();
                    self.dialogEditEntity.find(".copy_passive").show();
                }
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
                        "save table contextmenu directionality template paste textcolor colorpicker jbimages",
			"image"
                    ],
                    toolbar: "sizeselect bold italic textcolor forecolor backcolor fontselect fontsizeselect |"+
                            " searchreplace wordcount fullscreen |"+
                            " autolink link image media lists preview spellchecker table | jbimages code |" +
                            " undo redo | styleselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent |"+
                            " insert_input insert_checkbox insert_radio insert_select_box",
                    menubar : false,
		    image_advtab: true,
                    oninit:function(){
                        tinyMCE.activeEditor.setContent(state.content);
                        //Guarda el estado en el atributo data-val de los elementos en el editor
                        var iContent=$('#text_content_ifr').contents().find("#tinymce");
                        attachEventsDataValueAttribute(iContent);
                    },
                    setup:function(ed){
                        ed.addButton('insert_input', {
                            title : 'Insertar caja de texto',
                            image : self.imagesUrl+'editor/form_input_text.png',
                            onclick : function() {
                                // Add you own code to execute something on click
                                ed.focus();
                                ed.selection.setContent('<input type="text" />');
                            }
                        });
                        ed.addButton('insert_checkbox', {
                            title : 'Insertar cuadro de chequeo',
                            image : self.imagesUrl+'editor/form_checkbox.png',
                            onclick : function() {
                                // Add you own code to execute something on click
                                ed.focus();
                                ed.selection.setContent('<input type="checkbox" />');
                            }
                        });
                        ed.addButton('insert_radio', {
                            title : 'Insertar radio button',
                            image : self.imagesUrl+'editor/form_radio.png',
                            onclick : function() {
                                // Add you own code to execute something on click
                                ed.focus();
                                ed.selection.setContent('<input type="radio" name="radio'+self.editingEntity.id+'"/>');
                            }
                        });
                        ed.addButton('insert_select_box', {
                            title : 'Insertar caja de opciones',
                            image : self.imagesUrl+'editor/form_select_box.png',
                            onclick : function() {
                                // Add you own code to execute something on click
                                ed.focus();
                                ed.selection.setContent('<select><option selected="selected" value="1">Option 1</option>\n<option value="2">Option 2</option> </select><br>');
                            }
                        });
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
        try{
            entity.div.draggable("destroy");
        }catch(e){};
        entity.div.attr("title","Doble click para editar el contenido");
        entity.div.css("position","relative");
        //Elimina el z-index para poder editar
        entity.div.css('z-index',0);
        self.editingEntity.div.dblclick(function(){
            if(self.editingEntity.type!=="style"&&self.editingEntity.type!=="script"){
                attachEventsEditingEntity(stateName);
            }
        });
        //Si es una página de estilos o de audio se muestra el cargador de archivos
        //Carga los estilos en entity.draw()
        if(self.editingEntity.type==="style"||self.editingEntity.type==="audio"||self.editingEntity.type==="script"){
            //Si tenía cargada algúna hoja de estilos, se reemplaza
            var previous=false;
            if(self.editingEntity.getState('passive').content!==""){
                var previousContent=$(self.editingEntity.getState('passive').content);
                previous=previousContent.attr('data-file');
            }
            var type='';
            var extension='';
            var className='';
            if(self.editingEntity.type==="style"){
                type='style';
                extension='css';
                className='style_entity';
            }else if(self.editingEntity.type==="audio"){
                type='audio';
                extension='wav';
                className='audio_entity';
            }
            else if(self.editingEntity.type==="script"){
                type='script';
                extension='js';
                className='script_entity';
            }
//            self.editingEntity.div.text("Subir archivos");
            self.editingEntity.div.uploadFile({
                url:self.appUrl+"protected/views/designer/upload.php",
                fileName:"file",
                dynamicFormData: function() {
                    var data ={
                        activitySetName:self.activitySet.name,
                        type: type,
                        entity:entity.id,
                        extension:extension,
                        previous:previous
                    };
                    return data;
                },
                onSuccess:function(files,data,xhr){
                    var response=JSON.parse(data);
                    self.editingEntity.states['passive'].content='<p class="'+className+'" data-file="'+response.file+'">Archivo cargado correctamente</p>';
                    self.editingEntity.div.attr('data-file',response.file);
                    if(previous){
                        $('#'+previous.replace(".","_")).remove();
                    }
                }
            });
        }
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
        container.find('input:checkbox').change(function(){
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
                $(this).attr("data-element-id","entityElement_"+self.guid());
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
                $(this).attr("data-element-id","entityElement_"+self.guid());
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
                $(this).attr("data-element-id","entityElement_"+self.guid());
            }
            $(this).addClass("entityElement inputCheckbox");
        });
        //Se procesan los elementos select
        contentElements.find("select").each(function(){
            $(this).attr("data-val",$(this).val());
            
            if($.trim($(this).attr("data-element-id"))===""){
                $(this).attr("data-element-id","entityElement_"+self.guid());
            }
            $(this).addClass("entityElement inputSelect");
        });
        
        //TODO: Cargar este valor de la entidad
        var importanceEntity=10;
        //Da la misma importancia a todos los elementos
        contentElements.find('.entityElement').each(function(){
            $(this).attr("data-entity-importance",importanceEntity);
            $(this).attr("data-element-importance",1);
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
        self.divSolution.find('.check').click(function(){
            
            // Ejecuta esta función que está dentro de los JS agregados antes de calificar
            try{
                executeExternalJS();
            }
            catch (err){};
            
            var correctAll=true;
            //Valores para calificar
            var T=100;                                  //Máximo valor para un ejercicio
            var n=0;                                    //Cantidad de entidades con objetos calificables en el ejercicio
            var r=10;                                   //Máximo valor de importancia para una entidad
            var x=0;                                    //Multiplicador para mapeo
            var totalExercise=0;                        //Suma de calificación del ejercicio
            var mappedResult=0;                         //Resultado luego de ser mapeado de 0 a T
            
            for(var i in self.workspace.entities){
                var correct=true;
                var entity=self.workspace.entities[i];
                var right=entity.getState('right');
                
                if(entity.optional === "1"){
                     continue;
                }
                
                
                //Pone el estado resuelto en el DOM
                solutionDiv.append('<div id="entitySolution'+entity.id+'" class="entitySolution '+entity.type+'">'+right.content+'</div>');
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
                        entity.draw("wrong");
                    }
                    //Si es una entidad calificable suma n
                    n++;
                }
                
                //Califica el orden si es una entidad de lista
                if(solutionEntity.hasClass("list")){
                    var listElement=userResponse.find("#entity"+entity.id);
                    var orderRight=listElement.attr('data-order_right').split(',');
                    var orderUser=listElement.attr('data-order_passive').split(',');
                    correct=true;
                    for(var i in orderRight){
                        orderRight[i]=parseInt(orderRight[i]);
                        orderUser[i]=parseInt(orderUser[i]);
                        if(orderRight[i]!==orderUser[i]){
                            correct=false;
                            entity.draw("wrong");
                        }
                    }
                    if(correct){
                        totalExercise+=entity.weight;
                    }
                    //Si es una entidad calificable suma n
                    n++;
                }
                
                //Verifica el # de elementos calificables
                n += solutionEntity.find(":text").length;
                n += solutionEntity.find(":checkbox").length;
                n += solutionEntity.find("select").length;
                
                var names = [];
                var namesLength = [];
                if(solutionEntity.find(":radio").length>0){
                    solutionEntity.find(":radio").each(function(){
                       var name = $(this).attr("name");
                       var index = names.indexOf(name);
                        if(index >= 0){
                            namesLength[index]++;
                        }else{
                            names.push(name);
                            namesLength.push(1);
                            n++;
                        }
                    });
                }
                //Califica los elementos dentro de la entidad
                var elementImportances=0;
                solutionEntity.find('.entityElement').each(function(){
                    var solutionElement=$(this);
                    var answerElement=userResponse.find('[data-element-id="'+solutionElement.attr('data-element-id')+'"]');
                    var elementQualification=qualifyElements(solutionElement,answerElement);
                    if(solutionElement.is('input:radio')){
                        var name = $(this).attr("name");
                        var index = names.indexOf(name);
                        if(elementQualification){
                            namesLength[index] = 0;
                        }else{
                            //resetInputElement(answerElement);
                            if(namesLength[index] === 0 || --namesLength[index] > 0){
                                return;
                            }
                        }
                    }
                    correct=correct&&elementQualification;
                    //Suma la calilficación
                    if(elementQualification){
                        elementImportances+=parseFloat(answerElement.attr("data-element-importance"));
                    }else{
                        resetInputElement(answerElement);
                    }
                });
                totalExercise+=elementImportances*entity.weight;
                if(correct){
//                    entity.draw("right");
                }else{
//                    entity.draw("wrong");
                    correctAll=false;
                }
            }
            //Calcula la variable para mapeo
            x=T/(n*r);
            //Calcula el resultado mapeado
            mappedResult=x*totalExercise;
            if(isNaN(mappedResult)){
                mappedResult=0;
            }
            //Si no hay entidades calificables, se retorna el máximo puntaje
            if(n<=0){
                mappedResult=T;
            }
            var points=parseInt(mappedResult);
            if(correctAll){
                console.debug("Gained points: "+points);
            }
            //Almacena el resultado actual
            savePoints(self.currentStep,points);
            self.divSolution.find('#totalPoints').text(points);
            solutionDiv.empty();
            self.divSolution.find('.answers').css("display","block");
        });
        self.divSolution.find('.answers').css("display","none");
        self.divSolution.find('.answers').click(function(){
            for(var i in self.workspace.entities){
                var entity=self.workspace.entities[i];
                if(entity.optional === "1"){
                     continue;
                }
                entity.draw("right");
            }
            alert("Activity solved with help");
        });
    };
    
    /**
     * Califica si la respuesta dada a un elemento es correcta
     * @param {element} solution Elemento con la respuesta correcta
     * @param {element} answer Elemento con la respuesta dada por el estudiante
     * @returns {bool} Verdadero si la respuesta es correcta
     */
    function qualifyElements(solution,answer){
        try{   
            //Revisa los input:text
            if(solution.is('input:text')){
                if(solution.attr("data-val").toLowerCase()===$.trim(answer.val().toLowerCase())){
                    return true;
                }
            }
            //Revisa los input:radio
            if(solution.is('input:radio')){
                if(answer.attr("data-val") === "true"){
                    if(solution.attr("data-val")===answer.attr("data-val")){
                        return true;
                    }
                }
            }
            //Revisa los input:checkbox
            if(solution.is('input:checkbox')){
                if(solution.attr("data-val")===answer.attr("data-val")){
                    return true;
                }
            }
            //Revisa los select
            if(solution.is('select')){
                if(solution.attr("data-val")===answer.val()){
                    return true;
                }
            }
        }catch(e){
            return false;
        }
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
     * Deuelve al estado inicial el elemento de entrada que se le pase
     * @param {object} bladladladlallakdl
     */
    function resetInputElement(elem){
        if(elem.is('input:text')){
            elem.val("");
        }
        if(elem.is("input:radio")){
            elem.removeAttr("checked");
        }
        if(elem.is("input:checkbox")){
            elem.removeAttr("checked");
        }
        if(elem.is("select")){
            elem.removeAttr("data-val");
            elem[0].selectedIndex = 0;
        }
    }
    
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

    /**
     * Guarda el puntaje del usuario para el paso
     * @param {id} stepId Id del paso actual
     * @param {int} points Puntos obtenidos en el paso
     * @param {function} callback Function to return the response
     */
    function savePoints(stepId,points,callback){
        if(!self.savingPoints){
            self.savingPoints=true;
            editor.showLoading();
            $.ajax({
                url: self.ajaxUrl+'savePointsByAjax',
                type: "POST",
                data:{
                    stepId:stepId,
                    points:points
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
                self.savingPoints=false;
            });
        }
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
    self.save=function(callback){
        var entities=self.workspace.objectify();
        if(entities.length>0){
            saveEntities(self.currentStep.stepId,entities,function(err){
                if(err){
                    self.message("No se pueden guardar los cambios, por favor intente más tarde.");
                    editor.hideLoading();
                    self.saving=false;
                }else{
                    if(callback){callback();};
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
                    //Carga los eventos generales
                    attachEventsSolutionMode();
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
     * Crea un paso en una actividad usando Ajax
     * @param {id} activityId Id de la actividad
     * @param {function} callback Function to return the response
     */
    function createStep(activityId,callback){
        if(!self.creatingStep){
            self.creatingStep=true;
            editor.showLoading();
            $.ajax({
                url: self.ajaxUrl+'createStepByAjax',
                type: "POST",
                data:{
                    activityId:activityId
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
                self.creatingStep=false;
            });
        }
    };
    
    /**
     * Borra un paso de una actividad usando Ajax
     * @param {id} stepId Id del paso
     * @param {function} callback Function to return the response
     */
    function deleteStep(stepId,callback){
        if(!self.deletingStep){
            self.deletingStep=true;
            editor.showLoading();
            $.ajax({
                url: self.ajaxUrl+'deleteStepByAjax',
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
                self.deletingStep=false;
            });
        }
    };
    
    /**
     * Actualiza la instrucción de un paso
     * @param {id} stepId Id del paso
     * @param {string} name Nombre del paso
     * @param {string} instruction Instrucción del paso
     * @param {function} callback Function to return the response
     */
    function updateStepData(stepId,name,instruction,callback){
        if(!self.instructionStep){
            self.instructionStep=true;
            editor.showLoading();
            $.ajax({
                url: self.ajaxUrl+'updateStepDataByAjax',
                type: "POST",
                data:{
                    stepId:stepId,
                    name:name,
                    instruction:instruction
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
                self.instructionStep=false;
            });
        }
    };
    
    /**
     * Reordena los id de los pasos
     * @param {element} activity Elemento de actividad
     */
    function reorderSteps(activity){
        var counter=1;
        var next=activity.nextUntil(".l1");
        next.each(function(){
            $(this).find(".name").text("Paso "+counter);
            counter++;
        });
    };
    
    /**
     * Asocia los eventos a un botón de paso de la barra de bavegación
     * @param {element} stepElement Elemento de paso en la barra de navegación
     */
    function attachStepEvents(stepElement){
        //Eliminar un paso
        var removeStep=stepElement.find('.delete');
        removeStep.click(function(e){
            e.stopPropagation();
            var stepId=parseInt(stepElement.attr("data-step-id"));
            var activity=stepElement.prevUntil('.version');
            var next=activity.nextUntil(".l1");
            if(next.length<=1){
                self.message("Cada actividad debe tener al menos un paso.");
            }else{
                $('<div title="Borrar paso"><p>¿Borrar el paso seleccionado?</p></div>').dialog({
                    modal:true,
                    buttons:{
                        "Cancelar":function(){
                            $(this).dialog("close");
                        },
                        "Aceptar":function(){
                            $(this).dialog("close");
                            deleteStep(stepId,function(err){
                                if(err){
                                    self.message("No se puede eliminar el paso, por favor recargue la página e intente de nuevo.");
                                }else{
                                    stepElement.prev(".step").addClass("l3-last l2-last l1-last");
                                    stepElement.remove();
                                    //Reordena los pasos de la actividad
                                    reorderSteps(activity);
                                }
                            });
                        }
                    }
                });
            }
        });
        
        //Cambiar los datos del paso
        var stepDataButton=stepElement.find('.instruction');
        stepDataButton.click(function(e){
            e.stopPropagation();
            var stepId=parseInt(stepElement.attr("data-step-id"));
            $('<div title="Datos del paso"><p>'+
                    '<label for="nameInput">Nombre del paso</label>'+
                    '<input id="nameInput" type="text" placeholder="Nombre para el paso" value="'+stepElement.attr("data-step-name")+'" />'+
                    '<label for="intructionInput">Instrucción del paso</label>'+
                    '<textarea id="intructionInput" type="text" placeholder="Escriba la instrucción para el paso">'+stepElement.attr("data-instruction")+'</textarea>'+
                '</p>'+
            '</div>').dialog({
                modal:true,
                width:300,
                buttons:{
                    "Cancelar":function(){
                        $(this).dialog("close");
                    },
                    "Aceptar":function(){
                        $(this).dialog("close");
                        var name=$(this).find("#nameInput").val();
                        var instruction=$(this).find("#intructionInput").val();
                        updateStepData(stepId,name,instruction,function(err){
                            if(err){
                                self.message("No se puede actualizar la instrucción, por favor recargue la página e intente de nuevo.");
                            }else{
                                stepElement.attr("data-name",name);
                                stepElement.find(".name").text(name);
                                stepElement.attr("data-instruction",instruction);
                            }
                        });
                    }
                }
            });
        });
        
        //Click en el elemento
        stepElement.click(function(){
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
     * Guarda una grabación de un paso para un usuario
     * @param {id} stepId Id del paso actual
     * @param {string} audio Audio capturado or el usuario
     * @param {function} callback Function to return the response
     */
    self.saveRecord=function(audio,callback){
        if(!self.saving){
            self.saving=true;
            editor.showLoading();
            $.ajax({
                url: self.ajaxUrl+'saveRecordByAjax',
                type: "POST",
                data:{
                    stepId:self.currentStep,
                    audio:audio
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
     * Elimina archivos, se usa para eliminar los que están asociados a las 
     * entidades. Las rutas deben ser relativas al directorio del set de 
     * actividades dentro del directorio /protected/data/
     * @param {string} filename Nombre y ruta del archivo a eliminar
     * @param {function} callback Función a la que se retorna el resultado
     * @returns {bool} True si elimina el archivo, False en otro caso
     */
    self.deleteFile=function(filename,callback){
        editor.showLoading();
        $.ajax({
            url:self.appUrl+"protected/views/designer/deleteFile.php",
            type: "POST",
            data:{
                activitySetName:self.activitySet.name,
                filename:filename
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
     * Retorna el html de un paso
     * @param {object} stepData Datos del paso para construir el HTML
     * @returns {String} html del paso para los datos pasados
     */
    function htmlStep(stepData){
        var letter = String.fromCharCode(96+stepData.countActiviySets);
        return '<tr class="step l4 contracted  l3-last l2-last l1-last" data-level="4" id="level_4_'+letter+'" '+
            'data-step-id="'+stepData.stepId+'" '+
            'data-step-name="'+stepData.stepName+'" '+
            'data-activity-id="'+stepData.activityId+'" '+
            'data-activity-name="'+stepData.activityName+'" '+
            'data-version-id="'+stepData.versionId+'" '+
            'data-version-name="'+stepData.versionName+'" '+
            'data-section-name="'+stepData.sectionName+'" '+
            'data-activity-set-id="'+stepData.activitySetId+'" '+
            'data-activity-set-title="'+stepData.activitySetTitle+'" '+
            'data-instruction="'+stepData.instruction+'" '+
        '>'+
            '<td>'+
                '<div class="control">'+
                    '<div class="line level1">'+
                        '<div class="vert"></div>'+
                        '<div class="horz"></div>'+
                    '</div>'+
                    '<div class="line level2">'+
                        '<div class="vert"></div>'+
                        '<div class="horz"></div>'+
                    '</div>'+
                    '<div class="line level3">'+
                        '<div class="vert"></div>'+
                        '<div class="horz"></div>'+
                    '</div>'+
                    '<div class="line level4">'+
                        '<div class="vert"></div>'+
                        '<div class="horz"></div>'+
                    '</div>'+
                '</div>'+
                '<div class="expander"></div>'+
                '<div class="label">'+
                    '<div class="name">'+stepData.stepName+'</div>'+
                    '<div class="navbutton instruction" title="Cambiar los datos de este paso">i</div>'+
                    '<div class="navbutton delete" title="Eliminar este paso">x</div>'+
                '</div>'+
            '</td>'+
        '</tr>';
    };
    
    /**
     * 
     * @returns {String}
     */
    function htmlConfigActivitySet(){
        return '<div title="Configurando set de actividades">'+
                '<div class="upload_set_css">Subir hoja de estilos</div>'+
            '</div>';
    };
    
    /**
     * Retorna un ID aleatorio para los elementos
     * @returns {String} Id aleatorio
     */
    self.guid=function() {
        function s4() {
            return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
        }
        return s4() + s4() + '_' + s4() + '_' + s4() + '_' +s4() + '_' + s4() + s4() + s4();
    }
};
