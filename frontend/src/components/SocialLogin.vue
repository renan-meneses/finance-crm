<template>
  <div class="social-login">
    <button @click="loginWithGoogle" class="google-btn">
      <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" alt="G" />
      Entrar com Google
    </button>
    <button @click="loginWithFacebook" class="facebook-btn">
      <img src="https://upload.wikimedia.org/wikipedia/commons/0/05/Facebook_Logo_(2019).png" alt="f" />
      Entrar com Facebook
    </button>
  </div>
</template>

<script setup lang="ts">
const loginWithGoogle = () => {
  window.location.href = 'http://localhost:8000/auth/google/redirect'
}

const loginWithFacebook = () => {
  window.location.href = 'http://localhost:8000/auth/facebook/redirect'
}
</script>

<style scoped>
.social-login {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin: 1.5rem 0;
}

.google-btn, .facebook-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  background: white;
  color: #333;
  font-size: 1rem;
  cursor: pointer;
  transition: background 0.2s;
}

.google-btn:hover { background: #f5f5f5; }
.facebook-btn {
  background: #1877F2;
  color: white;
  border-color: #1877F2;
}
.facebook-btn:hover { background: #166FE5; }
.facebook-btn img { height: 20px; }
.google-btn img { height: 20px; }
</style>
