function openToastSuccess(title, message) {
  var toast = document.querySelector(".toast--success");
  var toastTitle = toast.querySelector(".toast__title");
  var toastP = toast.querySelector(".toast__p");

  toastTitle.textContent = title;
  message = decodeURIComponent(
    message.replace(/\+/g, " ").replace(/^}{|}$/g, "")
  );
  toastP.textContent = message;

  var openToastEvent = new CustomEvent("openToast");
  toast.dispatchEvent(openToastEvent);
}

function openToastFailed(title, message) {
  var toast = document.querySelector(".toast--error");
  var toastTitle = toast.querySelector(".toast__title");
  var toastP = toast.querySelector(".toast__p");

  toastTitle.textContent = title;
  message = decodeURIComponent(
    message.replace(/\+/g, " ").replace(/^}{|}$/g, "")
  );
  toastP.textContent = message;

  var openToastEvent = new CustomEvent("openToast");
  toast.dispatchEvent(openToastEvent);
}

const urlPath = window.location.pathname;

const segments = urlPath.split("/");

console.log("URL Segments:", segments);

if (segments.length >= 5) {
  const lastSegment = segments[segments.length - 1];

  // Remove the leading '%7B' and trailing '%7D'
  const cleanedSegment = lastSegment.slice(3, -3);

  // Split the cleaned segment into toast parameters
  const [toastValue, toastMessage] = cleanedSegment.split(":");
  const [toasttitleValue, ...messageParts] = toastMessage.split(";");

  const toastmessageValue = messageParts.join(";");

  console.log(
    "Decoded Parameters:",
    toastValue,
    toasttitleValue,
    toastmessageValue
  );

  if (
    toastValue !== undefined &&
    toasttitleValue !== undefined &&
    toastmessageValue !== undefined
  ) {
    if (toastValue === "true") {
      console.log("Triggering openToastSuccess function");
      openToastSuccess(toasttitleValue, toastmessageValue);
    } else if (toastValue === "false") {
      console.log("Triggering openToastFailed function");
      openToastFailed(toasttitleValue, toastmessageValue);
    } else {
      console.log("Invalid 'toast' parameter value.");
    }
  } else {
    console.log("Missing parameters for toast.");
  }
} else {
  console.log("Insufficient URL segments for toast.");
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
