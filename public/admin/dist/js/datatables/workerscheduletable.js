window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const datatablesSimple = document.getElementById('datatablesSimple1');
    const datatablesSimple2 = document.getElementById('datatablesSimple2');
    const datatablesSimple3 = document.getElementById('datatablesSimple3');
    const datatablesSimple4 = document.getElementById('datatablesSimple4');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple1);
    }
    if (datatablesSimple2) {
        new simpleDatatables.DataTable(datatablesSimple2);
    }
    if (datatablesSimple3) {
        new simpleDatatables.DataTable(datatablesSimple3);
    }
    if (datatablesSimple4) {
        new simpleDatatables.DataTable(datatablesSimple4);
    }
});
