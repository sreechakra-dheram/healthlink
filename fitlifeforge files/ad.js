let reminders = [];

    // Load reminders from localStorage if available
    if (localStorage.getItem('reminders')) {
        reminders = JSON.parse(localStorage.getItem('reminders'));
        displayReminders();
    }

    function addReminder() {
        const title = document.getElementById("reminderInput").value;
        const dueDate = document.getElementById("dueDate").value;
        const dueTime = document.getElementById("dueTime").value;

        if (title === '' || dueDate === '' || dueTime === '') {
            alert("Please enter a title, date, and time for the reminder.");
            return;
        }

        const id = new Date().getTime().toString(); // Generate a unique ID
        let reminderDateTime = new Date(`${dueDate}T${dueTime}`);

        const reminder = {
            id: id,
            title: title,
            dueDate: dueDate,
            dueTime: dueTime
        };

        reminders.push(reminder);
        saveReminders();
        displayReminders();
        setNotification(reminder);
        clearInputFields();
    }

    function removeReminder(id) {
        reminders = reminders.filter(reminder => reminder.id !== id);
        saveReminders();
        displayReminders();
    }

    function displayReminders() {
        const reminderList = document.getElementById("reminderList");
        reminderList.innerHTML = '';

        reminders.forEach(reminder => {
            const tr = document.createElement("tr");

            const titleTd = document.createElement("td");
            titleTd.textContent = reminder.title;

            const dueDateTd = document.createElement("td");
            dueDateTd.textContent = reminder.dueDate;

            const dueTimeTd = document.createElement("td");
            dueTimeTd.textContent = reminder.dueTime;

            const removeTd = document.createElement("td");
            const removeButton = document.createElement("button");
            removeButton.textContent = "Remove";
            removeButton.onclick = () => removeReminder(reminder.id);
            removeTd.appendChild(removeButton);

            tr.appendChild(titleTd);
            tr.appendChild(dueDateTd);
            tr.appendChild(dueTimeTd);
            tr.appendChild(removeTd);

            reminderList.appendChild(tr);
        });
    }

    function clearInputFields() {
        document.getElementById("reminderInput").value = '';
        document.getElementById("dueDate").value = '';
        document.getElementById("dueTime").value = '';
    }

    function saveReminders() {
        localStorage.setItem('reminders', JSON.stringify(reminders));
    }

    function setNotification(reminder) {
        const notificationMessage = `Reminder: ${reminder.title}`;
        const now = new Date();
        const timeDiff = new Date(`${reminder.dueDate}T${reminder.dueTime}`).getTime() - now.getTime();
        
        if (timeDiff > 0) {
            setTimeout(() => {
                document.getElementById("notification").textContent = notificationMessage;
                document.getElementById("notification").style.display = "block";
                playNotificationSound();
            }, timeDiff);
        }
    }

    function playNotificationSound() {
        const notificationSound = document.getElementById("notificationSound");
        notificationSound.play();
    }
document.addEventListener('DOMContentLoaded', function() {
    let currentQuestion = 1;

    document.getElementById('next-question').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('question' + currentQuestion).style.display = 'none';
        currentQuestion++;
        if (currentQuestion <= 10) {
            document.getElementById('question' + currentQuestion).style.display = 'block';
        } else {
            document.getElementById('calculate-points').style.display = 'inline-block';
            document.getElementById('next-question').style.display = 'none';
        }
    });

    document.getElementById('points-form').addEventListener('submit', function(event) {
        event.preventDefault();

        // Check if at least one radio button is selected in each question group
        for (let i = 1; i <= 10; i++) {
            const questionValue = getRadioValue('question' + i);
            if (questionValue === null) {
                alert("Please answer all questions before submitting.");
                return;
            }
        }

        // Calculate total points and update chart
        const totalPoints = calculateTotalPoints();
        updateDonutChart(totalPoints);

        // Display total points and message
        displayResult(totalPoints);
    });

    // Helper function to get selected radio button value or null if none selected
    function getRadioValue(questionName) {
        const selectedRadio = document.querySelector('input[name="' + questionName + '"]:checked');
        return selectedRadio ? parseInt(selectedRadio.value) : null;
    }

    // Helper function to calculate total points
    function calculateTotalPoints() {
        let totalPoints = 0;
        for (let i = 1; i <= 10; i++) {
            const questionValue = getRadioValue('question' + i);
            totalPoints += questionValue;
        }
        return totalPoints;
    }

    // Helper function to display result
    function displayResult(totalPoints) {
        const totalPointsElement = document.getElementById('total-points');
        totalPointsElement.textContent = "Total Points: " + totalPoints;

        const msgElement = document.getElementById('msg');
        if (totalPoints >= 10 && totalPoints <= 16) {
            msgElement.textContent = "Your health choices could be better, but don’t despair. It’s never too late to take action to improve your health.";
        } else if (totalPoints >= 17 && totalPoints <= 24) {
            msgElement.textContent = "You are doing a fair job of managing your health practices and have taken some steps in the right direction.";
        } else if (totalPoints >= 25 && totalPoints <= 32) {
            msgElement.textContent = "You are doing a good job and are above average in managing your health.";
        } else {
            msgElement.textContent = "You are in excellent shape managing your health. Keep up the good work!";
        }
    }

    // Helper function to update donut chart
    function updateDonutChart(totalPoints) {
        const correctPoints = totalPoints;
        const incorrectPoints = 40 - totalPoints;

        const data = {
            labels: ['Points Earned', ''],
            datasets: [{
                data: [correctPoints, incorrectPoints],
                backgroundColor: ['#7B68EE', '#F3E5AB'],
                hoverBackgroundColor: ['#7B68EE', '#F3E5AB']
            }]
        };

        const options = {
            responsive: false,
            cutoutPercentage: 70,
            animation: {
                animateRotate: true,
                animateScale: true
            },
            plugins: {
                datalabels: {
                    display: false
                }
            }
        };
        function calculateBMI() {
    var height = parseFloat(document.getElementById('height').value);
    var weight = parseFloat(document.getElementById('weight').value);

    if (isNaN(height) || isNaN(weight) || height <= 0 || weight <= 0) {
        document.getElementById('result').innerHTML = 'Please enter valid height and weight.';
        return;
    }

    var bmi = weight / (height * height);
    var bmiText = '';

    if (bmi < 18.5) {
        bmiText = 'Underweight';
    } else if (bmi >= 18.5 && bmi < 24.9) {
        bmiText = 'Normal weight';
    } else if (bmi >= 25 && bmi < 29.9) {
        bmiText = 'Overweight';
    } else {
        bmiText = 'Obesity';
    }

    document.getElementById('result').innerHTML = 'Your BMI: ' + bmi.toFixed(2) + ' - ' + bmiText;
}
        const ctx = document.getElementById('donut-chart').getContext('2d');

        if (window.myDonutChart instanceof Chart) {
            window.myDonutChart.data = data;
            window.myDonutChart.update();
        } else {
            window.myDonutChart = new Chart(ctx, {
                type: 'doughnut',
                data: data,
                options: options
            });
        }

        // Update the percentage label
        const percentageLabel = document.getElementById('percentage-label');
        percentageLabel.textContent = Math.min(((correctPoints / 40) * 100).toFixed(0), 100) + '%';
    }
});
function openPopup() {
    document.getElementById("popup").style.display = "block";
}
function closepopup(){
    document.getElementById("popup").style.display = "none";
}
function openPop() {
    document.getElementById("container").style.display = "block";
}
function closepop(){
    document.getElementById("container").style.display = "none";
}
