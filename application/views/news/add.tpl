<h1>Add a news</h1>

<form method="post" enctype="multipart/form-data">
	
	{% if news_success %}
		C'est ajouté x)
	{% endif %}
	
	
	<div class="controls">
		<label>
			Title:
			<input type="text" name="title" placeholder="Titre" />
			<span class="ferror">{{ news_error_title }}</span>
		</label>
	</div>
	
	<div class="controls">
		<label>
			Content:
			<textarea class="cleditor" name="content" id=content rows="3"></textarea>
		</label>
	</div>


	<input type="submit" name="add" value="Add" />

</form>
<script type="text/javascript">
$(document).ready(function () { $("#content").cleditor(); });
</script>


