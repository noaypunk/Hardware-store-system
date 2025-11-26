// Account Modal
const accountModal = document.getElementById('accountModal');
const accountBtn = document.querySelector('[data-bs-target="#accountModal"]');

accountBtn.onclick = () => { accountModal.style.display = 'flex'; };

window.onclick = (event) => {
  if (event.target === accountModal) {
    accountModal.style.display = 'none';
  }
};

// Product Search
document.getElementById("searchBtn")?.addEventListener("click", function() {
    let searchValue = document.getElementById("productSearchInput").value;
    fetch("search_api.php?search=" + searchValue)
        .then(response => response.text())
        .then(data => {
            document.getElementById("searchResults").innerHTML = data;
        });
});
