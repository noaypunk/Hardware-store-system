
accountBtn.onclick = () => {
  accountModal.style.display = 'flex';
};

window.onclick = (event) => {
  if (event.target === accountModal) {
    accountModal.style.display = 'none';
  }
};

