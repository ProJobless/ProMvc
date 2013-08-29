<div id="auth_container">
	<span id="auth_title">Portal : portail de démonstration</span>
	
	<form method = "post">
		<ol>
			<li>
				<label>
					Email:
					<input type = "text" name = "email" />
					{% if email_error %}
						{{ email_error }}
					{% endif %}
				</label>
			</li>
			<li>
				<label>
					Password:
					<input type = "password" name = "password" />
					{% if password_error %}
						{{ password_error }}
					{% endif %}
				</label>
			</li>
			<li>
				<input type = "submit" name = "login" value = "login" />
			</li>
		</ol>
	</form>
</div>	