<script>
  function filterEvents() {
    var inputValue = document.getElementById("searchInput").value.toUpperCase();

    var events = document.querySelectorAll(".event");

    for (var i = 0; i < events.length; i++) {
      var eventName = events[i].getAttribute("data-name");
      if (eventName.toUpperCase().indexOf(inputValue) > -1) {
        events[i].style.display = "";
      } else {
        events[i].style.display = "none";
      }
    }
  }
</script>