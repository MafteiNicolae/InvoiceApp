<template>
  <div class="spinner"></div>
</template>

<script>
export default {
  name: 'Spinner'
};
</script>

<style>
.spinner {
  /* Your spinner styles */
  border: 4px solid rgba(0, 0, 0, 0.1);
  border-left-color: #7983ff;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
