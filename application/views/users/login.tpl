<h1 > Login</h1>
<form method = "post">
	<ol>
		<li>
			<label>
				Email:
				<input type = "text" name = "email" />
				{if isset($email_error)}
					{echo $email_error}
				{/if}
			</label>
		</li>
		<li>
			<label>
				Password:
				<input type = "password" name = "password" />
				{if isset($password_error)}
					{echo $password_error}
				{/if}
			</label>
		</li>
		<li>
			<input type = "submit" name = "login" value = "login" />
		</li>
	</ol>
</form>