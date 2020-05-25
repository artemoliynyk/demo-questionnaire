require('chart.js');

$(document).ready(function () {
    var chartsCollection = [];

    $chartHolder = $('#chart-holder');

    for (let questionID in chart_data) {

        var labels = [];
        var data = [];
        var bgColors = [];

        var question = chart_data[questionID];

        var $qCanvas = $('<canvas class="chart"></canvas>');

        $chartHolder.append($qCanvas).append('<br>');

        var title = question.question;
        $.each(question.answers, function (id, answer) {
            let userAnswer = id == user_responses[questionID];

            let answerText = answer.text;

            // add user answer label
            if (userAnswer) {
                answerText += ' (your answer)';
            }

            // bar label
            labels.push(answerText);

            let color = userAnswer ? '#ff5f5f' : '#5f9cff';

            // bar color
            bgColors.push(color);

            // data value
            data.push(answer.count);
        });

        var chart = new Chart($qCanvas[0], {
            //type: 'bar',
            type: 'horizontalBar',
            options: {
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                legend: {
                    display: true,
                    labels: {
                        text: ['test123']
                    }
                }
            },
            data: {
                datasets: [{
                    label: title,
                    data: data,
                    fill: false,
                    backgroundColor: bgColors,
                    borderWidth: 1
                }],
                labels: labels,
            }
        });
    }
});