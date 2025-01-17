require('dotenv').config();
const path = require('path');
const CopyWebpackPlugin = require('copy-webpack-plugin');

module.exports = (env, argv) => {
    const mode = argv.mode || process.env.APP_ENV || 'production';
    
    return {
        mode: mode,
        entry: './public/index.js',
        output: {
            path: path.resolve(__dirname, 'public/')
        },
        module: {
            rules: [
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env']
                        }
                    }
                }
            ]
        },
        plugins: [
            new CopyWebpackPlugin({
                patterns: [ 
                    { from: './node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.css', to: 'bootstrap/css' },
                    { from: './node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.js', to: 'bootstrap/js' },
                    { from: './node_modules/print-js/dist/print.css', to: 'assets/printjs/css' },
                    { from: './node_modules/print-js/dist/print.js', to: 'assets/printjs/js' },
                    { from: './node_modules/select2/dist/css/select2.css', to: 'bootstrap/css' },
                    { from: './node_modules/select2/dist/js/select2.js', to: 'bootstrap/js' },
                    { from: './node_modules/toastr/build/toastr.min.css', to: 'assets/toastr/css' },
                    { from: './node_modules/toastr/build/toastr.min.js', to: 'assets/toastr/js' }, 
                    { from: './node_modules/chart.js/dist/chart.js', to: 'assets/charts/js' },
                    { from: './node_modules/sweetalert2/dist/sweetalert2.css', to: 'assets/sweetalert/css' },
                    { from: './node_modules/sweetalert2/dist/sweetalert2.js', to: 'assets/sweetalert/js' },
                    // { from: './node_modules/popper.js/dist/popper.js', to: 'assets/vendor/libs/popper' },
                    { from: './node_modules/datatables/media/css/jquery.dataTables.css', to: 'assets/jquery/css' },
                    { from: './node_modules/datatables/media/images', to: 'assets/jquery/images' },
                    { from: './node_modules/datatables/media/js/jquery.dataTables.js', to: 'assets/jquery/js' }
                ]
            })
        ],
        resolve: {
            extensions: ['.js']
        },
        devtool: 'source-map' // Optional, for easier debugging
    };
};
