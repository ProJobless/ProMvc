<div id="component_contact">
	<div class="title-divider">
		<h3>{{ contact_title }}</h3>
	</div>
	<section class="widget">
		{% for idx in contact_directique %}
        	{{ idx.first }} {{ idx.last }}<br />
    	{% endfor %}
	</section>
</div>