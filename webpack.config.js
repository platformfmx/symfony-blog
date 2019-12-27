var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath("public/build")
    .setPublicPath("build")
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .addEntry("js/app",[
        "./node_modules/jquery/dist/jquery.js",
        "./node_modules/bootstrap/dist/js/bootstrap.js",
        "./assets/js/app.js"
    ])
    .addStyleEntry("css/app",[
        "./node_modules/bootstrap/dist/css/bootstrap.css",
        "./assets/css/app.css"
    ]);

module.exports = Encore.getWebpackConfig();
