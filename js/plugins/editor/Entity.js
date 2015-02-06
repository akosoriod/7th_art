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
    
    /**************************************************************************/
    /********************* CONFIGURATION AND CONSTRUCTOR **********************/
    /**************************************************************************/
    //Mix the user parameters with the default parameters
    var def = {
        countable:true,
        id:false,
        optional:false,
        entities:{},
        weight:0
    };
    var options = $.extend(def, params);
    self.id=options.id;
    self.optional=options.optional;
    self.countable=options.countable;
    self.weight=options.weight;
    self.entities=options.entities;
    /**
     * Constructor Method 
     */
    var Entity = function() {
        self.states={
            /* Define los defaults para el estado pasivo (estado de la entidad en el editor) */
            'passive':new State({
                type:'passive',
                pos:options.pos,
                size:options.size,
                style:"backgound:red"
            }),
            'active':new State({
                type:'active'
            }),
            'solved':new State({
                type:'solved'
            }),
            'right':new State({
                type:'right'
            }),
            'wrong':new State({
                type:'wrong'
            })
        };
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
    
    /**************************************************************************/
    /******************************* GUI METHODS ******************************/
    /**************************************************************************/
    /**
     * Método que dibuja la entidad actual
     * @param {string} stateName Estado que se quiere dibujar, si no se pasa, se dibuja
     * el estado passive.
     */
    self.draw=function(stateName){
        if(stateName===undefined||!stateName){
            stateName='passive';
        }
        //Carga la entidad del workspace si existe
        loadDiv();
        
        //Muestra el estado definido en stateName
        self.showState(self.getState(stateName));
        
        
        self.div.find('.textContent').append(self.getState('passive').content);
        
        
//        self.workspace.append('<div class="draggable entity" id="entity'+self.countEntities+'" data-id="'+self.countEntities+'"><div class="content"><div class="text"><div class="textContent">'+content+'</div></div></div><div class="entityButton config"></div><div class="entityButton deleteEntity">x</div></div>');
//        var entity=self.workspace.find('#entity'+self.countEntities);
//        entity.draggable({
//            containment: "#workspace",
//            cursor: "move",
//            opacity: 0.4,
//            scroll: false
//        }).resizable({
////                        containment:"parent"
//        });
//        entity.css({
//            left:left,
//            top:top
//        });
//        entity.find(".deleteEntities").click(function(){
//            entity.remove();
//        });
//        entity.find(".config").click(function(){
//            var id=parseInt($(this).parent().attr("data-id"));
//            $("#properties").attr("data-entity",id);
//            $("#properties").dialog("open");
//        });
    };
    
    /**
     * Muestra el estado de una entidad a partir de su nombre
     * @returns {State} state Estado que se quiere visualizar
     */
    self.showState=function(state){
        self.div.css({
            'height':state.size.height,
            'left':state.pos.left,
            'top':state.pos.top,
            'width':state.size.width,
            'z-index':state.zindex
        });
    };
    
    
    /**
     * Carga el div de la entidad en self.div
     */
    function loadDiv(){
        self.container=self.workspace.div;
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
     * Asocia los eventos básicos a la entidad
     */
    function attachEvents(){
        self.div.draggable({
            containment: self.container,
            cursor: "move",
            opacity: 0.4,
            scroll: false,
            stop:function(event,ui){
                var diffLeft=ui.position.left-ui.originalPosition.left;
                var diffTop=ui.position.top-ui.originalPosition.top;
                self.updatePositionByDiff(diffLeft,diffTop);
                for(var i in self.entities){
                    self.entities[i].updatePositionByDiff(diffLeft,diffTop);
                    self.entities[i].draw();
                }
                self.draw();
            },
            zIndex: 10000
        }).resizable({
            containment: self.container,
            stop:function(event,ui){
                var diffHeight=ui.size.height-ui.originalSize.height;
                var diffWidth=ui.size.width-ui.originalSize.width;
                self.updateSizeByDiff(diffHeight,diffWidth);
            }
        }).droppable({
            accept: ".entity",
            hoverClass: "entity-hover",
            tolerance: "fit",
            drop: function(event,ui){
                var entityId=getIdFromElement(ui.draggable);
                var entity=self.workspace.getEntity(entityId);
                self.addEntity(entity);
            },
            out: function(event,ui){
                var entityId=getIdFromElement(ui.draggable);
                var entity=self.workspace.getEntity(entityId);
                self.removeEntity(entity);
            }
        });
        
        
        self.div.find(".deleteEntity").click(function(){
            self.workspace.deleteEntity(self.id);
        });
        self.div.dblclick(function(){
            console.warn(self);
            var passive=self.getState('passive');
            console.debug(passive.pos);
            console.debug(passive.size);
        });
//        entity.find(".config").click(function(){
//            var id=parseInt($(this).parent().attr("data-id"));
//            $("#properties").attr("data-entity",id);
//            $("#properties").dialog("open");
//        });
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
     * Actualiza la posición del estado pasivo, hace los desplazamientos en cada
     * estado
     * @param {int} diffLeft Diferencia de posición desde la izquierda
     * @param {int} diffTop Diferencia de posición desde arriba
     */
    self.updatePositionByDiff=function(diffLeft,diffTop){
        for(var i in self.states){
            if(self.statesFixedPos){
                self.states[i].pos.left=self.states[i].pos.left+diffLeft;
                self.states[i].pos.top=self.states[i].pos.top+diffTop;
            }else if(i==='passive'){
                self.states[i].pos.left=self.states[i].pos.left+diffLeft;
                self.states[i].pos.top=self.states[i].pos.top+diffTop;
            }
        }
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
        entity.setZindex(self.getZindex()+1);
        self.entities[entity.id]=entity;
    };
    
    /**
     * Agrega una entidad a la entidad actual
     * @param {Entity} entity Entidad que se incluirá dentro de las entidades
     */
    self.removeEntity=function(entity){
        delete self.entities[entity.id];
    };
    
    
    /**************************************************************************/
    /******************************* HTML METHODS *****************************/
    /**************************************************************************/
    
    
    /**
     * Retorna el html de la entidad
     */
    function getHtml(){
        return '<div class="draggable entity" id="entity'+self.id+'" data-id="'+self.id+'">'+
                '<div class="content">'+
                    '<div class="text">'+
                        '<div class="textContent"></div>'+
                    '</div>'+
                '</div>'+
                '<div class="entityButton config"></div>'+
                '<div class="entityButton deleteEntity">x</div>'+
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
    
};