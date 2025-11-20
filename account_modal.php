<div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      
      <div class="d-flex justify-content-end">
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="tab-buttons mt-2">
        <button class="tab active" id="loginTab" type="button">Login</button>
        <button class="tab" id="registerTab" type="button">Register</button>
      </div>

      <form id="loginForm" class="form-section active" action="login.php" method="POST">
        <h3 class="text-center text-primary mb-3">Login</h3>
        
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Enter username" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter password" required>
        </div>
        
        <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
      </form>

      <form id="registerForm" class="form-section" action="register.php" method="POST">
        <h3 class="text-center text-primary mb-3">Register</h3>
        
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="full_name" class="form-control" placeholder="Enter full name" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mobile Number</label>
            <input type="text" name="mobile" class="form-control" placeholder="Enter mobile number" required>
        </div>

        <div class="mb-3">
            <label class="form-label">User Type</label>
            <select name="user_type" class="form-select" required>
                <option value="Guest">Customer</option>
                <option value="Contractor">Contractor</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Create username" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Create password" required>
        </div>
        
        <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
      </form>

    </div>
  </div>
</div>

<style>
    
    .tab-buttons {
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
      border-bottom: 1px solid #dee2e6;
      padding-bottom: 10px;
    }

    .tab {
      flex: 1;
      padding: 10px;
      border: none;
      background: transparent;
      cursor: pointer;
      font-weight: 600;
      color: #6c757d;
      transition: 0.3s;
      border-bottom: 3px solid transparent;
    }

    .tab:hover {
        color: #0d6efd;
    }

    .tab.active {
      color: #0d6efd;
      border-bottom: 3px solid #0d6efd;
    }

    .form-section {
      display: none;
      animation: fadeIn 0.3s ease;
    }

    .form-section.active {
      display: block;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(5px); }
      to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
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
</script>