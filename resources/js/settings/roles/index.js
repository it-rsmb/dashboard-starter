async function getUser() {
    try {
        const token = localStorage.getItem("auth_token");

        if (!token) {
            console.log("Tidak ada token, redirect ke login");
            window.location.href = "/login";
            return;
        }

        const res = await fetch("/api/user", {
            method: "GET",
            headers: {
                "Authorization": "Bearer " + token,
                "Accept": "application/json"
            }
        });

        if (!res.ok) throw new Error(`Error ${res.status}: Unauthorized`);

        const data = await res.json();
        console.log("User aktif:", data);
    } catch (error) {
        console.error("Fetch error:", error.message);
    }
}
// jalankan ketika page selesai render
document.addEventListener("DOMContentLoaded", async () => {
    const user = await getUser();
    if (user) {
        console.log("User logged in:", user);
        // misalnya update UI
        document.querySelector("#userName").innerText = user.name;
    } else {
        console.log("Tidak ada user aktif");
    }
});
