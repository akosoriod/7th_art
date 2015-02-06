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
        size:{
            height:160,
            width:100
        },
        content:"",
        style:"",
        value:false,
        valueType:'boolean',
        zindex:0
    };
    var options = $.extend(def, params);
    self.type=options.type;
    self.pos=options.pos;
    self.size=options.size;
    self.content=options.content;
    self.style=options.style;
    self.value=options.value;
    self.valueType=options.valueType;
    self.zindex=options.zindex;
    /**
     * Constructor Method 
     */
    var State = function() {
        
    }();
    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
    
    /**************************************************************************/
    /******************************* GUI METHODS ******************************/
    /**************************************************************************/
    
    /**************************************************************************/
    /****************************** OTHER METHODS *****************************/
    /**************************************************************************/
    
};