<h1>Edit : {{ news.getTitle }}</h1>

<form method="post">
	<ol>
		<li>
			<label>
				Title:
				<input type="text" name="title" value="{{ news.getTitle }}" />
				{{ news_title_error }}
			</label>
		</li>
		<li>
			<label>
				Content:
				<textarea class="cleditor" name="content" id=content rows="3">{{ news.getContent }}</textarea>
			</label>
		</li>
		<li>
			<label>
				Live:
				<input type="checkbox" name="live" {%if news.getLive %} checked="checked"{% endif %} />
			</label>
		</li>
	
		<li>
			<input type="submit" name="save" value="save" />
		</li>
	</ol>
</form>

<script type="text/javascript">
$(document).ready(function () { $("#content").cleditor(); });
</script>