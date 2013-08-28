<h1>Register</h1>
{% if success %}
Your account has been created!
{% else %}
<form method="post" enctype="multipart/form-data">
<ol>
<li>
<label>
First name:
<input type="text" name="first" />
{{ error_first }}
</label>
</li>
<li>
<label>
Last name:
<input type="text" name="last" />
{{ error_last }}
</label>
</li>
<li>
<label>
Email:
<input type="text" name="email" />
{{ error_email }}
</label>
</li>
<li>
<label>
Password:
<input type="password" name="password" />
{{ error_password }}
</label>
</li>
<li>
	<label>
		Photo :
		<input type="file" name="photo" />
	</label>
</li>
<li>
<input type="submit" name="register" value="register" />
</li>
</ol>
</form>
{% endif %}