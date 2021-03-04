'use strict';
const HtmlWebpackPlugin = require('html-webpack-plugin');
const MiniCSSExtractPlugin = require('mini-css-extract-plugin');
const SpriteLoaderPlugin = require('svg-sprite-loader/plugin');
const helpers = require('./helpers');
const isDev = process.env.NODE_ENV === 'development';

/*
 * Чтобы добавить новую страницу
 * 1. создаем новый файл в @/pages
 * 2. добавляем его имя сторокой в массив pageNameArray
 */
const pageNameArray = [
  'index',
];

const pageHtmlWebpackPluginConfigArray = pageNameArray.map((entryName) => {
  return new HtmlWebpackPlugin({
    template: helpers.root('src', `${entryName}.html`),
    filename: entryName + '.html',
    minify: false,
  });
});

const webpackConfig = {
  entry: {
    main: helpers.root('src', 'index.js'),
  },
  resolve: {
    extensions: ['.js'],
    alias: {
      '@': helpers.root('src'),
    },
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        loader: 'babel-loader',
        include: [helpers.root('src')],
      },
      {
        test: /\.s[ac]ss$/i,
        include: [helpers.root('src')],
        use: [
          { loader: MiniCSSExtractPlugin.loader, options: { hmr: isDev } },
          { loader: 'css-loader', options: { sourceMap: true } },
          { loader: 'resolve-url-loader' },
          { loader: 'sass-loader', options: { sourceMap: true } },
        ],
      },
      {
        test: /\.css$/,
        use: [
          { loader: MiniCSSExtractPlugin.loader, options: { hmr: isDev } },
          { loader: 'css-loader', options: { sourceMap: true } },
        ],
      },
      {
        test: /\.(ttf|eot|woff|woff2)$/,
        loader: 'file-loader',
        include: [helpers.root('src')],
        options: {
          name: 'fonts/[name].[ext]',
          outputPath: 'fonts/',
          publicPath: 'fonts/',
        },
      },
      {
        test: /\.(jpg|png|gif)$/,
        loader: 'file-loader',
        include: [helpers.root('src')],
        options: {
          name: '[name].[ext]',
          outputPath: 'img/',
          publicPath: 'img/',
        },
      },
      {
        test: /\.svg$/,
        include: [helpers.root('src')],
        use: [
          {
            loader: 'svg-sprite-loader',
            options: {
              runtimeCompat: true,
            },
          },
          'svgo-loader',
        ],
      },
    ],
  },
  plugins: [
    new MiniCSSExtractPlugin(
      isDev
        ? undefined
        : {
          filename: 'css/[name].[hash].css',
        },
    ),
    ...pageHtmlWebpackPluginConfigArray,
    new SpriteLoaderPlugin(),
  ],
};

module.exports = webpackConfig;
