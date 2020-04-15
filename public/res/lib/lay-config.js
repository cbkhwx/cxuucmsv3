/**
 * description:此处放layui自定义扩展
 */

window.rootPath = (function (src) {
    src = document.scripts[document.scripts.length - 1].src;
    return src.substring(0, src.lastIndexOf("/") + 1);
})();

layui.config({
    base: rootPath + "lay-module/",
    version: true
}).extend({
    dtree: 'dtree/dtree', //table树形扩展
    iconPicker: 'iconPicker/iconPicker', // table选择扩展
    treeTable: 'treeTable/treeTable', // fa图标选择扩展
});