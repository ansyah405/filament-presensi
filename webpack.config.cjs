const path = require('path');

module.exports = {
  mode: 'production',
  entry: './src/index.js', // Pastikan file ini ada
  output: {
    filename: 'bundle.js',
    path: path.resolve(__dirname, 'dist'),
  },
  resolve: {
    extensions: ['.js', '.json'],
  },
};