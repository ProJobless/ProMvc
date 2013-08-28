{% set file = user.file %}
<h1>{{ first }} {{ last }}</h1>
{% if file %}<img src="/thumbnails/{{ file_id }}" />{% endif %}

This is a profile page!