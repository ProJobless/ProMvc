<h1>Edit User (admin)</h1>

{if isset($success)}
	The user has been updated!
{/if}
{else}
	<form method="post">
		<ol>
			<li>
				<label>
					First name:
					<input type="text" name="first" value="{echo $user->first}" />
					
				</label>
			</li>
			<li>
				<label>
					Last name:
					<input type="text" name="last" value="{echo $user->last}" />
					
				</label>
			</li>
			<li>
				<label>
					Email:
					<input type="text" name="email" value="{echo $user->email}" />
					{echo $email}
				</label>
			</li>
			<li>
				<label>
					Password:
					<input type="password" name="password" value="{echo $user->password}" />
					{echo $password}
				</label>
			</li>
			<li>
				<label>
					Live:
					<input type="checkbox" name="live" {if $user->live} checked="checked"{/if} />
				</label>
			</li>
			<li>
				<label>
					Admin:
					<input type="checkbox" name="admin" {if $user->admin} checked="checked"{/if} />
				</label>
			</li>
			<li>
				<input type="submit" name="save" value="save" />
			</li>
		</ol>
	</form>
{/else}