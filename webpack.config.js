const path = require('path');

module.exports = {

    entry: [
        __dirname + '/src/js/index.js'
    ],
    output: {
        path: path.resolve(__dirname, 'public/js'),
        filename: 'bundle.js',
    },
};