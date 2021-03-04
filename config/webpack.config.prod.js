'use strict';

const webpack = require('webpack');
const { merge } = require('webpack-merge');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const MiniCSSExtractPlugin = require('mini-css-extract-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const helpers = require('./helpers');
const commonConfig = require('./webpack.config.common');
const isProd = process.env.NODE_ENV === 'production';
const environment = isProd
  ? require('./env/prod.env')
  : require('./env/staging.env');

const webpackConfig = merge(commonConfig, {
  mode: 'production',
  output: {
    path: helpers.root('dist'),
    publicPath: '/',
    filename: 'js/[name].[hash].js',
  },
  optimization: {
    runtimeChunk: false,
    minimize: true,
    minimizer: [
      new OptimizeCSSAssetsPlugin({
        cssProcessorPluginOptions: {
          preset: ['default', { discardComments: { removeAll: true } }],
        },
      }),
      new TerserPlugin({
        cache: true,
        parallel: true,
        sourceMap: true,
      }),
    ],
  },
  plugins: [
    new webpack.EnvironmentPlugin(environment),
    new webpack.HashedModuleIdsPlugin(),
  ],
});

webpackConfig.devtool = 'source-map';

if (!isProd) {
  if (process.env.npm_config_report) {
    const BundleAnalyzerPlugin = require('webpack-bundle-analyzer')
      .BundleAnalyzerPlugin;
    webpackConfig.plugins.push(new BundleAnalyzerPlugin());
  }
}

module.exports = webpackConfig;
