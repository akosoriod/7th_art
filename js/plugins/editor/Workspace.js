/* 
 * Pseudo-Clase para el manejo del Workspace en 7th @rt
 * Universidad Nacional de Colombia
 * 7th @rt The Power & Magic of Films to Learn English
 * 7thart_bog@unal.edu.co
 * 2015
 * @param {object} params Object with the class parameters
 */
var Workspace = function(params){
    /**************************************************************************/
    /******************************* ATTRIBUTES *******************************/
    /**************************************************************************/
    var self = this;
    
    /***** Manejo de entidades *****/
    
    /**
     * Cuenta las entidades temporales creadas hasta el momento. A cada nueva entidad 
     * le asigna un id negativo, así se reconoce como una entidad temporal a la que
     * se le asigna un id positivo cuando se almacena en la base de datos.
     * @type int
     */
    self.tempEntities=0;
    
    /**
     * Zindex de la última entdad insertada en el workspace. Solo se asigna a una
     * entidad que no tenga zindex definido.
     * @type int
     */
    self.currentZindex=0;
    
    /**
     * Mantiene un registro de las entidades droppable con el mayor zindex, sirve para
     * identificar cual es la entidad en la que se agregará la entidad que se 
     * está arrastrando.
     * @type Entity[]
     */
    self.droppableStack={};
    
    /**************************************************************************/
    /********************* CONFIGURATION AND CONSTRUCTOR **********************/
    /**************************************************************************/
    //Mix the user parameters with the default parameters
    var def = {
        div:"#workspace",
        height:600,
        logHistory:true,
        saveHistory:function(){},
        width:1040,
        entities:{}
    };
    var options = $.extend(def, params);
    self.div=$(options.div);
    self.height=options.height;    
    self.logHistory=options.logHistory;
    self.saveHistory=options.saveHistory;
    self.entities=options.entities;
    self.width=options.width;
    /**
     * Constructor Method 
     */
    var Workspace = function() {
        attachEvents();
    }();
    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
    /**
     * Agrega una entidad al Workspace, si tiene un id, la actualiza.
     * @param {Entity} entity Entidad que se quiere agregar al workspace
     * @return {Entity} Entidad creada o actualizada
     */
    self.addEntity=function(entity){
        var obtainedEntity=self.getEntity(entity.id);
        if(!obtainedEntity){
            if(entity.id===false){
                //Usa un id temporal para la entidad
                self.tempEntities++;
                self.currentZindex++;
                entity.id=-self.tempEntities;
                entity.zindex=self.currentZindex;
                entity.setZindex(self.currentZindex);
            }else{
                if(entity.id<0&&Math.abs(entity.id)>self.tempEntities){
                    self.tempEntities=Math.abs(entity.id);
                }
                if(entity.getZindex()>self.currentZindex){
                    self.currentZindex=entity.getZindex();
                }
                //Si está en modo edición, cambia las url
                if(editor.mode==="solution"){
                    for(var i in entity.states){
                        entity.states[i].content=entity.content=util.replace('src="../../','src="'+editor.appUrl,entity.states[i].content);
                    }
                }
            }
            self.entities[entity.id]=entity;
        }else{
            self.updateEntity(entity);
        }
        entity.workspace=self;
        entity.draw();
        if(self.logHistory){self.saveHistory();}
        return entity;
    };
    
    /**
     * Retorna una entidad a partir de su id, si no existe en el Workspace, retorna
     * false
     * @param {int} entityId Identificador de la entidad
     * @returns {Mixed} Entidad a partir del id, Falso si no lo encuentra
     */
    self.getEntity=function(entityId){
        var output=false;
        for(var i in self.entities){
            if(self.entities[i].id===entityId){
                output=self.entities[i];
                break;
            }
        }
        return output;
    };
    
    /**
     * Actualiza una entidad
     * @param {Entity} entity Entidad a actualizar, debe tener un id
     * @returns {Entity} Entidad actualizada
     */
    self.updateEntity=function(entity){
        var output=false;
        for(var i in self.entities){
            if(self.entities[i].id===entity.id){
                self.entities[i]=entity;
                output=self.entities[i];
                break;
            }
        }
        if(self.logHistory){self.saveHistory();}
        return output;
    };
    
    /**
     * Elimina una entidad a partir de su id
     * @param {int} entityId Identificador de la entidad
     */
    self.removeEntity=function(entityId){
        var entity=self.entities[entityId];
        //Elimina la entidad de las entidades o subentidades 
        for(var i in self.entities){
            self.entities[i].removeEntityRecursive(entity);
        }
        //Elimina las subentidades de la entidad a eliminar
        for(var j in entity.entities){
            self.removeEntity(entity.entities[j].id);
        }
        //Elimina la entidad
        self.entities[entityId].deleteHtml();
        delete self.entities[entityId];
        if(self.logHistory){self.saveHistory();}
        //Elimina la hoja de estilos de la entidad (si existe)
        if(entity.type==="style"){
            var file="";
            //Se elimina el archivo del servidor
            if(entity.getState('passive').content!==""){
                var content=$(entity.getState('passive').content);
                file=content.attr('data-file');
                editor.deleteFile('css/'+file);
            }
            $('#'+file.replace(".","_")).remove();
        }
        //Elimina el archivo de scripts de la entidad (si existe)
        if(entity.type==="script"){
            var file="";
            //Se elimina el archivo del servidor
            if(entity.getState('passive').content!==""){
                var content=$(entity.getState('passive').content);
                file=content.attr('data-file');
                editor.deleteFile('js/'+file);
            }
            $('#'+file.replace(".","_")).remove();
        }
    };
    
    /**
     * Retorna la cantidad de entidades
     * @returns {int} cantidad de entidades en el workspace
     */
    self.numberEntities=function(){
        return self.entities.length;
    };
    
    /**
     * Redibuja todas las entidades
     * @returns {undefined}
     */
    self.redraw=function(){
        for(var i in self.entities){
            self.entities[i].draw();
        }
    };
    
    /**
     * Reinicia el Workspace, elimina todas las entidades del workspace.
     */
    self.clear=function(){
        self.tempEntities=0;
        self.currentZindex=0;
        self.droppableStack={};
        self.entities={};
        self.div.empty();
    };
    
    /**
     * Muestra todas las entidades en el estado seleccionado
     * @param {string} stateName Nombre del estado que se quiere mostrar
     */
    self.showState=function(stateName){
        for(var i in self.entities){
            self.entities[i].draw(stateName);
        }
        //Si está en modo respuesta, asigna eventos para controlar la calificación
        if(editor.mode==="solution"){
            window.setTimeout(function(){
                self.attachEventsSolutionMode();
            }, 500);
        }
    };
    /**
     * Asigna los eventos a los elementos insertados en modo solución para
     * hacer la calificación
     */
    self.attachEventsSolutionMode=function(){
        //Guarda el estado de los input:radio
        self.div.find("input:radio").change(function(){
            var radios=self.div.find('input:radio[name="'+$(this).attr('name')+'"]');
            radios.each(function(){
                $(this).attr("data-val",false);
                $(this).removeAttr("checked");
            });
            $(this).attr("data-val",true);
            $(this).attr("checked","checked");
        });
        //Guarda el estado de los input:checkbox
        self.div.find("input:checkbox").change(function(){
            if($(this).is(":checked")){
                $(this).attr("data-val",true);
                $(this).attr("checked","checked");
            }else{
                $(this).attr("data-val",false);
                $(this).removeAttr("checked");
            }
        });
        
        
        self.div.find(".entity").each(function(){
            var entity=$(this);
            //Si encuentra una entidad de tipo drag and drop, la activa
            if(entity.hasClass("dragdrop")){
                entity.draggable({
                    containment: self.container,
                    grid: [1,1],
                    opacity: 0.4,
                    scroll: false,
                    zIndex: 10000
                });
            }
            //Si encuentra una entidad de tipo grabación, la activa
            if(entity.hasClass("record")){
//                entity.draggable({
//                    containment: self.container,
//                    cursor: "move",
//                    grid: [10,10],
//                    opacity: 0.4,
//                    scroll: false,
//                    zIndex: 10000
//                });
            }
        });        
    };
    
    
    /**************************************************************************/
    /******************************** GUI METHODS *****************************/
    /**************************************************************************/
    /**
     * Crea la estructura del workspace y lo hace droppable
     */
    function attachEvents(){
        if(editor.mode==="edition"){
            self.div.droppable({
                accept: ".button",
                drop: function( event, ui ) {
                    if(editor.currentStep){
                        var create=true;
                        var displacement=self.div.offset();
                        var type="";
                        var content="";
                        var size={
                            height:160,
                            width:100
                        };
                        var parameters={};
                        if(ui.draggable.hasClass("button-basic")){
                            type="basic";
                        }else if(ui.draggable.hasClass("button-dragdrop")){
                            type="dragdrop";
                        }else if(ui.draggable.hasClass("button-audio")){
                            type="audio";
                            size={
                                height:50,
                                width:300
                            };
                        }else if(ui.draggable.hasClass("button-record")){
                            content="Entidad de grabación. No editable.";
                            type="record";
                            size={
                                height:50,
                                width:300
                            };
                        }else if(ui.draggable.hasClass("button-style")){
                            type="style";
                            size={
                                height:50,
                                width:300
                            };
                        }else if(ui.draggable.hasClass("button-script")){
                            type="script";
                            size={
                                height:50,
                                width:300
                            };
                        }else if(ui.draggable.hasClass("button-check")){
                            type="check";
                            size={
                                height:50,
                                width:50
                            };
                        }else if(ui.draggable.hasClass("button-answers")){
                            type="answers";
                            size={
                                height:50,
                                width:50
                            };
                        }else if(ui.draggable.hasClass("button-list")){
                            var elements=4;
                            create=false;
                            $('#list_elements').dialog({
                                modal:true,
                                buttons:{
                                    "Cancelar":function(){$(this).dialog("close");},
                                    "Aceptar":function(){
                                        elements=parseInt($(this).find('.selection').val());
                                        var randomId=editor.guid();
                                        var order=[];
                                        for(var k=0;k<elements;k++){
                                            order[k]=k+1;
                                        }
                                        var entity=new Entity({
                                            content:content,type:"list",
                                            pos:{left:ui.position.left-displacement.left,top:ui.position.top-displacement.top},
                                            size:{height:350,width:250},
                                            parameters:{
                                                elements:elements,
                                                match_id:randomId,
                                                order_passive:order,
                                                order_right:order,
                                                order_wrong:order
                                            }
                                        });
                                        //Se crea la entidad lista
                                        var entityList=self.addEntity(entity);
                                        //Para cada elemento se crea una entidad y se agrega
                                        for(var i=0;i<elements;i++){
                                            var subentity=new Entity({
                                                content:content,type:"list_element",
                                                pos:{left:0,top:0},
                                                size:{height:100,width:100},
                                                parameters:{
                                                    parent_element_id:(i+1),
                                                    match_id:randomId
                                                }
                                            });
                                            entityList.addEntity(self.addEntity(subentity));
                                        }
                                        $(this).dialog("close");
                                    }
                                }
                            });
                        }
                        
                        var entity=new Entity({
                            content:content,
                            type:type,
                            pos:{
                                left:ui.position.left-displacement.left,
                                top:ui.position.top-displacement.top
                            },
                            size:size
                        });
                        if(create){
                            self.addEntity(entity);
                        }
                        //Si es una entidad de estilo o script, se guarda todo y se recarga 
                        //para almacenar los estilos con nombre.
                        if(entity.type==="style"||entity.type==="script"){
                            editor.save(function(){
                                editor.load();
                            });
                        }
                    }else{
                        editor.message("Seleccione un paso en una sección para iniciar la edición.");
                    }
                }
            });
        }
    };
    
    /**
     * Retorna el droppable de self.maxDroppableStack={}; con el mayor zindex
     * @return {Entity} Entidad dropable con el mayor zindex
     */
    self.maxDroppableStack=function(){
        var maxZindex=0;
        var dropable=false;
        for(var i in self.droppableStack){
            if(self.droppableStack[i].getZindex()>maxZindex){
                dropable=self.droppableStack[i];
            }
        }
        return dropable;
    };
    
    /**************************************************************************/
    /****************************** OTHER METHODS *****************************/
    /**************************************************************************/
    
    /**
     * Actualiza una entidad a partir de otra pasada como parámetro
     * @param {Entity} entity Entidad fuente con la que se actualizará la entidad
     *                        debe tener el id de la entidad objetivo
     */
    self.updateEntityAfterEditing=function(entity){
        self.entities[entity.id].updateAfterEditing(entity);
        self.entities[entity.id].draw();
        if(self.logHistory){self.saveHistory();}
    };
    
    /**
     * Retorna las entidades del workspace en texto
     */
    self.objectify=function(){
        var entities=[];
        for(var i in self.entities){
            entities.push(self.entities[i].objectify());
        }
        return entities;
    };
    
    /**
     * Retorna el workspace a un estado anterior a partir de una lista de entidades
     * generadas con self.objectify()
     * @param {object[]} entities Array de entidades creadas con .objectify()
     */
    self.deobjectify=function(entities){
        for(var i in entities){
            var entity=new Entity();
            entity.deobjectify(entities[i]);
            self.addEntity(entity);
        }
        //Se asocian de nuevo las entidades hijas
        for(var i in self.entities){
            self.entities[i].entities={};
            for(var j in entities){
                var storedEntity=entities[j];
                if(storedEntity.id===self.entities[i].id){
                    for(var k in storedEntity.entities){
                        var subentity=self.getEntity(storedEntity.entities[k]);
                        self.entities[i].addEntity(subentity);
                    }
                }
            }
        }
        //Si está en modo respuesta, asigna eventos para controlar la calificación
        if(editor.mode==="solution"){
            self.attachEventsSolutionMode();
        }
    };
    
};