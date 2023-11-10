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
