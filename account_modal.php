<div id="accountModal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeAccount">&times;</span>
    <div class="tab-buttons">
      <button class="tab active" id="loginTab">Login</button>
      <button class="tab" id="registerTab">Register</button>
    </div>

    <form id="loginForm" class="form-section active" action="login.php" method="POST">
      <h2>Login</h2>
      <label>Username</label>
      <input type="text" name="username" placeholder="Enter username" required>
      <label>Password</label>
      <input type="password" name="password" placeholder="Enter password" required>
      <button type="submit" name="login">Login</button>
    </form>

    <form id="registerForm" class="form-section" action="register.php" method="POST">
      <h2>Register</h2>
      <label>Full Name</label>
      <input type="text" name="full_name" placeholder="Enter full name" required>
      <label>Mobile number</label>
      <input type="text" name="mobile" placeholder="Enter mobile number" required>
      <select id="userType" name="user_type" required>
        <option value="Guest">Customer</option>
        <option value="Contractor">Contractor</option>
      </select>
      <label>Username</label>
      <input type="text" name="username" placeholder="Create username" required>
      <label>Password</label>
      <input type="password" name="password" placeholder="Create password" required>
      <button type="submit" name="register">Register</button>
    </form>
  </div>

  <style>

#accountModal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.4);
  display: none;
  justify-content: center;
  align-items: center;
  z-index: 100;
  overflow-y: auto;
  padding: 20px;
}

.modal-content {
  background: #fff;
  padding: 30px 40px;
  border-radius: 10px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 420px;
  text-align: left;
  animation: fadeIn 0.3s ease;
}

.modal-content h2 {
  color: #0078d7;
  margin-bottom: 20px;
}

.modal-content input,
.modal-content select {
  width: 100%;
  padding: 10px 12px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 6px;
  outline: none;
  font-size: 0.95rem;
}

.modal-content input:focus,
.modal-content select:focus {
  border-color: #0078d7;
  box-shadow: 0 0 0 2px rgba(0, 120, 215, 0.1);
}

.modal-content button {
  width: 100%;
  background-color: #0078d7;
  color: #fff;
  border: none;
  padding: 10px 0;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 600;
  transition: 0.3s ease;
}

.modal-content button:hover {
  background-color: #005fa3;
}

.close {
  position: absolute;
  top: 7px;
  right: 14px;
  font-size: 30px;
  color: #000000;
  cursor: pointer;
  transition: 0.2s;
}

.close:hover {
  color: #333;
}


.tab-buttons {
  display: flex;
  justify-content: space-between;
  margin-bottom: 15px;
}

.tab {
  flex: 1;
  padding: 10px;
  border: none;
  background: #ddd;
  cursor: pointer;
  font-weight: 600;
  border-radius: 5px;
  transition: 0.3s;
}

.tab.active {
  background: #007bff;
  color: #fff;
}

.form-section {
  display: none;
}

.form-section.active {
  display: block;
}

form label {
  display: block;
  margin-top: 10px;
  font-weight: 500;
}

form input, form select {
  width: 100%;
  padding: 8px;
  margin-top: 5px;
  border-radius: 5px;
  border: 1px solid #ccc;
}

form button {
  margin-top: 15px;
  width: 100%;
  padding: 10px;
  background: #007bff;
  border: none;
  color: white;
  border-radius: 5px;
  cursor: pointer;
  font-weight: 600;
}

form button:hover {
  background: #0056b3;
}

@keyframes fadeIn {
  from {
    transform: translateY(-15px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

@media (max-width: 768px) {
  nav {
    gap: 20px;
    flex-wrap: wrap;
    padding: 12px;
  }

  .modal-content {
    padding: 25px;
  }
}
  </style>

  <script>
    const accountModal = document.getElementById("accountModal");
    const closeAccount = document.getElementById("closeAccount");
    const loginTab = document.getElementById("loginTab");
    const registerTab = document.getElementById("registerTab");
    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("registerForm");

    loginTab.onclick = () => {
      loginTab.classList.add("active");
      registerTab.classList.remove("active");
      loginForm.classList.add("active");
      registerForm.classList.remove("active");
    };

    registerTab.onclick = () => {
      registerTab.classList.add("active");
      loginTab.classList.remove("active");
      registerForm.classList.add("active");
      loginForm.classList.remove("active");
    };

    closeAccount.onclick = () => {
      accountModal.style.display = "none";
    };

  </script>
</div>
