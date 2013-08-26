{script $file = $user->file}
<h1>{echo $user-> first} {echo $user-> last}</h1>
{if $file}<img src="/uploads/{echo $file->name}" />{/if}
This is a profile page!