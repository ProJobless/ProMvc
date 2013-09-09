<div class="component_text">
	{% if text[nb]['text_title'] %}
		<div class="title-divider">
			<h3>{{ text[nb]['text_title'] }}</h3>
		</div>
	{% endif %}
	
	{{ text[nb]['text_content'] }}
</div>