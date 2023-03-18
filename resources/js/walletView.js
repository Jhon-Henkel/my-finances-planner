function edit(item) {
    // todo fazer o replace do ponto para virgula no amount ao inserir na modal
    document.getElementById('name-update').value = item.name
    document.getElementById('amount-update').value = item.amount
    document.getElementById('type-update').value = item.type
    document.getElementById('id-update').value = item.id
    let modal = new bootstrap.Modal(document.getElementById('updateWallet'))
    modal.show();
}