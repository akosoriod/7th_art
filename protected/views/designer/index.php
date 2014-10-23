<?php
/* @var $this DesignerController */

$this->breadcrumbs=array(
	'Designer',
);

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/editor.css');
Yii::app()->getClientScript()->registerCoreScript('jquery.ui');

?>
<script type="text/javascript">
            $( document ).ready(function(){
                $(".site-url").empty().append('<div class="icon"> </div> 7 <sup>th</sup> @rt Designer');
                
                
                
                
                
                
                var countObjects=0;
                $(".button").draggable({
                    appendTo: "body",
                    containment: "#workspace",
                    cursor: "move",
//                    helper: "clone",
                    helper: function(){
                        return $( "<div class='object-helper'></div>" );
                    },
                    opacity: 0.8,
                    scroll: false
                });
                $("#workspace").droppable({
                    accept: ".button",
                    drop: function( event, ui ) {
                        if(ui.draggable.hasClass("object")){
                            countObjects++;
                            $(this).append('<div class="draggable object" id="object'+countObjects+'" data-id="'+countObjects+'"><div class="content"><div class="image"></div><div class="text"></div></div><div class="objectButton config"></div><div class="objectButton close">x</div></div>');
                            var object=$(this).find('#object'+countObjects);
                            object.draggable({
                                containment: "#workspace",
                                cursor: "move",
                                opacity: 0.4,
                                scroll: false
                            }).resizable({
                                containment: "#workspace"
                            });
                            var displacement=$("#workspace").offset();
                            object.css({
                                left:ui.position.left-displacement.left,
                                top:ui.position.top-displacement.top
                            });
                            object.find(".close").click(function(){
                                object.remove();
                            });
                            object.find(".config").click(function(){
                                var id=parseInt($(this).parent().attr("data-id"));
                                $("#properties")
                                        .attr("data-object",id)
                                ;
                                $("#properties").dialog("open");
                            });
                            var image=object.find(".image");
                            var text=object.find(".text");
                            image.draggable({
                                containment: object,
                                cursor: "move",
                                scroll: false
                            });
                            text.draggable({
                                containment: object,
                                cursor: "move",
                                scroll: false
                            });
                        }else{
                            alert("I'm a prototype");
                        }
                    }
                });
                                
                $("#properties").dialog({
                    autoOpen: false,
                    modal:true,
                    open: function(event,ui){
                        var id=parseInt($(this).attr("data-object"));
                        var object=$("#object"+id);
                        var props=$("#properties");
                        props.find("#id").text(id);
                        props.find("#background").val(hexc(object.css("background-color")));
                        props.find("#borders").val(hexc(object.css("border-bottom-color")));
                    },
                    buttons: {
                        "Ok": function() {
                            var props=$("#properties");
                            var background=props.find("#background");
                            var borders=props.find("#borders");
                            var bValid = true;
                            bValid = bValid && checkRegexp(background, /^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/i, "Only Hex format color");
                            bValid = bValid && checkRegexp(borders, /^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/i, "Only Hex format color");
                            if (bValid){
                                var id=parseInt($(this).attr("data-object"));
                                var object=$("#object"+id);
                                object.css({
                                    'background':background.val(),
                                    'border-color':borders.val()
                                });
                                $(this).dialog("close");
                            }
                        },
                        Cancel: function() {
                            $(this).dialog("close");
                        }
                    }
                });
                function checkRegexp( o, regexp, n ) {
                    if ( !( regexp.test( o.val() ) ) ) {
                        o.addClass( "ui-state-error" );
                        alert( n );
                        return false;
                    } else {
                        return true;
                    }
                }
                function hexc(colorval) {
                    var color;
                    var parts = colorval.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
                    delete(parts[0]);
                    for (var i = 1; i <= 3; ++i) {
                        parts[i] = parseInt(parts[i]).toString(16);
                        if (parts[i].length == 1) parts[i] = '0' + parts[i];
                    }
                    color = '#' + parts.join('');

                    return color;
                }
                
                var sections=$("#navigation").children("ul");
                sections.click(function(){
                    alert("only a prototype");
                });
            });
        </script>
<main>
    
    
    <?php
    $this->breadcrumbs=array(
	'Activity Sets',
    );
    ?>
    
    
    
    
    
    
    
    <div id="container">
        <nav id="navigation">
            Perfume
            <ul>
                <li>                  
                    Film Credits
                </li>
                <li>
                    Film Activity Credits
                </li>
                <li>
                    Synopsis
                    <ul>
                        <li>version 1</li>
                        <li>version 2</li>
                    </ul>
                </li>
                <li>
                    Pre-Viewing
                    <ul>
                        <li>version 1</li>
                        <li>version 2</li>
                    </ul>
                </li>
                <li>
                    Who's Who in...?
                    <ul>
                        <li>version 1</li>
                        <li>version 2</li>
                    </ul>
                </li>
                <li>
                    Film-Based
                    <ul>
                        <li>version 1</li>
                        <li>version 2</li>
                    </ul>
                </li>
                <li>
                    Spidermap
                    <ul>
                        <li>version 1</li>
                        <li>version 2</li>
                    </ul>
                </li>
                <li>
                    After-Viewing
                    <ul>
                        <li>version 1</li>
                        <li>version 2</li>
                    </ul>
                </li>
                <li>
                    The Expert Says...
                    <ul>
                        <li>version 1</li>
                        <li>version 2</li>
                    </ul>
                </li>
                <li>
                    Did you know that...?
                    <ul>
                        <li>version 1</li>
                        <li>version 2</li>
                    </ul>
                </li>
                <li>
                    Acknoledgements
                    <ul>
                        <li>version 1</li>
                        <li>version 2</li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="area">
            <div id="editor">
                <div id="toolbar">
                    <div class="button object" id="button-object" title="Drag an object"></div>
                    <div class="button" id="button1" title="I'm a prototype"></div>
                    <div class="button" id="button2" title="I'm a prototype"></div>
                    <div class="button" id="button3" title="I'm a prototype"></div>
                    <div class="button" id="button4" title="I'm a prototype"></div>
                </div>
                <div id="workspace" class="droppable"></div>


                <div id="properties" title="Properties">
                    <form>
                        <fieldset>
                            <label for="id">identifier</label>
                            <div name="id" id="id">0</div>
                            <label for="background">Background</label>
                            <input type="text" name="background" id="background" value="#000" class="text ui-widget-content ui-corner-all">
                            <label for="borders">Borders</label>
                            <input type="text" name="borders" id="borders" value="#000" class="text ui-widget-content ui-corner-all">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>