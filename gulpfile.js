const gulp = require('gulp');
const fs = require('fs-jetpack');
const process = require('process');
const merge = require('merge-json');
const spawn = require('child_process').spawnSync;


var config = {
    // The path where we will build our compiled assets
    build: './build',

    mergeOriginal: true,

    paths: [
        'workbench',
        'extensions',
        'resources/themes',
    ],
};



gulp.task('default', [ 'build' ]);


gulp.task('build', function () {
    // Build the package.json
    createPackageJson(config);

    // Change the working directory
    changePath(config.build);

    // Install dependencies
    spawn('yarn', { stdio: 'inherit' });

    //compileAssets(config);
});



var createPackageJson = function (config) {
    var originalContents = fs.read('package.json', 'json');

    var original = {
        dependencies: getJsonProperty(originalContents, 'dependencies', {}),
        devDependencies: getJsonProperty(originalContents, 'devDependencies', {}),
    };

    var content = {
        dependencies: {},
        devDependencies: {},
    };

    var paths = config.paths;

    for (var p = 0; p < paths.length; p++) {
        var path = paths[p];

        if (fs.exists(path) === 'dir') {
            fs.find(path, {
                matching: 'package.json', files: true, directories: false
            }).forEach(function (file) {
                content = merge.merge(content, fs.read(file, 'json'));
            });
        };
    };

    var final = config.mergeOriginal === true ? merge.merge(original, content) : content;

    final.dependencies = sortArray(final.dependencies);
    final.devDependencies = sortArray(final.devDependencies);

    fs.dir(config.build).write('package.json', final);
};


var getJsonProperty = function (source, key, fallback) {
    return source.hasOwnProperty(key) ? source[key] : fallback;
};

var changePath = function (path) {
    process.chdir(path);
};

var sortArray = function (data) {
    var sorted = {};

    Object.keys(data).sort().forEach(function (v, i) { sorted[v] = data[v]; });

    return sorted;
};
