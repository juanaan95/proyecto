document.getElementById("registerForm").addEventListener("submit", async function (event) {
    event.preventDefault();

    const nombre = document.getElementById("nombre").value;
    const email = document.getElementById("emailRegister").value;
    const password = document.getElementById("passwordRegister").value;

    const response = await fetch("/api/register", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ nombre_completo: nombre, email, password })
    });

    const data = await response.json();
    alert(data.message || data.error);
});

document.getElementById("loginForm").addEventListener("submit", async function (event) {
    event.preventDefault();

    const email = document.getElementById("emailLogin").value;
    const password = document.getElementById("passwordLogin").value;

    const response = await fetch("/api/login", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ email, password })
    });

    const data = await response.json();
    alert(data.message || data.error);
});
