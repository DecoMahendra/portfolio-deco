import react from '@vitejs/plugin-react'
import tailwindcss from '@tailwindcss/vite'
import { defineConfig } from 'vite'

// Dokumentasi: https://vite.dev/config/
export default defineConfig({
  plugins: [
    react(),      // supaya Vite mengerti file .jsx (React)
    tailwindcss() // supaya Vite memproses class Tailwind
  ],
})
