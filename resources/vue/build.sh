#!/bin/bash
if [ ! -d "../../public/vueAssets" ]; then
  `mkdir "../../public/vueAssets"`
fi
`cp -r ./dist/css ../../public/vueAssets`
`cp -r ./dist/js ../../public/vueAssets`
`cp -r ./dist/img ../../public/vueAssets`
`cp ./dist/favicon.ico ../../public/vueAssets/favicon.ico`
`cp ./dist/index.html ../views/vue.blade.php`
