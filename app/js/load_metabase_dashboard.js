
"use strict";

console.log("Loading dashboard script...");

document.addEventListener("DOMContentLoaded", async () => {
    const status = document.querySelector("#mbStatus");
    const dashboardEl = document.querySelector("#mbDashboard");
    const shell = document.querySelector("#menu_quick_metrics .mb-embed-shell--quick");
    const panel = document.querySelector("#menu_quick_metrics > div");

    const syncHeight = () => {
        if (!shell || !panel) return;

        const shellHeight = shell.scrollHeight;

        if (shellHeight > 0) {
            panel.style.minHeight = shellHeight + "px";
        }
    };

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

        // Give Metabase a moment to begin rendering, then sync height
        setTimeout(syncHeight, 500);
        setTimeout(syncHeight, 1500);
        setTimeout(syncHeight, 3000);

        // Watch for size changes after render
        if (shell && panel) {
            const observer = new ResizeObserver(() => {
                syncHeight();
            });

            observer.observe(shell);
        }

    } catch (err) {
        console.error(err);
        status.textContent = "Unable to load metrics dashboard.";
    }
});



