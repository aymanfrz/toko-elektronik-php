function filterKategori() {
    let dropdown = document.getElementById('kategori-select');
    let pilihan = dropdown.options[dropdown.selectedIndex].text;
    if(pilihan !== "Kategori") {
        alert("Kamu memilih kategori: " + pilihan + ".");
    }
}

function beliProduk(namaBarang) {
    alert(namaBarang + " dimasukkan ke keranjang!");
}