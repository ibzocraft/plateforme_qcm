<!-- Time Component -->

<!-- Heure -->
<div class="d-flex justify-content-end ">
    <div class="time h1 d-flex flex-row align-items-center">
        <div class="hour">12</div>:<div class="minute">00</div>
    </div>
</div>
<!-- /Heure -->
<!-- Style -->
<style>
    @keyframes time-in {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }
    .time .time-in { animation: time-in 1s ease; }
</style>
<!-- /Style -->
<!-- Script -->
<script>
    const time = document.querySelector(".time");
    const hour = time.querySelector(".hour");
    const minute = time.querySelector(".minute");
    let time_last_values = { hour: null, minute: null };
    function updateTime() {
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');

        if (time_last_values.hour != hours) {
            hour.classList.add("time-in");
            hour.textContent = hours;
        }
        if (time_last_values.minute != minutes) {
            minute.classList.add("time-in");
            minute.textContent = minutes;
        }
        time_last_values = { hour: hours, minute: minutes };

        setTimeout(() => {
            hour.classList.remove("time-in");
            minute.classList.remove("time-in");
        }, 500);
    }

    setInterval(updateTime, 10000);
    updateTime();
</script>
<!-- /Script -->
 
 <!-- /Time Component -->