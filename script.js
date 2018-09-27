window.addEventListener('load', function (event) {
  window.onscroll = function() {toggleMenu()};

  var navbar = document.getElementById("navbar");
  var sticky = navbar.offsetTop;

  var contactUs = document.querySelector('#contact-nav-link');

  var cForm = document.getElementById("c-form");

  var brand = document.querySelector('#brand');

  var sendMsgBtn = document.getElementById("c-form-submit");

  var submitMsg = document.getElementById("submitMsg");

  function toggleMenu() {
    if (window.pageYOffset >= sticky) {
      navbar.classList.add("sticky");
    } else {
      navbar.classList.remove("sticky");
    }

    if(window.pageYOffset > (cForm.offsetTop - 500) && (window.pageYOffset < (cForm.offsetTop + 160) )) {
      navbar.classList.add("invisible");
    } else {
      navbar.classList.remove("invisible");
    }
  }

  contactUs.addEventListener('click', function() {
    smoothScroll("#form-title", 1000);
  });

  brand.addEventListener('click', function() {
    smoothScroll("#hero-section", 1000);
  });

  sendMsgBtn.addEventListener('click', function() {
    console.log('clicked send message');
    var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // submitMsg.innerHTML = this.responseText;
                console.log('this.responseText: ', this.responseText);
            }
        }
        xmlhttp.open("GET", "ajax_mail_handler.php", true);
        xmlhttp.send();
  });

  function smoothScroll(target, duration){
    var target = document.querySelector(target);
    var targetPosition = target.getBoundingClientRect().top;
    var startPosition = window.pageYOffset;
    var distance = targetPosition - startPosition;
    var startTime = null;

    function animation(currentTime){
      if(startTime === null) startTime = currentTime;
      var timeElapsed = currentTime - startTime;
      var run = ease(timeElapsed, startPosition, targetPosition, duration);
      window.scrollTo(0, run);
      if(timeElapsed < duration) requestAnimationFrame(animation);
    }

    function ease(t, b, c, d) {
      t /= d / 2;
      if (t < 1) return c / 2 * t * t + b;
      t--;
      return -c / 2 * (t * (t - 2) - 1) + b;
    }

    requestAnimationFrame(animation);

  }

  function scrollTo(element, to, duration) {
    if (duration <= 0) return;
    var difference = to - element.scrollTop;
    var perTick = difference / duration * 10;

    setTimeout(function() {
        element.scrollTop = element.scrollTop + perTick;
        if (element.scrollTop === to) return;
        scrollTo(element, to, duration - 10);
    }, 10);
}

});
