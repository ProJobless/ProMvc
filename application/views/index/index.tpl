<div class="row">
	<div class="col-md-3">.col-md-3</div>
    <div class="col-md-7">
    
    	<script type="text/javascript">
	    	var chart = new AmCharts.AmSerialChart();
	    	var graph = new AmCharts.AmGraph();
	    	graph.valueField = 'value';
	    	graph.type = 'line';
	    	graph.fillAlphas = 1;
	    	chart.addGraph(graph);
	    	chart.write("chartdiv");
        </script>
    	<div id="chartdiv" style="width: 100%; height: 400px;"></div>
    	
    </div>
    <div class="col-md-2">
    	{% include 'components/account/account.tpl' %}
    	{% include 'components/contact/contact.tpl' %}
    </div>
</div>