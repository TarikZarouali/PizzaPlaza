function openToastAndRedirect() {
  // Show the toast
  var toast = document.querySelector(".js-toast");
  toast.classList.remove("toast--hidden");

  // Wait for 2 seconds (2000 milliseconds) and then redirect
  setTimeout(function () {
    // Replace 'your-redirect-url' with the actual URL where you want to redirect
    window.location.href = "<? URLROOT ?>/vehiclescontroller/index";
  }, 2000); // 2000 milliseconds = 2 seconds
}

function closeToast() {
  var toast = document.querySelector(".js-toast");
  toast.classList.add("toast--hidden");
}
