<script>
    var ctx = document.getElementById('myChart').getContext('2d');

    var myChart = new Chart(ctx, {
        type: 'pie',

        data: {
            //labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            labels: [
                <?php foreach ($bookingChart as $level ){ echo '"'.$level->department.'"'.','; } ?>
                ],
            datasets: [{
                label: '# of Votes',
                //data: [12, 19, 3, 5, 2, 3],
                data: [
                <?php foreach ($bookingChart as $data ){ echo '"'.$data->total.'"'.','; } ?>
                ],
                backgroundColor: [<?php
                for ($i=0; $i <= $bookingChart->count(); $i++) {
                    echo  "'#". substr(md5(rand()), 0, 6)."',";
                    }?> ],
                borderColor: [],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });



var ctx2 = document.getElementById('todayTepmMeasuredChart').getContext('2d');
var myChart2 = new Chart(ctx2, {
    type: 'bar',
    data: {
        //labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        labels: [
                <?php foreach ($todayTepmMeasured as $level ){ echo '"'.$level->id_number.'"'.','; } ?>
                ],
        datasets: [{
            label: 'Today Records',
            data: [
                <?php foreach ($todayTepmMeasured as $data ){ echo '"'.$data->temp_final.'"'.','; } ?>
                ],
            backgroundColor: [<?php
                for ($i=0; $i <= $todayTepmMeasured->count(); $i++) {
                    echo  "'#". substr(md5(rand()), 0, 6)."',";
                    }?> ],
            borderColor: [],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});


</script>
