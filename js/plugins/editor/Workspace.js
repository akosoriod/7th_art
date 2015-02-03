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
    
    /***** Manejo de objetos *****/
    
    /**
     * Cuenta los objetos temporales creados hasta el momento. A cada nuevo objeto 
     * le asigna un id negativo, así se reconoce como un objeto temporal al que
     * se le asigna un id positivo cuando se almacena en la base de datos.
     * @type int
     */
    self.tempObjetos=0;
    
    /**
     * Zindex del último objeto insertado en el workspace. Solo se asigna a un 
     * objeto que no tenga zindex definido.
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
        objects:new Array(),
        width:1040
    };
    var options = $.extend(def, params);
    self.div=$(options.div);
    self.height=options.height;    
    self.objects=options.objects;
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
     * Agrega un objeto al Workspace, si tiene un id, lo actualiza.
     * @param {object} objeto Objeto que se quiere agregar al workspace
     */
    self.addObjeto=function(objeto){
        var obtainedObjeto=self.getObjeto(objeto.id);
        if(!obtainedObjeto){
            if(objeto.id===false){
                //Usa un id temporal para el objeto
                self.tempObjetos++;
                self.currentZindex++;
                objeto.id=-self.tempObjetos;
                objeto.zindex=self.currentZindex;
                objeto.setZindex(self.currentZindex);
            }
            self.objects.push(objeto);
        }else{
            self.updateObjeto(objeto);
        }
        objeto.workspace=self;
        objeto.draw();
    };
    
    /**
     * Retorna un objeto a partir de su id, si no existe en el Workspace, retorna
     * false
     * @param {int} objetoId Identificador del objeto
     * @returns {Mixed} Objeto a partir del id, Falso si no lo encuentra
     */
    self.getObjeto=function(objetoId){
        var output=false;
        for(var i in self.objects){
            if(self.objects[i].id===objetoId){
                output=self.objects[i];
                break;
            }
        }
        return output;
    };
    
    /**
     * Actualiza un objeto
     * @param {objeto} objeto Objeto a actualizar, debe tener un id
     * @returns {objeto} Objeto actualizado
     */
    self.updateObjeto=function(objeto){
        var output=false;
        for(var i in self.objects){
            if(self.objects[i].id===objeto.id){
                self.objects[i]=objeto;
                output=self.objects[i];
                break;
            }
        }
        return output;
    };
    
    /**
     * Elimina un objeto a partir de su id
     * @param {int} objetoId Identificador del objeto
     */
    self.deleteObjeto=function(objetoId){
        var output=false;
        for(var i in self.objects){
            if(self.objects[i].id===objetoId){
                self.objects[i].deleteHtml();
                self.objects.splice(i,1);
                break;
            }
        }
        return output;
    };
    
    /**
     * Retorna la cantidad de objetos
     * @returns {int} cantidad de objetos primarios en el workspace
     */
    self.numberObjects=function(){
        return self.objects.length;
    };
    
    /**
     * Reinicia el Workspace, elimina todos los objetos del workspace.
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
                if(ui.draggable.hasClass("object")){
                    var displacement=$("#workspace").offset();
                    self.addObjeto(new Objeto({
                        pos:{
                            left:ui.position.left-displacement.left,
                            top:ui.position.top-displacement.top
                        }
                    }));
                }
            }
        });
    };
    
    /**************************************************************************/
    /****************************** OTHER METHODS *****************************/
    /**************************************************************************/
    
};