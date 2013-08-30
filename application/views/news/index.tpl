<div class="row">
	<div class="col-md-3">.col-md-3</div>
    <div class="col-md-7">
    
    	<a href="/news/add">Nouvelle news</a>
    	
    	{% for new in news %}
    		<div id="news_container_{{ new.id }}">
    			<div class="news_header">
    				<div class="row">
    					<div class="col-md-7">
    						<b>{{ new.title }}</b>
    					</div>
    					<div class="col-md-3">{{ new.author }}</div>
    					<div class="col-md-2">
    						<div class="pull-right">
    							<a href="/news/edit/{{ new.id }}">Edt</a>
    							<a href="/news/delete/{{ new.id }}">Del</a>
    						</div>
    					</div>
    				</div>
    				
    			</div>
    		</div>
    		
    		
    		<div>
    		{{ new.content }}
    		</div>
    	{% endfor %}
    	
    	
    </div>
    <div class="col-md-2">
    	{% include 'components/account/account.tpl' %}
    	{% include 'components/contact/contact.tpl' %}
    </div>
</div>