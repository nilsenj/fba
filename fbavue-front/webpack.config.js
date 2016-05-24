/**
 * Created by nilse on 5/14/2016.
 */
// webpack.config.js
module.exports = {
  // entry point of our application
  entry: './main.js',
  // where to place the compiled bundle
  output: {
    path: __dirname,
    filename: 'build.js'
  },
  module: {
    // `loaders` is an array of loaders to use.
    // here we are only configuring vue-loader
    loaders: [
      {
        test: /\.vue$/, // a regex for matching all files that end in `.vue`
        loader: 'vue'   // loader to use for matched files
      },
      {
        test: /\.coffee$/, // a regex for matching all files that end in `.vue`
        loader: 'coffee'   // loader to use for matched files
      },
      {
        test: /\.jade$/, // a regex for matching all files that end in `.vue`
        loader: 'jade'   // loader to use for matched files
      },
      {
        test: /\.scss$/, // a regex for matching all files that end in `.vue`
        loader: 'sass'   // loader to use for matched files
      },
      {
        test: /\.(png|jpg|gif|css)$/,
        loader: 'url',
        query: {
          // limit for base64 inlining in bytes
          limit: 10000,
          // custom naming format if file is larger than
          // the threshold
          name: '[name].[ext]?[hash]'
        }
      }
    ]
  }
}