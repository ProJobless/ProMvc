<a href = "/">home</a>
<a href = "/search">search</a>
{if (isset($user))}    
	<a href = "/profile">profile</a>    
	<a href = "/settings">settings</a>    
	<a href = "/logout">logout</a> 
	{if $user->admin}
		<a href = "/users/view">view users</a>
		<a href = "/files/view">view files</a>
	{/if}
{/if} 
{else}    
	<a href = "/register">register</a>    
	<a href = "/login">login</a> 
{/else} 