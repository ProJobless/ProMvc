<h1 > {echo $user-> first} {echo $user-> last}</h1>
This is a profile page!

{if isset($messages)}
	{foreach $message in $messages}
		{echo $message->body}<br />
	{/foreach}
{/if}

{if (isset($user))}
	<form method="post" action="messages/add">
		<textarea name="body"></textarea>
		<input type="submit" name="share" value="share" />
	</form>
{/if}

{if isset($messages)}
	{foreach $message in $messages}
		{echo $message->body}<br />
		{foreach $reply in Message::fetchReplies($message->id)}
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{echo $reply->body}<br />
		{/foreach}
		<form method="post" action="messages/add">
			<textarea name="body"></textarea>
			<input type="hidden" value="{echo $message->id}" name="message" />
			<input type="submit" name="share" value="share" />
		</form>
	{/foreach}
{/if}