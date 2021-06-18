// vue.config.js

process.env.VUE_APP_API_ROOT_PATH = 'http://dummy.local';

/**
 * @type {import('@vue/cli-service').ProjectOptions}
 */
module.exports = {
    publicPath: process.env.NODE_ENV === 'production'
        ? '/vueAssets/'
        : '/',
}
