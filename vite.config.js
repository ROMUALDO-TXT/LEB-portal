import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
          output: {
            manualChunks: undefined // Certifique-se de que esta opção esteja undefined
          },
          external: ['inputmask'],
        },
        assetsDir: 'public' // Isso copiará os ativos para a pasta public do seu projeto
      }
});
