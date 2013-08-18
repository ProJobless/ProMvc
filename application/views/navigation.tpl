<a href="/">home</a>
{if (isset($user))}    
<a href = "/profile">profile</a>    
<a href = "/settings">settings</a>    
<a href = "/logout">logout</a> 
{/if} 
{else}    
<a href = "/register">register</a>    
<a href = "/login">login</a> 
{/else} 