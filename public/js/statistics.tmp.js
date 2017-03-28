$(document).ready(function(){
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Ages', 'Number of bookings'],
        ['Under 18', {{ $bookings18 }}],
        ['18 - 30', {{ $bookings30 }}],
        ['30 - 40', {{ $bookings40 }}],
        ['40 - 50', {{ $bookings50 }}],
        ['Over 50',{{ $bookingsover50 }}]
        ]);

      var options = {
        title: 'Bookings by ages',
        pieHole: 0.2,
      };

      var chart = new google.visualization.PieChart(document.getElementById('pie_chart_div'));
      chart.draw(data, options);
    }
});