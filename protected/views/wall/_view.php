<div id="comment-<%=id%>" class="comment">
    <% if(own){ %>
        <a href="#" class="close" 
           style="display: none"
           data-dismiss="alert" aria-label="close" 
           title="Delete comment"
           onclick="borrarComentario(<%=id%>)">&times;</a>
    <% } %>
    <div class="comment-body <%= own? 'own':'' %>">
        <div class="comment-heading">
            <h4 class="user"><%= user %></h4>
            <h5 class="time"><%= jQuery.timeago(date) %></h5>
        </div>
        <p><%= comment %></p>
    </div>
</div>