/* 
 * Pseudoclase para manejo de sets de actividades para los usuarios
 * Universidad Nacional de Colombia
 * 7th @rt The Power & Magic of Films to Learn English
 * 7thart_bog@unal.edu.co
 * 2015
 */
var ActivitySet = function(params){
    /**************************************************************************/
    /******************************* ATTRIBUTES *******************************/
    /**************************************************************************/
    var self = this;
    
    /**************************************************************************/
    /********************* CONFIGURATION AND CONSTRUCTOR **********************/
    /**************************************************************************/
    //Mix the user parameters with the default parameters
    var def = {
        index:$("#activity_set_index")
    };
    var options = $.extend(def, params);
    self.index=options.index;
    /**
     * Constructor Method 
     */
    var ActivitySet = function() {
        
    }();
    
    /**
     * Inicializa el objeto
     * @returns {undefined}
     */
    self.init=function(){
        attachEvents();
    };
    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
    /**
     * Asigna los eventos a los elementos
     */
    function attachEvents(){
        self.index.find(".activity_set_menu").dropit();
    };
    
    
    /**************************************************************************/
    /******************************* GUI METHODS ******************************/
    /**************************************************************************/
    
    /**************************************************************************/
    /****************************** OTHER METHODS *****************************/
    /**************************************************************************/
    
};