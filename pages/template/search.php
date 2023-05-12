<script>
  function filterEvents() {
    const inputValue = document.getElementById("searchInput").value.toUpperCase();

    const events = document.querySelectorAll(".event");

    for (var i = 0; i < events.length; i++) {
      const eventName = events[i].getAttribute("data-name");
      if (eventName.toUpperCase().indexOf(inputValue) > -1) {
        events[i].style.display = "";
      } else {
        events[i].style.display = "none";
      }
    }
  }
</script>