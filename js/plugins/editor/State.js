/* 
 * Pseudoclase para manejo de estados de objetos. Un estado de objeto puede ser:
 * - pasivo
 * - activo
 * - resuelto
 * - correcto
 * - incorrecto
 * Universidad Nacional de Colombia
 * 7th @rt The Power & Magic of Films to Learn English
 * 7thart_bog@unal.edu.co
 * 2015
 */
var State = function(params){
    /**************************************************************************/
    /******************************* ATTRIBUTES *******************************/
    /**************************************************************************/
    var self = this;
    
    /**************************************************************************/
    /********************* CONFIGURATION AND CONSTRUCTOR **********************/
    /**************************************************************************/
    //Mix the user parameters with the default parameters
    var def = {
        type:'passive',
        pos:{
            left:0,
            top:0
        },
        shape:{
            height:0,
            width:0
        },
        content:"",
        style:"",
        value:false,
        valueType:'boolean'
    };
    var options = $.extend(def, params);
    self.type=options.type;
    self.pos=options.pos;
    self.shape=options.shape;
    self.content=options.content;
    self.style=options.style;
    self.value=options.value;
    self.valueType=options.valueType;
    /**
     * Constructor Method 
     */
    var State = function() {
        
    }();
    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
    
    
    /**************************************************************************/
    /****************************** OTHER METHODS *****************************/
    /**************************************************************************/
    
};