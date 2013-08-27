<h1>View Users (admin)</h1>

<table>
	<tr>
		<th>Name</th>
		<th>Change</th>
	</tr>
	{foreach $_user in $users}
		<tr>
			<td>{echo $_user->first} {echo $_user->last}</td>
			<td>
				<a href="/users/edit/{echo $_user->id}">edit</a>
				{if $_user->live}
					<a href="/users/delete/{echo $_user->id}">delete</a>
				{/if}
				{else}
					<a href="/users/undelete/{echo $_user->id}">undelete</a>
				{/else}
			</td>
		</tr>
	{/foreach}
</table>