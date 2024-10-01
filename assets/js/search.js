$(document).ready(function () {
  $("#search-input").keyup(function () {
    var searchTerm = $(this).val();

    if (searchTerm.length >= 3) {
      $.ajax({
        url: "search.php",
        type: "POST",
        data: { searchTerm: searchTerm },
        beforeSend: function () {
          $("#search-results").html("<p>Searching...</p>");
        },
        success: function (data) {
          $("#search-results").html(data);
        },
        error: function () {
          $("#search-results").html("<p>Error occurred while searching.</p>");
        },
      });
    } else {
      $("#search-results").html("");
    }
  });
});
