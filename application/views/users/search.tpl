<h1 > Search</h1> 
<form method =  "post">    
<ol>        
<li>            
<label>                
Query:                
<input type =  "text" name =  "query" value =  "{echo $query}" />            
</label>        
</li>        
<li>            
<label>                
Order:                
<select name =  "order">                    
<option {if $order == "created"}selected =  "selected"{/if} value =  "created" > Created</option>                    
<option {if $order == "modified"}selected =  "selected"{/if} value =  "modified" > Modified</option>                    
<option {if $order == "first"}selected =  "selected"{/if} value =  "first" > First name</option>                    
<option {if $order == "last"}selected =  "selected"{/if} value =  "last" > Last name</option>                 
</select>             
</label>         
</li>         
<li>             
<label>                 
Direction:                 
<select name =  "direction">                     
<option {if $direction == "asc"}selected =  "selected"{/if} value =  "asc" > Ascending</option>                    
<option {if $direction == "desc"}selected =  "selected"{/if} value =  "desc" > Descending</option>                 
</select>             
</label>         
</li>         
<li>             
<label>                 
Page:                 
<select name =  "page">                     
{if $count == 0}                         
<option value =  "1" > 1</option>
{/if}                    
{else}                        
{foreach $_page in range(1, ceil($count / $limit))}                            
<option {if $page == $_page}selected =  "selected"{/if} value =  "{echo $_page}" > {echo $_page}</option>                        
{/foreach}                    
{/else}                
</select>            
</label>        
</li>        
<li>            
<label>                
Limit:                
<select name =  "limit">                    
<option {if $limit == "10"}selected= "selected"{/if} value= "10" > 10</option>                    
<option {if $limit == "20"}selected= "selected"{/if} value= "20" > 20</option>                    
<option {if $limit == "30"}selected= "selected"{/if} value= "30" > 30</option>                
</select>            
</label>        
</li>        
<li>            
<input type =  "submit" name =  "search" value =  "search" />        
</li>    
</ol> 
</form> {if $users !=  false}    <table>        
<tr>            
<th > Name</th>        
</tr>        
{foreach $row in $users}            
<tr>                
<td > {echo $row-> first} {echo $row->last}</td>   
<td>
	<a href="/users/friend/{echo $row->id}">friend</a>
	<a href="/users/unfriend/{echo $row->id}">unfriend</a>
</td>         
</tr>        
{/foreach}    
</table> 
{/if}              
