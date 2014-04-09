<html>
    <head>
        <title>Editor experiment</title>
        <link rel="stylesheet" type="text/css" href="../../css/reset.css">
        <link rel="stylesheet" type="text/css" href="editor.css">
        
        
        <link rel="stylesheet" type="text/css" href="../jquery/jquery-ui.min.css">
        <script src="../jquery/jquery-2.1.0.min.js"></script>
        <script src="../jquery/jquery-ui.min.js"></script>
        <script type="text/javascript">
            $( document ).ready(function(){
                $("#editor").click(function(){
                    alert("Hi 7th @rt");
                });
                
                $(".draggable").draggable();
                $( ".droppable" ).droppable({
                    drop: function( event, ui ) {
                      $(this)
                        .addClass( "ui-state-highlight" )
                        .find( "p" )
                          .html( "Dropped!" );
                    }
                    });
            });
        </script>
    </head>
    <body>
        <header>
            <div id="header_7th_art">7th @rt administrator</div>
        </header>
        <div id="container">
            <nav id="navigation">
                sections
            </nav>
            <div id="workspace">
                <div id="editor">
                    <div id="toolbar">
                        <div class="draggable">object</div>
                    </div>
                    <div id="area" class="droppable">
                        
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>