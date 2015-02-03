/* 
 * Pseudo-Clase para el manejo del Objetos en 7th @rt
 * Universidad Nacional de Colombia
 * 7th @rt The Power & Magic of Films to Learn English
 * 7thart_bog@unal.edu.co
 * 2015
 * @param {object} params Object with the class parameters
 */
var Objeto = function(params){
    /**************************************************************************/
    /******************************* ATTRIBUTES *******************************/
    /**************************************************************************/
    var self = this;
    
    self.workspace=false;           //Workspace en el que está el objeto
    self.container=false;           //Elemento contenedor del div del objeto (div del workspace)
    self.div=false;                 //Elemento del objeto
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
        subobjects:false,
        weight:0,
        zindex:0
    };
    var options = $.extend(def, params);
    self.id=options.id;
    self.optional=options.optional;
    self.countable=options.countable;
    self.weight=options.weight;
    self.subobjects=options.subobjects;
    self.zindex=options.zindex;
    /**
     * Constructor Method 
     */
    var Objeto = function() {
        self.states={
            /* Define los defaults para el estado pasivo (estado del objeto en el editor) */
            'passive':new State({
                type:'passive',
                pos:options.pos,
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
     * Retorna un estado del objeto a partir de su nombre
     * @param {string} stateName Nombre del estado a retornar
     * @returns {State} Estado del objeto
     */
    self.getState=function(stateName){
        return self.states[stateName];
    };
    
    /**************************************************************************/
    /******************************* GUI METHODS ******************************/
    /**************************************************************************/
    /**
     * Método que dibuja el objeto actual
     * @param {string} stateName Estado que se quiere dibujar, si no se pasa, se dibuja
     * el estado passive.
     */
    self.draw=function(stateName){
        if(stateName===undefined||!stateName){
            stateName='passive';
        }
        //Carga el objeto del workspace si existe
        loadDiv();
        
        //Muestra el estado definido en stateName
        self.showState(self.getState(stateName));
        
        
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
    };
    
    /**
     * Muestra el estado de un objeto a partir de su nombre
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
     * Carga el div del objeto en self.div
     */
    function loadDiv(){
        self.container=self.workspace.div;
        //Si no existe el div, se inserta
        if(!self.div.length){
            self.container.append(getHtml());
            self.div=self.container.find('#objeto'+self.id);
            //Se asocian los eventos del objeto
            attachEvents();
        }else{
            self.div=self.container.find('#objeto'+self.id);
        }
    };
    
    /**
     * Asocia los eventos básicos al objeto
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
            },
            zIndex: 10000
        }).resizable({
            containment: self.container,
            stop:function(event,ui){
                var diffHeight=ui.size.height-ui.originalSize.height;
                var diffWidth=ui.size.width-ui.originalSize.width;
                self.updateSizeByDiff(diffHeight,diffWidth);
            }
        });
        
        
        
        self.div.find(".deleteObject").click(function(){
            self.workspace.deleteObjeto(self.id);
        });
        self.div.dblclick(function(){
            console.warn(self);
            var passive=self.getState('passive');
            console.debug(passive.pos);
            console.debug(passive.size);
        });
//        object.find(".config").click(function(){
//            var id=parseInt($(this).parent().attr("data-id"));
//            $("#properties").attr("data-object",id);
//            $("#properties").dialog("open");
//        });
    };
    
    /**
     * Actualiza el container del objeto
     * @param {element} newContainer El nuevo elemento contenedor del objeto
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
     * Establece el zindex para el estado / los estados del objeto
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
    /******************************* HTML METHODS *****************************/
    /**************************************************************************/
    
    
    /**
     * Retorna el html del objeto
     */
    function getHtml(){
        return '<div class="draggable objeto" id="objeto'+self.id+'" data-id="'+self.id+'">'+
                '<div class="content">'+
                    '<div class="text">'+
                        '<div class="textContent"></div>'+
                    '</div>'+
                '</div>'+
                '<div class="objectButton config"></div>'+
                '<div class="objectButton deleteObject">x</div>'+
            '</div>'
        ;
    };
    
    /**
     * Elimina el elemento del objeto del DOM
     */
    self.deleteHtml=function(){
        self.container.find('#objeto'+self.id).remove();
    };
    
    /**
     * Retorna el Id del un objeto a partir de un elemento del DOM
     * @param {element} element Elemento de objeto
     * @returns {int} el id del objeto
     */
    function getIdFromElement(element){
        return parseInt(element.attr('data-id'));
    };
    
    /**************************************************************************/
    /****************************** OTHER METHODS *****************************/
    /**************************************************************************/
    
};