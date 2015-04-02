<?php
	header("Content-type: text/javascript");
?>

pageviews_chart_stats = function () {
    $.getJSON('userstatsdata/jsonpageviews.php', function (data) {

        // create the chart
        $('#pageviews_container').highcharts('StockChart', {
            chart: {
                alignTicks: false
            },

            rangeSelector: {
                selected: 1
            },

            title: {
                text: 'Page Views'
            },

            series: [{
                type: 'column',
                name: 'Page Views',
                data: data,
                dataGrouping: {
                    units: [
			[
                        'day', // unit name
                        [1] // allowed multiples
                    ]]
                }
            }]
        });
    });
}

