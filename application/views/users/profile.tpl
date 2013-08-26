{script $file = $user->file}
<h1>{echo $user-> first} {echo $user-> last}</h1>
{if $file}<img src="/thumbnails/{echo $file->id}" />{/if}
This is a profile page!