/* 
 * Pseudo-Clase para el manejo del Entidades en 7th @rt
 * Universidad Nacional de Colombia
 * 7th @rt The Power & Magic of Films to Learn English
 * 7thart_bog@unal.edu.co
 * 2015
 * @param {object} params Object with the class parameters
 */
var Entity = function(params){
    /**************************************************************************/
    /******************************* ATTRIBUTES *******************************/
    /**************************************************************************/
    var self = this;
    
    self.workspace=false;           //Workspace en el que está la entidad
    self.container=false;           //Elemento contenedor del div de la entidad (div del workspace)
    self.div=false;                 //Elemento de la entidad
    self.statesFixedPos=true;       //Si la posición de los estados cambia con el del estado principal
    self.statesFixedSize=true;      //Si el tamaño de los estados cambia con el del estado principal
    
    self.parent=false;
    
    /**************************************************************************/
    /********************* CONFIGURATION AND CONSTRUCTOR **********************/
    /**************************************************************************/
    //Mix the user parameters with the default parameters
    var def = {
        countable:true,
        id:false,
        optional:false,
        entities:{},
        type:'basic',
        weight:10,
        parameters:{},
        parent:false
    };
    var options = $.extend(def, params);
    self.id=options.id;
    self.optional=options.optional;     //Si se debe resolver para el éxito del ejercicio
    self.countable=options.countable;   //Si se cuenta dentro del cálculo del total de ejercicios
    self.type=options.type;             //Tipo de entidad: single, dragdrop, ... ver workspace.attachEvents()
    self.weight=options.weight;         //Peso de la entidad en el total de ejercicios
    self.entities=options.entities;
    self.parameters=options.parameters;
    self.parent=options.parent;
    /**
     * Constructor Method 
     */
    var Entity = function() {
        if(!options.pos){
            options.pos={left:0,top:0};
        }
        if(!options.size){
            options.size={height:160,width:100};
        }
        if(!options.content){
            options.content="";
        }
        //Si el contenido es vacío y es una lista, crea un contenido inicial
        if(options.content===""&&self.type==="list"){
            options.content=getHtmlList(options.parameters.elements);
        }
        self.states={
            /* Define los defaults para el estado pasivo (estado de la entidad en el editor) */
            'passive':new State({
                type:'passive',
                pos:{left:options.pos.left,top:options.pos.top},
                size:{height:options.size.height,width:options.size.width},
                content:options.content
            }),
            'active':new State({
                type:'active',
                pos:{left:options.pos.left,top:options.pos.top},
                size:{height:options.size.height,width:options.size.width},
                content:options.content
            }),
            'solved':new State({
                type:'solved',
                pos:{left:options.pos.left,top:options.pos.top},
                size:{height:options.size.height,width:options.size.width},
                content:options.content
            }),
            'right':new State({
                type:'right',
                pos:{left:options.pos.left,top:options.pos.top},
                size:{height:options.size.height,width:options.size.width},
                content:options.content
            }),
            'wrong':new State({
                type:'wrong',
                pos:{left:options.pos.left,top:options.pos.top},
                size:{height:options.size.height,width:options.size.width},
                content:options.content
            })
        };
        if(editor.mode==='solution'){
            attachModeSolutionEvents();
        }
    }();
    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
    
    /**
     * Retorna un estado de la entidad a partir de su nombre
     * @param {string} stateName Nombre del estado a retornar
     * @returns {State} Estado de la entidad
     */
    self.getState=function(stateName){
        return self.states[stateName];
    };    
    
    
    /**
     * Asocia los eventos básicos a la entidad
     */
    self.attachEvents=function(){
        attachEvents();
    };
    function attachEvents(){
        if(editor.mode==="edition"){
            if(self.type!=='list_element'){
                self.div.draggable({
                    containment: self.container,
                    cursor: "move",
                    grid: [1,1],
                    opacity: 0.4,
                    scroll: false,
                    zIndex: 10000,
                    stop:function(event,ui){
                        var diffLeft=ui.position.left-ui.originalPosition.left;
                        var diffTop=ui.position.top-ui.originalPosition.top;
                        self.updatePositionByDiff(diffLeft,diffTop,editor.currentState);
                        //Si es una lista, se recorren los subelementos y se redibujan
                        if(self.type==='list'){
                            for(var i in self.workspace.entities){
                                var entity=self.workspace.entities[i];
                                if(entity.type==='list_element'){
                                    if(self.parameters.match_id===entity.parameters.match_id){
                                        entity.draw();
                                    }
                                }
                                
                            }
                        }
                        self.saveHistory();
                    }
                }).resizable({
                    containment: self.container,
                    stop:function(event,ui){
                        var diffHeight=ui.size.height-ui.originalSize.height;
                        var diffWidth=ui.size.width-ui.originalSize.width;
                        self.updateSizeByDiff(diffHeight,diffWidth);
                        self.saveHistory();
                        //Si es una entidad de lista recalcula el tamaño de los elementos
                        var content=self.div.find('.content');
                        var elements=content.find('.listElement');
                        var totalHeight=content.height();
                        var totalWidth=content.width();
                        elements.each(function(){
                            var numberElements=parseInt($(this).attr('data-elements'));
                            $(this).height((totalHeight-numberElements)/numberElements);
                            var entityId=getIdFromElement($(this).find('.entity'));
                            var entity=self.workspace.getEntity(entityId);
                            var passive=entity.getState('passive');
                            var right=entity.getState('right');
                            var wrong=entity.getState('wrong');
                            var size={
                                height:(totalHeight-numberElements)/numberElements,
                                width:totalWidth
                            };
                            passive.size=size;
                            right.size=size;
                            wrong.size=size;
                        });
                    }
                }).droppable({
                    accept: ".entity",
                    hoverClass: "entity-hover",
                    greedy: true,
                    tolerance: "fit",
                    drop: function(e,ui){
                        var entity=self.workspace.getEntity(getIdFromElement(ui.draggable));
                        if(self.id===self.workspace.maxDroppableStack().id){
                            self.addEntity(entity);
                            self.workspace.droppableStack={};
                        }else{
                            self.removeEntity(entity);
                        }
                        return false;
                    },
                    out: function(e,ui){
                        var entity=self.workspace.getEntity(getIdFromElement(ui.draggable));
                        self.removeEntity(entity);
                        delete self.workspace.droppableStack[self.id];
                    },
                    over: function(e,ui){
                        self.workspace.droppableStack[self.id]=self;

                    }
                });
            }
        }
        self.div.find(".deleteEntity").click(function(){
            self.workspace.removeEntity(self.id);
        });
        self.div.find(".increaseZ").click(function(e){
            e.preventDefault();
            self.updateZindex(self.getZindex()+1);
            self.draw(editor.currentState);
        });
        self.div.find(".decreaseZ").click(function(e){
            e.preventDefault();
            if(self.getZindex()>0){
                self.updateZindex(self.getZindex()-1);
                self.draw(editor.currentState);
            }
        });
        self.div.dblclick(function(){
            //Lista de las entidades que no se pueden editar
            if(editor.mode!=="solution"&&(self.type!=="check"&&self.type!=="answers"&&self.type!=="record"&&self.type!=="list")){
                editor.editEntity(self);
            }
        });
    };
    
    /**
     * Dispara el método para guardar la historia en el workspace
     */
    self.saveHistory=function(){
        if(self.workspace.logHistory){
            self.workspace.saveHistory();
        }
    };
    
    /**************************************************************************/
    /******************************* GUI METHODS ******************************/
    /**************************************************************************/
    /**
     * Método que dibuja la entidad actual
     * @param {string} stateName Estado que se quiere dibujar, si no se pasa, se dibuja
     * el estado passive.
     */
    self.draw=function(stateName){
        if(!self.container){
            self.container=self.workspace.div;
        }
        if(self.container){
            if(stateName===undefined||!stateName){
                stateName='passive';
            }        
            //Carga la entidad del workspace si existe
            loadDiv();
            
            if(editor.mode==="solution"){
                //Si es una entidad de grabación, inserta el contenido
                if(self.type==="record"){
                    var content=htmlRecordEntity(editor.record);
                    self.states.passive.content=content;
                    self.states.active.content=content;
                    self.states.solved.content=content;
                    self.states.right.content=content;
                    self.states.wrong.content=content;
                }
            }
            
            //Muestra el estado definido en stateName
            self.showState(self.getState(stateName));
            
            //Si está en modo respuesta, asigna eventos para controlar la calificación
            if(editor.mode==="solution"){
                self.workspace.attachEventsSolutionMode();
                if(self.type==="record"){
                    attachRecordEvents(self.div);
                }
                if(self.type==="check"){
                    $("#userpoints").show();
                }
            }
            //Si es una entidad de estilo, carga el estilo en la página
            if(self.type==="style"&&self.getState('passive').content!==""){
                var content=$(self.getState('passive').content);
                var file=content.attr('data-file');
                if(self.workspace){
                    $('body').append('<link id="'+file.replace(".","_")+'" rel="stylesheet" type="text/css" href="'+editor.activitySet.url+'css/'+file+'">');
                    //Si es una entidad de estilos y está en modo solución, se oculta
                    if(editor.mode==="solution"){
                        self.div.hide();
                    }
                }
            }
            //Si es una entidad de estilo, carga el estilo en la página
            if(self.type==="script"&&self.getState('passive').content!==""){
                var content=$(self.getState('passive').content);
                var file=content.attr('data-file');
                if(self.workspace){
                    $('body').append('<script type="text/javascript" id="'+file.replace(".","_")+'" src="'+editor.activitySet.url+'js/'+file+'"></script>');
                    //Si es una entidad de estilos y está en modo solución, se oculta
                    if(editor.mode==="solution"){
                        self.div.hide();
                    }
                }
            }
            //Si es una entidad de audio, carga el audio en la página
            if(self.type==="audio"&&self.getState('passive').content!==""){
                var content=$(self.getState('passive').content);
                var file=content.attr('data-file');
                if(self.workspace){
                    self.div.find('.content').empty().append('<audio controls class="audio_entity" src="'+editor.activitySet.url+'audio/'+file+'" id="'+file+'"></audio>');
//                    $('body').append('<link id="'+file.replace(".","_")+'" rel="stylesheet" type="text/css" href="'+editor.activitySet.url+'css/'+file+'">');
                    //Si es una entidad de estilos y está en modo solución, se oculta
//                    if(editor.mode==="solution"){
//                        self.div.hide();
//                    }
                }
            }
            //Si es una entidad de lista recalcula el tamaño de cada elemento
            if(self.type==="list"&&self.container.attr('id')==='workspace'){
                var content=self.div.find('.content');
                var elements=content.find('.listElement');
                var sortable=content.children('ul');
                var totalHeight=content.height();
                elements.each(function(){
                    var numberElements=parseInt($(this).attr('data-elements'));
                    $(this).height((totalHeight-numberElements)/numberElements);
                    if(editor.mode==="edition"){
                        $(this).addClass('edition_mode');
                    }else{
                        //Elimina los elementos solo visibles en modo edición
                        $(this).find('.only_in_edition_mode').remove();
                    }
                });                
                sortable.sortable({
                    stop: function( event, ui ) {
                        var newElements=self.div.find('.content').find('.listElement');
                        var order=[];
                        newElements.each(function(){
                            order.push(parseInt($(this).attr('data-position')));
                        });
                        self.parameters['order_'+editor.currentState]=order;
                        self.div.attr('data-order_'+editor.currentState,order);
                    }
                });
//                sortable.disableSelection();
            }
        }
    };
    
    /**
     * Muestra el estado de una entidad a partir de su nombre
     * @returns {State} state Estado que se quiere visualizar
     */
    self.showState=function(state){
        self.div.attr("data-state",state.type);
        if(self.type==='list_element'&&self.container.attr('id')==='workspace'){
            self.div.css({
                'height':'100%',
                'left':state.pos.left,
                'top':state.pos.top,
                'width':'100%',
                'z-index':state.zindex
            });
        }else{
            self.div.css({
                'height':state.size.height,
                'left':state.pos.left,
                'top':state.pos.top,
                'width':state.size.width,
                'z-index':state.zindex
            });
        }
        self.div.find(".content").empty().append(state.content);
    };
    
    
    /**
     * Carga el div de la entidad en self.div
     */
    function loadDiv(){
        //Si no existe el div, se inserta
        if(!self.div.length){
            //Si es de la clase lista, se inserta en el objeto correspondiente
            if(self.type==="list_element"&&self.container.attr('id')==='workspace'){
                if(self.parameters){
                    self.div=self.container.find('#entity'+self.id);
                    var listEntity=self.container.find('.list[data-match_id="'+self.parameters.match_id+'"]');
                    var elements=listEntity.find('.listElement');
                    var element=false;
                    orderListBeforeInsert(listEntity);
                    elements.each(function(){
                        if(self.parameters.parent_element_id===parseInt($(this).attr('data-position'))){
                            element=$(this);
                            element.append(getHtml());
                            var entityId=getIdFromElement($(this).find('.entity'));
                            var entity=self.workspace.getEntity(entityId);
                            var passive=entity.getState('passive');
                            var right=entity.getState('right');
                            var wrong=entity.getState('wrong');
                            var size={
                                height:element.height(),
                                width:element.width()
                            };
                            passive.size=size;
                            right.size=size;
                            wrong.size=size;
                        }
                    });
                    self.div=self.container.find('#entity'+self.id);
                    elements.each(function(){
                        element=$(this);
                        var entityId=getIdFromElement($(this).find('.entity'));
                        var entity=self.workspace.getEntity(entityId);
                        try{
                            entity.attachEvents();
                        }catch(e){};
                    });
                }
            }else{
                self.container.append(getHtml());
                self.div=self.container.find('#entity'+self.id);
                //Se asocian los eventos de la entidad
                attachEvents();
            }
        }else{
            if(self.type==="list_element"&&self.container.attr('id')==='workspace'){
                if(self.parameters){
                    var listEntity=self.container.find('.list[data-match_id="'+self.parameters.match_id+'"]');
                    var elements=listEntity.find('.listElement');
                    var element=false;
                    orderListBeforeInsert(listEntity);
                    elements.each(function(){
                        if(self.parameters.parent_element_id===parseInt($(this).attr('data-position'))){
                            element=$(this);
                            element.empty().append(getHtml());
                            var entityId=getIdFromElement($(this).find('.entity'));
                            var entity=self.workspace.getEntity(entityId);
                            var passive=entity.getState('passive');
                            var right=entity.getState('right');
                            var wrong=entity.getState('wrong');
                            var size={
                                height:element.height(),
                                width:element.width()
                            };
                            passive.size=size;
                            right.size=size;
                            wrong.size=size;
                        }
                    });
                    self.div=self.container.find('#entity'+self.id);
                    elements.each(function(){
                        element=$(this);
                        var entityId=getIdFromElement($(this).find('.entity'));
                        var entity=self.workspace.getEntity(entityId);
                        try{
                            entity.attachEvents();
                        }catch(e){};
                    });
                }
            }
            self.div=self.container.find('#entity'+self.id);
        }
    };
    
    /**
     * Ordena una lista de LI en un objeto de lista ordenable antes de insertar las entidades internas
     * basado en el estado actual del editor
     * @param {element} listElements Elemento de lista ordenada
     */
    function orderListBeforeInsert(listElements){
        if(listElements.length){
            var newOrder=listElements.attr('data-order_'+editor.currentState).split(",");
            var elements=listElements.find('.listElement');
            for(var k=0; k<newOrder.length; k++) {
                newOrder[k]=parseInt(newOrder[k]);
            }
            for(var i=0; i<newOrder.length; i++) {
                elements.each(function(){
                    if(parseInt($(this).attr('data-position'))===newOrder[i]){
                        $(this).attr('data-new_order',i+1);
                    }
                });
            }
            elements.sort(function (a, b) {
                var contentA =parseInt($(a).attr('data-new_order'));
                var contentB =parseInt($(b).attr('data-new_order'));
                return (contentA < contentB) ? -1 : (contentA > contentB) ? 1 : 0;
            });
            listElements.find('.sortable_list').empty();
            listElements.find('.sortable_list').append(elements);
        }
    };
    
    /**
     * Actualiza el container de la entidad
     * @param {element} newContainer El nuevo elemento contenedor de la entidad
     */
    self.updateContainer=function(newContainer){
        self.container=newContainer;
        self.div.draggable({
            containment: self.container
        }).resizable({
            containment: self.container
        });
    };
    
    /**
     * Establece el zindex para el estado / los estados de la entidad
     * @param {int} zindex Zindex a establecer
     * @param {string} stateName (optional) si se pasa, establece el z-index del
     *                           estado, sino, establece el de todos los estados
     */
    self.setZindex=function(zindex,stateName){
        if(stateName){
            var state=self.getState(stateName);
            state.zindex=zindex;
        }else{
            for(var i in self.states){
                self.states[i].zindex=zindex;
            }
        }
    };
    
    /**
     * Retorna el zindex de un estado / si no se pasa, retorna el de passive
     * @param {string} stateName (optional) si se pasa, retorna el z-index del
     *                           estado, sino, establece el de passive
     */
    self.getZindex=function(stateName){
        var zindex=0;
        if(stateName){
            var state=self.getState(stateName);
            zindex=state.zindex;
        }else{
            zindex=self.states.passive.zindex;
        }
        return zindex;
    };
    
    /**
     * Actualiza la posición del estado pasivo, actualiza los demás estados si
     * aplica
     * @param {int} left Posición desde la izquierda
     * @param {int} top Posición desde arriba
     */
    self.updatePosition=function(left,top){
        for(var i in self.states){
            if(self.statesFixedPos){
                self.states[i].pos.left=left;
                self.states[i].pos.top=top;
            }else if(i==='passive'){
                self.states[i].pos.left=left;
                self.states[i].pos.top=top;
            }
        }
        for(var j in self.entities){
            if(typeof(self.entities)==="object"){
                self.entities[j].updatePosition(left,top);
            }
        }
        self.draw();
    };
    
    /**
     * Actualiza la posición del estado pasivo, hace los desplazamientos en cada
     * estado
     * @param {int} diffLeft Diferencia de posición desde la izquierda
     * @param {int} diffTop Diferencia de posición desde arriba
     * @param {string} stateName Nombre del estado (opcional)
     */
    self.updatePositionByDiff=function(diffLeft,diffTop,stateName){
        if(!stateName){
            stateName='passive';
        }
        if(stateName!=='passive'&&self.type==="dragdrop"){
            self.states[stateName].pos.left=self.states[stateName].pos.left+diffLeft;
            self.states[stateName].pos.top=self.states[stateName].pos.top+diffTop;
        }else{
            for(var i in self.states){
                if(self.statesFixedPos){
                    self.states[i].pos.left=self.states[i].pos.left+diffLeft;
                    self.states[i].pos.top=self.states[i].pos.top+diffTop;
                }else if(i==='passive'){
                    self.states[i].pos.left=self.states[i].pos.left+diffLeft;
                    self.states[i].pos.top=self.states[i].pos.top+diffTop;
                }
            }
            for(var j in self.entities){
                if(typeof(self.entities)==="object"){
//                    self.entities[j].updatePositionByDiff(diffLeft,diffTop);
                }
            }
        }
        self.draw(stateName);
    };
    
    /**
     * Actualiza el tamaño del estado pasivo, hace los desplazamientos en cada
     * estado
     * @param {int} diffHeight Diferencia de alto
     * @param {int} diffWidth Diferencia de ancho
     */
    self.updateSizeByDiff=function(diffHeight,diffWidth){
        for(var i in self.states){
            if(self.statesFixedSize){
                self.states[i].size.height=self.states[i].size.height+diffHeight;
                self.states[i].size.width=self.states[i].size.width+diffWidth;
            }else if(i==='passive'){
                self.states[i].size.height=self.states[i].size.height+diffHeight;
                self.states[i].size.width=self.states[i].size.width+diffWidth;
            }
        }
    };
    
    /**************************************************************************/
    /************************* MÉTODOS DE SUBENTIDADES ************************/
    /**************************************************************************/
    
    /**
     * Agrega una entidad a la entidad actual
     * @param {Entity} entity Entidad que se incluirá dentro de las entidades
     */
    self.addEntity=function(entity){
        entity.updateZindex(self.getZindex()+1);
        entity.parent=self.id;
        self.entities[entity.id]=entity;
        return self.entities[entity.id];
    };
    
    /**
     * Elimina una entidad de la entidad actual
     * @param {Entity} entity Entidad que se eliminará de las entidades
     */
    self.removeEntity=function(entity){
        entity.parent=false;
        delete self.entities[entity.id];
    };
    
    /**
     * Elimina una entidad de la entidad actual o de las subentidades
     * @param {Entity} entity Entidad que se eliminará de las entidades
     */
    self.removeEntityRecursive=function(entity){
        for(var i in self.entities){
            self.entities[i].removeEntityRecursive(entity);
        }
        self.removeEntity(entity);
    };
    
    /**
     * Retorna la cantidad de entidades
     * @returns {int} cantidad de entidades en el workspace
     */
    self.numberEntities=function(){
        return self.entities.length;
    };
    
    /**
     * Actualiza el zindex de la entidad y los de las subentidades
     * @param {int} zindex Zindex base a partir del cuál los demás se calculan,
     *              se asigna el zindex a la entidad actual y se calcula la diferencia
     *              con las subentidades.
     */
    self.updateZindex=function(zindex){
        for(var i in self.entities){
            var zindexDiff=self.entities[i].getZindex()-self.getZindex();
            self.entities[i].updateZindex(zindex+zindexDiff);
        }
        self.setZindex(zindex);
    };
    
    /**************************************************************************/
    /******************************* HTML METHODS *****************************/
    /**************************************************************************/
       
    /**
     * Retorna el html de la entidad
     */
    function getHtml(){
        var title="";
        var grid="";
        var buttons="";
        var editing="";
        if(editor.mode==="edition"){
            if(self.type==="check"||self.type==="answers"||self.type==="record"){
                title="Entidad no editable";
            }else{
                title="Doble click para editar";
            }
            grid=" grid ";
            if(self.type!=='list_element'){
                buttons=
                    '<div class="entityButton deleteEntity" title="Eliminar entidad">x</div>'+
                    '<div class="entityButton zindex increaseZ" title="Traer al frente">+</div>'+
                    '<div class="entityButton zindex decreaseZ" title="Enviar atras">-</div>'
                ;
            }
            editing="entity_editing";
        }
        if(self.type==="check"){
            title="Check";
        }
        if(self.type==="answers"){
            title="Answers";
        }
        //Inserta todos los parámetros como data-parameter en el html
        var parameters='';
        if(self.parameters){
            for(var i in self.parameters){
                parameters+=' data-'+i+'="'+self.parameters[i]+'"';
            }
        }
        return '<div class="draggable entity '+editing+' '+self.type+'" id="entity'+self.id+'" data-id="'+self.id+'" title="'+title+'" '+parameters+'>'+
                '<div class="box">'+
                    '<div class="content '+grid+'"></div>'+
                '</div>'+
                buttons+
            '</div>'
        ;
    };
    
    /**
     * Retorna el html para la entidad de listas
     * @param {int} elements Cantidad de elementos a crear en el list
     * @return {string} Html con los elementos
     */
    function getHtmlList(elements){
        var htmlElements='';
        for(var i=0;i<elements;i++){
            htmlElements+='<li class="listElement" data-elements="'+elements+'" data-position="'+(i+1)+'"><div class="only_in_edition_mode">Elemento '+(i+1)+'</div></li>';
        }
        return '<ul class="sortable_list">'+htmlElements+'</ul>';
    };
    
    /**
     * Elimina el elemento de la entidad del DOM
     */
    self.deleteHtml=function(){
        self.container.find('#entity'+self.id).remove();
    };
    
    /**
     * Retorna el Id de una entidad a partir de un elemento del DOM
     * @param {element} element Elemento de entidad
     * @returns {int} el id de la entidad
     */
    function getIdFromElement(element){
        return parseInt(element.attr('data-id'));
    };
    
    /**
     * Retorna el html para las entidades de grabación
     * @param {type} entity
     * @returns {undefined}
     */
    function htmlRecordEntity(record){
        var src='data:audio/wav;base64,UklGRiTAAgBXQVZFZm10IBAAAAABAAIARKwAABCxAgAEABAAZGF0YQDAAgCJ/Yn9gf2B';
        if(record){
            src=record;
        }
        var html=
            '<div class="record_controlls">'+
                '<div class="record_buttons">'+
                    '<a class="record_button" id="record" title="Record"></a>'+
//                    '<a class="record_button disabled one" id="stop" title="Stop"></a>'+
//                    '<a class="record_button disabled one" id="play" title="Play"></a>'+
//                    '<a class="record_button disabled one" id="download" title="download"></a>'+
                    '<a class="record_button one" id="base64" title="Stop"></a>'+
                '</div>'+
                '<div class="record_player">'+      
                    '<audio controls src="'+src+'" id="audio"></audio>'+
                '</div>'+
            '</div>';
        return html;
    };
    
    /**************************************************************************/
    /****************************** OTHER METHODS *****************************/
    /**************************************************************************/
    
    /**
     * Actualiza la entidad a partir de los atributos de la entidad parámetro
     * después de ser editada.
     * @param {Entity} entity Entidad con la que se actualizará la entidad actual
     */
    self.updateAfterEditing=function(entity){
        self.id=entity.id;
        self.optional=entity.optional;
        self.countable=entity.countable;
        self.weight=entity.weight;
        for(var i in entity.states){
            self.states[i].size=entity.states[i].size;
            self.states[i].content=entity.states[i].content;
            self.states[i].hidden=entity.states[i].hidden;
            self.states[i].css=entity.states[i].css;
            self.states[i].value=entity.states[i].value;
            self.states[i].valueType=entity.states[i].valueType;
            self.states[i].zindex=entity.states[i].zindex;
        }
    };
    
    /**
     * Retorna la entidad como un objeto almacenable en la base de datos
     * @returns {String}
     */
    self.objectify=function(){
        var objectified={};
        var entities=[];
        var noCopy=[
            "workspace","container","div",
            "entities"
        ];
        //A cada entidad se le asocian los id de las entidades hijas
        for(var i in self.entities){
            entities.push(self.entities[i].id);
        }
        //Solo copia los valores necesarios
        for(var i in self){
            if($.inArray(i,noCopy)===-1){
                if(!$.isFunction(self[i])){
                    objectified[i]=self[i];
                }
            }
        }
        objectified['entities']=entities;
        return objectified;
    };
    
    /**
     * Retorna la entidad a un estado anterior generado por self.objectify().
     * @param {objet} entity Entidad generada con self.objectify()
     */
    self.deobjectify=function(entity){
        for(var i in entity){
            self[i]=entity[i];
        }
    };
    
    /**
     * Convierte a texto una entidad
     * @returns {String}
     */
    self.stringify=function(){
        return JSON.stringify(self.objectify());
    };
    
    /**
     * Retorna una copia de la entidad (otra instancia)
     * @return {Entity} Compia de la entidad
     * @todo Verificar funcionamiento, no copia los divs
     */
    self.clone=function(){
        var entity=$.extend({},self);
        entity.div=entity.div.clone(true,true);
        return entity;
    };
    
    /**************************************************************************/
    /************************** SOLUTION MODE METHODS *************************/
    /**************************************************************************/
    /**
     * Asigna los eventos a la entidad cuando se está en modo 'solution'
     */
    function attachModeSolutionEvents(){
        
    };
    
    /**
     * Asigna los eventos a la entidad de grabación
     */
    function attachRecordEvents(entityDiv){
        //Función para reiniciar la grabación
        function restore(){$("#record, #live").removeClass("disabled");$(".one").addClass("disabled");$.voice.stop();}
        
        entityDiv.on("click", "#record:not(.disabled)", function(){
            elem = $(this);
            $.voice.record($("#live").is(":checked"), function(){
                elem.addClass("disabled");
                $("#live").addClass("disabled");
                $(".one").removeClass("disabled");
                self.div.find("#record").hide();
                self.div.find("#base64").show();
            });
	});
	entityDiv.on("click", "#stop:not(.disabled)", function(){
            restore();
	});
	entityDiv.on("click", "#play:not(.disabled)", function(){
            $.voice.export(function(url){
//                $("#audio").attr("src", url);
//                $("#audio")[0].play();
//                $('body').prepend("<a id='download_audio' href='"+url+"' download='MyRecording.wav'>AAA</a>")[0].click();
//                $(document).on("click", "#download_audio", function(){
//                    $(this).text("It works!");
//                });
//                setTimeout(function(){
//                    $('#download_audio').click();
//                },3000);
//                editor.saveRecord(url,function(err){
//                    if(err) {
//                        console.debug("Error almacenando audio");
//                    }
//                });
                $("#base64").click();
            }, "URL");
            restore();
	});
	entityDiv.on("click", "#download:not(.disabled)", function(){
            $.voice.export(function(url){
                $("<a href='"+url+"' download='MyRecording.wav'></a>")[0].click();
            }, "URL");
            restore();
	});
        entityDiv.on("click", "#base64", function(){
            $.voice.export(function(record){
                $("<a href='"+record+"' target='_blank'></a>")[0].click();
                editor.saveRecord(record,function(err){
                    if(err) {
                        console.debug("Error almacenando audio");
                    }else{
                        self.div.find("#audio").attr('src',record);
                        self.div.find("#audio")[0].play();
                        self.div.find("#record").show();
                        self.div.find("#base64").hide();
                    }
                });
            },"base64");
            restore();
	});
    };
};