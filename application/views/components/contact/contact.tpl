<div class="component_contact">
	<div class="title-divider">
		<h3>{{ contact[nb]['contact_title'] }}</h3>
	</div>
	<section class="widget">
		
		{% for idx in contact[nb]['contact_directique'] %}
			{{ loop.index }} - {{ idx.first }}
        	{{ idx.first }} {{ idx.last }}<br />
    	{% endfor %}
	</section>
</div>