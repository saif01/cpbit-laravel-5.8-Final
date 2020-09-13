<script>

 function formatDate(dateVal) {
                var newDate = new Date(dateVal);
                const monthFull = newDate.toLocaleString("default", {
                    month: "long"
                });
                var sMonth = padValue(newDate.getMonth() + 1);
                var sDay = padValue(newDate.getDate());
                var sYear = newDate.getFullYear();
                var sHour = newDate.getHours();
                var sMinute = padValue(newDate.getMinutes());
                var sAMPM = "AM";
                var iHourCheck = parseInt(sHour);

                if (iHourCheck > 12) {
                    sAMPM = "PM";
                    sHour = iHourCheck - 12;
                } else if (iHourCheck === 0) {
                    sHour = "12";
                }
                sHour = padValue(sHour);
                return monthFull + "-" + sDay + "-" + sYear + " " + sHour + ":" + sMinute + " " + sAMPM;
            }

            function padValue(value) {
                return (value < 10) ? "0" + value : value;
            }

</script>
