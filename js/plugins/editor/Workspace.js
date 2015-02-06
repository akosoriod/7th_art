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
    
    /**************************************************************************/
    /********************* CONFIGURATION AND CONSTRUCTOR **********************/
    /**************************************************************************/
    //Mix the user parameters with the default parameters
    var def = {
        div:"#workspace",
        height:600,
        width:1040,
        entities:{}
    };
    var options = $.extend(def, params);
    self.div=$(options.div);
    self.height=options.height;    
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
            }
            self.entities[entity.id]=entity;
        }else{
            self.updateEntity(entity);
        }
        entity.workspace=self;
        entity.draw();
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
        return output;
    };
    
    /**
     * Elimina una entidad a partir de su id
     * @param {int} entityId Identificador de la entidad
     */
    self.deleteEntity=function(entityId){
        var output=false;
        for(var i in self.entities){
            if(self.entities[i].id===entity){
                self.entities[i].deleteHtml();
                self.entities.splice(i,1);
                break;
            }
        }
        return output;
    };
    
    /**
     * Retorna la cantidad de entidades
     * @returns {int} cantidad de entidades en el workspace
     */
    self.numberEntities=function(){
        return self.entities.length;
    };
    
    /**
     * Reinicia el Workspace, elimina todas las entidades del workspace.
     */
    self.clear=function(){
        
    };
    
    
    /**************************************************************************/
    /******************************** GUI METHODS *****************************/
    /**************************************************************************/
    /**
     * Crea la estructura del workspace y lo hace droppable
     */
    function attachEvents(){
        self.div.droppable({
            accept: ".button",
            drop: function( event, ui ) {
                if(ui.draggable.hasClass("entity")){
                    var displacement=$("#workspace").offset();
                    self.addEntity(new Entity({
                        pos:{
                            left:ui.position.left-displacement.left,
                            top:ui.position.top-displacement.top
                        }
                    }));
                }else if(ui.draggable.hasClass("multi-single")){
                    var displacement=$("#workspace").offset();
                    var defaultOptions=4;
                    var left=ui.position.left-displacement.left;
                    var top=ui.position.top-displacement.top;
                    var options=new Array();
                    var id=parseInt(Math.random()*1000);
                    var entity=new Entity({
                        pos:{
                            left:left,
                            top:top
                        },
                        size:{
                            height:150,
                            width:350
                        }
                    });
                    self.addEntity(entity);
                    entity.draw();
                    for(var i=0;i<defaultOptions;i++){
                        var obj=entity.addEntity(new Entity({
                            pos:{
                                left:left+(10),
                                top:top+(30*i)
                            },
                            size:{
                                height:30,
                                width:300
                            }
                        }));
                        var passive=obj.getState('passive');
                        passive.content='<input type="radio" name="radio'+id+'" value="Opción 1">Opción 1';
                        obj.draw();
                        
                    }
//                }else if(ui.draggable.hasClass("true_false")){
//                    var displacement=$("#workspace").offset();
//                    var defaultOptions=4;
//                    var left=ui.position.left-displacement.left;
//                    var top=ui.position.top-displacement.top;
//                    var options=new Array();
////                    for(var i=0;i<defaultOptions;i++){
//                        var obj=self.addEntity(new Entity({
////                            pos:{
////                                left:left+(10),
////                                top:top+(30*i)
////                            },
//                            size:{
//                                height:30,
//                                width:300
//                            }
//                        }));
//                        var passive=obj.getState('passive');
//                        var id=parseInt(Math.random()*1000);
//                        passive.content='<select>'+
//                            '<option name="'+id+'">Opción 1</option>'+
//                            '<option name="'+id+'">Opción 2</option>'+
//                            '<option name="'+id+'">Opción 3</option>'+
//                        '</select>';
//                        obj.draw();
////                    }
//                }else if(ui.draggable.hasClass("multi-multi")){
//                    var displacement=$("#workspace").offset();
//                    var defaultOptions=4;
//                    var left=ui.position.left-displacement.left;
//                    var top=ui.position.top-displacement.top;
//                    var options=new Array();
//                    for(var i=0;i<defaultOptions;i++){
//                        var obj=self.addEntity(new Entity({
//                            pos:{
//                                left:left+(10),
//                                top:top+(30*i)
//                            },
//                            size:{
//                                height:30,
//                                width:300
//                            }
//                        }));
//                        var passive=obj.getState('passive');
//                        var id=parseInt(Math.random()*1000);
//                        passive.content='<input type="checkbox" name="'+id+'" value="Opción '+(i+1)+'">Opción 1';
//                        obj.draw();
//                    }
                }
            }
        });
    };
    
    /**************************************************************************/
    /****************************** OTHER METHODS *****************************/
    /**************************************************************************/
    
};