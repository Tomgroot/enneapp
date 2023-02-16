module.exports = {
    root: true,
    env: {
        node: true,
    },
    extends: [
        'plugin:vue/essential',
        'eslint:recommended',
        '@vue/typescript/recommended',
        '@vue/prettier',
    ],
    parserOptions: {
        ecmaVersion: 2020,
    },
    ignorePatterns: ['dist/'],
    rules: {
        'no-console': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
        'no-debugger': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
        '@typescript-eslint/no-explicit-any': 'off',
        '@typescript-eslint/camelcase': 'off',
        '@typescript-eslint/ban-ts-ignore': 'off',
        'no-case-declarations': 'off',
        '@typescript-eslint/no-non-null-assertion': 'off',
    },
    overrides: [
        {
            files: ['**/__tests__/*.ts?(x)', '**/tests/unit/**/*.spec.ts?(x)'],
            env: {
                jest: true,
            },
        },
    ],
};
