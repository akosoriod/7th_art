/* 
 * Pseudo-Clase para el manejo del Objetos en 7th @rt
 * Universidad Nacional de Colombia
 * 7th @rt The Power & Magic of Films to Learn English
 * 7thart_bog@unal.edu.co
 * 2014
 * @param {object} params Object with the class parameters
 */
var Objeto = function(params){
    /**************************************************************************/
    /******************************* ATTRIBUTES *******************************/
    /**************************************************************************/
    var self = this;
    
    /**************************************************************************/
    /********************* CONFIGURATION AND CONSTRUCTOR **********************/
    /**************************************************************************/
    //Mix the user parameters with the default parameters
    var def = {
        
    };
    self.params = $.extend(def, params);
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
        
        console.debug(self);
        
        
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
            'left':state.pos.left,
            'top':state.pos.top,
            'z-index':state.zindex
        });
    };
    
    /**
     * Retorna el html del objeto
     */
    function getHtml(){
        return '<div class="draggable object" id="objeto'+self.id+'" data-id="'+self.id+'">'+
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
     * Carga el div del objeto en self.div
     */
    function loadDiv(){
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
        
        var active=self.getState('active');
        
        active.pos.left=active.pos.left+14;
        active.pos.top=active.pos.top+14;
        
        
        
        
        self.div.draggable({
            containment: "#workspace",
            cursor: "move",
            opacity: 0.4,
            scroll: false,
            stop:function(event,ui){
                
                var diffLeft=ui.position.left-ui.originalPosition.left;
                var diffTop=ui.position.top-ui.originalPosition.top;
                self.updatePositionByDiff(diffLeft,diffTop);
                
                
                
                console.debug(ui.position);
                
                var passive=self.getState('passive');
                console.debug(passive.pos);
                
                var active=self.getState('active');
                console.debug(active.pos);
                
            }
        }).resizable({
//                        containment:"parent"
        });
//        self.div.find(".deleteObject").click(function(){
//            object.remove();
//        });
//        object.find(".config").click(function(){
//            var id=parseInt($(this).parent().attr("data-id"));
//            $("#properties").attr("data-object",id);
//            $("#properties").dialog("open");
//        });
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
     * Acrualiza la posición del estado pasivo, hace los desplazamientos en cada
     * estado
     */
    self.updatePositionByDiff=function(diffLeft,diffTop){
        for(var i in self.states){
            self.states[i].pos.left=self.states[i].pos.left+diffLeft;
            self.states[i].pos.top=self.states[i].pos.top+diffTop;
        }
    };
    
    /**************************************************************************/
    /****************************** OTHER METHODS *****************************/
    /**************************************************************************/
    
};