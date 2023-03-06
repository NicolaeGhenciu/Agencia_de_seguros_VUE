const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  transpileDependencies: true,
  publicPath: process.env.NODE_ENV === 'production' ? 'https://www.ieslamarisma.net/proyectos/2023/nicolaeadrian/Agencia/' : '/'
})