function countdown() {
  // Set the date we're counting down to
  var countDownDate = new Date("Jun 24, 2023 08:59:59").getTime();

  // Update the count down every 1 second
  var x = setInterval(function () {

    // Get today's date and time
    var now = new Date().getTime();

    // Find the distance between now and the count down date
    var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Display the result in the element with id="demo"
    $("#countdown").html("<span> <span>Hari</span>" + days + "</span>" + "<span><span>Jam</span>" + hours + "</span>" + "<span><span>Menit</span>" + minutes + "</span>" + "<span><span>Detik</span>" + seconds + "</span>");

    // If the count down is finished, write some text
    if (distance < 0) {
      clearInterval(x);
      $("#countdown").html("EXPIRED");
    }
  }, 1000);
}

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $('#sbt-preview').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

$(document).ready(function () {
  countdown();

  $("#sbt-photo").on('change', function () {
    if (this.files[0].size > 5242880) {
      alert("File terlalu besar!");
      this.value = "";
    } else {
      var ext = $(this).val().split('.').pop().toLowerCase();
      if ($.inArray(ext, ['HEIF', 'HEIC', 'jpg', 'jpeg']) == -1) {
        alert('Tipe file tidak sesuai!');
      } else {
        readURL(this);

        var i = $(this).siblings('label').find('span').clone();
        var file = $('#sbt-photo')[0].files[0].name;
        $(this).siblings('label').find('span').text(file);
      }
    }
  });
  
  $('#form_vote').on('submit', function(e) {
    $('#submit_vote').prop('disabled', true);

    return true;
  })
  $('#form_rsvp').on('submit', function(e) {
    $('#submit_rsvp').prop('disabled', true);

    return true;
  })
  $('#form_dpt').on('submit', function(e) {
    $('#submit_dpt').prop('disabled', true);

    return true;
  })

});

