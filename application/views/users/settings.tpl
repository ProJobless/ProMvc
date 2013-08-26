<h1 > Settings</h1> 
{if isset($success)}    
Your account has been updated! 
{/if}
{else}    
<form method="post" enctype="multipart/form-data">  
<ol>            
<li>                
<label>                    
First name:                    
<input type="text" name="first" value="{echo $user-> first}" />   
{echo \Framework\Shared\Markup::errors($errors, "first")}             
</label>            
</li>            
<li>                
<label>                    
Last name:                    
<input type="text" name="last" value="{echo $user-> last}" /> 
{echo \Framework\Shared\Markup::errors($errors, "last")}               
</label>            
</li>            
<li>                
<label>                    
Email:                    
<input type="text" name="email" value="{echo $user-> email}" />  
{echo \Framework\Shared\Markup::errors($errors, "email")}              
</label>            
</li>            
<li>                
<label>                    
Password:                    
<input type="password" name="password" value="{echo $user-> password}" /> 
{echo \Framework\Shared\Markup::errors($errors, "password")}            
</label>            
</li>   
<li>
	<label>
		Photo :
		<input type="file" name="photo" />
	</label>
</li>       
<li>                
<input type="submit" name="update" value="update" />            
</li>        
</ol>    
</form> 
{/else}

