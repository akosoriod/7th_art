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
        weight:10
    };
    var options = $.extend(def, params);
    self.id=options.id;
    self.optional=options.optional;     //Si se debe resolver para el éxito del ejercicio
    self.countable=options.countable;   //Si se cuenta dentro del cálculo del total de ejercicios
    self.type=options.type;             //Tipo de entidad: single, dragdrop, ... ver workspace.attachEvents()
    self.weight=options.weight;         //Peso de la entidad en el total de ejercicios
    self.entities=options.entities;
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
        self.states={
            /* Define los defaults para el estado pasivo (estado de la entidad en el editor) */
            'passive':new State({
                type:'passive',
                pos:{left:options.pos.left,top:options.pos.top},
                size:{height:options.size.height,width:options.size.width}
            }),
            'active':new State({
                type:'active',
                pos:{left:options.pos.left,top:options.pos.top},
                size:{height:options.size.height,width:options.size.width}
            }),
            'solved':new State({
                type:'solved',
                pos:{left:options.pos.left,top:options.pos.top},
                size:{height:options.size.height,width:options.size.width}
            }),
            'right':new State({
                type:'right',
                pos:{left:options.pos.left,top:options.pos.top},
                size:{height:options.size.height,width:options.size.width}
            }),
            'wrong':new State({
                type:'wrong',
                pos:{left:options.pos.left,top:options.pos.top},
                size:{height:options.size.height,width:options.size.width}
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
    function attachEvents(){
        if(editor.mode==="edition"){
            self.div.draggable({
                containment: self.container,
                cursor: "move",
                grid: [10,10],
                opacity: 0.4,
                scroll: false,
                zIndex: 10000,
                stop:function(event,ui){
                    var diffLeft=ui.position.left-ui.originalPosition.left;
                    var diffTop=ui.position.top-ui.originalPosition.top;
                    self.updatePositionByDiff(diffLeft,diffTop,editor.currentState);
                    self.saveHistory();
                }
            }).resizable({
                containment: self.container,
                stop:function(event,ui){
                    var diffHeight=ui.size.height-ui.originalSize.height;
                    var diffWidth=ui.size.width-ui.originalSize.width;
                    self.updateSizeByDiff(diffHeight,diffWidth);
                    self.saveHistory();
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
            editor.editEntity(self);
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
            //Muestra el estado definido en stateName
            self.showState(self.getState(stateName));
            
            //Si está en modo respuesta, asigna eventos para controlar la calificación
            if(editor.mode==="solution"){
                self.workspace.attachEventsSolutionMode();
            }
            
            //Si es una entidad de estilo, carga el estilo en la página
//            $('head').append('<link id="entity_style_sheet_'+self.id+'" rel="stylesheet" type="text/css" href="'+editor.appUrl+'protected/data/entity_'+self.id+'_style.css">');
        }
    };
    
    /**
     * Muestra el estado de una entidad a partir de su nombre
     * @returns {State} state Estado que se quiere visualizar
     */
    self.showState=function(state){
        self.div.attr("data-state",state.type);
        self.div.css({
            'height':state.size.height,
            'left':state.pos.left,
            'top':state.pos.top,
            'width':state.size.width,
            'z-index':state.zindex
        });
        self.div.find(".content").empty().append(state.content);
    };
    
    
    /**
     * Carga el div de la entidad en self.div
     */
    function loadDiv(){
        //Si no existe el div, se inserta
        if(!self.div.length){
            self.container.append(getHtml());
            self.div=self.container.find('#entity'+self.id);
            //Se asocian los eventos de la entidad
            attachEvents();
        }else{
            self.div=self.container.find('#entity'+self.id);
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
            title="Doble click para editar";
            grid=" grid ";
            buttons=
                '<div class="entityButton deleteEntity" title="Eliminar entidad">x</div>'+
                '<div class="entityButton zindex increaseZ" title="Traer al frente">+</div>'+
                '<div class="entityButton zindex decreaseZ" title="Enviar atras">-</div>'
            ;
            editing="entity_editing";
        }
        return '<div class="draggable entity '+editing+' '+self.type+'" id="entity'+self.id+'" data-id="'+self.id+'" title="'+title+'">'+
                '<div class="box">'+
                    '<div class="content '+grid+'"></div>'+
                '</div>'+
                buttons+
            '</div>'
        ;
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
};