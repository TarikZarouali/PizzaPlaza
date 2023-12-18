//START TOAST HANDLING{
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
  if (cleanedSegment !== undefined) {
    const [toastValue, toastMessage] = cleanedSegment.split(":");
    if (toastMessage !== undefined) {
      const [toasttitleValue, ...messageParts] = toastMessage.split(";");
      if (toastmessageValue !== undefined) {
        const toastmessageValue = messageParts.join(";");
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
    }
  }
}

// END TOAST HANDLING}

//START ENITY HANDLING ON REVIEW PAGE
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
// END ENTITY HANDLING ON REVIEW PAGE

// START navigation HOMEPAGE
// Add an event listener to the radio buttons
document.querySelectorAll('input[name="type"]').forEach(function (radio) {
  radio.addEventListener("change", function () {
    // Get the selected product type
    var selectedType = this.getAttribute("data-filter");

    // Hide all ingredients
    document.querySelectorAll(".ingredient").forEach(function (ingredient) {
      ingredient.style.display = "none";
    });

    // Show ingredients for the selected type
    if (selectedType !== "*") {
      document
        .querySelectorAll('.ingredient[data-filter="' + selectedType + '"]')
        .forEach(function (ingredient) {
          ingredient.style.display = "block";
        });
    }
  });
});
// END navigation HOMEPAGE

// START FORMCHECKING ON REGISTERE
async function signUp(event) {
  event.preventDefault();

  const form = document.querySelector("form");

  // Remove existing error messages
  const existingErrors = form.querySelectorAll(".bg-accent");
  existingErrors.forEach((error) => error.remove());

  // Create an object to store the form data
  const formData = new FormData(form);

  // Make a POST request using the fetch API
  const ajaxFetch = await fetch("http://localhost/pizzaplaza/users/register", {
    method: "POST",
    body: formData,
  });

  const response = await ajaxFetch.json();

  if (response.success) {
    console.log(response.success.message);
    window.location.href = "http://localhost/pizzaplaza/users/login/";
  } else {
    // Loop through the response and append error messages to the corresponding input fields
    Object.keys(response).forEach((fieldName) => {
      const inputField = form.querySelector(`[name="${fieldName}"]`);
      const errorMessage = response[fieldName].message;

      if (inputField) {
        // Create and append error element
        const errorElement = document.createElement("div");
        errorElement.className =
          "bg-accent bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs";
        errorElement.textContent = errorMessage;

        // Append error element after the input field
        inputField.parentNode.insertBefore(
          errorElement,
          inputField.nextSibling
        );
      }
    });
  }
}
//END FORMCHECKING ON REGISTER

//FORMCHECKING ON LOGIN
async function signIn(event) {
  event.preventDefault();

  const form = document.querySelector("form");

  // Remove existing error messages
  const existingErrors = form.querySelectorAll(".bg-accent");
  existingErrors.forEach((error) => error.remove());

  // Create an object to store the form data
  const formData = new FormData(form);

  // Make a POST request using the fetch API
  const ajaxFetch = await fetch("http://localhost/pizzaplaza/users/login", {
    method: "POST",
    body: formData,
  });

  const response = await ajaxFetch.json();

  if (response.success) {
    console.log(response.success.message);
    window.location.href = "http://localhost/pizzaplaza/users/usersettings/";
  } else {
    // Loop through the response and append error messages to the corresponding input fields
    Object.keys(response).forEach((fieldName) => {
      const inputField = form.querySelector(`[name="${fieldName}"]`);
      const errorMessage = response[fieldName].message;
      console.log(response);
      if (inputField) {
        // Create and append error element
        const errorElement = document.createElement("div");
        errorElement.className =
          "bg-accent bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs";
        errorElement.textContent = errorMessage;

        // Append error element after the input field
        inputField.parentNode.insertBefore(
          errorElement,
          inputField.nextSibling
        );
      }
    });
  }
}

async function editUser(event) {
  event.preventDefault();

  const form = document.querySelector("form");

  // Remove existing error messages
  const existingErrors = form.querySelectorAll(".bg-accent");
  existingErrors.forEach((error) => error.remove());

  // Create an object to store the form data
  const formData = new FormData(form);

  // Make a POST request using the fetch API
  const ajaxFetch = await fetch(
    "http://localhost/pizzaplaza/users/usersettings/",
    {
      method: "POST",
      body: formData,
    }
  );

  const response = await ajaxFetch.json();

  if (response.success) {
    console.log(response.success.message);
    window.location.href = "http://localhost/pizzaplaza/users/usersettings/";
  } else {
    // Loop through the response and append error messages to the corresponding input fields
    Object.keys(response).forEach((fieldName) => {
      const inputField = form.querySelector(`[name="${fieldName}"]`);
      const errorMessage = response[fieldName].message;
      console.log(response);
      if (inputField) {
        // Create and append error element
        const errorElement = document.createElement("div");
        errorElement.className =
          "bg-accent bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs";
        errorElement.textContent = errorMessage;

        // Append error element after the input field
        inputField.parentNode.insertBefore(
          errorElement,
          inputField.nextSibling
        );
      }
    });
  }
}

// END FORMCHECKING ON LOGIN
