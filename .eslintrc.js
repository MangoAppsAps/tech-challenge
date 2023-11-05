module.exports = {
    extends: [
        'eslint:recommended',
        'plugin:vue/recommended'
    ],
    rules: {
        "vue/singleline-html-element-content-newline": 0,
        "vue/html-indent": ["error", 4, {
            "attribute": 0,
            "baseIndent": 1,
            "alignAttributesVertically": false,
            "ignores": []
        }],
        "vue/html-self-closing": 0,
        "vue/max-attributes-per-line": 0,
        "vue/require-prop-types": 0,
    }
}