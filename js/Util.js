/**
 * Add util methods to JS
 */
/**
 * Util namespace
 * @type set of functions
 */
window.util={};
/**
 * Reverse an array
 * @type @pro;reverse|Array
 */
jQuery.fn.reverse = [].reverse;
/**
 * Number.prototype.format(n, x)s
 * @param integer n: length of decimal
 * @param integer x: length of sections
 */
Number.prototype.format = function(decimalcurrency,n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    if (decimalcurrency==="false")
        return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&.');
    else
        return this.toFixed(2);
};
/**
 * Make an input an only-input-money. Only allow numeric values and formatting as
 * money. Also fill the data-value attribute with the integer money value.
 * @param {mixed} inputMoney Money value
 */
jQuery.fn.moneyFormatting=function(decimalcurrency){
    var inputs=$(this);
    inputs.each(function(){
        var input=$(this);
        input.keyup(function(e){
            
            // skip for arrow keys
            if(e.which >= 37 && e.which <= 40) return;
            if(e.which === 190){
                if (decimalcurrency==="true"){
                    return;
                }
            }
            
            // format number
            input.val(function(index, value) {
                var number=0;
                if($.trim(value)===''){
                    number=0;
                }else{
                    number=(decimalcurrency==="false")?parseFloat(value.replace(/\D/g, "")):parseFloat(value.replace(/[^\d\.]/g,''));
                }
                return (decimalcurrency==="false")?String(number).replace(/\B(?=(\d{3})+(?!\d))/g, "."):String(number);
            });
            (decimalcurrency==="false")?input.setMoney(input.val(),decimalcurrency):input.setMoney(parseFloat(this.value).toFixed(2),decimalcurrency);
            
            if (decimalcurrency==="true"){
                if (typeof $(this).val().split(".")[1] !== "undefined"){
                    if($(this).val().split(".")[1].length > 2){                
                        if( isNaN( parseFloat( this.value ) ) ) return;
                        this.value = parseFloat(this.value).toFixed(2);
                    }
                }
            }
        });
    });
};
/**
 * Puts a value in an element, could be a div or a input
 * @param {mixed} inputMoney Money value
 */
jQuery.fn.setMoney=function(inputMoney,decimalcurrency){
    if(typeof(inputMoney)==='string'){
        inputMoney=(decimalcurrency==="false")?inputMoney.replace(/\D/g, ""):inputMoney.replace(/[^\d\.]/g,'');
    }
    var money=parseFloat(inputMoney);
    if(isNaN(money)){
        money=0;
    }
    $(this).attr("data-value",money);
};
/**
 * Returns the money value of an DOM element
 * @return {float} Value of the data-value attribute
 */
jQuery.fn.getMoney=function(){
    var num=0;
    if($(this).attr("data-value")){
        num=parseFloat($(this).attr("data-value"));
    }else{
        $(this).attr("data-value",0);
    }
    return num;
};
/**
* Returns the closest number to a v number. Example: if v=1000 and n=600
* returns 1000
* @param {int} n number to convert
* @param {type} v number ceil/floor
* @returns {Function.nearest.n|undefined.nearest.n}
*/
util.nearest=function(n, v) {
    n = n / v;
    n = (n < 0 ? Math.floor(n) : Math.ceil(n)) * v;
    return n;
};
/**
 * Print an element of the DOM
 * @param {type} element Element of the DOM that will be printed
 * @param {string} cssPath Path to the css file
 * @param {function} callback Function to retunr when the print is over
 */
util.print=function(element,cssPath,callback){
    Popup($(element).html());
    function Popup(data){
        var win = window.open('', 'receipt', 'height=400,width=600');
        $.when($.get(cssPath)).done(function(css) {
            var html=
            '<html moznomarginboxes mozdisallowselectionprint>'+
                '<head>'+
                    '<style>'+
                        css+
                    '</style>'+
                    '<script></script>'+
                '</head>'+
                '<body >'+
                    data+
                '</body>'+
            '</html>';
            win.document.write(html);
            win.print();
            win.close();
            if(callback)callback();
            return true;
        });
    }
};
/**
 * Returns the day name in spanish
 * @param {Date} date Date
 * @return {string} Name of the day in spanish
 */
util.daySpanish=function(date){
    var days=new Array("Lunes", "Martes", "Miércoles","Jueves", "Viernes", "Sábado","Domingo");
    if(typeof date==='string'){
        date=new Date(date);
    }
    return days[date.getDay()];
};

/**
 * Reemplaza una cadena en otra, todas las ocurrencias
 * @param {string} search La cadena que se busca
 * @param {string} replace La cadena con la que se reemplaza
 * @param {string} string Cadena donde se busca y reemplaza
 * @returns {string} Cadena con subcadenas reemplazadas
 */
util.replace=function(search,replace,string){
    var regexp = new RegExp(search,"g");
    return string.replace(regexp,replace);
};

/**
 * Remove accents from a string
 * @param {type} string
 * @returns {string}
 */
util.removeAccents=function(string) {
    var string = string.split('');
    var strAccentsOut = new Array();
    var strAccentsLen = string.length;
    var accents = 'ÀÁÂÃÄÅàáâãäåÒÓÔÕÕÖØòóôõöøÈÉÊËèéêëðÇçÐÌÍÎÏìíîïÙÚÛÜùúûüÑñŠšŸÿýŽž';
    var accentsOut = "AAAAAAaaaaaaOOOOOOOooooooEEEEeeeeeCcDIIIIiiiiUUUUuuuuNnSsYyyZz";
    for (var y = 0; y < strAccentsLen; y++) {
        if (accents.indexOf(string[y]) != -1) {
                strAccentsOut[y] = accentsOut.substr(accents.indexOf(string[y]), 1);
        } else
            strAccentsOut[y] = string[y];
    }
    strAccentsOut = strAccentsOut.join('');
    return strAccentsOut;
};

