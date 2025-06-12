document
    .getElementById("product-form")
    .addEventListener("submit", async function (e) {
        e.preventDefault();

        const form = e.target;
        const date = new FormData(form);

        const response = await fetch(form.action, {
            method: "POST",
            body: data,
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
        });

        if (response.ok) {
            location.reload();
        }
    });
