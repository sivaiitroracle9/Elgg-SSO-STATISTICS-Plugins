<?php
	header("Content-type: text/javascript");
?>


friends_chart_stats = function () {
    $.getJSON('userstatsdata/jsonfriends.php', function (data) {

        // create the chart
        $('#friends_container').highcharts('StockChart', {
            chart: {
                alignTicks: false
            },

            rangeSelector: {
                selected: 1
            },

            title: {
                text: 'Friends added statistics'
            },

            series: [{
                type: 'column',
                name: 'Friends',
                data: data,
                dataGrouping: {
                    units: [ [
                        'day',
                        [1] 
                    ], [
                        'week', // unit name
                        [1] // allowed multiples
                    ], [
                        'month',
                        [1, 2, 3, 6]
                    ], [
			'year',
			[1, 2, 3]
			]]
                }
            }]
        });
    });
}
