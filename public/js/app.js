function openToastSuccess(title, message) {
  var toast = document.querySelector(".toast--success"); // Update the selector to match the success toast
  var toastTitle = toast.querySelector(".toast__title");
  var toastP = toast.querySelector(".toast__p");

  toastTitle.textContent = title;
  message = message.replace(/\+/g, " ");
  toastP.textContent = message;

  // Trigger the openToast event if needed
  var openToastEvent = new CustomEvent("openToast");
  toast.dispatchEvent(openToastEvent);
}

function openToastFailed(title, message) {
  var toast = document.querySelector(".toast--error"); // Update the selector to match the error toast
  var toastTitle = toast.querySelector(".toast__title");
  var toastP = toast.querySelector(".toast__p");

  toastTitle.textContent = title;
  message = message.replace(/\+/g, " ");
  toastP.textContent = message;

  // Trigger the openToast event if needed
  var openToastEvent = new CustomEvent("openToast");
  toast.dispatchEvent(openToastEvent);
}

// Extract toast parameters from the URL path
const urlPath = window.location.pathname;

// Use a regular expression to extract content inside slashes
const match = urlPath.match(/\/([^\/]+)\/([^\/]+)\/([^\/]+)$/);

console.log("URL Path:", urlPath); // Log URL path for debugging

if (match) {
  // Extract the content inside slashes and decode each component
  const toastValue = decodeURIComponent(match[1]);
  const toasttitleValue = decodeURIComponent(match[2]);
  const toastmessageValue = decodeURIComponent(match[3]);

  console.log(
    "Decoded Parameters:",
    toastValue,
    toasttitleValue,
    toastmessageValue
  ); // Log decoded parameters for debugging

  // Check if 'toast' parameter is present and has a value of 'true'
  if (toastValue === "true" && toasttitleValue && toastmessageValue) {
    console.log("Triggering openToast function");
    openToastSuccess(toasttitleValue, toastmessageValue);
  } else if (toastValue == "false" && toasttitleValue && toastmessageValue) {
    openToastFailed(toasttitleValue, toastmessageValue);
  } else {
    console.log(toastValue);
    console.log("Invalid or missing parameters for toast.");
  }
} else {
  // 'toast' parameter is not present
  console.log("Toast parameter is not present in the URL.");
}

function updateEntityOptions() {
  // Get the selected Entity Type
  var entityType = document.getElementById("entityType").value;

  // Get the dropdown elements for Store, Order, and Product
  var storeDropdowns = document.getElementsByClassName("js-storeDropdown");
  var orderDropdowns = document.getElementsByClassName("js-orderDropdown");
  var productDropdowns = document.getElementsByClassName("js-productDropdown");

  // Hide all dropdowns
  hideDropdowns(storeDropdowns);
  hideDropdowns(orderDropdowns);
  hideDropdowns(productDropdowns);

  // Display the selected dropdown based on the Entity Type
  switch (entityType) {
    case "1": // Order
      showDropdowns(orderDropdowns);
      break;
    case "2": // Store
      showDropdowns(storeDropdowns);
      break;
    case "3": // Product
      showDropdowns(productDropdowns);
      break;
  }
}

function hideDropdowns(dropdowns) {
  // Hide all dropdowns
  for (var i = 0; i < dropdowns.length; i++) {
    dropdowns[i].style.display = "none";
  }
}

function showDropdowns(dropdowns) {
  // Show all dropdowns
  for (var i = 0; i < dropdowns.length; i++) {
    dropdowns[i].style.display = "block";
  }
}