/**
 * Difference between two dates in days
 * @param {Date} a First date
 * @param {Date} b Second date
 * @returns {Number}
 */
util.dateDiffInDays=function(a, b) {
    var _MS_PER_DAY = 1000 * 60 * 60 * 24;
    // Discard the time and time-zone information.
    var utc1 = Date.UTC(a.getFullYear(), a.getMonth(), a.getDate());
    var utc2 = Date.UTC(b.getFullYear(), b.getMonth(), b.getDate());
    return Math.floor((utc2 - utc1) / _MS_PER_DAY);
};

/**
* Return a Date object with date and the specified time in the input string
* @param {string} stringDate Date in string. Must be YYYY-mm-dd HH:ii:ss
* @return {Date} Date object
*/
util.stringToDate=function(stringDate){
    var parts=$.trim(stringDate).split(' ');
    var dateParts=$.trim(parts[0]).split('-');
    var timeParts=$.trim(parts[1]).split(':');
    var year=parseInt(dateParts[0]);
    var month=parseInt(dateParts[1])-1;
    var day=parseInt(dateParts[2]);
    var date=new Date();
    date.setYear(year);
    date.setMonth(month);
    date.setDate(day);
    //If has time part
    if(parts[1]){
        var hour=parseInt(timeParts[0]);
        var minutes=parseInt(timeParts[1]);
        var seconds=parseInt(timeParts[2]);
        date.setHours(hour);
        date.setMinutes(minutes);
        date.setSeconds(seconds);
    }
    return date;
};

/**
* Return a Date object with date and the specified time in the input string
* @param {Date} date Date object
* @return {string} Date in string: YYYY-mm-dd HH:ii:ss
*/
util.dateToString=function(date){
    var dateString=date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate();
    var timeString=date.getHours()+':'+date.getMinutes()+':'+date.getSeconds();
    return dateString+' '+timeString;
};

/**
* Return a Date object with today date and the specified time
* @param {string} time Time to return. Must be HH:ii:ss or HH:ii
* @return {Date} Date of today with the time
*/
util.stringToHour=function(time){
   var timeParts=$.trim(time).split(':');
   var hour=parseInt(timeParts[0]);
   var minutes=parseInt(timeParts[1]);
   var seconds=0;
   if(timeParts[2]!==undefined){
       seconds=parseInt(timeParts[2]);
   }
   var date=new Date();
   date.setHours(hour);
   date.setMinutes(minutes);
   date.setSeconds(seconds);
   return date;
};

/**
 * Returns the difference in secind from millis
 * @param {Number} millis
 * @returns {Number} In minutes
 */
util.inSeconds=function(millis){
    return Math.floor(millis/1000);
};
/**
 * Returns the difference in minutes from millis
 * @param {Number} millis
 * @returns {Number} In minutes
 */
util.inMinutes=function(millis){
    return Math.floor((millis/1000)/60);
};
/**
 * Returns the difference in hours from millis
 * @param {Number} millis
 * @returns {Number} In hours
 */
util.inHours=function(millis){
    return Math.floor((millis/1000)/60/60);
};

/**
 * Add time to a date
 * From Here: http://stackoverflow.com/a/1214753/1613459
 * @param {Date} date Date object
 * @param {string} interval Name of interval to add
 * @param {int} units Quantity to add
 * @returns {Date} Date object with the time added
 */
//DAVID: No funciona bien para agregar un mes cuando el día es 31
util.addTime=function(date,interval,units) {
    var ret = new Date(date); //don't change original date
    switch(interval.toLowerCase()) {
        case 'year'   :  ret.setFullYear(ret.getFullYear() + units);  break;
        case 'quarter':  ret.setMonth(ret.getMonth() + 3*units);  break;
        case 'month'  :  ret.setMonth(ret.getMonth() + units);  break;
        case 'week'   :  ret.setDate(ret.getDate() + 7*units);  break;
        case 'day'    :  ret.setDate(ret.getDate() + units);  break;
        case 'hour'   :  ret.setTime(ret.getTime() + units*3600000);  break;
        case 'minute' :  ret.setTime(ret.getTime() + units*60000);  break;
        case 'second' :  ret.setTime(ret.getTime() + units*1000);  break;
        default       :  ret = undefined;  break;
    }
    return ret;
};

/**
 * Add months to a date handling edge cases (leap year, shorter months, etc):
 * From Here: http://stackoverflow.com/questions/5645058/how-to-add-months-to-a-date-in-javascript
 * @param {int} months Quantity to add
 * @returns {Date} Date object with the time added
 */
Date.isLeapYear = function (year) { 
    return (((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0)); 
};

Date.getDaysInMonth = function (year, month) {
    return [31, (Date.isLeapYear(year) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
};

Date.prototype.isLeapYear = function () { 
    return Date.isLeapYear(this.getFullYear()); 
};

Date.prototype.getDaysInMonth = function () { 
    return Date.getDaysInMonth(this.getFullYear(), this.getMonth());
};

Date.prototype.addMonths = function (value) {
    var n = this.getDate();
    this.setDate(1);
    this.setMonth(this.getMonth() + value);
    this.setDate(Math.min(n, this.getDaysInMonth()));
    return this;
};