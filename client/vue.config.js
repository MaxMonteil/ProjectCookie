module.exports = {
  chainWebpack: config => {
    config.plugin('html').tap(args => {
      args[0].title = 'Project Cookie'
      return args
    })
  },
  devServer: {
    proxy: {
      '/api/v1': {
        target: 'http://[::1]:8888',
        logLevel: 'debug',
        timeout: 6000,
        changeOrigin: true,
        ws: true,
      },
    },
  },
}
