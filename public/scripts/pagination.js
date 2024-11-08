document.addEventListener("DOMContentLoaded", function () {
    const itemsPerPage = 5; // Número de elementos por página
    const items = document.querySelectorAll(".table-container tr"); // Todos los elementos a paginar
    const totalPages = Math.ceil(items.length / itemsPerPage); // Total de páginas
    
    let currentPage = 1;

    // Función para mostrar los elementos de la página actual
    function showPage(page) {
        // Oculta todos los elementos
        items.forEach((item, index) => {
            item.style.display = "none";
        });

        // Calcula el índice inicial y final de los elementos a mostrar
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        // Muestra solo los elementos de la página actual
        for (let i = start; i < end; i++) {
            if (items[i]) {
                items[i].style.display = "table-row";
            }
        }

        // Actualiza la clase activa de la paginación
        document.querySelectorAll(".page-number").forEach((pageElem) => {
            pageElem.classList.remove("active");
        });
        document.getElementById(`page-${page}`).classList.add("active");
    }

    // Función para cambiar de página
    function goToPage(page) {
        if (page < 1) page = 1;
        if (page > totalPages) page = totalPages;
        currentPage = page;
        showPage(page);
    }

    // Evento para cada número de página
    document.querySelectorAll(".page-number").forEach((pageElem) => {
        pageElem.addEventListener("click", function () {
            const page = parseInt(this.id.replace("page-", ""));
            goToPage(page);
        });
    });

    // Evento para los botones de siguiente y anterior
    document.getElementById("prev-page").addEventListener("click", function () {
        goToPage(currentPage - 1);
    });

    document.getElementById("next-page").addEventListener("click", function () {
        goToPage(currentPage + 1);
    });

    // Muestra la primera página al cargar la página
    showPage(1);
});
