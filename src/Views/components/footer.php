<?php

use NataInditama\Auctionx\App\Auth;

if (Auth::getSession()) : ?>
  </main>
  </div>
<?php endif; ?>

<footer class="footer bg-gray-900 py-8">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 text-center">
        <h2><a href="#" class="m-0 text-primary fw-bold"><?= SITE_NAME; ?></a></h2>
        <div class="d-flex gap-3 justify-content-center align-items-center my-4">
          <a class="text-light" href="./">Home</a>
          <a class="text-light" href="./">About</a>
          <a class="text-light" href="./">News</a>
          <a class="text-light" target="_blank" href="http://github.com/natainditama/auctionx">Contact</a>
        </div>
        <div class="ftco-footer-social p-0">
          <li class="ftco-animate"><a href="#" class="border text-white" data-toggle="tooltip" data-placement="top" title="Twitter"><i data-feather="twitter" class="icon-xs"></i></a></li>
          <li class="ftco-animate"><a href="#" class="border text-white" data-toggle="tooltip" data-placement="top" title="Facebook"><span data-feather="facebook" class="icon-xs"></span></a></li>
          <li class="ftco-animate"><a href="#" class="border text-white" data-toggle="tooltip" data-placement="top" title="Instagram"><span data-feather="instagram" class="icon-xs"></span></a></li>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col-md-12 text-center">
          <p class="copyright">
            Copyright &copy;<?= date("Y") ?> All rights reserved
          </p>
        </div>
      </div>
    </div>
</footer>

<!-- Libs JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.37.2/apexcharts.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/toolbar/prism-toolbar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs5/1.13.4/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive/2.4.1/dataTables.responsive.min.js"></script>
<script src="https://dashui.codescandy.com/dashuipro/assets/js/vendors/datatable.js"></script>
<script src="./assets/js/theme.min.js"></script>
<script>
  (function($) {
    $.fn.simpleMoneyFormat = function() {
      this.each(function(index, el) {
        var elType = null; // input or other
        var value = null;
        // get value
        if ($(el).is('input') || $(el).is('textarea')) {
          value = $(el).val().replace(/,/g, '');
          elType = 'input';
        } else {
          value = $(el).text().replace(/,/g, '');
          elType = 'other';
        }
        // if value changes
        $(el).on('paste keyup', function() {
          value = $(el).val().replace(/,/g, '');
          formatElement(el, elType, value); // format element
        });
        formatElement(el, elType, value); // format element
      });

      function formatElement(el, elType, value) {
        var result = '';
        var valueArray = value.split('');
        var resultArray = [];
        var counter = 0;
        var temp = '';
        for (var i = valueArray.length - 1; i >= 0; i--) {
          temp += valueArray[i];
          counter++
          if (counter == 3) {
            resultArray.push(temp);
            counter = 0;
            temp = '';
          }
        };
        if (counter > 0) {
          resultArray.push(temp);
        }
        for (var i = resultArray.length - 1; i >= 0; i--) {
          var resTemp = resultArray[i].split('');
          for (var j = resTemp.length - 1; j >= 0; j--) {
            result += resTemp[j];
          };
          if (i > 0) {
            result += ','
          }
        };
        if (elType == 'input') {
          $(el).val(result);
        } else {
          $(el).empty().text(result);
        }
      }
    };
  }(jQuery));
</script>

<script>
  $(document).ready(function() {
    $('.money').simpleMoneyFormat();
    $('.money').attr("autocomplete", "off");

    $(".countdown").toArray().map(function(item) {
      const datetime = $(item).data("datetime");
      const format = $(item).data("datetime-format");
      countdown(datetime, $(item), format);
      console.log(item)
    })

    $.ajax({
      url: "./data/images.json"
    }).done(function(data) {
      $(".car-thumb").each(function() {
        const angle = $(this).data("angle")
        const makeIndex = getRandomInt(0, (data).length - 1);
        const modelIndex = getRandomInt(0, (data[makeIndex]['model']).length - 1);
        const url = `https://cdn.imagin.studio/getImage?angle=${angle}&billingTag=web&customer=carwow&make=${data[makeIndex]['make']}&modelFamily=${data[makeIndex]['model'][modelIndex]}&tailoring=carwow&width=800&zoomLevel=0&zoomType=fullscreen`
        $(this).attr('src', url)
        $(this).attr('srcSet', url)
      })
    }).fail(function() {
      $(".car-thumb").each(function() {
        $(this).attr('src', `https://cdn.imagin.studio/getImage`)
        $(this).attr('srcSet', `https://cdn.imagin.studio/getImage`)
      })
    })

  });

  function countdown(datetime, target, format = {
    "days": true,
    "hours": true,
    "minutes": true,
    "seconds": true,
    "full": false
  }) {
    // Set the date we're counting down to
    var countDownDate = new Date(datetime).getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

      // Get today's date and time
      var now = new Date().getTime();

      // Find the distance between now and the count down date
      var distance = countDownDate - now;

      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

      // Output the result in an element with id="demo"
      if (format.full) {
        target.html(`${days}:${hours}:${minutes}:${seconds}`);
      } else {
        target.html(`${format.days ? (days + " days") : ""} ${format.hours ? (hours + " hours") : ""} ${format.minutes ? (minutes + " minutes") : ""} ${format.seconds ? (seconds + " seconds") : ""}`);
      }

      // If the count down is over, write some text 
      if (distance < 0) {
        clearInterval(x);
        if (format.full) {
          target.html(`${days}:${hours}:${minutes}:${seconds}`);
        } else {
          target.html(`${format.days ? (0 + " days") : ""} ${format.hours ? (0 + " hours") : ""} ${format.minutes ? (0 + " minutes") : ""} ${format.seconds ? (0 + " seconds") : ""}`);
        }
      }
    }, 1000);
  }

  function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
  }
</script>
</body>

</html>