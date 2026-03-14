"use strict";

console.log("Loading dashboard script...");

document.addEventListener("DOMContentLoaded", async () => {
  const status = document.querySelector("#mbStatus");
  const dashboardEl = document.querySelector("#mbDashboard");

  try {
    status.textContent = "Loading dashboard...";

    const response = await fetch("metrics_manager/metabase_token.php", {
  credentials: "same-origin",
});

    if (!response.ok) throw new Error("Failed to retrieve Metabase token.");

    const data = await response.json();

    if (!data.token) throw new Error("Token missing from response.");

    dashboardEl.setAttribute("token", data.token);

    status.textContent = "";
  } catch (err) {
    console.error(err);
    status.textContent = "Unable to load metrics dashboard.";
  }
});