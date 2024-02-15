const { defineConfig } = require('@vue/cli-service')
const { createProxyMiddleware } = require('http-proxy-middleware');

module.exports = defineConfig({
  transpileDependencies: true,
  devServer: {
    proxy: {
      '/api': {
        target: 'http://nginx:80', // Your backend API server
        changeOrigin: true,
        pathRewrite: {
          '^/api': '', // Remove '/api' from the request path
        },
      },
    },
  },
});
