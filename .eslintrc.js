module.exports = {
    extends: [
        'eslint:recommended',
        'plugin:vue/recommended'
    ],
    rules: {
        "vue/html-indent": ["error", 4, {
            "attribute": 0,
            "baseIndent": 1,
            "alignAttributesVertically": false,
            "ignores": []
        }],
    }
}
