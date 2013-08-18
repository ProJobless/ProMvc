<h1>Register</h1>
{if isset($success)}
Your account has been created!
{/if}
{else}
<form method="post">
<ol>
<li>
<label>
First name:
<input type="text" name="first" />
{echo \Framework\Shared\Markup::errors($errors, "first")}
</label>
</li>
<li>
<label>
Last name:
<input type="text" name="last" />
{echo \Framework\Shared\Markup::errors($errors, "last")}
</label>
</li>
<li>
<label>
Email:
<input type="text" name="email" />
{echo \Framework\Shared\Markup::errors($errors, "email")}
</label>
</li>
<li>
<label>
Password:
<input type="password" name="password" />
{echo \Framework\Shared\Markup::errors($errors, "password")}
</label>
</li>
<li>
<input type="submit" name="register" value="register" />
</li>
</ol>
</form>
{/else}