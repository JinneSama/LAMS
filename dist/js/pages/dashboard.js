$(function () {
  fetch('../data/weeklyAttendance.php')
    .then(response => response.json())
    .then(data => {
      const ctx = $('#visitors-chart');

      const visitorsChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: data.labels,
          datasets: [
            {
              label: 'This Week',
              data: data.thisWeek,
              backgroundColor: 'transparent',
              borderColor: '#007bff',
              pointBorderColor: '#007bff',
              pointBackgroundColor: '#007bff',
              fill: false
            },
            {
              label: 'Last Week',
              data: data.lastWeek,
              backgroundColor: 'transparent',
              borderColor: '#ced4da',
              pointBorderColor: '#ced4da',
              pointBackgroundColor: '#ced4da',
              fill: false
            }
          ]
        },
        options: {
          maintainAspectRatio: false,
          legend: {
            display: true
          },
          scales: {
            yAxes: [{
              gridLines: {
                display: true,
                lineWidth: '4px',
                color: 'rgba(0, 0, 0, .2)',
                zeroLineColor: 'transparent'
              },
              ticks: {
                beginAtZero: true,
                suggestedMax: 50
              }
            }],
            xAxes: [{
              gridLines: {
                display: false
              }
            }]
          }
        }
      });
    });
});
