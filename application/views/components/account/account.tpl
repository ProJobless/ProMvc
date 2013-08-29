<div id="component_account">
	<div class="title-divider">
		<h3>{{ account_title }}</h3>
	</div>
	<section class="widget">
		<b>{{ account_first }}</b><br />
		<b>{{ account_last }}</b><br />
		{{ account_admin }}<br />
		{{ account_ip_adress }}<br />
		
		{% if account_admin_link %}
			<a href="{{ account_admin_link }}">Module d'administration</a>
		{% endif %}
		
		<div class="pull-right">
			<a href="{{ account_logout }}"><i>Se déconnecter</i></a>
		</div>
		<div class="clearfix"></div>
	</section>
</div>
