<div class="w-full max-w-md">
  <div class="card bg-base-100 shadow-2xl">
    <div class="border-t-4 border-primary"></div>
    <div class="card-body">
      <h2 class="card-title text-2xl text-center justify-center mb-6">Create Account</h2>
      
      <div id="registerMessage" class="text-sm text-error mb-3" style="display:none;"></div>
      <form id="registerForm" method="POST" class="space-y-4">
        <!-- Full Name Input -->
        <div class="form-control w-full">
          <label class="label">
            <span class="label-text">Full Name</span>
          </label>
          <input 
            id="fullName"
            type="text" 
            name="fullName"
            placeholder="John Doe" 
            class="input input-bordered input-primary w-full"
            required 
          />
        </div>

        <!-- Email Input -->
        <div class="form-control w-full">
          <label class="label">
            <span class="label-text">Email Address</span>
          </label>
          <input 
            id="email"
            type="email" 
            name="email"
            placeholder="your@email.com" 
            class="input input-bordered input-primary w-full"
            required 
          />
        </div>

        <!-- Password Input -->
        <div class="form-control w-full">
          <label class="label">
            <span class="label-text">Password</span>
          </label>
          <input 
            id="password"
            type="password" 
            name="password"
            placeholder="••••••••" 
            class="input input-bordered input-primary w-full"
            required 
          />
        </div>

        <!-- Confirm Password Input -->
        <div class="form-control w-full">
          <label class="label">
            <span class="label-text">Confirm Password</span>
          </label>
          <input 
            id="confirmPassword"
            type="password" 
            name="confirmPassword"
            placeholder="••••••••" 
            class="input input-bordered input-primary w-full"
            required 
          />
        </div>

        <!-- Terms of Service Checkbox -->
        <div class="form-control">
          <label class="label cursor-pointer">
            <span class="label-text">I agree to the <a href="#" class="link link-hover">Terms of Service</a></span>
            <input 
              id="terms"
              type="checkbox" 
              name="terms"
              class="checkbox checkbox-primary" 
              required
            />
          </label>
        </div>

        <!-- Submit Button -->
        <button 
          type="submit" 
          class="btn btn-primary w-full"
        >
          Create Account
        </button>
      </form>

      <!-- Divider -->
      <div class="divider">OR</div>

      <!-- Social Login (Optional) -->
      <div class="space-y-2">
        <button 
          class="btn btn-outline w-full"
          onclick="alert('Google signup coming soon!')"
        >
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.09H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.91l2.85-2.22.81-.62z"/>
            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.09l3.85 2.99c.87-2.6 3.3-4.53 6.16-4.53z"/>
          </svg>
          Google
        </button>
        <button 
          class="btn btn-outline w-full"
          onclick="alert('Github signup coming soon!')"
        >
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
          </svg>
          GitHub
        </button>
      </div>

      <!-- Sign In Link -->
      <div class="card-actions justify-center mt-6">
        <p class="text-sm text-base-content/70">
          Already have an account? 
          <a href="index.php?page=login" class="link link-primary font-semibold" onclick="navigateTo('index.php?page=login')">Sign in</a>
        </p>
      </div>
    </div>
  </div>
</div>

<script>
async function showRegisterMessage(text, isError = true) {
  const msg = document.getElementById('registerMessage');
  msg.textContent = text;
  msg.style.display = 'block';
  msg.className = isError ? 'text-sm text-error mb-3' : 'text-sm text-success mb-3';
}

async function clearRegisterMessage() {
  const msg = document.getElementById('registerMessage');
  msg.textContent = '';
  msg.style.display = 'none';
}

document.getElementById('registerForm').addEventListener('submit', async function(event) {
  event.preventDefault();
  clearRegisterMessage();

  const formData = new FormData(this);

  const response = await fetch('server/api/register.php', {
    method: 'POST',
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: formData
  });

  const json = await response.json();
  if (!json.success) {
    showRegisterMessage(json.error || 'Registration failed');
    return;
  }

  showRegisterMessage('Registration successful! Redirecting...', false);
  setTimeout(() => {
    navigateTo(json.redirect || 'index.php?page=home');
  }, 300);
});
</script>
