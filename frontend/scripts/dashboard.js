// dashboard.js
document.addEventListener("DOMContentLoaded", () => {
  console.log("✅ dashboard.js DOMContentLoaded");

  const modal = document.getElementById("eventModal");
  const openBtn = document.getElementById("openEventForm");
  const closeBtn = document.getElementById("closeEventForm");

  if (!modal || !openBtn || !closeBtn) {
    console.error("⛔ Modal elements not found.");
    return;
  }

  openBtn.addEventListener("click", () => {
    modal.classList.remove("hidden");
  });

  closeBtn.addEventListener("click", () => {
    modal.classList.add("hidden");
  });

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") modal.classList.add("hidden");
  });

  const form = document.getElementById("createEventForm");
  if (form) {
    form.addEventListener("submit", (e) => {
      e.preventDefault();
      console.log("🎉 Event Created!");
      modal.classList.add("hidden");
      form.reset();
    });
  }
});
