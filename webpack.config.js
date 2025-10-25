const Encore = require('@symfony/webpack-encore');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or subdirectory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './assets/app.js')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
    .enableStimulusBridge('./assets/controllers.json')

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()

    // Displays build status system notifications to the user
    // .enableBuildNotifications()

    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // configure Babel
    // .configureBabel((config) => {
    //     config.plugins.push('@babel/a-babel-plugin');
    // })

    // enables and configure @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.38';
    })

    // enables Sass/SCSS support
    //.enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you use React
    //.enableReactPreset()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()
    .enablePostCssLoader()
    .addPlugin(new BrowserSyncPlugin(
        {
            host: 'localhost',
            port: 3000,
            proxy: 'https://localhost:8000',
            https: true,
            files: [
                'templates/**/*.twig',
                'assets/**/*.(js|css)'
            ],
            serveStatic: ['public'], // ✅ DIT VOEGEN WE TOE
            serveStaticOptions: {
                extensions: ['html']
            },
            notify: false
        },
        {
            reload: true
        }
    ))
    .configureWatchOptions((watchOptions) => {
        watchOptions.ignored = /public[\\/]build/;
    })
    // Ignore absolute /images/* URLs in CSS so they are served directly from the public/ folder
    .configureCssLoader(options => {
        // css-loader v7 expects either boolean or { filter }
        const previous = options.url;
        options.url = {
            filter: (url, resourcePath) => {
                if (typeof previous === 'function') {
                    const decision = previous(url, resourcePath);
                    if (decision === false) return false;
                }
                // Ignore absolute URLs that point to /images/* so they are served directly
                if (url.startsWith('/images/')) {
                    return false;
                }
                return true;
            }
        };
    })
;

module.exports = Encore.getWebpackConfig();
