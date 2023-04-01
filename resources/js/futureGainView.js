function edit(data) {
    let dataDecoded = JSON.parse(data)
    let modalItem = null
    if (dataDecoded.id) {
        // let modalItem =
    } else {
        // let modalItem =
    }
    let modal = new bootstrap.Modal(document.getElementById(modalItem))
    modal.show();
}