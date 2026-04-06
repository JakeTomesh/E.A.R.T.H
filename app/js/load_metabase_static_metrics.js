"use strict";

document.addEventListener("DOMContentLoaded", async () => {
  const status = document.querySelector("#mbStatusStatic");
  const dashboardEl = document.querySelector("#mbDashboardStatic");

  try {
    status.textContent = "Loading metrics…";

    const res = await fetch("metrics_manager/metabase_token_static.php", {
      credentials: "same-origin"
    });

    if (!res.ok) throw new Error("Failed to retrieve Metabase token.");
    const data = await res.json();

    if (!data.token) throw new Error("Token missing from response.");

    dashboardEl.setAttribute("token", data.token);
    status.textContent = "";
  } catch (err) {
    console.error(err);
    status.textContent = "Unable to load metrics.";
  }
});